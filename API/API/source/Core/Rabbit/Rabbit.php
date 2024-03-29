<?php

namespace Source\Core\Rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

abstract class Rabbit implements RabbitInterface
{
    use RabbitTrait;

    /**
     * @var string $host
     */
    const HOST = CONF_RABBITMQ_HOST;

    /**
     * @var int $port
     */
    const PORT = CONF_RABBITMQ_PORT;

    /**
     * @var string $user
     */
    const USER = CONF_RABBITMQ_USER;

    /**
     * @var string $passwd
     */
    const PASSWD = CONF_RABBITMQ_PASS;

    /**
     * @var AMQPStreamConnection $connection
     */
    protected $connection;

    /**
     * @var object $channel
     */
    protected $channel;

    /**
     * Declare the queue and exchanger of the your rabbitmq server
     * @var string $queue
     * @var string $exchanger
     * @return self
     */
    protected function getInstance(string $queue, string $exchanger, bool $reply = false): self
    {
        // basic validation for the queue, valid by the trait
        $this->setQueue($queue);

        // basic validation for the exchanger, valid by the trait
        $this->setExchanger($exchanger);

        // basic validation for the reply, valid by the trait
        $this->setReply($reply);

        $this->connection = new AMQPStreamConnection(self::HOST, self::PORT, self::USER, self::PASSWD);
        $this->channel = $this->connection->channel();

        $this->channel->queue_declare($this->queue, true, false, false, false);
        $this->channel->exchange_declare($this->exchanger, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($this->queue, $this->exchanger);

        $this->channel->basic_qos(null, 1, null);
        return $this;
    }

    /**
     * Close the connection with the rabbitmq
     */
    protected function closeConnection()
    {
        if (!empty($this->channel)) {
            $this->channel->close();
        }

        if (!empty($this->connection)) {
            $this->connection->close();
        }
    }

    /**
     * Close the connection with the rabbitmq
     */
    public function __destruct()
    {
        $this->closeConnection();
    }
}
