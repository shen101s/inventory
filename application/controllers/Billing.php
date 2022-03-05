<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Billing_model', 'Common_model', 'Transaction_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}


	public function index()
	{
		$hist = $this->Common_model->healthHistory();
		$this->load->view('tbarcode/index', ['hist'=>$hist]);
	}

	public function additem()
	{
		$barcode = $this->input->get('barcode');
		$libdid = $this->input->get('libdid');
		$enc = $this->input->get('enc');
		$res = $this->Billing_model->additem($barcode, $libdid, $enc);
		if (isset($res[0]['libdid'])) {
			$res[0]['libdid'] = $this->my_encrypt->encode($res[0]['libdid']);
		}
		
		echo json_encode(['res'=>$res]);
	}


	public function savetrans()
	{
		$oid = $this->input->get('oid');
		$trancash = $this->input->get('trancash');
		$transdet = $this->input->get('transdet');
		$lid = $this->my_encrypt->decode($this->session->userdata('lid'));
		$res= $this->Billing_model->transave($oid, date('Y-m-d'), $lid, 'B', $transdet, $trancash);

		$itemlist = [];
		$transact = [];
		if ($res['res'] == true) {
			$transact = $this->Transaction_model->selecttrans($res['transid']);
			$itemlist = $this->Transaction_model->selecttransserv($res['transid']);
		}

		echo json_encode(['res'=>$res['res'], 'transact'=>$transact, 'itemlist'=>$itemlist]);
	}


	public function searchitem()
	{
		$item = $this->input->get('search_item');
		$res = $this->Billing_model->searchitem($item);
		echo json_encode(['res'=>$res]);
	}


	public function displaypet()
	{
		$oid = $this->my_encrypt->decode($this->input->get('oid'));
		$pets = $this->Transaction_model->selectpet($oid);
		$len = count($pets);
		for ($i=0; $i < $len; $i++) { 
			$pets[$i]['pid'] = $this->my_encrypt->encode(trim($pets[$i]['pid']));
	    	$pets[$i]['oid'] = $this->my_encrypt->encode(trim($pets[$i]['oid']));
	    	$pets[$i]['pbday'] = $this->Common_model->displaychangeDateFormat($pets[$i]['pbday']);
		}
		echo json_encode(['pets'=>$pets]);
	}


}

