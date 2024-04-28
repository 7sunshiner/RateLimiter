<?php

namespace Sunshiner\RateLimiter\Adapter;

/**
 * Interface for rate limiter storage adapter
 * 
 * @author Ethan Zheng <ethanlucky2008@gmail.com>
 */
interface AdapterInterface {
    /**
     * Increments the value associated with the given key
     * 
     * @param string $key The key for identifying the request object
     * 
     * @return int The incremented value
     */
    public function increment($key);
    
    /**
     * Sets an expiration time for the given key.
     * 
     * @param string $key The key for identifying the request object
     * @param int $interval The expiration time in seconds
     */
    public function expire($key, $interval);

}
