<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends CI_Model
{
	public function changeDateFormat($mdate)
	{
		$myDateTime = DateTime::createFromFormat('M d, Y', $mdate);
		$newDateString = $myDateTime->format('Y-m-d');
		return $newDateString;
	}

	public function displaychangeDateFormat($mdate)
	{
		$myDateTime = DateTime::createFromFormat('Y-m-d', $mdate);
		$newDateString = $myDateTime->format('M d, Y');
		return $newDateString;
	}

	/** datatable 
	 * @param array $col
	 * @param str $order = $col[$_GET['order']['0']['column']]
	 * @param str $dir = $_GET['order']['0']['dir'];
	 * @param array $prm
	 * @param str $sql_totalrecord
	 * @param int $start
	 * @param int $length
	 */
	public function datatablefunc($col, $order, $dir, $prm, $sql_tr, $start, $length)
	{
		$res_tr = $this->db->query($sql_tr, $prm)->result_array();
		$prm[] = ($start * 1);
		$prm[] = ($length * 1);
		$sql_limit = $sql_tr . ' ORDER BY ' . $order . ' ' . $dir . ' LIMIT ?, ?';
		$res_limit = $this->db->query($sql_limit, $prm)->result_array();
		return ['limit'=>$res_limit, 'totalrecord'=>count($res_tr)];
	}

	/** select service*/
	public function selectservice($sid = '')
	{
		$prm = [1];
		$sql = $this->sqlselectservice();
		if (strlen(trim($sid)) !== 0) {
			$prm[] = $sid;
			$sql .= ' AND a.sid=? ';
		}
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}


	/** tbl library save*/
	public function libsave($libid, $sid, $libdesc, $libstatus)
	{
		try {
			$this->db->trans_start();
			if (strlen($libid) === 0) {
				$prm = ['sid'=>$sid, 'libdesc'=>$libdesc, 'libstatus'=>$libstatus];
				$this->db->insert('tbl_library', $prm);
			} else {
				$libid_ = $this->my_encrypt->decode($libid);
				$prm = ['libdesc'=>$libdesc, 'libstatus'=>$libstatus];
				$this->db->where('libid', $libid_);
				$this->db->update('tbl_library', $prm);
			}
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}

		return $res;
	}

	public function sqldtlibrary()
	{
		$sql = 'SELECT a.*, IF(a.libstatus=1, "Active", "Inactive") as libstatus
				FROM tbl_library a 
				WHERE a.sid=? AND (a.libdesc LIKE ?)';
		return $sql;
	}


	public function selectUnit()
	{
		$prm = [1];
		$sql = $this->sqlselectUnit();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	// public function selectemployees()
	// {
	// 	$prm = [1];
	// 	$sql = $this->sqlselectemployees();
	// 	$res = $this->db->query($sql, $prm)->result_array();
	// 	return $res;
	// }


	public function selectpurpose()
	{
		$prm = ['Active'];
		$sql = $this->sqlselectpurpose();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlselectpurpose()
	{
		$sql = 'SELECT a.* FROM tbl_purpose a WHERE a.tpstatus=? ORDER BY a.tpdet ASC';
		return $sql;
	}




	public function selectspecies()
	{
		$prm = ['Active'];
		$sql = $this->sqlselectspecies();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlselectspecies()
	{
		$sql = 'SELECT a.* FROM tbl_lib_species a WHERE a.specstatus=? ORDER BY a.specdesc ASC';
		return $sql;
	}

	public function selectbreed($specid='')
	{
		$whre = '';
		$prm = ['Active'];
		if (strlen($specid) !== 0) {
			$prm[] = $specid;
			$whre = ' AND a.specid=? ';
		} 
		
		$sql = $this->sqlselectbreed($whre);
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlselectbreed($whre)
	{
		$sql = 'SELECT a.* FROM tbl_lib_breed a WHERE a.breedstatus=? ' . $whre . ' ORDER BY a.breeddesc ASC';
		return $sql;
	}



	private function sqlselectUnit()
	{
		$sql = 'SELECT a.* FROM tbl_unit a WHERE a.unitstatus=?';
		return $sql;
	}

	private function sqlselectservice()
	{
		$sql = 'SELECT a.* FROM tbl_service a WHERE a.sstatus=?';
		return $sql;
	}


	// private function sqlselectemployees()
	// {
	// 	$sql = 'SELECT a.* FROM tbl_emp a WHERE a.estatus=?';
	// 	return $sql;
	// }



	public function getlasttrannumber()
	{
		$prm = date('Y');
		$sql = $this->sqlgetlasttrannumber();
		$res = $this->db->query($sql, $prm)->result_array();
		return isset($res[0]['trancode']) ? str_pad($res[0]['trancode'] + 1 , 7, '0', STR_PAD_LEFT)  : '0000001';
	}

	private function sqlgetlasttrannumber()
	{
		$sql = 'SELECT a.trancode FROM tbl_trans a WHERE a.tranyear=? ORDER BY a.trancode DESC LIMIT 1';
		return $sql;
	}


	public function healthHistory()
	{
		$this->db->select('a.*');
		$this->db->from('tbl_lib_history a');
		$this->db->where('a.histstatus', 'Active');
		$this->db->order_by('a.histdesc', 'ASC');
		return $this->db->get()->result_array();
	}
}
