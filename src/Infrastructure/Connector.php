<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure;

use Raketa\BackendTestTask\Domain\Cart;
use Redis;
use RedisException;

class Connector
{
    private Redis $redis;

    /**
     * Connector constructor.
     * @param Redis $redis Instance of the Redis client.
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Retrieves a value from Redis and deserializes it.
     *
     * @param string $key The key to retrieve.
     * @return Cart|null The deserialized Cart object or null if not found.
     * @throws ConnectorException If a RedisException occurs.
     */
    public function get(string $key): ?Cart
    {
        try {
            $data = $this->redis->get($key);
            return $data !== false ? unserialize($data, ['allowed_classes' => true]) : null;
        } catch (RedisException $e) {
            throw new ConnectorException('Error retrieving data from Redis.', $e->getCode(), $e);
        }
    }

    /**
     * Serializes and stores a value in Redis with a TTL.
     *
     * @param string $key The key to store the value under.
     * @param Cart $value The Cart object to store.
     * @return void
     * @throws ConnectorException If a RedisException occurs.
     */
    public function set(string $key, Cart $value): void
    {
        try {
            $this->redis->setex($key, 24 * 60 * 60, serialize($value));
        } catch (RedisException $e) {
            throw new ConnectorException('Error saving data to Redis.', $e->getCode(), $e);
        }
    }

    /**
     * Checks if a key exists in Redis.
     *
     * @param string $key The key to check.
     * @return bool True if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        try {
            return $this->redis->exists($key) > 0;
        } catch (RedisException $e) {
            throw new ConnectorException('Error checking key existence in Redis.', $e->getCode(), $e);
        }
    }
}