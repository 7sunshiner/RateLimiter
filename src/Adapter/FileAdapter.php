<?php

namespace Sunshiner\RateLimiter\Adapter;

/**
 * FileAdapter class for rate limiter storage using file
 * 
 * @author Ethan Zheng <ethanlucky2008@gmail.com>
 */
class FileAdapter implements AdapterInterface {
    /**
     * Increments the value associated with the given key
     * 
     * @param string $key The key for identifying the request object
     * 
     * @return int The incremented value
     */
    public function increment($key) {
        $filename = $this->getFilename($key);
        if (file_exists($filename)) {
            $count = intval(file_get_contents($filename)) + 1;
        } else {
            $count = 1;
        }
        file_put_contents($filename, $count);
        return $count;
    }

    /**
     * Sets an expiration time for the given key (removes the file).
     * 
     * @param string $key The key for identifying the request object
     * @param int $interval The expiration time in seconds.
     *
     * @return void
     */
    public function expire($key, $interval) {
        $filename = $this->getFilename($key);
        if ((time() - filemtime($filename)) > $interval) {
            $this->release($key);
        } else {
            touch($filename, time() + $interval);
        }
    }

    /**
     * Generates a filename based on the key
     * 
     * @param string $key The key for identifying the request object
     * 
     * @return string The filename
     */
    private function getFilename($key) {
        return '/tmp/' . md5($key) . '.txt';
    }

    /**
     * Delete a given key
     * 
     * @param string $key The key for identifying the request object
     *
     * @return bool
     */
    public function release($key) {
        $filename = $this->getFilename($key);
        if (file_exists($filename)) {
            return unlink($filename);
        }
        return false;
    }
}

?>

