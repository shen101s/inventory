<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Users_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}


	public function index()
	{
		$this->load->view('users/index');
	}

	public function dtuserindex()
	{
		$col = [0=>'uname', 1=>'fname', 2=>'mname', 3=>'lname', 4=>'privilege', 5=>'status'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = ['%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%', 
				'%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Users_model->sqldtuserindex();
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	


		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['lid'] = $this->my_encrypt->encode($data[$i]['lid']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}

	public function usersave()
	{
		$m_lid = trim($this->input->post('m_lid'));
		$m_uname = trim($this->input->post('m_uname'));
		$m_pword = trim($this->input->post('m_pword'));
		$m_fname = strtoupper(trim($this->input->post('m_fname')));
		$m_mname = strtoupper(trim($this->input->post('m_mname')));
		$m_lname = strtoupper(trim($this->input->post('m_lname')));
		$m_privilege = trim($this->input->post('m_privilege'));
		$m_status = trim($this->input->post('m_status'));
		$res = $this->Users_model->usersave($m_lid, $m_uname, $m_pword, $m_fname, $m_mname, $m_lname, $m_privilege, $m_status);

		if ($res) {
			$this->session->set_flashdata('success', 'Successfully Saved');
		} else {
			$this->session->set_flashdata('error', $res);
		}
      	
      	redirect('users');
	}

	public function useredit()
	{
		$lid = $this->my_encrypt->decode(trim($this->input->get('lid')));
		$res = $this->Users_model->useredit($lid);
		echo json_encode(['res'=>$res]);
	}

	public function userchangepassword()
	{
		$lid = $this->my_encrypt->decode(trim($this->input->post('m_pw_lid')));
		$pword = $this->input->post('m_pw_pword');
		$res = $this->Users_model->userchangepassword($lid, $pword);
		
		if ($res) {
			$this->session->set_flashdata('success', 'Successfully Saved');
		} else {
			$this->session->set_flashdata('error', $res);
		}
      	
      	redirect('users');
	}
}

