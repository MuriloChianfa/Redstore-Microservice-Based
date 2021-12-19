<?php

declare(strict_types=1);

namespace Source\Infra\Queue\RabbitMQ;

use PhpAmqpLib\Wire\AMQPWriter;

/**
 * The rabbit receiver will be listening infinitefor messages in your queue
 * Handler method can be overwrited by main class for handle the received messages
 *
 * @version 0.1.0
 * @author Murilo Chianfa <github.com/MuriloChianfa>
 * @package Source\Infra\Queue\RabbitMQ\RabbitMQ
 */
abstract class RabbitReceiver extends RabbitMQ
{
    /**
     * The handler of the messages received from queue
     *
     * @param mixed $message Received from rabbitmq queue
     * @return void
     */
    protected function handler($message)
    {
        // Simple print on getted message from the queue
        print_r($message->body);
    }

    /**
     * Infinite loop for listen the queue messages
     *
     * @return void
     */
    protected function consume()
    {
        $callback = function($message) { $this->handler($message); };
        $this->channel->basic_consume($this->getQueue(), 'consumer', false, $this->getReply(), false, false, $callback);
        
        $pid = pcntl_fork();

        if ($pid == -1) {
            echo 'annot fork consume proccess...';
            return;
        }

        if ($pid) {
            while (true) {
                $this->send_heartbeat();
                sleep(10);
            }
        } else {
            while (count($this->channel->callbacks))
            {
                $this->channel->wait();
            }
        }

        $this->closeConnection();
    }

    /**
     * work on PhpAmqpLib 2.9.2
     */
    private function send_heartbeat()
    {
        $packet = new AMQPWriter();
        $packet->write_octet(8);
        $packet->write_short(0);
        $packet->write_long(0);
        $packet->write_octet(0xCE);

        $this->connection->getIO()->write($packet->getvalue());
    }
}
