<?php

namespace Sunshiner\RateLimiter\Adapter;

/**
 * RedisAdapter class for rate limiter storage using Redis
 * 
 * @author Ethan Zheng <ethanlucky2008@gmail.com>
 */
class RedisAdapter implements AdapterInterface {
    /**
     * @var mixed The Redis connection.
     */
    private $redis;

    /**
     * Constructor
     *
     * @param object $redis redis client
     * @return void
     */ 
    public function __construct($redis = null)
    {
        if (!$redis) {
            $redis = (new \Redis())->connect('localhost');
        }
        $this->redis = $redis;
    }

    /**
     * Increments the value associated with the given key
     * 
     * @param string $key The key for identifying the request object
     * 
     * @return int The incremented value
     */
    public function increment($key) {
        return $this->redis->incr($key);
    }

    /**
     * Sets an expiration time for the given key
     * 
     * @param string $key The key for identifying the request object
     * @param int $interval The expiration time in seconds
     * 
     * @return void
     */
    public function expire($key, $interval) {
        $this->redis->expire($key, $interval);
    }

    /**
     * Delete a given key
     * 
     * @param string $key The key for identifying the request object
     * @return boolean
     */
    public function release($key) {
        return $this->redis->del($key);
    }
}
