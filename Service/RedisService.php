<?php

namespace Service;

require_once './vendor/predis/predis/src/Autoloader.php';

use Predis\Autoloader;
use Predis\Client as Client;

class RedisService
{

    //todo move this to .env file and add logic to override default if value is set
    const DEFAULT_TTL = 3600;
    // expires in 1 hour

    /** @var Client $client */
    public $client;

    /** @var int $ttl */
    public $ttl;

    public function __construct()
    {
        Autoloader::register();
        $this->ttl = self::DEFAULT_TTL;
        $this->client = new Client(
            [
                'scheme' => 'tcp',
                'host'   => 'redis',
                'port'   => 6379,
            ]
        );
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setValue(string $key, string $value)
    {
        $this->client->set($key, $value, 'EX', $this->ttl);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function valueExists(string $key): bool
    {
        return $this->client->exists($key);
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getValue(string $key): ?string
    {
        return $this->client->get($key);
    }
}
