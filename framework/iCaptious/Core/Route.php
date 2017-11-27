<?php

namespace iCaptious\Core;

use iCaptious\Core\Route\Exceptions\RouteException;
use iCaptious\Core\Domain\Path;
use iCaptious\Core\Func\Call;
use iCaptious\Core\Func\Arr;
use iCaptious\Core\Func\Str;

/**
* 
*/
class Route extends Path
{

	/**
	 * This variable has the prefix value, wich will be
	 * appended to the route called inside Group() function.
	 * 
	 * @var string
	 */
	public static $Group;

	/**
	 * All the Http Request Methods supported
	 * 
	 * @var array
	 */
	private static $HttpScope = array( "GET", "POST", "PUT", "DELETE", "CONNECT", "OPTIONS", "TRACE", "PATCH" );


	/**
	 * Route by pairing all Http Verbs
	 * 
	 * @param  string   $route
	 * @param  callable $callback
	 * @return mixed
	 */
	public static function All(){
		return Call::FuncArr(__NAMESPACE__ .'\Route::Load', func_get_args());
	}


	// To be reviewed
	public static function Name(){

	}

	public static function getValue(){
		echo self::$Group;
	}

	/**
	 * Calls the callback given if route matches
	 * 
	 * @param  string   $route
	 * @param  callable $callback
	 * @return mixed
	 */
	public static function Load($route, $callback){
		if (!empty(self::$Group)) {
			$route = ($route[0] == "/" ?
			 self::$Group.$route :
			 self::$Group."/".$route);
		}
		$route = self::Sanitize_Route($route);
		$real_route = self::Sanitize_Route(parent::path_call());
		$arguments = array();
		$last_sign = '';

		foreach ($real_route as $key => $name) {
			if (!empty($route[$key])) {
				if (preg_match_all('/{(.*?)}/', $route[$key])) {
					$last_sign = $route[$key];

					$route[$key] = $argument = $real_route[$key];
					$arguments[] = htmlentities($argument); 
				}				
			} elseif($last_sign == "{*}") {
				$argument = $real_route[$key];
				$arguments[Arr::LastKey($arguments)] .= "/".htmlentities($argument); 
				unset($real_route[$key]);
			}
		}
		if (!empty($arguments) && $last_sign == "{*}") {
			// This converts the unknown path into an array
			$arguments[Arr::LastKey($arguments)] = explode("/",$arguments[Arr::LastKey($arguments)]);
		}

		if ($route === $real_route) {
			Call::FuncArr($callback, $arguments);
		}
		return new static;
	}

	/**
	 * This method groups a path and changes the start point temporary
	 * 
	 * @param  string $route
	 * @param  callable $callback
	 * @return mixed
	 */
	public static function Group($route, $callback){
		$route = self::Sanitize_Route($route);
		$real_route = self::Sanitize_Route(parent::path_call());
		array_splice($real_route, count($route));
		if ($route === $real_route) {
			self::$Group = implode("/", $real_route);
			Call::Func($callback);
			self::$Group = "";
		}
		return new static;
	}

	/**
	 * Filtering and return the route as an array
	 * 
	 * @param   string $route 
	 * @return  array         
	 */
	public static function Sanitize_Route($route) {
		# remove slash if it exist at the end of the route
		$route = trim($route, '/'); 
		# 	$route = (strpos($route, '/') ? explode('/', $route) : $route);
		$route = explode('/', $route);
		return $route;
	}

	/**
	 * Check if this is the actual domain
	 * 
	 * @param  string    $domain
	 * @param  callable  $callback
	 * @return mixed  
	 */
	public static function isDomain(string $domain, $callback){
		if (is_string($domain)) {
			if ($_SERVER['SERVER_NAME'] == $domain || $_SERVER['SERVER_NAME'] == "www.".$domain) {
				Call::Func($callback);
			}
		}
		return new static;
	}

	/**
	 * Duplicate of Route::isDomain
	 * 
	 * @param  string   $domain
	 * @param  callable $callback
	 * @return mixed
	 */
	public static function Domain($domain, $callback){
		Call::FuncArr(__NAMESPACE__ .'\Route::isDomain', func_get_args());
		return new static;
	}

	/**
	 * Redirects the client to a website
	 * 
	 * @param  string  $url
	 * @param  boolean $permanently
	 */
	public static function Redirect($url,$permanently=false){
		if ($permanently === true) {
			header('HTTP/1.1 301 Moved Permanently'); // The Redirect will be cached by the browser
		}
	    header('Location: ' . $url);
	}

	/**
	 * Route and Compose a view
	 * @param string $view
	 * @param string $ViewName
	 * @param array  $assign
	 */
	public static function Compose($view, $ViewName, $assign = array()){
		if ($view && $ViewName && !empty($assign)) {

		}
	}

	/**
	 * Mark the given parameter with the given regular expresion.
	 * This will be marked globaly and will be processed only 
	 * if the given regular expresion is valid.
	 * 
	 * @param string $param
	 * @param string $regex
	 */
	public static function Mark($param, $regex){
		if ($param && $regex) {
		}
	}

	public static function __callStatic($method, $args){
		if (Arr::InArray(Str::Upper($method), self::$HttpScope)) {
			if ($_SERVER['REQUEST_METHOD'] === Str::Upper($method)) {
				return Call::FuncArr(__NAMESPACE__ .'\Route::Load', $args);
			}
			return new static;
		} else {
			if (method_exists(new static, $method)) {
				return Call::FuncArr(array(get_called_class(), $method), $args);
			}
			throw new RouteException("Method $method not found", 1);
		}
	}
}
