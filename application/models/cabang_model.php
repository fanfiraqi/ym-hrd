<?php
			
class cabang_model extends MY_Model {
	var $table="mst_cabang";
	var $primaryID = 'ID_CABANG';
	
	function __construct()
	{
		 parent::__construct(); 
         $this->gate_db=$this->load->database('gate', TRUE);
	} 
	
	function getCabangById($id=0){
		$query = $this->gate_db->select()
			->where($this->primaryID,$id)
			->get($this->table)->row();
		return $query;
	}  
	function ubahStatus($id=null, $sts=null){
		$this->gate_db->trans_begin();
		$sts=($sts=="1"?"0":"1");
		try {
			if ($this->gate_db->where('id_cabang',$id)->update("mst_cabang", array("is_active"=>$sts))){
				$this->gate_db->trans_commit();
				$respon->status = 'success';
			} else {
				throw new Exception("gagal simpan");
			}
		} catch (Exception $e) {
			$respon->status = 'error';
			$respon->errormsg = $e->getMessage();
				$this->gate_db->trans_rollback();
		}
	
	return $respon;
	}
}