<?php

date_default_timezone_set("Europe/London");

require __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function() use($app) {
	return 'Try /hello/:name';
});

$app->get('/hello/{name}', function($name) use($app) {
	return 'Hello ' . $app->escape($name);
});

$app->get('/histogram/{username}', function($username) use($app) {
	
});

$app->run();