<?php
			
class thr_model extends MY_Model {
	var $table = '';
	var $primaryID = '';

	
	public function comboTahunStaff($empty=''){
		$query = $this->db->query("select distinct TAHUN from mst_thr_staff")->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'TAHUN','TAHUN',$empty);
		}
		return $combo;
	}
}
