<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Units_model extends CI_Model
{
	public function sqldtunitindex()
	{
		$sql = 'SELECT a.unitid, a.unitcode, a.unitdesc, IF(a.unitstatus=1, "Active", "Inactive") as unitstatus
				FROM tbl_unit a 
				WHERE a.unitcode LIKE ? OR a.unitdesc LIKE ?';
		return $sql;
	}

	public function unitedit($unitid)
	{
		$prm = [$unitid];
		$sql = $this->sqlunitedit();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	public function unitsave($unitid, $unitcode, $unitdesc, $unitstatus)
	{
		try {
			$this->db->trans_start();
			if (strlen($unitid) === 0) {
				$prm = ['unitcode'=>$unitcode, 'unitdesc'=>$unitdesc, 'unitstatus'=>$unitstatus];
				$this->db->insert('tbl_unit', $prm);
			} else {
				$unitid = $this->my_encrypt->decode($unitid);
				$prm = ['unitcode'=>$unitcode, 'unitdesc'=>$unitdesc, 'unitstatus'=>$unitstatus];
				$this->db->where('unitid', $unitid);
				$this->db->update('tbl_unit', $prm);
			}
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}
		return $res;
		
	}

	
	private function sqlunitedit()
	{
		$sql = 'SELECT a.*
				FROM tbl_unit a 
				WHERE a.unitid = ?';
		return $sql;
	}
}
