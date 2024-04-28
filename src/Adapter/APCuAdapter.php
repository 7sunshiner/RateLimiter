<?php

namespace Sunshiner\RateLimiter\Adapter;

/**
 * ApcuAdapter class for rate limiter storage using APCu
 */
class APCuAdapter implements AdapterInterface {
    /**
     * Increments the value associated with the given key
     * 
     * @param string $key The key for identifying the request object
     * 
     * @return int The incremented value
     */
    public function increment($key) {
        return apcu_inc($key);
    }
    
    /**
     * Sets an expiration time for the given key.
     * 
     * @param string $key The key for identifying the request object
     * @param int $interval The expiration time in seconds
     *
     * @return void
     */
    public function expire($key, $interval) {
        $count = apcu_fetch($key);
        apcu_store($key, $count, $interval);
    }

    /**
     * Delete a given key
     * 
     * @param string $key The key for identifying the request object
     *
     * @return boolean
     */
    public function release($key) {
        return (bool)apcu_delete($key);
    }
}