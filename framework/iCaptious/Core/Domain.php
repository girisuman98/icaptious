<?php

namespace iCaptious\Core;

use iCaptious\Core\Func\Call;

class Domain
{
    public function __construct($Domain)
    {
        if ($_SERVER['REMOTE_ADDR'] == $Domain) {
            return $this;
        }
    }

    /**
     * Checks if the website is in Secure mode and tries to redirect to Secure mode.
     */
    public static function Secure()
    {
        Call::Func(__NAMESPACE__.'\Domain::Security');
    }

    /**
     * Checks if the website is not in Secure mode and tries to redirect to Insecure mode.
     */
    public static function inSecure()
    {
        Call::FuncArr(__NAMESPACE__.'\Domain::Security', [0 => false]);
    }

    public static function Security(bool $valid = true)
    {
        $HTTPS = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off');
        if (!$HTTPS && $valid) {
            $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$redirect);
        } elseif ($HTTPS && !$valid) {
            $redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$redirect);
        }
    }
}
