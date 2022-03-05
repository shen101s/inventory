<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Services_model extends CI_Model
{

	public function servsave($sid, $scode, $sdescription, $sstatus)
	{
		try {
			$this->db->trans_start();
			if (strlen($sid) === 0) {
				$prm = ['scode'=>$scode, 'sdescription'=>$sdescription, 'sstatus'=>$sstatus];
				$this->db->insert('tbl_service', $prm);
			} else {
				$sid_ = $this->my_encrypt->decode($sid);
				$prm = ['scode'=>$scode, 'sdescription'=>$sdescription, 'sstatus'=>$sstatus];
				$this->db->where('sid', $sid_);
				$this->db->update('tbl_service', $prm);
			}
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}

		return $res;
	}


	public function editservice($sid)
	{
		$prm = [$sid];
		$sql = $this->sqleditservice();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}


	private function sqleditservice()
	{
		$sql = 'SELECT a.* FROM tbl_service a WHERE a.sid=?';
		return $sql;
	}


	public function sqldtservindex()
	{
		$sql = 'SELECT a.*, IF(a.sstatus=1, "Active", "Inactive") as sstatus
				FROM tbl_service a 
				WHERE a.scode LIKE ? OR a.sdescription LIKE ?';
		return $sql;
	}



	public function sqldtservindexprice()
	{

		$sql = 'SELECT a.*, IF(a.libdstatus=1,"Active","Inactive") as libdstatus, b.*, a.libdqtyrem
				FROM tbl_library_det a 
				LEFT JOIN tbl_unit b ON a.unitid=b.unitid

				LEFT JOIN tbl_trans_serv c ON a.libdid=c.tslibdid

				WHERE a.libdescid=? AND 
						(a.libdprice LIKE ? OR a.libdqty LIKE ? OR 
							a.libdexp LIKE ? OR a.libdstatus LIKE ? OR 
							b.unitdesc LIKE ?) 
				GROUP BY a.libdid ';
		return $sql;	
	}



	/*start description*/
	public function sqldtservindexdesc()
	{
		$sql = 'SELECT a.libdescid, a.libid, a.libdescitem, IF(a.libdescstatus=1,"Active","Inactive") as libdescstatus
				FROM tbl_library_desc a 
				WHERE a.libid=? AND 
						a.libdescitem LIKE ?';
		return $sql;	
	}

	public function servdetailssavedesc($libdescid, $libid, $libdescitem, $libdescstatus) 
	{
		try {
			$this->db->trans_start();
			$prm = ['libid'=>$libid, 'libdescitem'=>$libdescitem, 'libdescstatus'=>$libdescstatus];
			if (strlen($libdescid) === 0) {
				$this->db->insert('tbl_library_desc', $prm);
			} else {
				$libid_ = $this->my_encrypt->decode($libdescid);
				$this->db->where('libdescid', $libid_);
				$this->db->update('tbl_library_desc', $prm);
			}
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}

		return $res;
	}

	public function servdescedit($libdescid)
	{
		$prm = [$libdescid];
		$sql = $this->sqlservdescedit();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}


	private function sqlservdescedit()
	{
		$sql = 'SELECT a.* FROM tbl_library_desc a WHERE a.libdescid=?';
		return $sql;
	}




	/*end description*/
	










	/* services details*/
	public function servdetailsedit($libid)
	{
		$prm = [$libid];
		$sql = $this->sqlservdetailsedit();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlservdetailsedit()
	{
		$sql = 'SELECT a.* FROM tbl_library a WHERE a.libid=?';
		return $sql;
	}


	public function servsaveprice($libdescid, $libdid, $unitid, $libdprice, $libdqty, $libdexp_, $libdstatus)
	{
		$this->load->model('Common_model', 'common');
		$libdexp = strlen(trim($libdexp_)) === 0 ? NULL : $this->common->changeDateFormat($libdexp_);
		#$libdbarcode = strlen(trim($libdbarcode_)) === 0 ? NULL : $libdbarcode_;

		try {
			$this->db->trans_start();
			if (strlen($libdid) === 0) {
				$prm = ['libdescid'=>$libdescid, 'unitid'=>$unitid, 'libdprice'=>$libdprice, 'libdqty'=>$libdqty, 'libdqtyrem'=>$libdqty, 'libdexp'=>$libdexp, 'libdstatus'=>$libdstatus, 'libddateadded'=>date('Y-m-d G:i:s')];
				$res = $this->db->insert('tbl_library_det', $prm);
			} else {
				#TODO update only if libdqty=libdqtyrem
				#check if libdqty=libdqtyrem
				$check_qty = $this->checkQtyIsEqual($libdid);
				#$check_qty_trans = $this->checkItemHasTransaction($libdid);

				if ($check_qty === true) {
					$prm = ['unitid'=>$unitid, 'libdprice'=>$libdprice, 'libdqty'=>$libdqty, 'libdqtyrem'=>$libdqty, 'libdexp'=>$libdexp, 'libdstatus'=>$libdstatus];
					$this->db->where('libdid', $libdid);
					$res = $this->db->update('tbl_library_det', $prm);
				} else {
					$res = 2;	// already used. delete the transaction first before updating the qty
				}

				
			}
			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}

		return $res;
	}


	private function checkQtyIsEqual($libdid)
	{
		$this->db->select('a.libdid, a.libdqty, a.libdqtyrem');
		$this->db->from('tbl_library_det a');
		$this->db->where('a.libdid', $libdid);
		$res = $this->db->get()->result_array();

		if (isset($res[0]['libdid']) && trim($res[0]['libdqty']) === trim($res[0]['libdqtyrem'])) {
			return true;
		}
		return false;
	}

	// private function checkItemHasTransaction($libdid)
	// {
	// 	$this->db->select('a.transservid');
	// 	$this->db->from('tbl_trans_serv a');
	// 	$this->db->where('a.libdid', $libdid);
	// 	$this->db->where('a.tsstatus', 0);
	// 	$res = $this->db->get()->result_array();

	// 	if (count($res) > 0) {
	// 		return true;
	// 	}
	// 	return false;
	// }



	public function servpriceedit($libdid)
	{
		$prm = [$libdid];
		$sql = $this->sqlservpriceedit();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlservpriceedit()
	{
		$sql = 'SELECT a.* FROM tbl_library_det a WHERE a.libdid=?';
		return $sql;
	}


	/*qty adjustment*/
	public function servsaveadjustqty($transservid, $tslibdid, $tslibdqty, $tsremarks) 
	{
		try {
			$this->db->trans_start();
			$prm = [
					'transid' => 0, 
					'tslibdid' => $tslibdid, 
					'tslibdqty'=> $tslibdqty, 
					'lid' => $this->my_encrypt->decode($this->session->userdata('lid')), 
					'tsremarks' => $tsremarks,
					'tsdiscount' => '0.00',
					'tslocation' => 'ADJ'
				];

			if (strlen($transservid) === 0) {
				$this->db->insert('tbl_trans_serv', $prm);
			} else {
				$this->db->where('transservid', $transservid);
				$this->db->update('tbl_trans_serv', $prm);
			}
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = $e->getMessage();
		}

		return $res;
	}


	public function serveditadjustqty($transservid)
	{
		$this->db->select('a.*');
		$this->db->from('tbl_trans_serv a');
		$this->db->where('a.transservid', $transservid);
		return $this->db->get()->result_array();
	}
}
