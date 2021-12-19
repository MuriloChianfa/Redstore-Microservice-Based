<?php

declare(strict_types=1);

namespace Source\Infra\Cache\Redis;

use Predis\Client;
use Predis\Autoloader;

/**
 * Redis class...
 *
 * @version 0.1.0
 * @author Murilo Chianfa <github.com/MuriloChianfa>
 * @package Source\Infra\Cache\Redis\Redis
 */
final class Redis
{
    private $client;

    public function __construct()
    {
        Autoloader::register();

        $this->client = new Client([
            'scheme' => CONF_REDIS_SCHEME,
            'host'   => CONF_REDIS_HOST,
            'port'   => CONF_REDIS_PORT,
        ]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function __destruct()
    {
        if (!empty($this->client)) {
            $this->client->quit();
        }
    }

    /**
     * Connect clone.
     */
    final private function __clone()
    {
    }
}
