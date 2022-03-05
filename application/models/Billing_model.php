<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_model extends CI_Model
{
	public function additem($barcode, $libdid, $enc)
	{
		if ($libdid == -1) {
			$prm = [1, $barcode];
			$sql_ = ' AND det.libdbarcode=? ';
		} elseif ($barcode == -1) {

			if ($enc === 'YES') {
				$libdid = $this->my_encrypt->decode($libdid);
			}
			$prm = [1, $libdid];
			$sql_ = ' AND det.libdid=? ';
		}
		
		$sql = $this->sqladditem() . $sql_;
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqladditem()
	{
		$sql = 'SELECT det.libdid, det.libdprice, 
					det.libdqty, det.libdqtyrem, det.libdbarcode, 
					CONCAT(item.libdesc, IF(des.libdescitem="", "", CONCAT(" - ", des.libdescitem))) AS libdesc, unit.unitcode
				FROM tbl_library_det det 
				LEFT JOIN tbl_library_desc des ON det.libdescid=des.libdescid
				LEFT JOIN tbl_library item ON des.libid=item.libid 
				LEFT JOIN tbl_unit unit ON det.unitid=unit.unitid
				WHERE det.libdstatus=? 
					AND (det.libdqty = 0 OR (det.libdqtyrem > 0 AND det.libdqty > 0)) ';
		return $sql;
	}


	/**
	 * also used in barcode
	 */
	public function transave($oid, $trandate, $lid, $trantype, $transdet, $trancash)
	{		
		try {
			$this->db->trans_start();

			$this->load->model('Common_model', 'common');
			$trancode = $this->common->getlasttrannumber();
			$prm = [
				'tranyear' => date('Y'),
				'trancode' => $trancode,
				'trantype' => $trantype,
		        'oid' => $this->my_encrypt->decode($oid),
		        'trandate' => $trandate,
		        'trancash' => $trancash, 
		        'lid' => $lid,
		        'trandateadded' => date('Y-m-d G:i:s')
			];
			$this->db->insert('tbl_trans', $prm);
			$transid = $this->db->insert_id();

			$prm_det = [];
			$len = count($transdet);
			for ($i=0; $i < $len; $i++) { 
				$prm_det[] = [
						'transid' => $transid,
						'tslibdid' => $this->my_encrypt->decode($transdet[$i][0]),
						'tslibdqty' => $transdet[$i][1],
						'tsstatus' => 0,
						'lid' => $this->my_encrypt->decode($this->session->userdata('lid')),
						'tsdiscount' => $transdet[$i][2]
					];
			}
			if ($len > 0) {
				$this->db->insert_batch('tbl_trans_serv', $prm_det);
			}
			
			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = false;
		}

		return ['res'=>$res, 'transid'=>$transid];
	}



	// public function savetransdetails($transid, $transdet)
	// {
	// 	$prm = [];
	// 	$len = count($transdet);
	// 	for ($i=0; $i < $len; $i++) { 
	// 		$prm[] = [
	// 				'transid' => $transid,
	// 				'tslibdid' => $this->my_encrypt->decode($transdet[$i][0]),
	// 				'tslibdqty' => $transdet[$i][1],
	// 				'tsstatus' => 0,
	// 				'empid' => 0,
	// 				'tsdiscount' => $transdet[$i][2]
	// 			];
	// 	}

	// 	$res = $this->db->insert_batch('tbl_trans_serv', $prm);
	// 	return $res;
	// }



	public function searchitem($item)
	{
		$prm = ['%'.$item.'%', '%'.$item.'%'];
		$sql = 'SELECT a.libdid, 
					IF(a.libdbarcode IS NULL, "-", a.libdbarcode) AS libdbarcode, 
					a.libdprice, 
					IF(a.libdexp IS NULL OR a.libdexp="0000-00-00", "", DATE_FORMAT(a.libdexp, \'%b %d, %Y\')) AS libdexp, 
					CONCAT(b.libdesc, IF(des.libdescitem="", "", CONCAT(" - ", des.libdescitem))) AS libdesc, c.unitcode
				FROM tbl_library_det a
				LEFT JOIN tbl_library_desc des ON a.libdescid=des.libdescid
				LEFT JOIN tbl_library b ON des.libid=b.libid
				LEFT JOIN tbl_unit c ON a.unitid=c.unitid
				WHERE a.libdstatus = 1
					AND (a.libdqty = 0 OR (a.libdqtyrem > 0 AND a.libdqty > 0))
					AND (des.libdescitem LIKE ? OR b.libdesc LIKE ?)';
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;


		// $this->db->select('a.libdid, IF(a.libdbarcode IS NULL, "-", a.libdbarcode) AS libdbarcode, a.libdprice, 
		// 	IF(a.libdexp IS NULL OR a.libdexp="0000-00-00", "", DATE_FORMAT(a.libdexp, \'%b %d, %Y\')) AS libdexp, 
		// 	CONCAT(b.libdesc, IF(des.libdescitem="", "", CONCAT(" - ", des.libdescitem))) AS libdesc, c.unitcode');
		// $this->db->from('tbl_library_det a');
		// $this->db->join('tbl_library_desc des', 'a.libdescid=des.libdescid', 'left');
		// $this->db->join('tbl_library b', 'des.libid=b.libid', 'left');
		// $this->db->join('tbl_unit c', 'a.unitid=c.unitid', 'left');
		// $this->db->where('a.libdstatus', 1);
		
		// $this->db->group_start();
		// 	$this->db->or_where('a.libdqty', 0);
		// 	$this->db->group_start();
		// 		$this->db->or_where('a.libdqtyrem >', 0);
		// 		$this->db->where('a.libdqty >', 0);
		// 	$this->db->group_end();
		// $this->db->group_end();

		// $this->db->group_start();
		// 	$this->db->or_where('des.libdescitem LIKE ', '%'.$item.'%');
		// 	$this->db->or_where('b.libdesc LIKE ', '%'.$item.'%');
		// $this->db->group_end();
		// $res = $this->db->get()->result_array();

		// print_r($this->db->last_query());
		// die();
		// return $res;
	}
}
