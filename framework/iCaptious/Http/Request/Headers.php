<?php

namespace iCaptious\Http\Request;

use iCaptious\Http\Cookie;

class Headers
{
    /**
     * All request Headers.
     *
     * @var mixed
     */
    protected static $RequestHeaders;

    public function __construct()
    {
        self::$RequestHeaders = self::$RequestHeaders ?? self::GetHeaders();
    }

    /**
     * Get Header Content.
     *
     * @param string $header
     *
     * @return HeaderContent iCaptious\Http\Request\HeaderContent
     */
    public function Get(string $header)
    {
        return new HeaderContent($header);
    }

    /**
     * Get all headers
     * Check if function getallheaders exists.
     * If getallheaders doesn't exist get the headers with the
     * help of the global variable $_SERVER.
     *
     * @return bool|array
     */
    public static function GetHeaders()
    {
        if (!function_exists('getallheaders')) {
            $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }

            return $headers;
        }

        return getallheaders();
    }

    public function GetCookies()
    {
        return Cookie::FromString($this->Get('COOKIE'));
    }
}
