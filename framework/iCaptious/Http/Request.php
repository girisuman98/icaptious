<?php

namespace iCaptious\Http;

use iCaptious\Http\Request\Headers;
use iCaptious\Http\Request\Query;

class Request
{
    /**
     * Rewuest Methods.
     */
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PURGE = 'PURGE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_TRACE = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';

    /**
     * iCaptious\Http\Request\Headers.
     *
     * @var Headers
     */
    protected static $Headers;

    /**
     * iCaptious\Http\Request\Query.
     *
     * @var Query
     */
    protected static $Query;

    /**
     * clone of $_SERVER.
     *
     * @var mixed
     */
    protected static $SERVER;

    /**
     * The Constructer.
     */
    public function __construct()
    {
        /*
         * Need to change this i the future.
         * It is temporary
         */
        if (!isset($_SERVER) || empty($_SERVER)) {
            throw new \Exception('Error Processing Request', 1);
        }

        self::$SERVER = self::$SERVER ?? $_SERVER;
        self::$Headers = self::$Headers ?? (new Headers());
        self::$Query = self::$Query ?? (new Query());
    }

    /**
     * Return iCaptious\Http\Request\Headers.
     *
     * @return mixed
     */
    public function headers()
    {
        return self::$Headers;
    }

    /**
     * Return the redirect url.
     *
     * @return string
     */
    public function url()
    {
		$queryString = !empty(self::$SERVER['argv']) ? self::$SERVER['argv'][0] : self::$SERVER['QUERY_STRING'];
        self::$SERVER['REQUEST_URI'] = trim(self::$SERVER['REQUEST_URI'], '?'.$queryString);

        return !empty(self::$SERVER['REQUEST_URI']) ? urldecode(self::$SERVER['REQUEST_URI']) : '/';
    }

    /**
     * Return query string as an array.
     *
     * @return array
     */
    public function query()
    {
        return self::$Query;
    }

    /**
     * Return the request method.
     *
     * @return string [GET|POST|PUT|DELETE|PATCH]
     */
    public function method()
    {
        return self::$SERVER['REQUEST_METHOD'];
    }

    /**
     * Returns the base url.
     *
     * @return string
     */
    public function basename()
    {
        return rtrim(dirname(self::$SERVER['SCRIPT_NAME']), '\/');
    }

    /**
     * Return the request scheme.
     *
     * @return string [http||https]
     */
    public function scheme()
    {
        return self::$SERVER['REQUEST_SCHEME'];
    }

    /**
     * Return the server port.
     *
     * @return int [80||443]
     */
    public function port()
    {
        return intval(self::$SERVER['SERVER_PORT']);
    }

    /**
     * Return the server protocol type.
     *
     * @return string
     */
    public function protocol()
    {
        return self::$SERVER['SERVER_PROTOCOL'];
    }

    /**
     * Return the gateway interface.
     *
     * @return [type] [description]
     */
    public function gateway()
    {
        return self::$SERVER['GATEWAY_INTERFACE'];
    }
}
