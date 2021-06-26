<?php

namespace Source\Core;

final class Request
{
    private $error;

    public function getRequestHeader(string $headerParam)
    {
        $headers = getallheaders();

        if ($headerParam == 'all') {
            return $headers;
        }

        return isset($headers[$headerParam]) ? [$headerParam => $headers[$headerParam]] : false;
    }

    public function getToken()
    {
        if (!($token = $this->getRequestHeader('Authorization'))) {
            $this->error = "require login";
            return false;
        }

        $token = str_replace(['Bearer', ' '], '', $token['Authorization']);

        return $token;
    }

    public function getError()
    {
        return $this->error;
    }
}
