<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{

	public function sqldttransindex()
	{
		$sql = 'SELECT CONCAT(f.ofname, " ", LEFT(f.omname, 1), ". ", f.olname) as fullname, 
					CONCAT(a.tranyear,a.trantype,a.trancode) as trannumber, a.transid, a.oid, a.trandate, a.lid, b.tslibdqty, c.libdprice, d.libdesc, f.ofname, f.omname, f.olname, g.scode,
					SUM((b.tslibdqty * c.libdprice) - (b.tslibdqty * b.tsdiscount)) as totamount,
					GROUP_CONCAT(DISTINCT(g.scode)) as isdisabled
				FROM tbl_trans a 
				LEFT JOIN tbl_trans_serv b ON a.transid=b.transid  AND b.tsstatus=0
				LEFT JOIN tbl_library_det c ON b.tslibdid=c.libdid 
				LEFT JOIN tbl_library_desc des ON c.libdescid=des.libdescid
				LEFT JOIN tbl_library d ON des.libid=d.libid 
				LEFT JOIN tbl_service g ON d.sid=g.sid

				LEFT JOIN tbl_owner f ON a.oid=f.oid 

				WHERE a.transtatus = ? AND 
					(f.ofname LIKE ? OR f.omname LIKE ? OR f.olname LIKE ? OR 
					g.scode LIKE ? OR 
					CONCAT(a.tranyear,a.trantype,a.trancode) LIKE ?) 
				GROUP BY a.transid 
				';
		return $sql;
	}


	public function deltrans($transid)
	{
		$prm = [
	        'transtatus' => 1
		];
		$this->db->where('transid', $transid);
		$res = $this->db->update('tbl_trans', $prm);
		return $res;
	}


	public function transsave()
	{
		try {
			$this->db->trans_start();

			$m_oid = $this->input->post('m_oid');
			$m_fname = strtoupper($this->input->post('m_fname'));
			$m_mname = strtoupper($this->input->post('m_mname'));
			$m_lname = strtoupper($this->input->post('m_lname'));
			$m_address = strtoupper($this->input->post('m_address'));
			$m_contactnum = $this->input->post('m_contactnum');
			$m_emailadd = $this->input->post('m_emailadd');
			$timestamp = date('Y-m-d G:i:s');


			if (strlen(trim($m_oid)) === 0) {
				$prm = ['ofname'=>$m_fname, 'omname'=>$m_mname, 'olname'=>$m_lname, 'oaddress'=>$m_address, 'ocontactnum'=>$m_contactnum, 'oemailadd'=>$m_emailadd, 'odateadded'=>$timestamp];
				$res = $this->db->insert('tbl_owner', $prm);
				$m_oid = $this->my_encrypt->encode($this->db->insert_id());
			} else {
				$oid = $this->my_encrypt->decode($m_oid);
				$prm = [$m_fname, $m_mname, $m_lname, $m_address, $m_contactnum, $m_emailadd, $oid];
				$sql = $this->updateTblOwner();
				$res = $this->db->query($sql, $prm);
			}
		
			


			/*$prm_pet = [0, $oid];
			$sql_pet = $this->updateTblPet();
			$res_pet = $this->db->query($sql_pet, $prm_pet);*/


			/*$prminsert = [];
			$prmupdate = [];
			$m_pid = $this->input->post('m_pid');
			$m_pname = $this->input->post('m_fpetname');
			$m_pbday = $this->input->post('m_fpetbday');

			$this->load->model('Common_model', 'common');

			for ($i=0; $i < count($m_pid); $i++) { 
				$pbday = $this->common->changeDateFormat($m_pbday[$i]);
				if (strlen(trim($m_pid[$i])) === 0) {
					$prm = ['oid'=>$oid, 'pname'=>$m_pname[$i], 'pbday'=>$pbday, 'pstatus'=>1, 'pdateadded'=>$timestamp];
					$prminsert[] = $prm;
				} else {
					$prm = ['pid'=>$m_pid[$i], 'oid'=>$oid, 'pname'=>$m_pname[$i], 'pbday'=>$pbday, 'pstatus'=>1];
					$prmupdate[] = $prm;
				}
			}

			if (count($prminsert) > 0) {
				$this->db->insert_batch('tbl_pet', $prminsert);
			}
			if (count($prmupdate) > 0) {
				$this->db->update_batch('tbl_pet', $prmupdate, 'pid');
			}*/

			$this->db->trans_commit();
			$res = true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$res = false;
		}

		return ['res'=>$res, 'm_oid'=>$m_oid, 'clientname'=>$m_fname . ' ' . $m_lname];
	}



	public function dtownerdata()
	{
		$col = [0=>'ofname', 1=>'omname', 2=>'olname', 3=>'oaddress', 4=>'ocontactnum', 5=>'pname', 6=>'pbday', 7=>'odateadded'];
		$order = $col[$_GET['order']['0']['column']];
        $dir = $_GET['order']['0']['dir'];

		$prm = [ '%'.$_GET['search']['value'].'%',  '%'.$_GET['search']['value'].'%', '%'.$_GET['search']['value'].'%',
				 '%'.$_GET['search']['value'].'%',  '%'.$_GET['search']['value'].'%', '%'.$_GET['search']['value'].'%' ];
		
		$sql_totalrecord = $this->sqldtownerdata();
		$res_totalrecord = $this->db->query($sql_totalrecord, $prm)->result_array();
		
		$prm[] = ($_GET['start'] * 1);
		$prm[] = ($_GET['length'] * 1);
		$sql_limit = $sql_totalrecord . ' ORDER BY ' . $order . ' ' . $dir . ' LIMIT ?, ?';
		$res_limit = $this->db->query($sql_limit, $prm)->result_array();

		return ['limit'=>$res_limit, 'totalrecord'=>count($res_totalrecord)];
	}




	/** select owner*/
	public function selectowner($oid)
	{
		$prm = [$oid];
		$sql = $this->sqlselectowner();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}




	private function sqlselectowner()
	{
		$sql = 'SELECT a.*
				FROM tbl_owner a 
				WHERE a.oid=?';
		return $sql;
	}




	private function sqldtownerdata()
	{
		$sql = 'SELECT a.*, GROUP_CONCAT(b.pname SEPARATOR ", ")  as pname
				FROM tbl_owner a 
				LEFT JOIN tbl_pet b ON a.oid=b.oid AND b.pstatus != 0
				WHERE a.ofname LIKE ? OR a.omname LIKE ? OR a.olname LIKE ? OR
					a.oaddress LIKE ? OR a.ocontactnum LIKE ? OR b.pname LIKE ?
				GROUP BY a.oid';
		return $sql;
	}

	

	private function updateTblOwner()
	{
		$sql = 'UPDATE tbl_owner a 
				SET a.ofname=?, a.omname=?, a.olname=?, a.oaddress=?, a.ocontactnum=?, a.oemailadd=?
				WHERE a.oid=?';
		return $sql;
	}

	private function updateTblPet()
	{
		$sql = 'UPDATE tbl_pet a 
				SET a.pname=?, a.pbday=?, a.specid=?, a.breedid=?, a.pgender=?
				WHERE a.pid=?';
		return $sql;
	}




	/* start pet */
	public function savepet()
	{
		$this->load->model('Common_model', 'common');

		$m_oidpet = $this->my_encrypt->decode($this->input->post('m_oidpet'));
		$m_fpetname = $this->input->post('m_fpetname');
		$m_fpetbday = $this->common->changeDateFormat($this->input->post('m_fpetbday'));
		$m_fpetspecies = $this->input->post('m_fpetspecies');
		$m_fpetbreed = $this->input->post('m_fpetbreed');
		$m_fpetgender = $this->input->post('m_fpetgender');
		//$m_fpethistory = $this->input->post('m_fpethistory');
		$m_pid = $this->input->post('m_pid');
		$timestamp = date('Y-m-d G:i:s');


		if (strlen(trim($m_pid)) === 0) {
			$prm = ['oid'=>$m_oidpet, 'pname'=>$m_fpetname, 'pbday'=>$m_fpetbday, 'specid'=>$m_fpetspecies, 'breedid'=>$m_fpetbreed, 'pgender'=>$m_fpetgender, 'pstatus'=>1, 'pdateadded'=>$timestamp];
			$res = $this->db->insert('tbl_pet', $prm);
		} else {
			$m_pid = $this->my_encrypt->decode($m_pid);
			$prm = [$m_fpetname, $m_fpetbday, $m_fpetspecies, $m_fpetbreed, $m_fpetgender, $m_pid];
			$sql = $this->updateTblPet();
			$res = $this->db->query($sql, $prm);
		}

		return $res;
	}

		/** select owner's pet*/
	public function selectpet($oid)
	{
		$prm = [$oid, 1];
		$sql = $this->sqlselectpet();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}



	public function deletepet($pid)
	{
		$prm = [0, $pid];
		$sql = $this->sqldeletepet();
		$res = $this->db->query($sql, $prm);
		return $res;	
	}


	private function sqldeletepet()
	{
		$sql = 'UPDATE tbl_pet 
				SET pstatus=? 
				WHERE pid=?';
		return $sql;
	}

	private function sqlselectpet()
	{
		$sql = 'SELECT pet.*, breed.breeddesc, spec.specdesc
				FROM tbl_pet pet 
				LEFT JOIN tbl_lib_species spec ON pet.specid=spec.specid
				LEFT JOIN tbl_lib_breed breed ON pet.breedid=breed.breedid
				WHERE pet.oid=? and pet.pstatus = ?';
		return $sql;
	}


	public function editpet($pid)
	{
		$prm = [$pid];
		$sql = $this->sqleditpet();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;	
	}

	private function sqleditpet()
	{
		$sql = 'SELECT pet.*
				FROM tbl_pet pet 
				WHERE pet.pid=?';
		return $sql;
	}

	/* end pet */

	

	/* start add new transaction*/

	public function selectmed()
	{
		$sql = 'SELECT a.libid, a.sid, a.libstatus, a.libdesc,
					CONCAT(a.libdesc, IF(des.libdescitem="", "", CONCAT(" - ", des.libdescitem))) AS libdesc,

					b.libdprice, b.libdexp, b.libdid, b.libdstatus, 
					c.unitcode, b.libdqty, b.libdqtyrem, d.tsstatus
				FROM tbl_library a 
				LEFT JOIN tbl_library_desc des ON a.libid=des.libid 
				LEFT JOIN tbl_library_det b ON des.libdescid=b.libdescid 
				LEFT JOIN tbl_unit c ON b.unitid=c.unitid
				LEFT JOIN tbl_trans_serv d ON b.libdid=d.tslibdid
				
				GROUP BY b.libdid 
				HAVING (a.sid=? AND a.libstatus=1 AND b.libdstatus=1) AND (a.libdesc LIKE ? OR c.unitcode LIKE ?) 
					AND (b.libdqty = 0 OR (b.libdqtyrem > 0 AND b.libdqty > 0)) ';
		return $sql;
	}


	public function addserv($libdid)
	{
		$prm = [$libdid];
		$sql = $this->sqladdserv();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}


	/**
	 * also used in barcode
	 * save transaction
	 */
	public function transave($transid, $oid, $pid, $purid, $trandate, $remarks, $lid, $trantype)
	{
		if (strlen($transid) === 0) {
			$this->load->model('Common_model', 'common');
			$trancode = $this->common->getlasttrannumber();
			$prm = [
				'tranyear' => date('Y'),
				'trancode' => $trancode,
				'trantype' => $trantype,
		        'oid' => $this->my_encrypt->decode($oid),
		        'trandate' => $trandate,
		        'lid' => $lid,
		        'trandateadded' => date('Y-m-d G:i:s')
			];
			$res = $this->db->insert('tbl_trans', $prm);
		} else {
			$transid = $this->my_encrypt->decode($transid);
			$prm = [
		        'trandate' => $trandate,
		        'lid' => $lid
			];
			$this->db->where('transid', $transid);
			$res = $this->db->update('tbl_trans', $prm);
		}
		if (strlen($transid) === 0) {
			$transid = $this->db->insert_id();
		}
		return ['res'=>$res, 'transid'=>$transid];
	}


	public function selecttrans($transid)
	{
		$prm = [$transid];
		$sql = $this->sqlselecttrans();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	public function selecttransserv($transid)
	{
		$prm = [$transid];
		$sql = $this->sqlselecttransserv();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqlselecttrans()
	{
		$sql = 'SELECT 
				CONCAT(a.tranyear,a.trantype,a.trancode) as trannumber, a.oid, a.trandate, a.trancash, a.trandateadded,
				o.ofname, o.omname, o.olname
			FROM tbl_trans a 
			LEFT JOIN tbl_owner o ON a.oid=o.oid
			WHERE a.transid=?';
		return $sql;
	}

	private function sqlselecttransserv()
	{
		$sql = 'SELECT x.*, a.libdprice, b.unitcode, a.libdbarcode, 
				CONCAT(c.libdesc, IF(des.libdescitem="", "", CONCAT("-", des.libdescitem))) AS libdesc, d.sid, d.scode
			FROM tbl_trans_serv x 
			LEFT JOIN tbl_library_det a ON x.tslibdid=a.libdid
			LEFT JOIN tbl_unit b ON a.unitid=b.unitid 
			LEFT JOIN tbl_library_desc des ON a.libdescid=des.libdescid
			LEFT JOIN tbl_library c ON des.libid=c.libid 
			LEFT JOIN tbl_service d ON c.sid=d.sid 

			WHERE x.transid=? AND x.tsstatus=0';
		return $sql;
	}


	/*private function sqlinserttransave()
	{
		$sql = 'INSERT INTO tbl_trans(`oid`, pid, purid, trandate, remarks, lid) 
				VALUES (?,?,?,?,?)';
		return $sql;
	}*/

	/*private function sqlupdatetransave()
	{
		$sql = 'UPDATE tbl_trans 
				SET pid=?, purid=?, trandate=?,remarks=?,lid=? 
				WHERE transid=?';
		return $sql;
	}*/


	private function sqladdserv()
	{
		$sql = 'SELECT a.*, b.unitcode, 
					CONCAT(c.libdesc, IF(des.libdescitem="", "", CONCAT(" - ", des.libdescitem))) AS libdesc, d.scode
				FROM tbl_library_det a 
				LEFT JOIN tbl_unit b ON a.unitid=b.unitid 
				LEFT JOIN tbl_library_desc des ON a.libdescid=des.libdescid
				LEFT JOIN tbl_library c ON des.libid=c.libid 
				LEFT JOIN tbl_service d ON c.sid=d.sid 
				WHERE a.libdid=?';
		return $sql;
	}
	/* end add new transaction*/
	
	/**
	 * start add trans serv
	 * 
	 */
	public function transervsave($transid, $tslibdid, $tslibdqty, $tsdiscount, $transservid)
	{
		$lid = $this->my_encrypt->decode($this->session->userdata('lid'));
		if (strlen($transservid) === 0) {
			$prm = [$transid, $tslibdid, $tslibdqty, 0, $lid, $tsdiscount, date('Y-m-d G:i:s')];
			$sql = $this->sqlinserttranserv();
		} else {
			$transservid = $this->my_encrypt->decode($transservid);
			$prm = [$tslibdqty, $lid, $tsdiscount, $transservid];
			$sql = $this->sqlupdatetranserv();
		}
		$res = $this->db->query($sql, $prm);
		return $res;
	}


	public function transervdel()
	{
		$transservid = $this->my_encrypt->decode(trim($this->input->get('transservid')));
		$prm = [1, $transservid];
		$sql = $this->sqldeleteranserv();
		$res = $this->db->query($sql, $prm);
		return $res;
	}



	private function sqlinserttranserv()
	{
		$sql = 'INSERT INTO tbl_trans_serv(transid, tslibdid, tslibdqty, tsstatus, lid, tsdiscount, tsdateadded) 
				VALUES (?,?,?,?,?,?,?)';
		return $sql;
	}

	private function sqlupdatetranserv()
	{
		$sql = 'UPDATE tbl_trans_serv 
				SET tslibdqty=?, lid=?, tsdiscount=?
				WHERE transservid=?';
		return $sql;
	}

	private function sqldeleteranserv()
	{
		$sql = 'UPDATE tbl_trans_serv 
				SET tsstatus=?
				WHERE transservid=?';
		return $sql;
	}
	/* end add tran serv*/


	/* start pet history*/
	public function selpethistory($pid)
	{	
		$prm = [$pid, 'Active'];
		$sql = $this->sqlselpethistory();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	public function savepethistory()
	{
		$this->load->model('Common_model', 'common');

		$phid = $this->input->get('phid');
		$pid = $this->my_encrypt->decode($this->input->get('pid'));
		$phdesc = $this->input->get('phdesc');
		$phdate = $this->common->changeDateFormat($this->input->get('phdate'));
		$phremarks = $this->input->get('phremarks');


		$prm = ['pid'=>$pid, 'phdesc'=>$phdesc, 'phdate'=>$phdate, 'phremarks'=>$phremarks, 'phstatus'=>'Active'];
		if (strlen(trim($phid)) === 0) {
			$res = $this->db->insert('tbl_pet_history', $prm);
		} else {
			$this->db->where('phid', $this->my_encrypt->decode($phid));
			$res = $this->db->update('tbl_pet_history', $prm);
		}

		return $res;
	}

	public function deletepethistory($phid)
	{
		$prm = ['phstatus'=>'Inactive'];
		$this->db->where('phid', $phid);
		$res = $this->db->update('tbl_pet_history', $prm);
		return $res;
	}


	public function editpethistory($phid)
	{
		$this->db->select('a.*');
		$this->db->from('tbl_pet_history a');
		$this->db->where('a.phid', $phid);
		$res = $this->db->get()->result_array();
		return $res;
	}


	private function sqlselpethistory()
	{
		$sql = 'SELECT * 
				FROM tbl_pet_history 
				WHERE pid=? AND phstatus=? 
				ORDER BY phdate DESC, phdesc ASC';
		return $sql;
	}
	/* end pet history */
}
