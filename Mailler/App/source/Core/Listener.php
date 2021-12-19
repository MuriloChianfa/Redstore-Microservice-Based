<?php

declare(strict_types=1);

namespace Source\Core;

use Source\Infra\Logger\Log;
use Source\Infra\Queue\RabbitMQ\RabbitReceiver;

use Source\Domain\Email\Email;
use Source\Domain\Templates\ConfirmEmail;

/**
 * Main listener for send emails
 * 
 * using the rabbitmq as a message broker
 * used protocol:
 * Advanced Message Queuing Protocol (AMQP)
 *
 * @version 0.1.0
 * @author Murilo Chianfa <github.com/MuriloChianfa>
 * @package Source\Core\Listener
 */
final class Listener extends RabbitReceiver
{
    /**
     * @param string $queue
     * @param string $exchanger
     */
    public function __construct(string $queue, string $exchanger)
    {
        $this->getInstance($queue, $exchanger)->consume();
    }

    /**
     * The handler of the messages received from queue
     * @param mixed $message Received from rabbitmq queue
     * @return void
     */
    protected function handler($receivedMessage)
    {
        $message = json_decode($receivedMessage->body);
        $handledMessage = false;

        try {
            $handledMessage = $this->dispatch($message);
        } catch (\Throwable $exception) {
            Log::exception($exception);
        } finally {
            // Verify if the message are received and if yes, send the ack for the queue
            if ($handledMessage) {
                // Send ack for remove message from the queue
                $receivedMessage->delivery_info['channel']->basic_ack($receivedMessage->delivery_info['delivery_tag']);
                return;
            }

            // Return message to queue 
            $receivedMessage->delivery_info['channel']->basic_nack($receivedMessage->delivery_info['delivery_tag']);
        }
    }

    /**
     * @param object $message
     * @return bool
     */
    private function dispatch($message): bool
    {
        if (!isset($message->type)) {
            throw new \Exception('Invalid message, missing type');
        }

        switch ($message->type) {
            case 'confirmEmail':
                $Email = new Email([
                    $message->content->email
                ], true);

                if (!$Email->SendMail(
                    ConfirmEmail::bind('127.0.0.1:80/confirm'),
                    'Confirm your email')
                ) {
                    Log::warning('Confirm email not delivered for: ' . $message->content->email);
                    Log::warning($Email->getError());
                }

                return true;

            default:
                Log::debug(json_encode($message));
                return true;
        }
    }
}
