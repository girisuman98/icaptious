<p align="center"><a href="https://www.icaptious.com" target="_blank"><img width="40" height="40" alt="iCaptious" src="https://icaptious.com/app/media/logo/ic_logo.png"></a></p>

<p align="center">
<a href="https://travis-ci.org/icaptious/icaptious"><img src="https://api.travis-ci.org/icaptious/icaptious.svg" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/icaptious/icaptious/"><img src="https://scrutinizer-ci.com/g/icaptious/icaptious/badges/quality-score.png" alt="Code Quality"></a>
<a href="https://gitter.im/iCaptious/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge"><img src="https://badges.gitter.im/iCaptious/Lobby.svg" alt="Code Quality"></a>
</p>

## About iCaptious

* Project page: http://developers.icaptious.com/icaptious/
* Repository: https://github.com/icaptious/icaptious
* Version: 1.0.0
* License: MIT, see [LICENSE](LICENSE)

## Description

iCaptious is an Open Source Framework built for PHP, which makes prgramming easier.
iCaptious provides plugins for third-party integration with itself.

## Installation

### Direct download (no Composer)

If you wish to install the framework manually (i.e. without Composer), then you
can use the links on the main project page to either clone the repo or download
the [ZIP file](https://github.com/icaptious/icaptious/archive/master.zip). For
convenience, an autoloader script is provided in `autoload.php` which you
can require into your script instead of Composer's `vendor/autoload.php`. For
example:

```php
//Composer
Require('/path/to/icaptious/vendor/autoload.php');
//
//Self-Made Autoload Script
Require('/path/to/icaptious/autoload.php');

use iCaptious\Core\Route;

Route::Get("/", function(){
   echo "Hello World!";
});

```

### Using "git clone" comand in the comand line

You can also clone this repository using the git comand.
All you need is to install Git Bash into your operation system (Linux, Mac, Windows).
Just type in the comand line ```git clone https://github.com/icaptious/icaptious``` and you're good to go. 

## Server Requirements

PHP version 5.6 or newer is recommended.

## Usage

First, require the autoload file `autoload.php`

iCaptious Routing library can do many requests as Redirect, Secure SSL Connection, process GET, POST, PUT etc requests.
For example:
```php
<?php
use iCaptious\Core\Route;

// run this function if the domain was requested
Route::Domain("icaptious.com", function(){ 

	/*
	 * Secure the connection for this domain
	 * by default if is not secured already.
	 */
	Route::Secure();

	echo "<h1>Welcome to icaptious.com :)</h1>";

	// Route for GET Request Method
	Route::Get("/", function(){
	   echo "Hello World!";
	});

	// Route for POST Request Method
	Route::Post("/", function(){
	   echo "Hello World!";
	});

	// Route for PUT Request Method
	Route::Put("/", function(){
	   echo "Hello World!";
	});

	// Route for all Request Methods
	Route::All("/", function(){
	   echo "Hello World!";
	});

	/*
	 * Route groups allow you to share route attributes, such as middleware 
	 * or namespaces, across a large number of routes without needing to define those attributes on each 
	 * individual route. Shared attributes are specified in an array format as the first parameter 
	 * to the Route::Group method
	 */ 
	Route::Group("user/profile", function(){
	   Route::Get("{username}", function($username){
	   	echo "Profile Page for the user {$username}";
	   });
	});
});
```

## Contributing

We are an open Community and appreciate your contributions via GitHub Pull Requests.

## License

This framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
