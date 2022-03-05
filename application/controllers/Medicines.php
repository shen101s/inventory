<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicines extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Medicines_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}

	public function index()
	{
		$unit = $this->Common_model->selectUnit();
		$this->load->view('medicines/index', ['unit'=>$unit]);
	}

	public function dtmedindex()
	{
		$col = [0=>'libdesc', 1=>'libstatus'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = [ 1, '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Common_model->sqldtlibrary();;
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		$data_ = [];
		foreach ($data as $value) {
	    	$array['libid'] = $this->my_encrypt->encode($value['libid']);
	    	$array['libdesc'] = $value['libdesc'];
	    	$array['libstatus'] = $value['libstatus'];;
	    	$data_[] = $array;
		}


		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data_
	    );
		echo json_encode($json_data);
	}


	

	public function mededit()
	{
		$libid = $this->my_encrypt->decode(trim($this->input->get('libid')));
		$res = $this->Medicines_model->mededit($libid);
		echo json_encode(['res'=>$res]);
	}

	public function medselprice()
	{
		$libid = $this->my_encrypt->decode(trim($this->input->get('libid')));
		$medname = $this->Medicines_model->mededit($libid);
		$medprice = $this->Medicines_model->medselprice($libid);
		echo json_encode(['medname'=>$medname, 'medprice'=>$medprice]);
	}
	
	

	public function mededitprice()
	{
		$libdid = $this->my_encrypt->decode(trim($this->input->get('libdid')));
		$res = $this->Medicines_model->mededitprice($libdid);
		echo json_encode(['res'=>$res]);
	}

	


	public function dtmedindexprice()
	{
		$libid = $this->my_encrypt->decode(trim($this->input->get('libid')));
		$col = [0=>'unitdesc', 1=>'libdprice', 2=>'libdqty', 3=>'libdqty', 4=>'libdqtyrem', 5=>'libdexp', 6=>'libdstatus']; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = [ $libid, '%'. trim($_GET['search']['value']).'%',  '%' . trim($_GET['search']['value']) . '%',
					'%'. trim($_GET['search']['value']).'%',  '%' . trim($_GET['search']['value']) . '%', 
					'%'. trim($_GET['search']['value']).'%', '%'. trim($_GET['search']['value']).'%' ];
		$sql_tr = $this->Medicines_model->sqldtmedindexprice();;


		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		


		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		$data_ = [];
		foreach ($data as $value) {
	    	$array['libdid'] = $this->my_encrypt->encode($value['libdid']);
	    	$array['unitdesc'] = $value['unitdesc'];
	    	$array['libdprice'] = $value['libdprice'];
	    	
	    	$array['libdqty'] = $value['libdqty'];
	    	$array['libdqtyrem'] = $value['libdqtyrem'];
	    	$array['libdexp'] = $this->Common_model->displaychangeDateFormat($value['libdexp']);
	    	$array['libdstatus'] = $value['libdstatus'];
	    	$data_[] = $array;
		}



		#$medname = $this->Medicines_model->mededit($libid);
		$json_data = array(
	        "draw"            	=> intval($_REQUEST['draw']),
	        "recordsTotal"    	=> intval($totaldata),
	        "recordsFiltered" 	=> intval($totaldata),
	        "data"            	=> $data_
	    );
		echo json_encode($json_data);
	}
}
