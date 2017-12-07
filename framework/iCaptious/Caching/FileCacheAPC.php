<?php

namespace iCaptious\Cache;

/*
*
*/
class FileCacheAPC extends FileCacheAbstract
{
    /**
     * Fetch a stored variable from the cache.
     *
     * @param string $key
     * @param mixed  $data
     * @param int    $ttl
     *
     * @return mixed
     */
    public static function fetch($key)
    {
        return apc_fetch($key);
    }

    /**
     * Cache a variable in the data store.
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function store($key, $data, $ttl)
    {
        return apc_store($key, $data, $ttl);
    }

    /**
     * Remove a stored variable from the cache.
     *
     * @param string $key
     *
     * @return bool
     */
    public static function delete($key)
    {
        return apc_delete($key);
    }
}
