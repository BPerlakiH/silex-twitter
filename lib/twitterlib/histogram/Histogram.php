<?php

namespace TwitterLib\Histogram;

use Endroid\Twitter\Twitter;
use Exception;

class Histogram {

	/**
	* @var Twitter
	*/
	private $_twitter;
	/**
	* @var array - associative array to store tweets counts for each hour e.g.: 09:00 => 197, 10:00 => 55, ...
	*/
	private $_hourCount = [];

	public function __construct(array $twitter_conf) {
		$this->_twitter = new Twitter($twitter_conf['consumer_key'], $twitter_conf['consumer_secret'], $twitter_conf['access_token'], $twitter_conf['access_token_secret']);
	}

	/**
	* @param Twitter $screen_name 	user's screen name
	* @param int $tweet_count 		the amount of tweets we want our stats to be based on
	*/
	public function getHistogramFor($screen_name, $tweet_count = 200) {
		$params = ['screen_name' => $screen_name, 'count' => $tweet_count];
		$response = $this->_twitter->query('statuses/user_timeline', 'GET', 'json', $params);
		$content_string = $response->getContent();
		$content = json_decode($content_string);
		//check twitter's response:
		if($response->getStatusCode() === 200) {
			return $this->_getTweetCount($content);
		} else {
			throw new Exception('Twitter error: ' . $content_string);
		}
	}
	

	/**
	* Get stats on amount of tweets in each hour
	*/
	private function _getTweetCount(array $tweets) {
		$hourCount = $this->_getNewHourCount();
		foreach ($tweets as $tweet) {
			$date_created = strtotime($tweet->created_at);
			$hour = $this->_getKeyFromHour((int) date('H', $date_created));
			if(array_key_exists($hour, $hourCount)) {
				$hourCount[$hour] += 1;
			} else {
				$hourCount[$hour] = 1;
			}
		}
		return $hourCount;
	}

	/**
	* Initialise each hour with a value of 0 tweets:
	*/
	private function _getNewHourCount() {
		$hourCount = [];
		for ($i=0; $i < 24; $i++) { 
			$hourCount[$this->_getKeyFromHour($i)] = 0;
		}
		return $hourCount;
	}

	/**
	* Creates string keys from hour values that can be used in an assoc. array
	* @param all $hour
	* @return string hour value as a string
	*/
	private function _getKeyFromHour($hour) {
		return strval($hour) . ":00";
	}

}