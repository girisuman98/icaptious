<?php
/*
*
*/
class MemCache extends FileCacheAbstract {

    // Memcache object
    private static $connection = new MemCache;

    /**
    * Store data at the server
    * 
    * @param  string $key  
    * @param  mixed  $data
    * @param  int    $ttl
    * @return void
    */
    public static function store(string $key, $data, int $ttl) {
        return self::$connection->set($key,$data,0,$ttl);
    }

    /**
    * Retrieve item from the server
    * 
    * @param  string $key
    * @return mixed
    */
    public static function fetch(string $key) {
        return self::$connection->get($key);
    }

    /**
    * Delete item from the server
    * 
    * @param  string $key
    * @return bool
    */
    public static function delete(string $key) {
        return self::$connection->delete($key);
    }

    /**
     * Add a memcached server to connection pool
     * 
     * @param string    $host
     * @param integer   $port
     * @param integer   $weight
     */
    public static function addServer(string $host, int $port = 11211, int $weight = 10) {
        self::$connection->addServer($host,$port,true,$weight);
    }
}