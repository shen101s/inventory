<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barcode_model extends CI_Model
{
	public function displayBarcodeList($category)
	{
		$prm = [1];
		$sql = 'SELECT lib.libdesc, desc_.libdescitem, det.libdbarcode
				FROM tbl_service serv
				LEFT JOIN tbl_library lib ON serv.sid=lib.sid
				LEFT JOIN tbl_library_desc desc_ ON lib.libid=desc_.libid
				LEFT JOIN tbl_library_det det ON desc_.libdescid=det.libdescid
				WHERE serv.sstatus=? AND lib.libstatus=1 AND desc_.libdescstatus=1 AND det.libdstatus 
					AND (det.libdqty = 0 OR (det.libdqtyrem > 0 AND det.libdqty > 0))';
		if ($category !== 'all') {
			$prm[] = $category;
			$sql .= ' AND serv.sid = ? ';
		}
		$sql .= ' ORDER BY det.libdbarcode DESC ';
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;

	}
}
