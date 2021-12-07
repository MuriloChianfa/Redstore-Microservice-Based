<?php

namespace Source\Core\Rabbit;

use PhpAmqpLib\Wire\AMQPWriter;

/**
 * The rabbit receiver will be listening infinitefor messages in your queue
 *
 * the handler method can be overwrited by main class for handle the received messages
 */
abstract class RabbitReceiver extends Rabbit // implements Interface
{
    /**
     * The handler of the messages received from queue
     * @var mixed $message Received from rabbitmq queue
     */
    protected function handler($message)
    {
        // Simple print on getted message from the queue
        print_r($message->body);
    }

    /**
     * Infinite loop for listen the queue messages
     */
    protected function consume()
    {
        $callback = function ($message) {
            $this->handler($message);
        };
        $this->channel->basic_consume($this->getQueue(), 'consumer', false, $this->getReply(), false, false, $callback);

        $pid = pcntl_fork();

        if ($pid == -1) {
            echo "can i help u ?";
        } else if ($pid) {
            while (true) {
                $this->sendHeartbeat();
                sleep(10);
            }
        } else {
            while (count($this->channel->callbacks)) {
                $this->channel->wait();
            }
        }

        $this->closeConnection();
    }

    /**
     * work on PhpAmqpLib 2.9.2
     */
    private function sendHeartbeat()
    {
        $packet = new AMQPWriter();
        $packet->write_octet(8);
        $packet->write_short(0);
        $packet->write_long(0);
        $packet->write_octet(0xCE);
        $this->connection->getIO()->write($packet->getvalue());
    }
}
