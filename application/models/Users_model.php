<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
	public function sqldtuserindex()
	{
		$sql = 'SELECT a.lid, a.uname, a.fname, a.mname, a.lname, 
					IF(a.privilege=99, "Superadmin", "Admin") as privilege,
					IF(a.status=1, "Active", "Inactive") as status
				FROM tbl_login a 
				WHERE a.uname LIKE ? OR a.fname LIKE ? OR a.mname LIKE ? OR a.lname LIKE ?';
		return $sql;
	}

	public function usersave($lid, $uname, $pword, $fname, $mname, $lname, $privilege, $status)
	{
		try {
			$this->db->trans_start();
			
			if (strlen($lid) === 0) {
				$prm = ['uname'=>$uname, 'pword'=>PASSWORD_HASH($pword, PASSWORD_DEFAULT), 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname, 'privilege'=>$privilege, 'status'=>$status];
				$this->db->insert('tbl_login', $prm);
			} else {
				$prm = ['fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname, 'privilege'=>$privilege, 'status'=>$status];
				$lid = $this->my_encrypt->decode($lid);
				$this->db->where('lid', $lid);
				$this->db->update('tbl_login', $prm);
			}
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}
		return $res;
	}

	public function useredit($lid)
	{
		$this->db->select('a.*');
		$this->db->from('tbl_login a');
		$this->db->where('a.lid', $lid);
		return $this->db->get()->result_array();
	}


	public function userchangepassword($lid, $pword)
	{
		$prm = ['pword'=>PASSWORD_HASH($pword, PASSWORD_DEFAULT)];
		$this->db->where('lid', $lid);
		return $this->db->update('tbl_login', $prm);
	}


	

}
