<?php
			
class pengguna_model extends MY_Model {
	var $table = 'mst_user';
	var $primaryID = 'ID';

	function deleteUser($id=null){
		$this->db->trans_begin();
		try {
			if ($this->db->delete('mst_user', array("ID"=>$id))){
				$this->db->trans_commit();
				$respon->status = 'success';
			} else {
				throw new Exception("gagal simpan");
			}
		} catch (Exception $e) {
			$respon->status = 'error';
			$respon->errormsg = $e->getMessage();;
				$this->db->trans_rollback();
		}
	
	return $respon;
	}
}