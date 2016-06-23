<?php

date_default_timezone_set("UTC");
require_once __DIR__ . '/../vendor/autoload.php';
use Endroid\Twitter\Twitter;


$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function() use($app) {
	return 'Try /hello/:name';
});

$app->get('/hello/{name}', function($name) use($app) {
	return 'Hello ' . $app->escape($name);
});

$app->get('/histogram/{screen_name}', function($screen_name) use($app) {
	//load the twitter config file
	require_once __DIR__ . '/../twitter_conf.php';

	$twitter = new Twitter($twitter_conf['consumer_key'], $twitter_conf['consumer_secret'], $twitter_conf['access_token'], $twitter_conf['access_token_secret']);

	$params = ['screen_name' => $screen_name];
	$response = $twitter->query('statuses/user_timeline', 'GET', 'json', $params);
	$data = json_decode($response->getContent());
	$dates = [];

	$histogram = [];
	//set up the histogram assoc. array:
	for ($i=0; $i < 24; $i++) { 
		// initialise each hour with a value of 0 tweets:
		$histogram[strval($i) . ":00"] = 0;
	}

	foreach ($data as $tweet) {
		$date_created = strtotime($tweet->created_at);
		$hour = strval((int) date('H', $date_created)) . ":00";
		if(array_key_exists($hour, $histogram)) {
			$histogram[$hour] += 1;	
		} else {
			$histogram[$hour] = 1;
		}
	}

	return $app->json($histogram);
});

$app->run();