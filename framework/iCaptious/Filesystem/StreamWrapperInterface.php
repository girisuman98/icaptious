<?php
namespace iCaptious\Filesystem;

interface StreamWrapperInterface
{
	
	function Open($path, $mode, $options, &$opened_path);

	function Close();

	function Read($count);

	function Write($data);

	function EOF();

 	function Tell();

	function Seek($offset, $whence);

	function Flush();

	function Stat();

	function unlink($path);

	function rename($path_from, $path_to);

	function mkdir($path, $mode, $options);

	function rmdir($path, $options);

	function OpenDir($path, $options);

	function ReadDir();

	function RewindDir();

	function CloseDir();
}