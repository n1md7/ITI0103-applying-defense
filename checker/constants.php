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
define('ASSESMENT', ROOT_PATH.'student/ajax');

define('TITLE', 'SQLiLab');
define('LAB_TYPE', 'Applying');
define('TITLE_DESCR', 'SQLi challenge for level [ Applying - defense]');

