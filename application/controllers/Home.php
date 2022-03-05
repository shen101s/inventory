<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Homeclass_model']);
	}

	public function index()
	{
		if($this->session->userdata('loggedin') === true) {
			$exp = $this->Homeclass_model->nearlyexpiryitem();
			$expd = $this->Homeclass_model->expireditem();

			$this->load->view('home/index', ['exp'=>$exp, 'expd'=>$expd]);
		} else {
			$this->load->view('auth');
		}
	}


	public function validate()
	{
		$res = $this->Homeclass_model->validate();
		if ($res === false) {
        	$this->session->set_flashdata('error', ' Invalid Username and Password!');
        }
        redirect('');
	}


	public function logout()
	{
		clearstatcache();
		$this->session->sess_destroy();
		redirect('');
	}


	public function changepassword()
	{
		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
		
		$currentpassword = trim($this->input->get('currentpassword'));
		$newpassword = trim($this->input->get('newpassword'));
		$confirmpassword = trim($this->input->get('confirmpassword'));
		$res = $this->Homeclass_model->changepassword($currentpassword, $newpassword, $confirmpassword);
		if ($res === 1) {
			clearstatcache();
			$this->session->sess_destroy();
			$this->session->set_flashdata('success', 'Password was successfully updated');
		} 
		echo json_encode(['res'=>$res]);
	}


	/**
	 * line graph
	 */
	public function totalsalespermonth()
	{
		$yy = $this->input->get('yy');
		$totsale = $this->datatotalsalespermonth($yy);

		echo json_encode(['totdmms'=>$totsale[0], 'totvax'=>$totsale[1], 'totdw'=>$totsale[2], 'totos'=>$totsale[3], 'totdf'=>$totsale[4], 'totvs'=>$totsale[5], 'totgs'=>$totsale[6]]);
	}

	private function datatotalsalespermonth($yy) 
	{
		$jan = $this->Homeclass_model->totalrepsales($yy. '-01-%');
		$feb = $this->Homeclass_model->totalrepsales($yy. '-02-%');
		$mar = $this->Homeclass_model->totalrepsales($yy. '-03-%');
		$apr = $this->Homeclass_model->totalrepsales($yy. '-04-%');
		$may = $this->Homeclass_model->totalrepsales($yy. '-05-%');
		$jun = $this->Homeclass_model->totalrepsales($yy. '-06-%');
		$jul = $this->Homeclass_model->totalrepsales($yy. '-07-%');
		$aug = $this->Homeclass_model->totalrepsales($yy. '-08-%');
		$sep = $this->Homeclass_model->totalrepsales($yy. '-09-%');
		$oct = $this->Homeclass_model->totalrepsales($yy. '-10-%');
		$nov = $this->Homeclass_model->totalrepsales($yy. '-11-%');
		$dec = $this->Homeclass_model->totalrepsales($yy. '-12-%');


		$month = [];
		$arr = ['totdmms', 'totvax', 'totdw', 'totos', 'totdf', 'totvs', 'totgs'];
		for ($i=0; $i < count($arr); $i++) { 
			$sales = [];
			$sales[] = ($jan[0][$arr[$i]] == null ? 0 : $jan[0][$arr[$i]]);
			$sales[] = ($feb[0][$arr[$i]] == null ? 0 : $feb[0][$arr[$i]]);
			$sales[] = ($mar[0][$arr[$i]] == null ? 0 : $mar[0][$arr[$i]]);
			$sales[] = ($apr[0][$arr[$i]] == null ? 0 : $apr[0][$arr[$i]]);
			$sales[] = ($may[0][$arr[$i]] == null ? 0 : $may[0][$arr[$i]]);
	        $sales[] = ($jun[0][$arr[$i]] == null ? 0 : $jun[0][$arr[$i]]);
	        $sales[] = ($jul[0][$arr[$i]] == null ? 0 : $jul[0][$arr[$i]]);
	        $sales[] = ($aug[0][$arr[$i]] == null ? 0 : $aug[0][$arr[$i]]);
	        $sales[] = ($sep[0][$arr[$i]] == null ? 0 : $sep[0][$arr[$i]]);
	        $sales[] = ($oct[0][$arr[$i]] == null ? 0 : $oct[0][$arr[$i]]);
	        $sales[] = ($nov[0][$arr[$i]] == null ? 0 : $nov[0][$arr[$i]]);
	        $sales[] = ($dec[0][$arr[$i]] == null ? 0 : $dec[0][$arr[$i]]);

	        $month[] = $sales;
		}
        return $month;
	}

}