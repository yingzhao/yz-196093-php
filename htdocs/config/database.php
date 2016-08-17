<?php

//Get Bluemix database access details
// THIS IS THE BLUEMIX DATABASE STUFF
 $services = json_decode(getenv('VCAP_SERVICES'), true);
 // echo("SERVICES: " + $services);
 $sqlCreds = $services['user-provided'][0]['credentials'];

return [

	/*
	|--------------------------------------------------------------------------
	| PDO Fetch Style
	|--------------------------------------------------------------------------
	|
	| By default, database results will be returned as instances of the PHP
	| stdClass object; however, you may desire to retrieve records in an
	| array format for simplicity. Here you can tweak the fetch style.
	|
	*/

	'fetch' => PDO::FETCH_CLASS,

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work. Of course
	| you may use many connections at once using the Database library.
	|
	*/

	'default' => 'mysql',

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|



	*/

	
 'connections' => [

 		'mysql' => [
 	   'driver'    => 'mysql',
       'host'      => $sqlCreds['hostname'],
       'database'  => $sqlCreds['name'],
       'username'  => $sqlCreds['username'],
       'password'  => $sqlCreds['password'],
 			'charset'   => 'utf8',
 			'collation' => 'utf8_unicode_ci',
 			'prefix'    => '',
 			'strict'    => false,
 		],

 	],

//	'connections' => [
//
//		'mysql' => [
//			'driver'    => 'mysql',
//    'host'      => env('DB_HOST', 'us-cdbr-iron-east-03.cleardb.net'),
//      'database'  => env('DB_DATABASE', 'ad_7bc1ee7176cf06a'),
//      'username'  => env('DB_USERNAME', 'b7eec383b4ae74'),
//      'password'  => env('DB_PASSWORD', '543ca390'),
//			'charset'   => 'utf8',////////
//			'collation' => 'utf8_unicode_ci',
//			'prefix'    => '',
//			'strict'    => false,
//		],
//
//	],

	/*
	|--------------------------------------------------------------------------
	| Migration Repository Table
	|--------------------------------------------------------------------------
	|
	| This table keeps track of all the migrations that have already run for
	| your application. Using this information, we can determine which of
	| the migrations on disk haven't actually been run in the database.
	|
	*/

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => [

		'cluster' => false,

		'default' => [
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		],

	],

];
