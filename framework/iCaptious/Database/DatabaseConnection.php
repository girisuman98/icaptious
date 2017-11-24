<?php
namespace iCaptious\Database;
use iCaptious\Database\DatabaseException;
/**
* 
*/
class DatabaseConnection
{

	public static function Start($HOST, $DATABASE, $USER, $PASSWORD, $TYPE = "mysql", $CHARSET = "utf8") {
		try {
			$PDO = new \PDO($TYPE.':host='.$HOST.';dbname='.$DATABASE.';charset='.$CHARSET, $USER, $PASSWORD);
		} catch( \PDOException $Exception ) {
		    new DatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
		}
		$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$PDO->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		return $PDO;
	}
}