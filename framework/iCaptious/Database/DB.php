<?php
namespace iCaptious\Database;
use iCaptious\Database\DatabaseException;
use iCaptious\Database\DatabaseConnection;
/**
* 
*/
class DB
{
	private $DB;

	const FETCH_ASSOC = \PDO::FETCH_ASSOC;
	const FETCH_NUM = \PDO::FETCH_NUM;
	const FETCH_BOTH = \PDO::FETCH_BOTH;
	const FETCH_OBJ = \PDO::FETCH_OBJ;
	const FETCH_LAZY = \PDO::FETCH_LAZY;

	const FETCH_DEFAULT = self::FETCH_ASSOC;

	var $exec;
	
	function __construct()
	{
		return call_user_func_array(__NAMESPACE__ .'\DB::Setup', func_get_args());
	}

	/*
	* Setting up the database
	*/
	public function Setup($host, $database, $user, $pass) {
		if (isset($host) && isset($database) && isset($user) && isset($pass)) {
			$this->DB = DatabaseConnection::Start($host, $database, $user, $pass);
			return true;
		}
		new DatabaseException("DatabaseConnection::Setup($host, $database, $user, $pass)", 1);	
	}


	public function Query($query) {
		$this->exec = $this->DB->query($query);
		return $this;
	} 

	public function Exec($query) {
		$this->exec = $this->DB->exec($query);
		return $this;
	} 

	public function fetch(){
		return $this->exec->fetchAll(self::FETCH_DEFAULT);
	}

}
