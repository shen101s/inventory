<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Barcode_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}


	public function index()
	{
		$category = $this->input->get('category');
		#$display = $this->input->get('display');

		$serv = $this->Common_model->selectservice();
		$bclist = $this->Barcode_model->displayBarcodeList($category);
		$this->load->view('barcode/index', ['serv'=>$serv, 'bclist'=>$bclist]);
	}



}

