<?php 

class FinanceController{
	public $page_title;
	public $view;

	public function __construct() {
		$this->view 	= 'show';
		$this->Entity 	= 'Finance';
		require_once 'model/'.$this->Entity.'.php';
		$this->Model 	= New $this->Entity;
	}

	public function index(){
		$finance 	= new FinanceController;
		$date       = $_GET['date'];
		if($date){
			$monthly_transactions 			= $finance->get_monthly_transactions($date, date('Y'));
			$monthly_transactions_detail 	= $finance->get_monthly_transactions_detail($date, date('Y'));
			return (object)array('monthly_transactions' => $monthly_transactions, 'monthly_transactions_detail' => $monthly_transactions_detail);
		}
	}

	public function save_json(){
		header('Content-Type: application/json');

		$date         = $_POST['date'];
		$type         = $_POST['type'];
		$value        = $_POST['value'];
		$response_id  = $this->get_id();
		
		$data = array(
			'date' 	=> $date,
			'type' 	=> $type,
			'value' => $value,
		);

		if ($response_id && $data) {
			$this->Model->Update($data, $response_id);
		} elseif ($data) {
			$result = $this->Model->Insert($data);
		}

		$id = $_POST['id'] ? $_POST['id'] : $result[1];

		$json = [
            'type' 	=> $this->Entity,
            'id' 	=> (string) $id,
            'attributes' => [
                'date' 	=> $date,
                'type' 	=> $type,
                'value' => $value,
            ],
            'links'	=> [
                'self' => 'index.php?view='.$this->Entity.'&action=get_json&datatype=json&id='.$id,
            ]
        ];

		echo json_encode($json); 
	}

	public function get_json(){
		header('Content-Type: application/json');

		$id  	= $_GET['id'];
		$data	= $this->one($id);
		

		$json = [
            'type' 	=> $this->Entity,
            'id' 	=> (string) $id,
            'attributes' => [$data],
            'links'	=> [
                'self' => 'index.php?view='.$this->Entity.'&action=get_json&datatype=json&id='.$id,
            ]
        ];

		echo json_encode($json); 
	}

	public function delete_json(){
		header('Content-Type: application/json');

		$id  	= $_GET['id'];
		$data	= $this->delete($id);
		
		$json = [
            'type' 	=> $this->Entity,
            'id' 	=> (string) $id,
            'attributes' => [$data],
            'links'	=> [
                'self' => 'index.php?view='.$this->Entity.'&action=get_json&datatype=json&id='.$id,
            ]
        ];

		echo json_encode($json); 
	}

	public function get_monthly_transactions($month, $year){

		$filter 	= 'MONTH(date) = '.$month.' AND YEAR(date) = '.$year;
		$data 		= $this->many($filter);
		$income 	= 0;
		$expenses 	= 0;

		foreach ($data as $value) {

			switch ($value->type) {
				case 'income':
					$income = $value->value + $income;
					break;
				case 'expenses':
					$expenses = $value->value + $expenses;
					break;
			}
		}

		$total = $income - $expenses;

		return (object)array('month'=>$month,'year'=>$year, 'income'=>$income, 'expenses'=>$expenses, 'total'=>$total);
	}

	public function get_monthly_transactions_resume($month, $year, $limit){
		$filter 	= 'MONTH(date) = '.$month.' AND YEAR(date) = '.$year.' ORDER BY id DESC LIMIT '.$limit;
		return $this->many($filter);
	}

	public function get_monthly_transactions_detail($month, $year){
		$filter 	= 'MONTH(date) = '.$month.' AND YEAR(date) = '.$year;
		return $this->many($filter);
	}

	public function get_id() {
        $id = $_POST['id'] ? $_POST['id'] : 0;
        $response = $id ? $this->one($id) : FALSE;      
        return $response->id;
    }

    public function one($id, $filter = NULL) {
        return $this->Model->One($id, $filter);
    }

	public function many($filter = NULL) {
        return $this->Model->All($filter);
    }
	
	public function delete($id = 0, $filter = NULL) {
        return $this->Model->Delete($id,$filter);
    }

}

?>