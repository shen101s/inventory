<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Employees_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}


	public function index()
	{
		$this->load->view('employees/index');
	}

	public function dtempindex()
	{
		$col = [0=>'efname', 1=>'emname', 2=>'elname', 3=>'eposition', 4=>'estatus'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = ['%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%', 
				'%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Employees_model->sqldtempindex();
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	


		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['empid'] = $this->my_encrypt->encode($data[$i]['empid']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}

	public function empsave()
	{
		$m_empid = trim($this->input->post('m_empid'));
		$m_efname = trim($this->input->post('m_efname'));
		$m_emname = trim($this->input->post('m_emname'));
		$m_elname = trim($this->input->post('m_elname'));
		$m_eposition = trim($this->input->post('m_eposition'));
		$m_estatus = trim($this->input->post('m_estatus'));
		$res = $this->Employees_model->empsave($m_empid, $m_efname, $m_emname, $m_elname, $m_eposition, $m_estatus);

		if ($res) {
			$this->session->set_flashdata('success', 'Successfully Saved');
		} else {
			$this->session->set_flashdata('error', $res);
		}
      	
      	redirect('employees');
	}

	public function empedit()
	{
		$empid = $this->my_encrypt->decode(trim($this->input->get('empid')));
		$res = $this->Employees_model->empedit($empid);
		echo json_encode(['res'=>$res]);
	}
}

