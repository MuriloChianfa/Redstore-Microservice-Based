<?php

declare(strict_types=1);

namespace Source\Infra\Queue\RabbitMQ;

// RabbitMQ MessageType lib. (The buffer class)
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Send a message to queue
 *
 * @version 0.1.0
 * @author Murilo Chianfa <github.com/MuriloChianfa>
 * @package Source\Infra\Queue\RabbitMQ\RabbitSender
 */
final class RabbitSender extends RabbitMQ
{
    /**
     * @param string $queue
     * @param string $exchanger
     */
    public function __construct(string $queue, string $exchanger)
    {
        // basic validation for the queue, valid by the trait
        $this->setQueue($queue);

        // basic validation for the exchanger, valid by the trait
        $this->setExchanger($exchanger);
    }

    /**
     * The sender will be send your text message to queue
     *
     * @param string $message The message you will send
     * @return void
     */
    public function sendMessage(string $message): void
    {
        $message = str_replace("\n", '<br>', $message);

        $Buffer = new AMQPMessage($message, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->getInstance(
            $this->getQueue(),
            $this->getExchanger()
        )->channel->basic_publish($Buffer, $this->getExchanger());
        $this->closeConnection();
    }
}
