<?php

namespace iCaptious\Cache;

/*
*
*/
class FileCache extends FileCacheAbstract
{
    /**
     * Store data in the cache directory.
     *
     * @param steing $key
     * @param mixed  $data
     * @param int    $ttl
     *
     * @return void
     */
    public static function store(string $key, $data, int $ttl)
    {

        // Opening the file in read/write mode
        $h = fopen(self::getFileName($key), 'a+');
        if (!$h) {
            throw new \Exception('Could not write to cache');
        }
        flock($h, LOCK_EX); // exclusive lock, will get released when the file is closed

        fseek($h, 0); // go to the start of the file

        // truncate the file
        ftruncate($h, 0);

        // Serializing along with the TTL
        $data = serialize([time() + $ttl, $data]);
        if (fwrite($h, $data) === false) {
            throw new \Exception('Could not write to cache');
        }
        fclose($h);
    }

    /**
     * Retrieve item from the cache directory.
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function fetch(string $key)
    {
        $filename = self::getFileName($key);
        if (!file_exists($filename)) {
            return false;
        }
        $h = fopen($filename, 'r');

        if (!$h) {
            return false;
        }

        // Getting a shared lock
        flock($h, LOCK_SH);

        $data = file_get_contents($filename);
        fclose($h);

        $data = @unserialize($data);
        if (!$data) {
            // If unserializing somehow didn't work out, we'll delete the file
            unlink($filename);

            return false;
        }

        if (time() > $data[0]) {
            // Unlinking when the file was expired
            unlink($filename);

            return false;
        }

        return $data[1];
    }

    /**
     * Delete item from the cache directory.
     *
     * @param string $key
     *
     * @return bool
     */
    public static function delete(string $key)
    {
        $filename = self::getFileName($key);
        if (file_exists($filename)) {
            return unlink($filename);
        } else {
            return false;
        }
    }

    /**
     * Give back the filename from the cache directory.
     *
     * @param string $key
     *
     * @return string
     */
    private static function getFileName(string $key)
    {
        return ini_get('session.save_path').'/uniCache'.md5($key);
    }
}
