<?php
// for challenge lab it should be false
$LOCAL = false;

if($LOCAL){
	require('./webserver/classes/functions.php');
}else{
	//in actual lab environment it wil execute from /var/www 
	require('/var/www/html/classes/functions.php');
}

//root user credentials
//if db changes then please specify here
$DB_USER = 'student_root';
$DB_PASS = 'MICRosoFT_Sucks_for_real';
$DB_HOST = '138.68.96.132';
$DB_PORT = '3306';
$DB_NAME_ROOT = 'bloom_assessment';
$username = trim(file_get_contents($LOCAL?'../username.txt':'/var/www/username.txt'));

$DB_NAME = "{$username}_level_apply_defense";
$DB_USER_NAME = "{$username}_user_apply_defense";
$DB_USER_PASS = Generate::csha1("{$DB_USER_NAME}defense");

$USER_PASS = Generate::sha512($DB_PASS.$DB_NAME.'apply_defense');

if($LOCAL){
	file_put_contents('../db_user_name.txt', $DB_USER_NAME);
	file_put_contents('../db_user_pass.txt', $DB_USER_PASS);
	file_put_contents('../db_user_host.txt', $DB_HOST);
	file_put_contents('../db_user_port.txt', $DB_PORT);
	file_put_contents('../db_name.txt', 	 $DB_NAME);
}else{
	file_put_contents('/var/www/db_user_name.txt', $DB_USER_NAME);
	file_put_contents('/var/www/db_user_pass.txt', $DB_USER_PASS);
	file_put_contents('/var/www/db_user_host.txt', $DB_HOST);
	file_put_contents('/var/www/db_user_port.txt', $DB_PORT);
	file_put_contents('/var/www/db_name.txt', 	   $DB_NAME);
}

$IS_LOCAL = $LOCAL?"true":"false";
//update config
$CONFIG = <<<CONF
<?php
	/*
		@DEBUG global variable for error reporting
	*/
	define('DEBUG', false);
	define('LOCALHOST', $IS_LOCAL);

	/*
		Database constants
		@DB_HOST - db hostname
		@DB_USER - db username
		@DB_PASS - db password
		@DB_NAME - db name
	*/
	define("DB_HOST", "$DB_HOST");
 	define('DB_USER', '$DB_USER');
 	define('DB_PASS', '$DB_PASS');
 	define('DB_NAME', '$DB_NAME_ROOT');
 	define('DB_PORT', '$DB_PORT');
CONF;
if($LOCAL){
	file_put_contents('./webserver/config.php', $CONFIG);
}else{
	file_put_contents('/var/www/html/config.php', $CONFIG);
}

try {
    $dbh = new PDO("mysql:host=$DB_HOST;DB_NAME=$DB_NAME;port=$DB_PORT", $DB_USER, $DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //create Database for current user if not exists
    $dbh->exec("CREATE DATABASE IF NOT EXISTS $DB_NAME");
    $dbh->exec("use $DB_NAME");
	$dbh->exec("DROP TABLE IF EXISTS books");
    $dbh->exec("
    	CREATE TABLE IF NOT EXISTS books (
		  id int(3) NOT NULL AUTO_INCREMENT,
		  title text NOT NULL,
		  description text NOT NULL,
		  img text NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
	$dbh->exec("INSERT INTO books (title, description, img) VALUES ('Twilight', 'Bella Swan moves to Forks and encounters Edward Cullen, a gorgeous boy with a secret.', 'twilight.jpg')");
	$dbh->exec("INSERT INTO books (title, description, img) VALUES ('Harry Potter and the Sorcerer\'s Stone (2001)', 'An orphaned boy enrolls in a school of wizardry, where he learns the truth about himself, his family and the terrible evil that haunts the magical world.', 'harrypotter.jpg')");
	$dbh->exec("INSERT INTO books (title, description, img) VALUES ('Harry Potter and the Prisoner of Azkaban (2004)', 'It\'s Harry\'s third year at Hogwarts; not only does he have a new \'Defense Against the Dark Arts\' teacher, but there is also trouble brewing. Convicted murderer Sirius Black has escaped the Wizards\' Prison and is coming after Harry.', 'harry_azkaban.jpg')");
	$dbh->exec("INSERT INTO books (title, description, img) VALUES ('Harry Potter and the Goblet of Fire (2005)', 'A young wizard finds himself competing in a hazardous tournament between rival schools of magic, but he is distracted by recurring nightmares.', 'goblet.jpg')");
	$dbh->exec("INSERT INTO books (title, description, img) VALUES ('Harry Potter and the Order of the Phoenix (2007)', 'With their warning about Lord Voldemort\'s return scoffed at, Harry and Dumbledore are targeted by the Wizard authorities as an authoritarian bureaucrat slowly seizes power at Hogwarts.', 'phoenix.jpg')");

	$dbh->exec("DROP TABLE IF EXISTS users");
	$dbh->exec("
		CREATE TABLE IF NOT EXISTS users (
		  id int(3) NOT NULL AUTO_INCREMENT,
		  user varchar(22) NOT NULL,
		  pass varchar(150) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;


		INSERT INTO users (user, pass) VALUES ('admin', '$USER_PASS');

		ALTER TABLE books
		  ADD PRIMARY KEY (id);

		ALTER TABLE users
		  ADD PRIMARY KEY (id);

		ALTER TABLE books
		  MODIFY id int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
		ALTER TABLE users
		  MODIFY id int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
    ");
    //create db user for this lab user
    $dbh->exec("CREATE USER IF NOT EXISTS '$DB_USER_NAME'@'%' IDENTIFIED BY '$DB_USER_PASS';");
	//grant privileges to this db user, only select and insert
	$dbh->exec("GRANT SELECT, INSERT ON $DB_NAME.* TO '$DB_USER_NAME'@'%';");
}catch(PDOException $e){
	if($LOCAL)echo $e;
	else file_put_contents('/var/www/sqlcommand.log', $e);
}
