<?php

declare(strict_types=1);

namespace Source\Infra\Queue\RabbitMQ;

/**
 * The global trait to use in Rabbitmq classes
 */
trait RabbitTrait
{
    /** @var string $queue */
    private $queue;

    /** @var string $exchanger */
    private $exchanger;

    /** @var bool $reply */
    private $reply;

    /**
     * @param string $queue
     * @return self
     */
    protected function setQueue(string $queue): self
    {
        $queue = trim($queue);

        if (empty($queue)) {
            throw new \InvalidArgumentException("Fila inválida!");
        }

        if (!filter_var($queue)) {
            throw new \InvalidArgumentException("Fila inválida!");
        }

        $this->queue = $queue;
        return $this;
    }

    /**
     * @param string $queue
     * @return self
     */
    protected function setExchanger(string $exchanger): self
    {
        $exchanger = trim($exchanger);

        if (empty($exchanger)) {
            throw new \InvalidArgumentException("Exchanger '{$exchanger}' inválido!");
        }

        if (!filter_var($exchanger)) {
            throw new \InvalidArgumentException("Exchanger '{$exchanger}' inválido!");
        }

        $this->exchanger = $exchanger;
        return $this;
    }

    /**
     * @param string $queue
     * @return self
     */
    protected function setReply(bool $reply): self
    {
        $this->reply = ($reply === true) ?? false;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getQueue(): ?string
    {
        return $this->queue;
    }

    /**
     * @return null|string
     */
    public function getExchanger(): ?string
    {
        return $this->exchanger;
    }

    /**
     * @return null|bool
     */
    public function getReply(): ?bool
    {
        return $this->reply;
    }
}
