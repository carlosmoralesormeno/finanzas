<?php
require_once 'config/database.php';

class Functions {

    private $db;

    public function __Construct(){
		$this->db = new Database(); 
	}

    public function mapped_implode($glue, $array, $symbol = '=') {
		return implode($glue, array_map(
				function($k, $v) use($symbol) {
					return $k . $symbol . "'".$v."'";
			},
			array_keys($array),
			$this->escaped_values(array_values($array))
			)
		);
	}

	public function escaped_values($data){
		return array_map(function( $e ) {
			return mysqli_real_escape_string($this->db->get_connect(), $e);
   		}, $data);
	}

}

?>