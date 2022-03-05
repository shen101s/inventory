<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Species_model extends CI_Model
{
	public function sqldtspeciesindex()
	{
		$sql = 'SELECT a.*
				FROM tbl_lib_species a 
				WHERE a.specdesc LIKE ?';
		return $sql;
	}

	public function sqldtbreedindex()
	{
		$sql = 'SELECT a.*
				FROM tbl_lib_breed a 
				WHERE a.specid=? AND a.breeddesc LIKE ?';
		return $sql;
	}


	public function savespec($specid, $specdesc, $specstatus)
	{
		$prm = [
	        'specdesc' => $specdesc,
	        'specstatus' => $specstatus
		];
		if (strlen($specid) === 0) {
			$res = $this->db->insert('tbl_lib_species', $prm);
		} else {
			$this->db->where('specid', $this->my_encrypt->decode($specid));
			$res = $this->db->update('tbl_lib_species', $prm);
		}	
		
		return $res;
	}

	public function editspec($specid)
	{
		$prm = [$specid];
		$sql = $this->sqleditspec();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}

	private function sqleditspec()
	{
		$sql = 'SELECT a.specdesc, a.specstatus
				FROM tbl_lib_species a 
				WHERE a.specid = ?';
		return $sql;
	}	
	

	/* breed */
	public function savebreed($breedid, $specid, $breeddesc, $breedstatus)
	{
		$prm = [
			'specid' => $this->my_encrypt->decode($specid),
	        'breeddesc' => $breeddesc,
	        'breedstatus' => $breedstatus
		];
		if (strlen($breedid) === 0) {
			$res = $this->db->insert('tbl_lib_breed', $prm);
		} else {
			$this->db->where('breedid', $this->my_encrypt->decode($breedid));
			$res = $this->db->update('tbl_lib_breed', $prm);
		}	
		
		return $res;
	}


	public function editbreed($breedid)
	{
		$prm = [$breedid];
		$sql = $this->sqleditbreed();
		$res = $this->db->query($sql, $prm)->result_array();
		return $res;
	}
	
	private function sqleditbreed()
	{
		$sql = 'SELECT a.*
				FROM tbl_lib_breed a 
				WHERE a.breedid = ?';
		return $sql;
	}
}
