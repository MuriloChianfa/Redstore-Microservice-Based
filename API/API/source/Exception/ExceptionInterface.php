<?php

namespace Source\Core\Exception;

/**
 * The mandatory method and arguments for the custom Exception's classes
 */
interface ExceptionInterface
{
    /* Protected methods inherited from Exception class */

    /**
     * Exception message
     */
    public function getMessage();

    /**
     * User-defined Exception code
     */
    public function getCode();

    /**
     * Source filename
     */
    public function getFile();

    /**
     * Source line
     */
    public function getLine();

    /**
     * An array of the backtrace()
     */
    public function getTrace();

    /**
     * Formated string of trace
     */
    public function getTraceAsString();
    
    /**
     * @var string $message
     * @var int $code
     */
    public function __construct(string $message = null, int $code = 0);

    /**
     * formated string for display
     */
    public function __toString();
}
