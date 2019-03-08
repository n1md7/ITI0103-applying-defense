<?php

session_start();

if(!isset($_SESSION['student'])){
    if(file_exists('../../username.txt')){
        $_SESSION['student'] = trim(file_get_contents('../../username.txt'));
    }else if(file_exists('/var/www/username.txt')){
        $_SESSION['student'] = trim(file_get_contents('/var/www/username.txt'));
    }
}
require('config.php');
require('constants.php');

error_reporting(E_ALL);
ini_set('display_errors', DEBUG ? 'On' : 'Off');

foreach (['functions', 'Messages', 'Bootstrap', 'Controller', 'Model'] as $file) 
	require("classes/$file.php");

foreach (['user', 'home', 'student'] as $file):
	require("controllers/$file.php");
	require("models/$file.php");	
endforeach;

$controller = (new Bootstrap($_GET))->createController();
if($controller)
	$controller->executeAction();
