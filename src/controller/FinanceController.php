<?php
require_once('controller/AbstractClassController.php');

class FinanceController extends AbstractClassController {

	public function entity() {
        return 'Finance'; 
    }

	public function data() {
		$date         = $_POST['date'];
		$type         = $_POST['type'];
		$value        = $_POST['value'];
		
		return array(
			'date' 	=> $date,
			'type' 	=> $type,
			'value' => $value,
		);
	}

	public function index(){
		$finance 	= new FinanceController;
		$date       = $_GET['date'] ? $_GET['date'] : date('m');
		if($date){
			$monthly_transactions 			= $finance->get_monthly_transactions($date, date('Y'));
			$monthly_transactions_detail 	= $finance->get_monthly_transactions_detail($date, date('Y'));
			return (object)array('monthly_transactions' => $monthly_transactions, 'monthly_transactions_detail' => $monthly_transactions_detail);
		}
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

}

?>