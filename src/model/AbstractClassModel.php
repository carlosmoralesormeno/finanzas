<?php
require_once 'model/InterfaceModel.php';
require_once 'config/functions.php';
require_once 'controller/ExecutorController.php';
require_once 'controller/ModelController.php';

abstract class AbstractClassModel implements InterfaceModel{

	abstract public function table();

    public function __Construct(){
		$this->executor	= new ExecutorController(); 
		$this->model 	= new ModelController(); 
		$this->function = new Functions(); 
	}

    public function Insert($data){
		$table 			= $this->table();
		$columns 		= implode(", ",array_keys($data));
		$escaped_values = $this->function->escaped_values(array_values($data));
		$values  		= implode("', '", $escaped_values);
		$sql 			= "INSERT INTO {$table} ({$columns}) VALUES ('$values')";
		return 			$this->executor->doit($sql);

	}

	public function Update($data, $id){
		$table 		= $this->table();
		$values 	= $this->function->mapped_implode(", ", $data, " = ");
		$sql 		= "UPDATE {$table} SET {$values} WHERE ID = {$id}";
		return 		$this->executor->doit($sql);
	}

	public function Delete($id){
		$table 	= $this->table();
		$sql 	= "DELETE FROM {$table} WHERE ID = {$id}";
		return 	$this->executor->doit($sql);
	}

	public function All($filter = NULL) {
		$table 		= $this->table();
        if($filter){
          $filter 	= ' WHERE '. $filter;
        }
        $sql 	= "SELECT * FROM {$table} {$filter}";
		$query 	= $this->executor->doit($sql);
		return 	$this->model->Many($query[0]);
    }

	public function One($id = 0, $filter = NULL) {
		$table 		= $this->table();
        if($filter){
          $filter 	= ' AND '. $filter;
        }
		$sql 	= "SELECT * FROM {$table} WHERE id = {$id} {$filter}";
		$query 	= $this->executor->doit($sql);
		return 	$this->model->one($query[0]);
    }
}