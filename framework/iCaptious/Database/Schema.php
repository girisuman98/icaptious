<?php
namespace iCaptious\Database;
use iCaptious\Database\Schema\DatabaseHandler;
use iCaptious\Database\Schema\TableHandler;
 
class Schema
{
	public static function Table($table){
		return new TableHandler($table);
	}

	public static function Database($database){
		return new DatabaseHandler($database);
	}
}