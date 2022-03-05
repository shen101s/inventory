<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Species extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Species_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}

	public function index()
	{
		$this->load->view('species/index');
	}

	public function dtspeciesindex()
	{
		$col = [0=>'specdesc', 1=>'specstatus'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = ['%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Species_model->sqldtspeciesindex();
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	


		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['specid'] = $this->my_encrypt->encode($data[$i]['specid']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}


	public function dtbreedindex()
	{
		$specid = $this->my_encrypt->decode(trim($this->input->get('specid')));

		$col = [0=>'breeddesc', 1=>'breedstatus'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = [$specid, '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Species_model->sqldtbreedindex();
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	


		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['breedid'] = $this->my_encrypt->encode($data[$i]['breedid']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}

	public function savespec()
	{
		$specid = trim($this->input->post('m_specid'));
		$specdesc = trim($this->input->post('m_specdesc'));
		$specstatus = trim($this->input->post('m_specstatus'));
		$res = $this->Species_model->savespec($specid, $specdesc, $specstatus);      	
      	echo json_encode(['res'=>$res]);
	}

	public function editspec()
	{
		$specid = $this->my_encrypt->decode(trim($this->input->get('specid')));
		$res = $this->Species_model->editspec($specid);
		echo json_encode(['res'=>$res]);
	}

	

	/* breed */
	public function savebreed()
	{
		$breedid = trim($this->input->post('m_breedid'));
		$specid = trim($this->input->post('m_specid'));
		$breeddesc = trim($this->input->post('m_breeddesc'));
		$breedstatus = trim($this->input->post('m_breedstatus'));
		$res = $this->Species_model->savebreed($breedid, $specid, $breeddesc, $breedstatus);      	
      	echo json_encode(['res'=>$res]);
	}


	public function editbreed()
	{
		$breedid = $this->my_encrypt->decode(trim($this->input->get('breedid')));
		$res = $this->Species_model->editbreed($breedid);
		$len = count($res);
		for ($i=0; $i < $len; $i++) { 
			$res[$i]['specid'] = $this->my_encrypt->encode($res[$i]['specid']);
		}
		echo json_encode(['res'=>$res]);
	}
	
}

