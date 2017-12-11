<?php

namespace iCaptious\Core\Func;

class Str
{
    /**
     * Replace the given string with another string
     * in a string variable.
     *
     * @param string $search  string to replace
     * @param string $replace the replacement
     * @param string $str     string variable
     *
     * @return string
     */
    public static function Replace($search, $replace, $str)
    {
        return str_replace($search, $replace, $str);
    }

    /**
     * Determine if the given string contains the given substring.
     *
     * @param string $haystack string
     * @param string $needle   substring
     *
     * @return bool
     */
    public static function Contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Determine if the given string starts with the given substring.
     *
     * @param string $haystack string
     * @param string $needle   substring
     *
     * @return bool
     */
    public static function StartsWith($haystack, $needle)
    {
        $length = static::Length($needle);

        return substr($haystack, 0, $length) === $needle;
    }

    /**
     * Determine if the given string ends with the given substring.
     *
     * @param string $haystack string
     * @param string $needle   substring
     *
     * @return bool
     */
    public static function EndsWith($haystack, $needle)
    {
        $length = static::Length($needle);

        return $length === 0 || (substr($haystack, -$length) === $needle);
    }

    /**
     * Return the length of the given string.
     *
     * @param string $string
     *
     * @return int
     */
    public static function Length($str)
    {
        return strlen($str);
    }

    /**
     * Convert the string to lower-case.
     *
     * @param string $str
     *
     * @return string
     */
    public static function Lower($str)
    {
        return strtolower($str);
    }

    /**
     * Convert the string to upper-case.
     *
     * @param string $str
     *
     * @return string
     */
    public static function Upper($str)
    {
        return strtoupper($str);
    }

    /**
     * Change string's first character uppercase.
     *
     * @param string $str
     *
     * @return string
     */
    public static function Ucfirst($str)
    {
        return function_exists('ucfirst') ?
            ucfirst($str) :
            static::Upper(substr($str, 0, 1)).substr($str, 1);
    }

    /**
     * Generate a random string
     *
     * @param int $length
     * @return string
     */
    public function Random($length)
    {
        $seed = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789';
        $max = strlen($seed) - 1;
        $string = '';
        for ($i = 0; $i < $length; ++$i) {
            $string .= $seed{intval(mt_rand(0.0, $max))};
        }
        return $string;
    }
}
