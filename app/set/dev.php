<?php

return [
	'app' => [
		'url' => 'http://localhost',
		'hash' => [
			'algo' => PASSWORD_BCRYPT,
			'cost' => 10
		]
	],
	
	'db' => [
		'driver' => 'mysql',
		'host' => 'localhost',
		'database' => 'uzuria - grs',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => ''
	],
	
	'auth' => [
		'session' => 'user_id',
		'remember' => 'user_r'
	],
	
	'mail' => [
		'smtp_auth' => true,
		'smtp_secure' => 'ssl',
		'host' => 'smtp.gmail.com',
		'username' => 'costa.seem@gmail.com',
		'password' => '250299250299',
		'port' => 465,
		'html' => true
	],
	
	'twig' => [
		'debug' => true
	],
	
	'csrf' => [
		'key' => 'csrf_token'
	]
]; 

?>