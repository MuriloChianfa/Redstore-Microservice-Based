<?php

namespace Source\Core;

use Source\Core\Redis;

class Token
{
    private $token;

    private $timeout;

    private $error;

    private $Redis;

    public function __construct(int $timeout = 1 * 60 * 60)
    {
        $this->timeout = $timeout;

        $this->Redis = (new Redis)->getClient();
    }

    /**
     * @param string $jwt
     * @param string $secret
     * @return bool
     */
    public function validateToken(string $jwt, string $secret = CONF_JWT_SECRET): bool
    {
        $tokenParts = explode('.', $jwt);
        $payload = base64_decode($tokenParts[1]);

        $signature = hash_hmac('sha256', base64UrlEncode(base64_decode($tokenParts[0])) . "." . base64UrlEncode($payload), $secret, true);

        if (!(base64UrlEncode($signature) === $tokenParts[2])) {
            $this->error = 'this token is invalid';
            return false;
        }

        if (!$this->Redis->get((json_decode($payload)->id.json_decode($payload)->expirationTime))) {
            $this->error = 'please login first';
            return false;
        }

        if ((json_decode($payload)->expirationTime - (time()) <= 0) ? true : false) {
            $this->error = 'token expired';
            $this->Redis->del((json_decode($payload)->id.json_decode($payload)->expirationTime));
            return false;
        }

        $this->token = $payload;
        return true;
    }

    /**
     * @param object $data
     * @param array $context
     * @param string $secret
     * @return 
     */
    public function generateNewToken(object $data, array $context = CONF_JWT_CONTEXT, string $secret = CONF_JWT_SECRET): string
    {
        $data = array_merge((array) $data, [
            'expirationTime' => (time() + $this->timeout)
        ]);

        $base64UrlHeader = base64UrlEncode(json_encode($context));
        $base64UrlPayload = base64UrlEncode(json_encode($data));

        $parsedPayload = "{$base64UrlHeader}.{$base64UrlPayload}";
        
        $token = "{$parsedPayload}." . base64UrlEncode(hash_hmac('sha256', $parsedPayload, $secret, true));

        $this->Redis->set($data['id'].$data['expirationTime'], $token, 'EX', $this->timeout);

        return $token;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getToken(): array
    {
        return (array) json_decode($this->token);
    }
}
