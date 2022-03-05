<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Units_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}

	public function index()
	{
		$this->load->view('unit/index');
	}

	public function dtunitindex()
	{
		$col = [0=>'unitcode', 1=>'unitdesc', 2=>'unitstatus'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = ['%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Units_model->sqldtunitindex();
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	


		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['unitid'] = $this->my_encrypt->encode($data[$i]['unitid']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}


	public function unitedit()
	{
		$unitid = $this->my_encrypt->decode(trim($this->input->get('unitid')));
		$res = $this->Units_model->unitedit($unitid);
		echo json_encode(['res'=>$res]);
	}

	public function unitsave()
	{
		$unitid = trim($this->input->post('m_unitid'));
		$unitcode = trim($this->input->post('m_unitcode'));
		$unitdesc = trim($this->input->post('m_unitdesc'));
		$unitstatus = trim($this->input->post('m_unitstatus'));
		$res = $this->Units_model->unitsave($unitid, $unitcode, $unitdesc, $unitstatus);

		if ($res) {
			$this->session->set_flashdata('success', 'Successfully Saved');
		} else {
			$this->session->set_flashdata('error', $res);
		}
      	
      	redirect('unit');
	}
}

