<?php
namespace Sunshiner\RateLimiter;

use Sunshiner\RateLimiter\Adapter\AdapterInterface;
use Exception;

/**
 * RateLimiter class for API rate limiting
 * 
 * @author Ethan Zheng <ethanlucky2008@gmail.com>
 */
class RateLimiter {
    /**
     * @var AdapterInterface The adapter for storage
     */
    private $adapter;

    /**
     * Constructs a new RateLimiter instance
     * 
     * @param AdapterInterface $adapter The adapter for storing rate limit data
     */
    public function __construct(AdapterInterface $adapter) {
        $this->adapter = $adapter;
    }

    /**
     * Limits the number of requests for a given key
     * 
     * @param string $key The key for identifying the request object
     * @param int $limit The maximum number of requests allowed within the interval
     * @param int $interval The time interval in seconds
     * 
     * @return boolean default value is false, If the rate limit is exceeded, then return value is true
     */
    public function check($key, $limit, $interval) {
        $result = false;
        $count = $this->adapter->increment($key);
        if ($count > $limit) {
            $result = true;
        }
        $this->adapter->expire($key, $interval);

        return $result;
    }

    /**
     * Release a given key
     * 
     * @param string $key The key for identifying the request object
     * 
     * @return boolean default value is false, If the key is released successful then return value is true
     */
    public function release($key) {
        $result = $this->adapter->release($key);

        return (bool)$result;
    }
}
