<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Services_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}

	public function index()
	{
		$this->load->view('services/index');
	}

	public function servsave()
	{
		$sid = trim($this->input->post('m_serv_sid'));
		$scode = trim($this->input->post('m_serv_code'));
		$sdescription = trim($this->input->post('m_serv_desc'));
		$sstatus = trim($this->input->post('m_serv_status'));

		$res = $this->Services_model->servsave($sid, $scode, $sdescription, $sstatus);

		if ($res) {
			$this->session->set_flashdata('success', 'Successfully Saved');
		} else {
			$this->session->set_flashdata('error', $res);
		}
      	
      	redirect('services');
	}

	public function dtservindex()
	{
		#$sid = $this->my_encrypt->decode(trim($this->input->get('sid')));

		$col = [0=>'scode', 1=>'sdescription', 2=>'sstatus'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = ['%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Services_model->sqldtservindex();;
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['sid'] = $this->my_encrypt->encode($data[$i]['sid']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}


	public function dtservindexdesc()
	{
		$libid = $this->my_encrypt->decode(trim($this->input->get('libid')));
		$col = [0=>'a.libdescitem', 1=>'libdescstatus']; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = [ $libid, '%'. trim($_GET['search']['value']).'%' ];
		$sql_tr = $this->Services_model->sqldtservindexdesc();;


		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		
		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		$data_ = [];
		foreach ($data as $value) {
	    	$array['libdescid'] = $this->my_encrypt->encode($value['libdescid']);
	    	$array['libid'] = $value['libid'];
	    	$array['libdescitem'] = $value['libdescitem'];
	    	$array['libdescstatus'] = $value['libdescstatus'];
	    	
	    	$data_[] = $array;
		}

		$json_data = array(
	        "draw"            	=> intval($_REQUEST['draw']),
	        "recordsTotal"    	=> intval($totaldata),
	        "recordsFiltered" 	=> intval($totaldata),
	        "data"            	=> $data_
	    );
		echo json_encode($json_data);
	}

	public function servdetailssavedesc()
	{
		$sid = $this->my_encrypt->decode(trim($this->input->get('m_serv_qsid')));
		$libdescid = trim($this->input->get('m_serv_libdescid'));
		$libid = trim($this->my_encrypt->decode(trim($this->input->get('m_serv_libid_desc'))));
		$libdescitem = trim($this->input->get('m_serv_libdescitem'));
		$libdescstatus = trim($this->input->get('m_serv_libdescstatus'));
		$res = $this->Services_model->servdetailssavedesc($libdescid, $libid, $libdescitem, $libdescstatus);
      	echo json_encode($res);
	}

	public function servdescedit()
	{
		$libdescid = $this->my_encrypt->decode(trim($this->input->get('libdescid')));
		$res = $this->Services_model->servdescedit($libdescid);
		if (isset($res[0]['libid'])) {
			$res[0]['libid'] = $this->my_encrypt->encode($res[0]['libid']);
		}
		echo json_encode(['res'=>$res]);
	}









	#delete below

	public function dtservindexprice()
	{
		$libdescid = $this->my_encrypt->decode(trim($this->input->get('libdescid')));
		$col = [0=>'libdbarcode', 1=>'unitdesc', 2=>'libdprice', 3=>'libdqty', 4=>'libdqty', 5=>'libdqtyrem', 6=>'libdexp', 7=>'libdstatus']; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = [ $libdescid, '%'. trim($_GET['search']['value']).'%',  
					'%'. trim($_GET['search']['value']).'%',  '%' . trim($_GET['search']['value']) . '%', 
					'%'. trim($_GET['search']['value']).'%', '%'. trim($_GET['search']['value']).'%' ];
		$sql_tr = $this->Services_model->sqldtservindexprice();;


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
	    	$array['libdqtyrem'] = ($value['libdqty'] == 0 ? '' : $value['libdqtyrem']);
	    	$array['libdexp'] = ($value['libdexp'] === NULL) ? '-' : $this->Common_model->displaychangeDateFormat($value['libdexp']);
	    	$array['libdstatus'] = $value['libdstatus'];
	    	$array['libdbarcode'] = $value['libdbarcode'];

	    	
	    	$data_[] = $array;
		}


		$json_data = array(
	        "draw"            	=> intval($_REQUEST['draw']),
	        "recordsTotal"    	=> intval($totaldata),
	        "recordsFiltered" 	=> intval($totaldata),
	        "data"            	=> $data_
	    );
		echo json_encode($json_data);
	}



	public function editservice()
	{
		$sid = $this->my_encrypt->decode(trim($this->input->get('sid')));
		$res = $this->Services_model->editservice($sid);
		echo json_encode(['res'=>$res]);
	}


	/** start details page */

	public function dtservdetails()
	{
		$sid = $this->my_encrypt->decode(trim($this->input->get('sid')));

		$col = [0=>'libdesc', 1=>'libstatus'];; 
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = [ $sid, '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Common_model->sqldtlibrary();;
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['libid'] = $this->my_encrypt->encode($data[$i]['libid']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}


	#delete
	public function details()
	{
		$qsid = $this->input->get('qsid');
		$sid = $this->my_encrypt->decode($qsid);
		$serv = $this->Common_model->selectservice($sid);
		$unit = $this->Common_model->selectUnit();
		$this->load->view('services/details', ['serv'=>$serv, 'unit'=>$unit]);
	}


	/*save service in details.php*/
	public function servdetailssave()
	{
		$sid = $this->my_encrypt->decode(trim($this->input->post('m_serv_qsid')));
		$libid = trim($this->input->post('m_serv_libid'));
		$libdesc = trim($this->input->post('m_serv_libdesc'));
		$libstatus = trim($this->input->post('m_serv_libstatus'));
		$res = $this->Common_model->libsave($libid, $sid, $libdesc, $libstatus);
      	echo json_encode($res);
	}


	/*edit services details*/
	public function servdetailsedit()
	{
		$libid = $this->my_encrypt->decode(trim($this->input->get('libid')));
		$res = $this->Services_model->servdetailsedit($libid);
		echo json_encode(['res'=>$res]);
	}



	/*price*/
	
	public function servsaveprice()
	{
		$libdescid = $this->my_encrypt->decode(trim($this->input->post('m_serv_libdescid_price')));
		$libdid = (strlen(trim($this->input->post('m_serv_libdid'))) === 0) ? '' : $this->my_encrypt->decode(trim($this->input->post('m_serv_libdid')));
		#$libdbarcode = $this->input->post('m_serv_libdbarcode');

		$unitid = $this->input->post('m_serv_unit');
		$libdprice = $this->input->post('m_serv_libdprice');
		$libdqty = $this->input->post('m_serv_libdqty');
		$libdexp = $this->input->post('m_serv_libdexp');
		$libdstatus = $this->input->post('m_serv_libdstatus');

		$res = $this->Services_model->servsaveprice($libdescid, $libdid, $unitid, $libdprice, $libdqty, $libdexp, $libdstatus);
		echo json_encode(['res'=>$res]);
	}


	public function servpriceedit()
	{
		$libdid = $this->my_encrypt->decode(trim($this->input->get('libdid')));
		$res = $this->Services_model->servpriceedit($libdid);
		if (count($res) > 0) {
			$res[0]['libdexp'] = ($res[0]['libdexp'] === NULL) ? '' : $this->Common_model->displaychangeDateFormat($res[0]['libdexp']);
		}
		echo json_encode(['res'=>$res]);
	}


	/*qty adjustment*/
	public function servsaveadjustqty()
	{
		$transservid = trim($this->input->post('adj_transservid'));
		$libdid = $this->my_encrypt->decode(trim($this->input->post('adj_tslibdid')));
		$libdqty = $this->input->post('adj_tslibdqty');
		$remarks = $this->input->post('adj_tsremarks');

		$res = $this->Services_model->servsaveadjustqty($transservid, $libdid, $libdqty, $remarks);
		echo json_encode(['res'=>$res]);
	}

	public function serveditadjustqty()
	{
		$transservid = trim($this->input->get('transservid'));
		$res = $this->Services_model->serveditadjustqty($transservid);
		echo json_encode(['res'=>$res]);
	}
}
