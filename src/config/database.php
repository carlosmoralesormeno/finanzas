<?php

class Database {

	private $user;
	private $pass;
	private $host;
	private $ddbb;

	function __Construct(){
		$this->host = "mysql_db";
		$this->user = "user";
		$this->pass = "1234";
		$this->ddbb = "dbchallenge";
	}

	function connect(){
		$mysqli = new mysqli($this->host,$this->user,$this->pass,$this->ddbb);
		mysqli_set_charset($mysqli,"utf8");
		return $mysqli;
	}

	public function get_connect(){
		$connect = $this->connect();
        if (!$connect->connect_error) {
            return $connect;
        }else{
			echo 'Error en la conexión a la base de datos';
            exit();
        }
	}

}

?>