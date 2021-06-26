<?php

namespace Source\RabbitMQ;

/**
 * RabbitMQ MessageType lib. (The buffer class)
 */
use PhpAmqpLib\Message\AMQPMessage;

/**
 * The rabbit receiver will be listening infinitefor messages in your queue
 * 
 * the handler method can be overwrited by main class for handle the received messages
 */
final class RabbitSender extends RabbitMQ // implements Interface
{
    public function __construct(string $queue, string $exchanger)
    {
        // basic validation for the queue, valid by the trait
        $this->setQueue($queue);

        // basic validation for the exchanger, valid by the trait
        $this->setExchanger($exchanger);
    }

    /**
     * The sender will be send your text message to queue
     * @var string $message The message you will send
     */
    public function sendMessage(string $message)
    {
        $properties = array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT);
        
        $message = str_replace("\n", "<br>", $message);

        $Buffer = new AMQPMessage($message, $properties);

        $this->getInstance($this->getQueue(), $this->getExchanger())->channel->basic_publish($Buffer, $this->getExchanger());

        $this->closeConnection();
    }
}
