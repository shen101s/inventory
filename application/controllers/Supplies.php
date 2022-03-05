<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplies extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Supplies_model']);

		if(!$this->session->userdata('loggedin')) {
			redirect('');
		}
	}

	public function index()
	{
		$this->load->view('supplies/index');
	}
}
