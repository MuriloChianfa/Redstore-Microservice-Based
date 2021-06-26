<?php

namespace Source\Core;

final class Response
{
    private $headers = [
        'Content-Type' => 'application/json',
        'Cache-Control' => 'no-cache',
        'Pragma' => 'no-cache',
        'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, OPTIONS, DELETE',
        'Accept-Language' => 'en-US;q=0.5,en;q=0.3',
        'Keep-Alive' => 'timeout=5, max=100',
        'Connection' => 'keep-alive'
    ];
    
    private const HTTP_PROTOCOL = 'HTTP/1.1';
    
    private $statusCode;
    
    private $message;

    public function __construct($customHeaders = null)
    {
        if (!empty($customHeaders)) {
            $this->addHeader($customHeaders);
        }
    }

    private function addHeader(array $headers): void
    {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }

        return;
    }

    private function setHeaders(): void
    {
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        return;
    }

    private function setMessage(object $message): Response
    {
        if (!is_array((array) $message)) {
            throw new \Exception("Invalid message");
        }

        $this->message = $message;

        return $this;
    }
    
    public function setStatusCode(int $statusCode): Response
    {
        $text = $this->handleCode($statusCode);

        header(self::HTTP_PROTOCOL . " {$statusCode} {$text}");

        return $this;
    }

    private function handleCode(int $statusCode): string
    {
        if (($text = handleStatusCode($statusCode)) == 'unknown') {
            throw new \Exception("Unknown status code");
        }

        return $text;
    }

    public function send(object $message): void
    {
        $this->setMessage($message);
        $this->setHeaders();
        $this->sendResponse();

        return;
    }    

    private function sendResponse(): void
    {
        echo json_encode((array) $this->message);

        return;
    }
}
