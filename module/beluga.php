<?php
/**
 * 認証URL：http://beluga.fm/authorize?app_id=52
 * コールバックURL：http://localhost/beluga/
 */
class Beluga {
	private $app_id,$app_secret;
	private $user_id,$user_token;

	function __construct($id,$token){
		$this->app_id = '52';
		$this->app_secret = 'NDUxZWE0YzFlZjdhNTBhNDc2MTU1Zjk5NmM1YjI5MWY0NGNiOGZmYgXX';
		$this->user_id = $id;
		$this->user_token = $token;
	}

	function isConnect(){
		return count($this->home()) >0;
	}

	function home($since_id='0'){
		$url = 'http://api.beluga.fm/1/statuses/home?app_id='.$this->app_id
				.'&app_secret='.$this->app_secret.'&user_id='.$this->user_id.'&user_token='.$this->user_token
				.'&since_id='.$since_id;
		return json_decode(@file_get_contents($url),true);
	}

	function update($text,$room_hash){
		$url = 'http://api.beluga.fm/1/statuses/update?app_id='.$this->app_id
				.'&app_secret='.$this->app_secret.'&user_id='.$this->user_id.'&user_token='.$this->user_token
				.'&text='.urlencode($text).'&room_hash='.urlencode($room_hash);
		return json_decode(@file_get_contents($url),true);
	}

	function room($room_hash,$since_id='0'){
		$url = 'http://api.beluga.fm/1/statuses/room?app_id='.$this->app_id
				.'&app_secret='.$this->app_secret.'&user_id='.$this->user_id.'&user_token='.$this->user_token
				.'&since_id='.$since_id.'&room_hash='.urlencode($room_hash);
		return json_decode(@file_get_contents($url),true);
	}

	function mentions(){
		$url = 'http://api.beluga.fm/1/statuses/mentions?app_id='.$this->app_id
				.'&app_secret='.$this->app_secret.'&user_id='.$this->user_id.'&user_token='.$this->user_token;
		return json_decode(@file_get_contents($url),true);
	}

	function following(){
		$url = 'http://api.beluga.fm/1/account/following?app_id='.$this->app_id
				.'&app_secret='.$this->app_secret.'&user_id='.$this->user_id.'&user_token='.$this->user_token;
		return json_decode(@file_get_contents($url),true);
	}
}
?>
