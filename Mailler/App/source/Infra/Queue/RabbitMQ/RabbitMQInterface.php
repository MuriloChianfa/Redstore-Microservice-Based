<?php

declare(strict_types=1);

namespace Source\Infra\Queue\RabbitMQ;

/**
 * The mandatory method and arguments for the base Rabbitmq class
 * 
 * @version 0.1.0
 * @author Murilo Chianfa <github.com/MuriloChianfa>
 * @package
 */
interface RabbitMQInterface
{
    /**
     * The method getInstance, is used by create one new connection with your 
     * queue, and you can set one exchanger into
     *
     * they is very usable by RabbitMQSend because you dont entry in one already
     * oppened connection
     *
     * @param string $queue
     * @param string $exchanger
     * @param bool $reply
     * @return self
     */
    // public function getInstance(string $queue, string $exchanger, bool $reply = false): self;

    /**
     * Close your current openned connection, is private because
     * you cannot initiate two connections in one object 
     * 
     * @return void
     */
    // public function closeConnection(): void;

    /**
     * Called when the object is destroyd, will be call
     * the closeConnection method
     * 
     * @return void
     */
    // public function __destruct();
}
