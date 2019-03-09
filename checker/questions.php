<?php
if(file_exists('../../flag.txt')){
    $flag = trim(file_get_contents('../../flag.txt'));
}else if(file_exists('/var/www/flag.txt')){
    $flag = trim(file_get_contents('/var/www/flag.txt'));
}
// echo ROOT_URL.'home/ajax';
return array(
	'description' => 'In this challenge lab you need to answer all the question which can be found in Flag submission tab. <br>If you face any technical problem here, you can always try to open lab (<b>192.168.8.254</b>) in <b>fireforx</b>.',
	'questions' => [
		'Who are you?',
	],
	'answers' => [
		'dude'
	],
	'hints' => [
		'Try 2 Google 😁'
	]
);



