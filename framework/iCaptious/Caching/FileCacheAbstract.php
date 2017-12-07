<?php
namespace iCaptious\Cache;
/*
*
*/
abstract class FileCacheAbstract {
    abstract function fetch($key);
    abstract function store($key,$data,$ttl);
    abstract function delete($key);
}