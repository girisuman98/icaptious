<?php
namespace iCaptious\Database\Schema;
use iCaptious\Database\Schema\ColumnHandler;
 
class TableHandler
{
	private $Table;

	function __construct($table = null) {
		$this->$Table = $table;
	}

	public function Create($table, Closure $callback){

	}

	public function Drop(){

	}

	public function DropAllTables(){

	}

	public function TableListing(){

	}

	public function Rename($to){

	}

	public function Has($table){

	}

	public function Column($column){
		return new ColumnHandler($column);
	} 
}