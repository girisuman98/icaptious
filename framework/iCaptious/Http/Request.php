<?php
namespace iCaptious\Http;

/**
* 
*/
class Request
{
	
	function __construct(){
		/**
		 * Need to change this i the future.
		 * It is temporary
		 */
		if (!isset($_SERVER) || empty($SERVER)) {
			throw new Exception("Error Processing Request", 1);
		}
	}

	/**
	 * Return the redirect url
	 * @return string
	 */
	public function url(){
		return urldecode($_SERVER['REDIRECT_URL']);
	}

	/**
	 * Return query string as an array
	 * @return array
	 */
	public function query(){
		if (!empty($_SERVER['QUERY_STRING'])) {
			$query = explode("&", urldecode($_SERVER['QUERY_STRING']));
			$aQuery = array();
			foreach ($query as $key => $value) {
				$values = explode("=", $value);
				$aQuery[] = array(
					$values[0] => (!empty($values[1]) ? $values[1] : "");
				);
			}
			return $aQuery;
		}
		return array();
	}

	/**
	 * Return the request method
	 * @return string [GET|POST|PUT|DELETE|PATCH]
	 */
	public function method(){
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Returns the base url
	 * @return string
	 */
	public function basename(){
		return rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');;
	}

	/**
	 * Return the request scheme
	 * @return string [http||https]
	 */
	public function scheme(){
		return $_SERVER['REQUEST_SCHEME'];
	}

	/**
	 * Return the server port
	 * @return int [80||443]
	 */
	public function port(){
		return intval($_SERVER['SERVER_PORT']);
	}

	/**
	 * Return the server protocol type
	 * @return string
	 */
	public function protocol(){
		return $_SERVER['SERVER_PROTOCOL'];
	}

	/**
	 * Return the gateway interface
	 * @return [type] [description]
	 */
	public function gateway(){
		return $_SERVER['GATEWAY_INTERFACE'];
	}
}