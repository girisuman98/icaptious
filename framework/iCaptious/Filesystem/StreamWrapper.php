<?php
namespace iCaptious\Filesystem;

use iCaptious\Filesystem\StreamWrapperInterface:

class StreamWrapper implements StreamWrapperInterface
{
	
	function __construct()
	{
		
	}

	public function Open($path, $mode, $options, &$opened_path){

	}

	public function Close(){

	}

	public function Read($count){

	}

	public function Write($data){

	}

	public function EOF(){

	}

 	public function Tell(){

 	}

	public function Seek($offset, $whence){

	}

	public function Flush(){

	}

	public function Stat(){

	}

	public function unlink($path){

	}

	public function rename($path_from, $path_to){

	}

	public function mkdir($path, $mode, $options){

	}

	public function rmdir($path, $options){

	}

	public function OpenDir($path, $options){

	}

	public function ReadDir(){

	}

	public function RewindDir(){

	}

	public function CloseDir(){

	}
}