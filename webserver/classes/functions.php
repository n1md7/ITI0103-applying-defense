<?php
/**
* genereta sha1 userpassword
*/
class Generate{
	public static function csha1($sha1){
		$salt = array(":)(.","(.)(:)");
		return sha1($salt[0].$sha1.$salt[1]);
	}
	public static function sha512($sha512){
		$salt = array("Tr@()","mU4b!");
		return 'HTB{'.hash('sha512', $salt[0].$sha512.$salt[1]).'}';
	}
	public static function csrf($len = 32, $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", $csrf = ""){
		for($k = 0; $k < $len; $k ++)
			$csrf .= $str[ rand( 0, strlen($str) - 1 ) ];
		
		$_SESSION['csrf'] = $csrf;

		//delay randomly 0-2 seconds
		usleep(rand(0,99) * 10000);

		return $csrf;
	}
	public static function rndChar($chars){
		return $chars[rand(0, strlen($chars) - 1)];
	}
}
 
class Count{
	public static function char($string, $char, $counter = 0){
		for( $i = 0; $i < strlen($string); $i ++){
			if ($string[$i] == $char){
				$counter ++;
			}
		}
		return $counter;
	}
}

/**
* 
*/
class Encode{
	public static function json($dt){
		$arr = ['csrf' => Generate::csrf()];
		exit(
			json_encode(array_merge($arr, $dt))
		);
	}	
}


class Curl{
	public static function send($url, $data){
		/*
			if I move to server may not work.
			and the I have to install php-curl there
			sudo apt-get install php-curl
		*/
		// Get cURL resource
		try{

			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => $url,
			    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => $data
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);

		} catch (Exception $e) {}


	}
}

class Client{
	public static function ip(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}




class Captcha
{
	
	function __construct()
	{
		$this->template = array(
				'%s plus %s',
				'Square of %s',
				'If u were born %s years ago, how old would u be?',
				'%s multiply %s'
			);
	}

	public function genereate(){
		$tIndex = rand(0, sizeof($this->template) - 1);

		switch($tIndex){
			case 0:
				$f = rand(0,10);
				$l = rand(0,10);
				$this->question = sprintf($this->template[0], $f, $l);
				$this->answer = $f + $l;
				break;
			case 1:
				$f = rand(0,10);
				$this->question = sprintf($this->template[1], $f);
				$this->answer = pow($f, 2);
				break;
			case 2:
				$f = rand(0,20);
				$this->question = sprintf($this->template[2], $f);
				$this->answer = $f;
				break;
			case 3:
				$f = rand(0,10);
				$l = rand(0,10);
				$this->question = sprintf($this->template[3], $f, $l);
				$this->answer = $f * $l;
				break;

		}
	}

	public function getQuestion(){
		return $this->question;
	}

	public function getAnswer(){
		return $this->answer;
	}
}


class Restrict{

	public static function isloggedin(){
		return !isset($_SESSION["islogged_in"])?False:True;
	}

	public static function view(){
		if(!Restrict::isloggedin()):
			header('Location: '.USER_SIGN_IN);
			exit(':)');
		endif;
	}
}



function isDefined($var){
	if(!isset($post[$var]) || empty($post[$var])){
		return true;
	}
	return false;
}