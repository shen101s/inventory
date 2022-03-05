<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homeclass_model extends CI_Model
{
	public function validate()
	{
		$uname = $this->input->post('authuname');
		$pword = trim($this->input->post('authpword'));

		$prm = [ $uname, 1 ];
		$sql = 'SELECT a.lid, a.uname, a.pword, CONCAT(a.fname, LEFT(a.mname, 1), a.lname) as fullname, a.fname, a.privilege, a.dateadded
				FROM tbl_login a
                WHERE a.uname = ? 
                    AND a.status = ?';		
		$query = $this->db->query($sql, $prm);


		if ($query->num_rows() === 1) {
			$query = $query->row_array();

			if (password_verify($pword, $query['pword'])) {
				$data = [
                    'lid' => $this->my_encrypt->encode($query['lid']),
                    'uname' => $query['uname'],
                    'loggedin' => TRUE,
                    'fullname' => $query['fullname'],
                    'fname' => $query['fname'],
                    'privilege' => $query['privilege'],
                    'dateadded' => $query['dateadded']
                ];

                

                session_set_cookie_params(0);
				$this->session->set_userdata($data);
				return true;
			}
		}

		return false;
	}


	/**
	 * nearly expiry item
	 */
	public function nearlyexpiryitem()
	{
		$prm = [date('Y-m-d', strtotime("+6 months")), date('Y-m-d')];	
		$sql_ = ' AND det.libdexp < ? AND det.libdexp >= ? ';
		$sql = $this->sqlnearlyexpiryitem($sql_);
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	public function expireditem()
	{
		$prm = [date('Y-m-d')];	
		$sql_ = ' AND det.libdexp < ? ';
		$sql = $this->sqlnearlyexpiryitem($sql_);
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}



	private function sqlnearlyexpiryitem($sql_)
	{
		$sql = 'SELECT serv.scode,
					lib.libdesc, 
					des.libdescitem, 
					det.libdqty, det.libdqtyrem, det.libdprice, det.libdexp, 
					unit.unitcode
			FROM tbl_service serv 
			LEFT JOIN tbl_library lib ON serv.sid=lib.sid 
			LEFT JOIN tbl_library_desc des ON lib.libid=des.libid
			LEFT JOIN tbl_library_det det ON des.libdescid=det.libdescid 
			LEFT JOIN tbl_unit unit ON det.unitid=unit.unitid
			WHERE 
				lib.libstatus = "1" AND des.libdescstatus = "1" AND det.libdstatus = "1" 
				AND (det.libdqty = 0 OR (det.libdqtyrem > 0 AND det.libdqty > 0))
				' . $sql_ . '
				AND det.libdexp != "0000-00-00"
			ORDER BY det.libdexp ASC';
		return $sql;
	}


	

	public function totalrepsales($mydate)
	{
		$this->load->model('Report_model', 'report_model');

		$prm = [0, $mydate];
		$sql_ = ' AND a.trandate LIKE ? ';
		$sql = $this->report_model->sqlrepsales($sql_);
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	// private function sqltotalrepsales()
	// {
	// 	$sql = 'SELECT 
	// 				SUM(IF(d.sid=1, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totmed, 
	// 				SUM(IF(d.sid=2, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totlab, 
	// 				SUM(IF(d.sid=3, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totsrv, 
	// 				SUM(IF(d.sid=4, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totsup, 
	// 				SUM(IF(d.sid=5, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totvax, 
	// 				SUM(IF(d.sid=6, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totfod
	// 			FROM tbl_trans a 
	// 			LEFT JOIN tbl_trans_serv b ON a.transid=b.transid AND b.tsstatus=0
	// 			LEFT JOIN tbl_library_det c ON b.tslibdid=c.libdid AND c.libdstatus=1
	// 			LEFT JOIN tbl_library_desc des ON c.libdescid=des.libdescid AND des.libdescstatus=1
	// 			LEFT JOIN tbl_library d ON des.libid=d.libid 
	// 			WHERE a.transtatus = ? AND a.trandate LIKE ?';
	// 	return $sql;
	// }

	public function changepassword($currentpassword, $newpassword, $confirmpassword)
	{
		$uname = $this->session->userdata('uname');
		$pword = $currentpassword;

		$prm = [ $uname, 1 ];
		$sql = 'SELECT a.uname, a.pword, CONCAT(a.fname, LEFT(a.mname, 1), a.lname) as fullname, a.privilege
				FROM tbl_login a
                WHERE a.uname = ? 
                    AND a.status = ?';		
		$query = $this->db->query($sql, $prm);

		if ($query->num_rows() === 1) {
			$query = $query->row_array();
			if (password_verify($pword, $query['pword'])) {

				#password was verified. change password.
				$prm_ = [ 'pword' => PASSWORD_HASH($newpassword, PASSWORD_DEFAULT) ];
				$this->db->where('lid', $this->my_encrypt->decode($this->session->userdata('lid')));
				$res = $this->db->update('tbl_login', $prm_);
				
				if ($res == true) {
					return 1; #success
				} else {
					return 2; #something went wrong
				}
			} else {
				return 0; #incorrect old password
			}
		}
		return 0; #incorrect old password
	}
}
