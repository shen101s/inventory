<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
	public function repsales($startdate, $enddate)
	{
		$prm = [0, $startdate, $enddate];

		$sql_ = ' AND (a.trandate >= ? AND a.trandate <= ? )
                GROUP BY a.trandate ';
		$sql = $this->sqlrepsales($sql_);
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	public function sqlrepsales($sql_)
	{
		$sql = 'SELECT a.trandate, 
					SUM(IF(d.sid=1, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totdmms, 
					SUM(IF(d.sid=2, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totvs, 
					SUM(IF(d.sid=3, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totgs, 
					SUM(IF(d.sid=4, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totos, 
					SUM(IF(d.sid=5, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totvax, 
					SUM(IF(d.sid=6, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totdf,
					SUM(IF(d.sid=7, (b.tslibdqty * c.libdprice) - (b.tsdiscount * b.tslibdqty), 0)) as totdw
				FROM tbl_trans a 
				LEFT JOIN tbl_trans_serv b ON a.transid=b.transid AND b.tsstatus=0
				LEFT JOIN tbl_library_det c ON b.tslibdid=c.libdid 
				LEFT JOIN tbl_library_desc libdesc ON c.libdescid=libdesc.libdescid 
				LEFT JOIN tbl_library d ON libdesc.libid=d.libid 
				WHERE a.transtatus = ? ' . $sql_;
		return $sql;
	}

	public function generateindex($sid, $stock)
	{
		$sql_ = '';
		if ($stock === 'stockonhand') {
			$sql_ = ' AND (c.libdqty=0 OR (c.libdqty > 0 AND c.libdqtyrem > 0)) ';
		} elseif ($stock === 'outofstock') {
			$sql_ = ' AND c.libdqty > 0 AND c.libdqtyrem = 0 ';
		}

		$prm = [$sid];	
		$sql = $this->sqlgenerateindex($sql_);
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlgenerateindex($sql_)
	{
		$sql = 'SELECT a.*, b.*, c.*, 
				IF(c.libdstatus=1,"Active","Inactive") as libdstatus, 
				d.*, c.libdqty, c.libdqtyrem,
				f.trandate, 
				CONCAT(g.fname, " ", LEFT(g.mname, 1), " ", g.lname) as empname, 
				e.tslibdqty,
				libdesc.libdescitem
			FROM tbl_service a 
			LEFT JOIN tbl_library b ON a.sid=b.sid 
			LEFT JOIN tbl_library_desc libdesc ON b.libid=libdesc.libid 
			LEFT JOIN tbl_library_det c ON libdesc.libdescid=c.libdescid 
			LEFT JOIN tbl_unit d ON c.unitid=d.unitid
			LEFT JOIN tbl_trans_serv e ON c.libdid=e.tslibdid 
			LEFT JOIN tbl_trans f ON e.transid=f.transid AND (f.transtatus=0 OR f.transtatus IS NULL)
			LEFT JOIN tbl_login g ON e.lid=g.lid
			WHERE c.libdstatus=1 AND a.sid=? ' . $sql_ . '
			GROUP BY c.libdid 
			ORDER BY b.libdesc ASC';
		return $sql;
	}


	public function stockcard($libdid)
	{
		$prm = [$libdid];
		$sql = $this->sqlstockcard();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlstockcard()
	{
		$sql = 'SELECT 
				transerv.transservid, transerv.tslibdqty, transerv.tsdiscount, transerv.tsremarks, transerv.tslocation, transerv.tsdateadded, 
				CONCAT(trans.tranyear,trans.trantype,trans.trancode) as trannumber
			FROM tbl_trans_serv transerv 
			LEFT JOIN tbl_trans trans ON transerv.transid=trans.transid
			WHERE transerv.tslibdid=? AND transerv.tsstatus=0
			ORDER BY transerv.tsdateadded ASC';
		return $sql;
	}

	public function stockcardHeader($libdid)
	{
		$prm = [$libdid];
		$sql = $this->sqlstockcardHeader();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlstockcardHeader()
	{
		$sql = 'SELECT 
				libdet.libdid, libdet.libdbarcode, libdet.libdprice, libdet.libdqty, 
				DATE_FORMAT(libdet.libdexp, \'%b %d, %Y\') AS libdexp,
				libdesc.libdescitem,
				lib.libdesc,
				unit.unitcode
			FROM tbl_library_det libdet
			LEFT JOIN tbl_library_desc libdesc ON libdet.libdescid=libdesc.libdescid 
			LEFT JOIN tbl_library lib ON libdesc.libid=lib.libid 
			LEFT JOIN tbl_unit unit ON libdet.unitid=unit.unitid
			WHERE libdet.libdid=?';
		return $sql;
	}


	public function repstockissuance($startdate, $enddate)
	{
		$prm = [$startdate, $enddate, $startdate, $enddate];
		$sql = $this->sqlrepstockissuance();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlrepstockissuance()
	{
		$sql = 'SELECT a.trandate, CONCAT(a.tranyear,a.trantype,a.trancode) as trannumber, 
					b.tslibdqty, b.tsdiscount, b.tsremarks, b.tslocation, 
					c.libdprice, libdesc.libdescitem, d.libdesc, 
					unit.unitcode
				FROM tbl_trans a 
				LEFT JOIN tbl_trans_serv b ON a.transid=b.transid
				LEFT JOIN tbl_library_det c ON b.tslibdid=c.libdid 
				LEFT JOIN tbl_library_desc libdesc ON c.libdescid=libdesc.libdescid 
				LEFT JOIN tbl_library d ON libdesc.libid=d.libid 
				LEFT JOIN tbl_unit unit ON c.unitid=unit.unitid
				WHERE a.transtatus = 0 AND b.tsstatus = 0 AND (a.trandate >= ? AND a.trandate <= ? )

				UNION 

				SELECT DATE_FORMAT(adj_b.tsdateadded, \'%b %d, %Y\') AS trandate, "" AS trannumber,
					adj_b.tslibdqty, adj_b.tsdiscount, adj_b.tsremarks, adj_b.tslocation, 
					adj_c.libdprice, adj_libdesc.libdescitem, adj_d.libdesc, 
					adj_unit.unitcode
				FROM tbl_trans_serv adj_b
				LEFT JOIN tbl_library_det adj_c ON adj_b.tslibdid=adj_c.libdid 
				LEFT JOIN tbl_library_desc adj_libdesc ON adj_c.libdescid=adj_libdesc.libdescid 
				LEFT JOIN tbl_library adj_d ON adj_libdesc.libid=adj_d.libid 
				LEFT JOIN tbl_unit adj_unit ON adj_c.unitid=adj_unit.unitid
				WHERE adj_b.tsstatus = 0 AND adj_b.tslocation="ADJ" AND (DATE_FORMAT(adj_b.tsdateadded, \'%Y-%m-%d\') >= ? AND DATE_FORMAT(adj_b.tsdateadded, \'%Y-%m-%d\') <= ? )

                ORDER BY trandate ASC';
		return $sql;
	}




	// public function repmedicine($checkval='false')
	// {
	// 	$prm = [1];
	// 	$sql_ = '';
	// 	if ($checkval == 'true') {
	// 		$expdate = date('Y-m-d', strtotime("+6 months"));
	// 		$sql_ = ' AND c.libdexp < ? AND c.libdexp != "0000-00-00" ';
	// 		$prm[] = $expdate;
	// 	}
		
	// 	$sql = $this->sqlrepmedicine($sql_);
	// 	$res = $this->db->query($sql, $prm)->result_array();
	// 	return $res;
	// }

	// public function repsupply($checkval='false')
	// {
	// 	$prm = [4];
	// 	$sql_ = '';
	// 	if ($checkval == 'true') {
	// 		$expdate = date('Y-m-d', strtotime("+6 months"));
	// 		$sql_ = ' AND c.libdexp < ? AND c.libdexp != "0000-00-00" ';
	// 		$prm[] = $expdate;
	// 	}
	// 	$sql = $this->sqlrepmedicine($sql_);
	// 	$res = $this->db->query($sql, $prm)->result_array();

	// 	return $res;
	// }


	// public function repfood($checkval='false')
	// {
	// 	$prm = [6];
	// 	$sql_ = '';
	// 	if ($checkval == 'true') {
	// 		$expdate = date('Y-m-d', strtotime("+6 months"));
	// 		$sql_ = ' AND c.libdexp < ? AND c.libdexp != "0000-00-00" ';
	// 		$prm[] = $expdate;
	// 	}
	// 	$sql = $this->sqlrepmedicine($sql_);
	// 	$res = $this->db->query($sql, $prm)->result_array();

	// 	return $res;
	// }


	// public function repvaccine($checkval='false')
	// {
	// 	$prm = [5];
	// 	$sql_ = '';
	// 	if ($checkval == 'true') {
	// 		$expdate = date('Y-m-d', strtotime("+6 months"));
	// 		$sql_ = ' AND c.libdexp < ? AND c.libdexp != "0000-00-00" ';
	// 		$prm[] = $expdate;
	// 	}
	// 	$sql = $this->sqlrepmedicine($sql_);
	// 	$res = $this->db->query($sql, $prm)->result_array();

	// 	return $res;
	// }


	// public function repcommission($startdate, $enddate)
	// {
	// 	$prm = [3, $startdate, $enddate];
	// 	$sql_ = ' AND (f.trandate >= ? AND f.trandate <= ?) ';
	// 	$sql = $this->sqlrepmedicine($sql_);
	// 	$res = $this->db->query($sql, $prm)->result_array();
	// 	return $res;
	// }


	// private function sqlrepmedicine($sql_)
	// {
	// 	$sql = 'SELECT a.*, b.*, c.*, 
	// 				IF(c.libdstatus=1,"Active","Inactive") as libdstatus, 
	// 				d.*, 
	// 				c.libdqty, c.libdqtyrem,
	// 				f.trandate, 
	// 				CONCAT(g.fname, " ", LEFT(g.mname, 1), " ", g.lname) as empname, 
	// 				e.tslibdqty
	// 		FROM tbl_service a 
	// 		LEFT JOIN tbl_library b ON a.sid=b.sid 
	// 		LEFT JOIN tbl_library_desc libdesc ON b.libid=libdesc.libid
	// 		LEFT JOIN tbl_library_det c ON libdesc.libdescid=c.libdescid 

	// 		LEFT JOIN tbl_unit d ON c.unitid=d.unitid
	// 		LEFT JOIN tbl_trans_serv e ON c.libdid=e.tslibdid 
	// 		LEFT JOIN tbl_trans f ON e.transid=f.transid AND  (f.transtatus=0 OR f.transtatus IS NULL)
	// 		LEFT JOIN tbl_login g ON e.lid=g.lid
	// 		WHERE c.libdstatus=1 AND a.sid=? ' . $sql_ . '
	// 		GROUP BY c.libdid 
	// 		ORDER BY b.libdesc ASC';
	// 	return $sql;
	// }


	

}
