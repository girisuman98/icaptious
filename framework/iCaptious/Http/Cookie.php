<?php

namespace iCaptious\Http;

class Cookie
{
    protected $name;
    protected $value;
    protected $domain;
    protected $expire;
    protected $path;
    protected $secure;
    protected $HttpOnly;
    private $raw;
    private $SameSite;

    public function __construct($Cookie)
    {

        // from PHP source code
        if (preg_match("/[=,; \t\r\n\013\014]/", $Cookie['name'])) {
            throw new \InvalidArgumentException("The cookie name \"$Cookie[name]\" contains invalid characters.");
        }

        if (empty($Cookie['name'])) {
            throw new \InvalidArgumentException('The cookie name cannot be empty.');
        }

        // convert expiration time to a Unix timestamp
        if ($expire instanceof \DateTimeInterface) {
            $expire = $expire->format('U');
        } elseif (!is_numeric($expire)) {
            $expire = strtotime($expire);
            if (false === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.');
            }
        }

        foreach ($Cookie as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function FromString($CookieString, $decode = false)
    {
        $placeholder = [
            'expires'  => 0,
            'path'     => '/',
            'domain'   => null,
            'secure'   => false,
            'httponly' => false,
            'raw'      => !$decode,
            'samesite' => null,
        ];
        foreach (explode(';', $CookieString) as $part) {
            if (false === strpos($part, '=')) {
                $key = trim($part);
                $value = true;
            } else {
                list($key, $value) = explode('=', trim($part), 2);
                $key = trim($key);
                $value = trim($value);
            }
            if (!isset($placeholder['name'])) {
                $placeholder['name'] = $decode ? urldecode($key) : $key;
                $placeholder['value'] = true === $value ? null : ($decode ? urldecode($value) : $value);
                continue;
            }
            switch ($key = strtolower($key)) {
                case 'name':
                case 'value':
                    break;
                case 'max-age':
                    $placeholder['expires'] = time() + (int) $value;
                    break;
                default:
                    $placeholder[$key] = $value;
                    break;
            }
        }

        return new self($placeholder);
    }

    /**
     * Returns the cookie as a string.
     *
     * @return string The cookie
     */
    public function __toString()
    {
        $str = ($this->IsRaw() ? $this->GetName() : urlencode($this->GetName())).'=';
        if ('' === (string) $this->GetValue()) {
            $str .= 'deleted; expires='.gmdate('D, d-M-Y H:i:s T', time() - 31536001).'; max-age=-31536001';
        } else {
            $str .= $this->IsRaw() ? $this->GetValue() : rawurlencode($this->GetValue());
            if (0 !== $this->GetExpireTime()) {
                $str .= '; expires='.gmdate('D, d-M-Y H:i:s T', $this->GetExpireTime()).'; max-age='.$this->GetMaxAge();
            }
        }
        if ($this->GetPath()) {
            $str .= '; path='.$this->GetPath();
        }
        if ($this->GetDomain()) {
            $str .= '; domain='.$this->GetDomain();
        }
        if (true === $this->IsSecure()) {
            $str .= '; secure';
        }
        if (true === $this->iSHttpOnly()) {
            $str .= '; httponly';
        }
        if (null !== $this->SameSite()) {
            $str .= '; samesite='.$this->SameSite();
        }

        return $str;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function GetValue()
    {
        return $this->value;
    }

    public function GetDomain()
    {
        return $this->domain;
    }

    public function GetPath()
    {
        return $this->path;
    }

    public function GetExpireTime()
    {
        return $this->expire;
    }

    public function GetMaxAge()
    {
    }

    public function IsRaw()
    {
        return $this->raw ?? false;
    }

    public function IsSecure()
    {
        return $this->secure ?? false;
    }

    public function IsHttpOnly()
    {
        return $this->HttpOnly ?? false;
    }

    public function SameSite()
    {
        return $this->SameSite ?? false;
    }
}
