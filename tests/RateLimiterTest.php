<?php

use PHPUnit\Framework\TestCase;
use Sunshiner\RateLimiter\RateLimiter;
use Sunshiner\RateLimiter\Adapter\FileAdapter;
use Sunshiner\RateLimiter\Adapter\RedisAdapter;
use Sunshiner\RateLimiter\Adapter\ApcuAdapter;
use Sunshiner\RateLimiter\Adapter\MemcachedAdapter;

/**
 * Test cases for RateLimiter class
 * 
 * @author Ethan Zheng <ethanlucky2008@gmail.com>
 */
class RateLimiterTest extends TestCase {

    /**
     * Times
     */
    CONST LIMIT_TIMES = 5;

    /**
     * Period, second
     */
    CONST INTERVAL = 10;


    /**
     * Test limiting requests with FileAdapter
     */
    public function testLimitRequestWithFileAdapter() {
        $rateLimiter = new RateLimiter(new FileAdapter());
        
        $key = 'file';

        $rateLimiter->release($key);
        
        for ($i = 0; $i < self::LIMIT_TIMES; $i++) {
            $this->assertFalse($rateLimiter->check($key, self::LIMIT_TIMES, self::INTERVAL));
        }

        $this->assertTrue($rateLimiter->check($key, self::LIMIT_TIMES, self::INTERVAL));
    }
    
    /**
     * Test limiting requests with RedisAdapter
     */
    public function testLimitRequestWithRedisAdapter() {
        if (!extension_loaded('redis')) {
            $this->markTestSkipped('Redis extension is not available');
        }
        
        $redis = new Redis();
        $redis->connect('localhost', 6379);
        
        $rateLimiter = new RateLimiter(new RedisAdapter($redis));

        $key = 'test';

        $rateLimiter->release($key);
        
        for ($i = 0; $i < self::LIMIT_TIMES; $i++) {
            $this->assertFalse($rateLimiter->check($key, self::LIMIT_TIMES, self::INTERVAL));
        }
        
        $this->assertTrue($rateLimiter->check($key, self::LIMIT_TIMES, self::INTERVAL));
    }
    
    /**
     * Test limiting requests with ApcuAdapter
     */
    public function testLimitRequestWithApcuAdapter() {
        if (!extension_loaded('apcu')) {
            $this->markTestSkipped('APCu extension is not available');
        }

        ini_set('apc.enable_cli', 1);

        $rateLimiter = new RateLimiter(new ApcuAdapter());

        $key = 'apcu';

        $rateLimiter->release($key);

        for ($i = 0; $i < self::LIMIT_TIMES; $i++) {
            $this->assertFalse($rateLimiter->check($key, self::LIMIT_TIMES, self::INTERVAL));
        }
        
        $this->assertTrue($rateLimiter->check($key, self::LIMIT_TIMES, self::INTERVAL));
    }

}

?>
