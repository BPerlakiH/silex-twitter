<?php

date_default_timezone_set("UTC");
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/twitterlib/histogram/Histogram.php';

use Endroid\Twitter\Twitter;
use TwitterLib\Histogram\Histogram;
use Symfony\Component\HttpFoundation\Response;


$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function() use($app) {
	return 'Try /hello/:name';
});

$app->get('/hello/{name}', function($name) use($app) {
	return 'Hello ' . $app->escape($name);
});

$app->get('/histogram/{screen_name}', function($screen_name) use($app) {
	//load the twitter config containg the authentication details
	require_once __DIR__ . '/../twitter_conf.php';
	$histogram = new Histogram($twitter_conf);
	try {
		$data = $histogram->getHistogramFor($screen_name, 200);
		return $app->json($data);
	} catch (Exception $e) {
		return new Response($e->getMessage(), 404);
	}
});

$app->run();