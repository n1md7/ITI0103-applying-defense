<?php
	
if(defined('LOCALHOST') && LOCALHOST == True){
        define("ROOT_PATH", "/ITI0103-level-applying-defense/checker/");
}else{
        define("ROOT_PATH", "/");
}

/*
        Root url for webpage
*/
define("ROOT_URL", $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].ROOT_PATH);

define("MAIN_PAGE", ROOT_URL);

define('HOME_AJAX', ROOT_PATH.'home/ajax');
define('HOMEINDEX', ROOT_PATH.'home/index');

define('TITLE', 'SQLiLab-defense');
define('LAB_TYPE', 'Applying-defense');
define('TITLE_DESCR', 'SQLi challenge for level [ Applying - defense]');

if(LOCALHOST == True){
	define('TARGET', 'http://localhost/ITI0103-level-applying-defense/webserver/');
}else{
	define('TARGET', 'http://192.168.8.253/');
}