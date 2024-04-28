# RateLimiter
RateLimiter is a little library to try and provide an easy way of rate limit requests.

Install via Composer
-------

```
cd RateLimiter
composer install
```

Usage Example
-----------------

``` php
<?php
use Sunshiner\RateLimiter\RateLimiter;

$redis = new Redis();
$redis->connect('localhost', 6379);

$rateLimiter = new RateLimiter(new RedisAdapter($redis));
$result = $rateLimiter->check('test', 5, 10);
```

Adapters
-------

Currenctly support 3 adapters

* Redis
* APC
* Fuile


Unit Tests
-------------------

``` shell
$ vendor/bin/phpunit tests/RateLimiterTest.php

PHPUnit 7.5.20 by Sebastian Bergmann and contributors.

.
..                                                                 3 / 3 (100%)

Time: 27 ms, Memory: 4.00 MB

OK (3 tests, 18 assertions)

```
