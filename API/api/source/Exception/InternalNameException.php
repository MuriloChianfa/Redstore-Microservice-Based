<?php

namespace Source\Core\Exception;

use \Exception;

final class InternalNameException extends Exception implements ExceptionInterface
{
    /**
     * Exception message
     */
    protected $message = "";
    
    /**
     * Unknown
     */
    private $string;
    
    /**
     * User-defined exception code
     */
    protected $code = 0;

    /**
     * Source filename of exception
     */
    protected $file;

    /**
     * Source line of exception
     */
    protected $line;

    /**
     * Unknown
     */
    private $trace;

    /**
     * @var string $message
     * @var int $code
     */
    public function __construct(string $message = null, int $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }

        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n" . "{$this->getTraceAsString()}";
    }
}
