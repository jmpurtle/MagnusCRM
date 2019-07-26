<?php
// Settings file
return array(
	// Filesystem
	'serverRoot' => dirname(__DIR__),
	'vendors'    => dirname(__DIR__) . '/vendor',
	'assets'     => dirname(__DIR__) . '/public/assets',

	// Application
	'debug' => false,

	// Database
	'dbDrivers' => array(
		'mysql' => array(
			'host' => 'localhost',
			'port' => '3306',
			'name' => 'tablename',
			'user' => 'sample',
			'pass' => 'sample'
		)
	)
);