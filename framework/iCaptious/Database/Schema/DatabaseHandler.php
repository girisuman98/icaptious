<?php

namespace iCaptious\Database\Schema;

class DatabaseHandler
{
    private $Database;

    public function __construct($database = null)
    {
        $this->$database = $database;
    }

    public static function Create($database)
    {
    }

    public static function List()
    {
    }

    public static function Drop($column)
    {
    }

    public static function Rename($from, $to)
    {
    }
}
