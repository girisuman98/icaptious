<?php

namespace iCaptious\Cache;

/*
*
*/
abstract class FileCacheAbstract
{
    abstract public function fetch($key);

    abstract public function store($key, $data, $ttl);

    abstract public function delete($key);
}
