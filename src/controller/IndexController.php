<?php 

class IndexController{
	public $page_title;
	public $view;
	public $Entity;

	public function __construct() {
		$this->view = 'show';
	}

	public function index(){
		require_once 'controller/FinanceController.php';
		$finance 						= new FinanceController;
		$monthly_transactions 			= $finance->get_monthly_transactions(date('m'), date('Y'));
		$monthly_transactions_resume 	= $finance->get_monthly_transactions_resume(date('m'), date('Y'), 5);
		return (object)array('monthly_transactions' => $monthly_transactions, 'monthly_transactions_resume' => $monthly_transactions_resume);
	}

	


}

?>