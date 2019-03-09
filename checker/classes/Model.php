<?php
class Model{
	protected $dbh;
	protected $stmt;

	public function __construct($db_host = null, $db_name = null, $db_user = null, $db_pass = null, $db_port = null){
		try{
			if(null === $db_host)$db_host = DB_HOST;
			if(null === $db_name)$db_name = DB_NAME;
			if(null === $db_user)$db_user = DB_USER;
			if(null === $db_pass)$db_pass = DB_PASS;
			if(null === $db_port)$db_port = DB_PORT;
			$this->dbh = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8;port=$db_port;", $db_user, $db_pass);
		}
		catch(PDOException $e){
		    die(DEBUG?$e->getMessage():'');
		}
	}

	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}

	//Binds the prep statement
	public function bind($param, $value, $type = null){
 		if (is_null($type)) {
  			switch (true) {
    			case is_int($value):
      				$type = PDO::PARAM_INT;
      				break;
    			case is_bool($value):
      				$type = PDO::PARAM_BOOL;
      				break;
    			case is_null($value):
      				$type = PDO::PARAM_NULL;
      				break;
    				default:
      				$type = PDO::PARAM_STR;
  			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

	public function execute(){
		$this->stmt->execute();
	}

	public function resultSet(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}

	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function rowCount(){
		$this->execute();
		return $this->stmt->rowCount();
	}
}



