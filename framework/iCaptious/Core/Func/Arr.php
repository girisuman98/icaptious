<?php
namespace iCaptious\Core\Func;

/**
* 
*/
class Arr
{

	/**
	 * Check if a value exists in the given array.
	 * 
	 * @param  mixed $needle
	 * @param  array $haystack
	 * @return bool
	 */
	public static function InArray($needle, array $haystack) {
		if (in_array($needle, $haystack)) {
			return true;
		}
		return false;
	}

	/**
	 * Returns the length of the given array
	 * 
	 * @param  array $array
	 * @return int
	 */
	public static function Length($array) {
		return count($array);
	}

	/**
	 * Returns the key at the end of the given array
	 * 
	 * @param  array $array
	 * @return mixed
	 */
	public static function LastKey(array $array) {
		end($array);
		return key($array);
	}

	/**
	 * Returns the value from the end of the given array
	 * 
	 * @param  array $array
	 * @return mixed
	 */
	public static function LastValue(array $array) {
		return end($array);
	}

	/**
	 * Shuffle the array and return the results
	 * 
	 * @param 	array $array
	 * @return 	array
	 */
	public static function Shuffle($array){
        shuffle($array);
        return $array;
    }
}
