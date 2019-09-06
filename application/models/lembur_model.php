<?php
			
class lembur_model extends MY_Model {
	var $table = 'v_lembur';
	var $primaryID = 'NO_TRANS';
	
	
	
	function lembur_d($notrans){
		$query = $this->db->select()
				->where('no_trans',$notrans)
				->order_by('TGL_LEMBUR')
				->get('lembur_d')->result();
		return $query;
	}
}