<?php

namespace Source\Core\Rabbit;

/**
 * The mandatory method and arguments for the base Rabbitmq class
 */
interface RabbitInterface
{
    /**
     * The method getInstance, is used by create one new connection with your 
     * queue, and you can set one exchanger into
     * 
     * they is very usable by RabbitSend because you dont entry in one already
     * oppened connection
     * 
     * @return self
     */
    // protected function getInstance(string $queue, string $exchanger, bool $reply = false);

    /**
     * Close your current openned connection, is private because
     * you cannot initiate two connections in one object 
     * 
     * @return void
     */
    // protected function closeConnection();
    
    /**
     * Called when the object is destroyd, will be call
     * the closeConnection method
     * 
     * @return void
     */
    // public function __destruct();
}
