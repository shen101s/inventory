<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Transaction_model', 'Common_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}


	public function index()
	{
		$this->load->view('transaction/index');
	}

	public function dttransindex()
	{
		$col = [0=>'a.transid', 1=>'a.trandate', 2=>'fullname', 3=>'totamount'];
		$order =  $col[$_GET['order']['0']['column']];
		$dir = $_GET['order']['0']['dir'];
		$prm = [ 0, 
				'%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%', 
				'%' . trim($_GET['search']['value']) . '%', '%' . trim($_GET['search']['value']) . '%'];
		$sql_tr = $this->Transaction_model->sqldttransindex();;
		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['trandate'] = $this->Common_model->displaychangeDateFormat($data[$i]['trandate']);
			$data[$i]['transid'] = $this->my_encrypt->encode($data[$i]['transid']);
			$data[$i]['oid'] = $this->my_encrypt->encode($data[$i]['oid']);

			$data[$i]['isdisabled'] = strpos('LAB', $data[$i]['isdisabled']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}


	public function deltrans()
	{
		$transid = $this->my_encrypt->decode($this->input->post('transid'));
		$res = $this->Transaction_model->deltrans($transid);
		echo json_encode(['res'=>$res]);
	}

	public function clientselect()
	{
		$remselect = 'FALSE';
		$this->load->view('transaction/transaction', ['remselect'=>$remselect]);
	}

	public function clientpage()
	{
		$remselect = 'TRUE';
		$this->load->view('transaction/transaction', ['remselect'=>$remselect]);
	}

	public function clienttranssave()
	{
		$res = $this->Transaction_model->transsave();
		if ($res['res']) {
			$this->session->set_flashdata('success', 'Successfully Added');
		} else {
			$this->session->set_flashdata('error', 'Oops! There\'s something wrong!');
		}
      	
		$m_page = $this->input->post('m_page');
		if ($m_page === 'BILLING') {
			echo json_encode(['res'=>$res]);	
		} else {
			redirect('client');	
		}
	}


	public function dtownerdata()
	{
		$data_obj = $this->Transaction_model->dtownerdata();
		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		$data_ = [];
		foreach ($data as $value) {
	    	$array['oid'] = $this->my_encrypt->encode($value['oid']);
	    	$array['ofname'] = $value['ofname'];
	    	$array['omname'] = $value['omname'];
	    	$array['olname'] = $value['olname'];
	    	$array['oaddress'] = $value['oaddress'];
	    	$array['ocontactnum'] = $value['ocontactnum'];
	    	$array['oemailadd'] = $value['oemailadd'];
	    	$array['pname'] = $value['pname'];
	    	$array['odateadded'] = $value['odateadded'];

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


	public function transsave()
	{
		$res = $this->Transaction_model->transsave();

		if ($res) {
			$this->session->set_flashdata('success', 'Successfully Added');
		} else {
			$this->session->set_flashdata('error', 'Oops! There\'s something wrong!');
		}
      	
      	redirect('transaction/clientselect');
	}

	/** select pet name and owner */
	

	public function editowner()
	{
		$oid = $this->my_encrypt->decode($this->input->get('oid'));
		$own = $this->Transaction_model->selectowner($oid);
		echo json_encode(['own'=>$own]);
	}

	public function clientinfo()
	{
		$this->load->view('transaction/clientinfo');
	}


	/* start pet*/
	public function savepet()
	{
		$res = $this->Transaction_model->savepet();

		if ($res) {
			$oid = $this->my_encrypt->decode($this->input->post('m_oidpet'));
			$pet = $this->petDetails($oid);
		}

		$species = $this->Common_model->selectspecies();
		$breed = $this->Common_model->selectbreed();

		echo json_encode(['res'=>$res, 'pet'=>$pet, 'species'=>$species, 'breed'=>$breed]);
	}

	public function selectpet()
	{
		$oid = $this->my_encrypt->decode($this->input->get('oid'));
		$pet = $this->petDetails($oid);

		$species = $this->Common_model->selectspecies();
		$breed = $this->Common_model->selectbreed();

		echo json_encode(['pet'=>$pet, 'species'=>$species, 'breed'=>$breed]);
	}


	public function deletepet()
	{
		$pid = $this->my_encrypt->decode($this->input->post('pid'));
		$res = $this->Transaction_model->deletepet($pid);


		$oid = $this->my_encrypt->decode($this->input->post('oid'));
		$pet = $this->petDetails($oid);

		$species = $this->Common_model->selectspecies();
		$breed = $this->Common_model->selectbreed();

		echo json_encode(['res'=>$res, 'pet'=>$pet, 'species'=>$species, 'breed'=>$breed]);
	}

	public function petDetails($oid)
	{
		$pets = $this->Transaction_model->selectpet($oid);
		$len = count($pets);
		for ($i=0; $i < $len; $i++) { 
			$pets[$i]['pid'] = $this->my_encrypt->encode(trim($pets[$i]['pid']));
	    	$pets[$i]['oid'] = $this->my_encrypt->encode(trim($pets[$i]['oid']));
	    	$pets[$i]['pbday'] = $this->Common_model->displaychangeDateFormat($pets[$i]['pbday']);
		}

		return $pets;
	}

	public function editpet()
	{
		$pid = $this->my_encrypt->decode($this->input->get('pid'));
		$res = $this->Transaction_model->editpet($pid);	

		$species = $this->Common_model->selectspecies();
		$breed = []; #$this->Common_model->selectbreed();

		if (count($res) > 0) {
			$res[0]['pid'] = $this->my_encrypt->encode($res[0]['pid']);
	    	$res[0]['pbday'] = $this->Common_model->displaychangeDateFormat($res[0]['pbday']);

	    	$breed = $this->Common_model->selectbreed($res[0]['specid']);
		}

		echo json_encode(['res'=>$res, 'species'=>$species, 'breed'=>$breed]);
	}
	/* end pet*/


	/* start add new transaction*/
	public function addnew()
	{
		$oid = $this->my_encrypt->decode($this->input->get('o'));
		$transid = trim($this->input->get('trans')) === '' ? '' : $this->my_encrypt->decode($this->input->get('trans'));

		#$pet = $this->Transaction_model->selectpet($oid);
		$own = $this->Transaction_model->selectowner($oid);
		$serv = $this->Common_model->selectservice();
		#$emp = $this->Common_model->selectemployees();
		#$pur = $this->Common_model->selectpurpose();

		$trans = $this->Transaction_model->selecttrans($transid);
		$transserv = $this->Transaction_model->selecttransserv($transid);


		// var_dump($transserv);
		// die();

		$this->load->view('transaction/addnew', ['own'=>$own, 'serv'=>$serv, 'transid'=>$transid, 'oid'=>$oid, 'trans'=>$trans, 'transserv'=>$transserv]);
	}


	public function selectmed()
	{
		$sid = $this->input->get('sid');

		$col = [0=>'a.libdesc', 1=>'c.unitcode', 2=>'b.libdprice', 3=>'b.libdexp', 4=>'b.libdqtyrem'];
		$order = $col[$_GET['order']['0']['column']];
        $dir = $_GET['order']['0']['dir'];
		$prm = [ $sid, '%'.$_GET['search']['value'].'%',  '%'.$_GET['search']['value'].'%'];

		$sql_tr = $this->Transaction_model->selectmed();


		$start = $_GET['start'];
		$length = $_GET['length'];
		$data_obj = $this->Common_model->datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length);

		$totaldata = $data_obj['totalrecord'];
		$data = $data_obj['limit'];	

		/*print_r($data);
		die();*/
		
		$len = count($data);
		for ($i=0; $i < $len; $i++) { 
			$data[$i]['libdid'] = $this->my_encrypt->encode($data[$i]['libdid']);
			$data[$i]['libdexp'] = ($data[$i]['libdexp'] == '') ? '-' : $this->Common_model->displaychangeDateFormat($data[$i]['libdexp']);

			$data[$i]['libdqtyrem'] = ($data[$i]['libdqty'] == 0 ? '' : $data[$i]['libdqtyrem']);
		}

		$json_data = array(
	        "draw"            => intval($_REQUEST['draw']),
	        "recordsTotal"    => intval($totaldata),
	        "recordsFiltered" => intval($totaldata),
	        "data"            => $data
	    );
		echo json_encode($json_data);
	}

	public function addserv()
	{
		$libdid = $this->my_encrypt->decode(trim($this->input->get('libdid')));
		$res = $this->Transaction_model->addserv($libdid);
		// $emp = $this->Common_model->selectemployees();

		if (count($res)>0) {
			$res[0]['libdid'] = $this->my_encrypt->encode($res[0]['libdid']);
		}

		echo json_encode(['res'=>$res]);
	}


	public function transave()
	{
		$transid = trim($this->input->get('trans_transid'));
		$oid = $this->input->get('trans_oid');
		$pid = $this->input->get('trans_pet');
		$purid = $this->input->get('trans_pur');
		$trandate = $this->Common_model->changeDateFormat($this->input->get('trans_date'));
		$remarks = $this->input->get('trans_remarks');
		$lid = $this->my_encrypt->decode($this->session->userdata('lid'));


		$res = $this->Transaction_model->transave($transid, $oid, $pid, $purid, $trandate, $remarks, $lid, 'T');
		$transid = $this->my_encrypt->encode($res['transid']);
		$oid = $this->input->get('trans_oid');
		echo json_encode(['res'=>$res['res'], 'transid'=>$transid, 'oid'=>$oid]);
	}


	public function transervsave()
	{
		$transid = $this->my_encrypt->decode(trim($this->input->get('transid')));
		$tslibdid = $this->my_encrypt->decode(trim($this->input->get('tslibdid')));
		$tslibdqty = $this->input->get('tslibdqty');
		$tsdiscount = $this->input->get('tsdiscount');
		// $empid = $this->input->get('tsempid');
		$transservid = trim($this->input->get('transservid'));


		$res = $this->Transaction_model->transervsave($transid, $tslibdid, $tslibdqty, $tsdiscount, $transservid);
		$transserv = [];
		$emp = [];

		if ($res) {
			$transserv = $this->Transaction_model->selecttransserv($transid);
			// $emp = $this->Common_model->selectemployees();

			$len = count($transserv);
			for ($i=0; $i < $len; $i++) { 
				$transserv[$i]['transid'] = $this->my_encrypt->encode($transserv[$i]['transid']);
				$transserv[$i]['transservid'] = $this->my_encrypt->encode($transserv[$i]['transservid']);
				$transserv[$i]['tslibdid'] = $this->my_encrypt->encode($transserv[$i]['tslibdid']);
			}
		}
		echo json_encode(['res'=>$res, 'transserv'=>$transserv]);
	}

	public function transervdel()
	{
		$res = $this->Transaction_model->transervdel();
		$transserv = [];
		$emp = [];
		
		if ($res) {
			$transid = $this->my_encrypt->decode(trim($this->input->get('transid')));
			$transserv = $this->Transaction_model->selecttransserv($transid);
			$emp = $this->Common_model->selectemployees();

			$len = count($transserv);
			for ($i=0; $i < $len; $i++) { 
				$transserv[$i]['transid'] = $this->my_encrypt->encode($transserv[$i]['transid']);
				$transserv[$i]['transservid'] = $this->my_encrypt->encode($transserv[$i]['transservid']);
				$transserv[$i]['tslibdid'] = $this->my_encrypt->encode($transserv[$i]['tslibdid']);
			}
		}
		echo json_encode(['res'=>$res, 'transserv'=>$transserv, 'emp'=>$emp]);
	}
	/* end add new transaction*/



	/*labresult*/
	public function labresult($transid)
	{
		$this->load->view('transaction/labresult');
	}


	/*pet history*/
	public function selpethistory()
	{
		$pid = $this->my_encrypt->decode($this->input->get('pid'));
		$res = $this->selpethistory_priv($pid);
		echo json_encode(['res'=>$res]);
	}

	
	public function savepethistory()
	{
		$res = $this->Transaction_model->savepethistory();
		$pethist = [];
		if ($res) {
			$pid = $this->my_encrypt->decode($this->input->get('pid'));
			$pethist = $this->selpethistory_priv($pid);
		}
		echo json_encode(['res'=>$res, 'pethist'=>$pethist]);
	}

	public function deletepethistory()
	{
		$phid = $this->my_encrypt->decode($this->input->get('phid'));
		$res = $this->Transaction_model->deletepethistory($phid);
		$pid = $this->my_encrypt->decode($this->input->get('pid'));
		$pethist = $this->selpethistory_priv($pid);
		echo json_encode(['res'=>$res, 'pethist'=>$pethist]);
	}
	

	public function editpethistory()
	{
		$phid = $this->my_encrypt->decode($this->input->get('phid'));
		$res = $this->Transaction_model->editpethistory($phid);

		if (count($res) > 0) {
	    	$res[0]['phdate'] = $this->Common_model->displaychangeDateFormat($res[0]['phdate']);
		}

		$pid = $this->my_encrypt->decode($this->input->get('pid'));
		$pethist = $this->selpethistory_priv($pid);
		echo json_encode(['res'=>$res, 'pethist'=>$pethist]);
	}


	private function selpethistory_priv($pid)
	{
		$res = $this->Transaction_model->selpethistory($pid);
		$len = count($res);
		for ($i=0; $i < $len; $i++) { 
			$res[$i]['phid'] = $this->my_encrypt->encode($res[$i]['phid']);
			$res[$i]['phdate'] = $this->Common_model->displaychangeDateFormat($res[$i]['phdate']);
		}
		return $res;
	}

	public function selectbreed()
	{
		$specid = $this->input->get('specid');
		$breed = $this->Common_model->selectbreed($specid);
		echo json_encode(['breed'=>$breed]);
	}
}
