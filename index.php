<?php

date_default_timezone_set("Europe/London");
require __DIR__ . '/vendor/autoload.php';
use Endroid\Twitter\Twitter;

$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function() use($app) {
	return 'Try /hello/:name';
});

$app->get('/hello/{name}', function($name) use($app) {
	return 'Hello ' . $app->escape($name);
});

$app->get('/histogram/{username}', function($username) use($app) {

	$consumer_key = "dV6IsreN1vIBQo2ipFeymv0ex";
	$consumer_secret = "RNJhrRcMHt5EWo3QKCj2q2yJfOiksVeS5Wwda6KuWeKG5ycRoW";
	$access_token = "746038941392973824-jpwcdL3WAAL1oxyrpyu6U2S8dPoaPdq";
	$access_token_secret = "KBkx3KyL9x7dSRUprURtiALQUcP7buQ1U5J1oduCXc6Fm";

	$twitter = new Twitter($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	$params = ['screen_name' => $username];

	$response = $twitter->query('statuses/user_timeline', 'GET', 'json', $params);
	$data = json_decode($response->getContent());
	$dates = [];

	$histogram = [];
	#create the histogram part:
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

	// var_dump($histogram);

	return $app->json($histogram);
});

$app->run();