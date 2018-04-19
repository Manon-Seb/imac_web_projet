<?php
// twitter access

require 'twitter/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterAPICall {

	/* ---- API AUTHENTIFICATION PROPERTIES ---- */

	// twitter API keys
	// TODO: (documentation) qu'est-ce qu'une apiKey?
	private static $apiKey = null;
	private static $apiSecret = null;

	// twitter API token
	// TODO: (documentation) qu'est-ce qu'un accessToken?
	private static $accessToken = null;
	private static $accessTokenSecret = null;

	// active api connection
	private static $connection;

	// query parameters
	private static $regionCode = 'en';
	private static $resultType = "recent";
	private static $resultCount = 100;


	/* --- API AUTHENTIFICATION METHODS --- */

	// set secret keys and token
	public static function setAPIAccessToken($apiKey, $apiSecret, $accessToken, $accessTokenSecret) {
		self::$apiKey = $apiKey;
		self::$apiSecret = $apiSecret;
		self::$accessToken = $accessToken;
		self::$accessTokenSecret = $accessTokenSecret;
	}

	// establish connection to twitter api
	public static function connect() {
		self::$connection = new TwitterOAuth(
			self::$apiKey, 
			self::$apiSecret, 
			self::$accessToken, 
			self::$accessTokenSecret
		);
	}




	/* ---- API CALL PROPERTIES ---- */

	private $tweets = null;



	/* ---- GETTERS ----- */

	public function getTweetCount() {
		return count($this->tweets);
	}


	
	/* ---- CONSTRUCTOR ---- */

	public function __constructor($subject = 'e') {
		$this->tweets = self::$connection->get(
			"search/tweets", 
			[
				"q" => $subject, 
				"lang" => self::regionCode, 
				"result_type" => self::result_type, 
				"count" => self::resultCount
			]
		);
	}

}