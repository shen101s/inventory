<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Report_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}

	public function sales()
	{
		$startdate = $this->input->get('startdate') == '' ? Date('M 01, Y') :  $this->input->get('startdate');
		$enddate = $this->input->get('enddate') == '' ? Date('M d, Y') : $this->input->get('enddate');

		$startdate_ = $this->Common_model->changeDateFormat($startdate);
		$enddate_ = $this->Common_model->changeDateFormat($enddate);

		$res = $this->Report_model->repsales($startdate_, $enddate_);
		$this->load->view('report/repsales', ['res'=>$res, 'startdate'=>$startdate, 'enddate'=>$enddate]);
	}

	public function stockinventory()
	{
		$sid_ = trim($this->input->get('category'));
		$stock_ = trim($this->input->get('stock'));

		$sid = ($sid_ == null || strlen($sid_) === 0) ? '' : $this->my_encrypt->decode($sid_);
		$stock = ($stock_ == null || strlen($stock_) === 0) ? 'stockonhand' : $stock_;

		$serv = $this->Common_model->selectservice();

		$res = $this->Report_model->generateindex($sid, $stock);
		$this->load->view('report/index', ['serv'=>$serv, 'sid'=>$sid, 'stock'=>$stock, 'res'=>$res]);
	}


	public function stockcard()
	{
		$libdid = $this->my_encrypt->decode(trim($this->input->get('libdid')));
		$res_head = $this->Report_model->stockcardHeader($libdid);
		$res = $this->Report_model->stockcard($libdid);
		echo json_encode(['res_head'=>$res_head, 'res'=>$res]);
	}


	public function stockissuance()
	{
		$startdate = $this->input->get('startdate') == '' ? Date('M 01, Y') :  $this->input->get('startdate');
		$enddate = $this->input->get('enddate') == '' ? Date('M d, Y') : $this->input->get('enddate');

		$startdate_ = $this->Common_model->changeDateFormat($startdate);
		$enddate_ = $this->Common_model->changeDateFormat($enddate);

		$res = $this->Report_model->repstockissuance($startdate_, $enddate_);
		$this->load->view('report/repstockissuance', ['res'=>$res, 'startdate'=>$startdate, 'enddate'=>$enddate]);
	}







	// public function medicine()
	// {
	// 	$res = $this->Report_model->repmedicine();
	// 	$this->load->view('report/repmedicine', ['res'=>$res]);
	// }
	// public function medicineexpiry()
	// {
	// 	$checkval = $this->input->get('checkval');
	// 	$res = $this->Report_model->repmedicine($checkval);
	// 	echo json_encode(['res'=>$res]);
	// }


	// public function supply()
	// {
	// 	$res = $this->Report_model->repsupply();
	// 	$this->load->view('report/repsupply', ['res'=>$res]);
	// }
	// public function supplyexpiry()
	// {
	// 	$checkval = $this->input->get('checkval');
	// 	$res = $this->Report_model->repsupply($checkval);
	// 	echo json_encode(['res'=>$res]);
	// }



	// public function food()
	// {
	// 	$res = $this->Report_model->repfood();
	// 	$this->load->view('report/repfood', ['res'=>$res]);
	// }

	// public function foodexpiry()
	// {
	// 	$checkval = $this->input->get('checkval');
	// 	$res = $this->Report_model->repfood($checkval);
	// 	echo json_encode(['res'=>$res]);
	// }

	// public function vaccine()
	// {
	// 	$res = $this->Report_model->repvaccine();
	// 	$this->load->view('report/repvaccine', ['res'=>$res]);
	// }

	// public function vaccineexpiry()
	// {
	// 	$checkval = $this->input->get('checkval');
	// 	$res = $this->Report_model->repvaccine($checkval);
	// 	echo json_encode(['res'=>$res]);
	// }


	// public function commission()
	// {
	// 	$startdate = $this->input->get('startdate');
	// 	$enddate = $this->input->get('enddate');

	// 	$startdate_ = ($startdate == '') ? '' : $this->Common_model->changeDateFormat($startdate);
	// 	$enddate_ = ($enddate == '') ? '' : $this->Common_model->changeDateFormat($enddate);

	// 	$res = $this->Report_model->repcommission($startdate_, $enddate_);
	// 	$this->load->view('report/repcom', ['res'=>$res, 'startdate'=>$startdate, 'enddate'=>$enddate]);
	// }


	


	

}
