<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure;

use Redis;
use RedisException;

class ConnectorFacade
{
    private string $host;
    private int $port;
    private ?string $password;
    private ?int $dbindex;
    private ?Connector $connector = null;

    /**
     * ConnectorFacade constructor.
     *
     * @param string $host Redis server host.
     * @param int $port Redis server port.
     * @param ?string $password Redis authentication password.
     * @param ?int $dbindex Redis database index.
     */
    public function __construct(string $host, int $port = 6379, ?string $password = null, ?int $dbindex = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->dbindex = $dbindex;
    }

    /**
     * Builds the Redis connection and initializes the Connector.
     *
     * @return void
     * @throws RedisException If connection or authentication fails.
     */
    public function build(): void
    {
        $redis = new Redis();

        try {
            if (!$redis->isConnected()) {
                $redis->connect($this->host, $this->port);
                $redis->auth($this->password);
                if ($this->dbindex !== null) {
                    $redis->select($this->dbindex);
                }
            }

            $this->connector = new Connector($redis);
        } catch (RedisException $e) {
            throw new RedisException('Failed to build Redis connection: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Returns the initialized Connector instance.
     *
     * @return Connector The Redis Connector.
     */
    public function getConnector(): Connector
    {
        if ($this->connector === null) {
            throw new RedisException('Connector has not been initialized. Call build() first.');
        }

        return $this->connector;
    }
}