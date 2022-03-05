<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employees_model extends CI_Model
{
	public function sqldtempindex()
	{
		$sql = 'SELECT a.empid, a.efname, a.emname, a.elname, a.eposition, IF(a.estatus=1, "Active", "Inactive") as estatus
				FROM tbl_emp a 
				WHERE a.efname LIKE ? OR a.emname LIKE ? OR a.elname LIKE ? OR a.eposition LIKE ?';
		return $sql;
	}

	public function empsave($empid, $efname, $emname, $elname, $eposition, $estatus)
	{
		try {
			$this->db->trans_start();
			$prm = ['efname'=>$efname, 'emname'=>$emname, 'elname'=>$elname, 'eposition'=>$eposition, 'estatus'=>$estatus];
			if (strlen($empid) === 0) {
				$this->db->insert('tbl_emp', $prm);
			} else {
				$empid = $this->my_encrypt->decode($empid);
				$this->db->where('empid', $empid);
				$this->db->update('tbl_emp', $prm);
			}
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}
		return $res;
	}

	public function empedit($empid)
	{
		$prm = [$empid];
		$sql = $this->sqlempedit();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlempedit()
	{
		$sql = 'SELECT a.*
				FROM tbl_emp a 
				WHERE a.empid = ?';
		return $sql;
	}
}
