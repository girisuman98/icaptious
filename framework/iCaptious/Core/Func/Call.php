<?php
namespace iCaptious\Core\Func;

 
class Call
{

	/**
	 * Check if a function is callable
	 * 
	 * @param 	mixed $Callable
	 * @return 	bool
	 */
	public static function Callable($Callable){
		if (is_callable($Callable)) {
			return true;
		}
		return false;
	}

	/**
	 * Call a function if callable
	 * 
	 * @param 	callable $Callable 
	 * @return 	mixed
	 */
	public static function Func(callable $Callable){
		return call_user_func($Callable);
	}

	/**
	 * Call a function with the given parameters
	 * 
	 * @param 	callable $Callable 
	 * @param 	array    $Param
	 * @return 	mixed    
	 */
	public static function FuncArr(callable $Callable, array $Param){
		return call_user_func_array($Callable, $Param);
	}
}