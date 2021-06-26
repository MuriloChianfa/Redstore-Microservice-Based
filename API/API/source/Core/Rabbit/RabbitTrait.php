<?php

namespace Source\Core\Rabbit;

/**
 * Exception.
 */
use Source\Core\Exception\InternalNameException;

/**
 * The global trait to use in Rabbitmq classes
 */
trait RabbitTrait
{
    /**
     * @var string $queue
     */
    private $queue;

    /**
     * @var string $exchanger
     */
    private $exchanger;

    /**
     * @var bool $reply
     */
    private $reply;

    /**
     * @var string $queue
     * @return self
     */
    protected function setQueue(string $queue): self // Return yourself
    {
        $queue = trim($queue);

        if (empty($queue)) {
            throw new InternalNameException("Fila inválida!");
        }

        if (!filter_var($queue)) {
            throw new InternalNameException("Fila inválida!");
        }

        $this->queue = $queue;
        return $this;
    }

    /**
     * @var string $queue
     * @return self
     */
    protected function setExchanger(string $exchanger): self // Return yourself
    {
        $exchanger = trim($exchanger);

        if (empty($exchanger)) {
            throw new InternalNameException("Exchanger '{$exchanger}' inválido!");
        }

        if (!filter_var($exchanger)) {
            throw new InternalNameException("Exchanger '{$exchanger}' inválido!");
        }

        $this->exchanger = $exchanger;
        return $this;
    }

    /**
     * @var string $queue
     * @return self
     */
    protected function setReply(bool $reply): self // Return yourself
    {
        $this->reply = ($reply === true) ?? false;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    /**
     * @return null|string
     */
    public function getExchanger(): string
    {
        return $this->exchanger;
    }

    /**
     * @return null|bool
     */
    public function getReply(): bool
    {
        return $this->reply;
    }
}
