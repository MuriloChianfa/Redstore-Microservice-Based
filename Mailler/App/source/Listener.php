<?php

namespace Source;

/**
 * Exception
 */
use Source\Exception\InvalidArgumentException;

/**
 * RabbitMQ
 */
use Source\RabbitMQ\RabbitReceiver;
use Source\RabbitMQ\RabbitSender;

/**
 * Email
 */
use Source\Email\Email;

// Email templates
use Source\Templates\ConfirmEmail;

/**
 * Main listener for send emails
 * 
 * using the rabbitmq as a message broker
 * used protocol:
 * Advanced Message Queuing Protocol (AMQP)
 */
final class Listener extends RabbitReceiver
{
    /**
     * @var RabbitSender $RabbitSender
     */
    private $RabbitSender;

    /**
     * @var string $queue
     * @var string $exchanger
     */
    public function __construct(string $queue, string $exchanger)
    {
        $this->getInstance($queue, $exchanger)->consume();
    }

    /**
     * The handler of the messages received from queue
     * @var mixed $message Received from rabbitmq queue
     */
    protected function handler($receivedMessage)
    {
        $message = json_decode($receivedMessage->body);

        $handledMessage = false;

        try {
            if (!isset($message->type)) {
                throw new \Exception('Invalid message, missing type');
            }

            switch ($message->type) {
                case 'confirmEmail':
                    $Email = new Email([ $message->content->email ], true);

                    if (!$Email->SendMail(ConfirmEmail::bind('127.0.0.1:80/confirm'), 'Confirm your email')) {
                        \writeLog('Confirm email not delivered for: ', $message->content->email);
                        \writeLog($Email->getError());
                    }

                    $handledMessage = true;
                    break;

                default: \writeLog(json_encode($message)); $handledMessage = true; break;
            }
        }
        catch (\Throwable $exception) {
            \writeLog($exception->getMessage());
            $handledMessage = true;
        }
        finally {
            /**
             * Verify if the message are received and if yes, send the ack for the queue
             */
            if (!empty($handledMessage)) {
                // Send ack for remove message from the queue
                $receivedMessage->delivery_info['channel']->basic_ack($receivedMessage->delivery_info['delivery_tag']);
                unset($handledMessage);
            } else {
                // Return to the queue 
                $receivedMessage->delivery_info['channel']->basic_nack($receivedMessage->delivery_info['delivery_tag']);
            }
        }
    }
}
