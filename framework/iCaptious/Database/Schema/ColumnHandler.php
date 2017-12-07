<?php

namespace iCaptious\Database\Schema;

class ColumnHandler
{
    private $Table;
    private $Column;

    public function __construct($table, $column = null)
    {
        $this->$Table = $table;
        $this->$Column = $column;
    }

    public static function Create($column)
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
