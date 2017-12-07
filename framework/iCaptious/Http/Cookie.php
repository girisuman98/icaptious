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
    protected $httpOnly;
    private $raw;
    private $sameSite;


	public function __construct($Cookie) {

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

	public static function FromString($CookieString, $decode = false){
		$placeholder = array(
            'expires' => 0,
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httponly' => false,
            'raw' => !$decode,
            'samesite' => null,
        );
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
        $str = ($this->Raw() ? $this->Name() : urlencode($this->Name())).'=';
        if ('' === (string)$this->getValue()) {
            $str .= 'deleted; expires='.gmdate('D, d-M-Y H:i:s T', time() - 31536001).'; max-age=-31536001';
        } else {
            $str .= $this->isRaw() ? $this->getValue() : rawurlencode($this->getValue());
            if (0 !== $this->getExpiresTime()) {
                $str .= '; expires='.gmdate('D, d-M-Y H:i:s T', $this->getExpiresTime()).'; max-age='.$this->getMaxAge();
            }
        }
        if ($this->Path()) {
            $str .= '; path='.$this->Path();
        }
        if ($this->Domain()) {
            $str .= '; domain='.$this->Domain();
        }
        if (true === $this->Secure()) {
            $str .= '; secure';
        }
        if (true === $this->HttpOnly()) {
            $str .= '; httponly';
        }
        if (null !== $this->SameSite()) {
            $str .= '; samesite='.$this->getSameSite();
        }
        return $str;
    }
}