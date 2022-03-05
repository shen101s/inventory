<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medicines_model extends CI_Model
{
	public function medselprice($libid)
	{
		$prm = [$libid];
		$sql = $this->sqlmedselprice();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	public function mededit($libid)
	{
		$prm = [$libid];
		$sql = $this->sqlmededit();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}


	public function sqldtmedindexprice()
	{
		$sql = 'SELECT a.*, IF(a.libdstatus=1,"Active","Inactive") as libdstatus, b.*
				FROM tbl_library_det a 
				LEFT JOIN tbl_unit b ON a.unitid=b.unitid
				WHERE a.libid=? AND 
						(a.libdprice LIKE ? OR a.libdqty LIKE ? OR 
							a.libdqtyrem LIKE ? OR 
							a.libdexp LIKE ? OR a.libdstatus LIKE ? OR 
							b.unitdesc LIKE ?) ';
		return $sql;	
	}


	


	public function mededitprice($libdid)
	{
		$prm = [$libdid];
		$sql = $this->sqlmededitprice();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlmedselprice()
	{
		$sql = 'SELECT a.* FROM tbl_library_det a WHERE a.libid=?';
		return $sql;
	}


	

	private function sqlmededitprice()
	{
		$sql = 'SELECT a.* FROM tbl_library_det a WHERE a.libdid=?';
		return $sql;
	}



}
