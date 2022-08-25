<?php

abstract class AbstractClassController {
    public $Entity;
    public $view;
    
    abstract public function entity();
    abstract public function data();    

    public function __construct() {
        
        $object = $this->entity();
        require_once("model/".$this->entity().".php");
        $this->Entity = new $object();
        $this->view = 'show';
    } 

    public function view($view = NULL) {
        require_once('view/'.$this->entity().'/'.$view.'.php'); 
    }

    /** CRUD */

    public function save_json(){
		header('Content-Type: application/json');

        $data           = $this->data();
        $response_id    = $this->get_id();

		if ($response_id && $data) {
			$this->Entity->Update($data, $response_id);
		} elseif ($data) {
			$result = $this->Entity->Insert($data);
		}

		$id = $_POST['id'] ? $_POST['id'] : $result[1];

		$json = [
            'type' 	=> $this->Entity(),
            'id' 	=> (string) $id,
            'attributes' => [$data],
            'links'	=> [
                'self' => 'index.php?view='.$this->Entity().'&action=get_json&datatype=json&id='.$id,
            ]
        ];

		echo json_encode($json); 
	}

	public function get_json(){
		header('Content-Type: application/json');

		$id  	= $_GET['id'];
		$data	= $this->one($id);
		
		$json = [
            'type' 	=> $this->Entity(),
            'id' 	=> (string) $id,
            'attributes' => [$data],
            'links'	=> [
                'self' => 'index.php?view='.$this->Entity().'&action=get_json&datatype=json&id='.$id,
            ]
        ];

		echo json_encode($json); 
	}

	public function delete_json(){
		header('Content-Type: application/json');

		$id  	= $_GET['id'];
		$data	= $this->delete($id);
		
		$json = [
            'type' 	=> $this->Entity(),
            'id' 	=> (string) $id,
            'attributes' => [$data],
            'links'	=> [
                'self' => 'index.php?view='.$this->Entity().'&action=get_json&datatype=json&id='.$id,
            ]
        ];

		echo json_encode($json); 
	}

    public function get_id() {
        $id = $_POST['id'] ? $_POST['id'] : 0;
        $response = $id ? $this->one($id) : FALSE;      
        return $response->id;
    }

    public function one($id, $filter = NULL) {
        return $this->Entity->One($id, $filter);
    }

	public function many($filter = NULL) {
        return $this->Entity->All($filter);
    }
	
	public function delete($id = 0, $filter = NULL) {
        return $this->Entity->Delete($id,$filter);
    }

}

?>