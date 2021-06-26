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
        $message = $receivedMessage->body;

        try {
            switch ($message) {
                default:
                    \writeLog(json_encode($message));
                    break;
            }
        }
        catch (\Throwable $exception) {
            \writeLog($exception->getMessage());
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

