<?php

namespace Source\Log;

/**
 * This class is used by logging the events on rabbitmq sented messages
 */
final class Logger
{
    use LoggerTrait;

    /**
     * @var string $filePath
     * @var string $fileName
     */
    public function __construct(string $filePath, string $fileName)
    {
        $this->setFilePath();
        $this->setFileName();
    }

    /**
     * @var string $message
     * @var bool $timestamp
     */
    public function log(string $message, bool $timestamp = true)
    {
        // logar a mensagem com o tempo atual dela, no arquivo.
    }
}
