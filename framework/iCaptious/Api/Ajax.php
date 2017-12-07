<?php
namespace iCaptious\Api;

 
class Ajax
{
	
	/**
	 * Check if Request is a valid ajax request
	 *
	 * @return bool
	 */
	public static function ValidRequest() {
		if (defined('DOING_AJAX')) {
			return true;
		}
		return false;
	}
}