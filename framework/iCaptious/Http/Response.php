<?php
namespace iCaptious\Http;

use iCaptious\Http\Request\Headers;

class Response
{
	
	protected $Version;

	protected $StatusCode;

	protected $StatusText;

	/**
     * iCaptious\Http\Request\Headers
     * @var Headers
     */
    protected static $Headers;

	/**
     * Status codes text table.
     *
     * The list of codes is complete according to the 
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status HTTP response status codes
     * @var array
     */
    protected static $StatusTexts = array(
    	// Information responses
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // WebDAV

        // Successful responses
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // WebDAV
        208 => 'Already Reported',      // WebDAV
        226 => 'IM Used',

        // Redirection messages
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        // Client error responses
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',										// WebDAV
        423 => 'Locked',													// WebDAV
        424 => 'Failed Dependency',											// WebDAV
        425 => 'Reserved for WebDAV advanced collections expired proposal',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',

        // Server error responses
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    );

	public function __construct(){
		self::$Headers 	= self::$Headers ?? (new Headers());
	}

	/**
     * Sends HTTP headers.
     *
     * @return $this
     */
    public function SendHeaders()
    {
        // headers have already been sent
        if (headers_sent()) {
            return $this;
        }

        header("HTTP/".$this->Version." ".$this->StatusCode." ".$this->StatusText, true, $this->StatusCode);

        foreach ($this->Headers->GetCookies() as $cookie) {
            setcookie($cookie->Name(), $cookie->Value(), $cookie->ExpiresTime(), $cookie->Path(), $cookie->Domain(), $cookie->Secure(), $cookie->HttpOnly());
        }
        return $this;
    }
}