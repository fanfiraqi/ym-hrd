<?php
			
class mastergaji_fr_model extends MY_Model {
	var $table = 'mst_gaji_fr';
	var $primaryID = 'ID';
	
	function deletePelatihan($id=null){
		$this->db->trans_begin();
		try {
			if ($this->db->delete('mst_gaji_fr', array("ID"=>$id))){
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
	
	function getEdited($id=null){
							
		$str= "SELECT * from mst_gaji_fr where id=$id";		
		$query = $this->db->query($str)->row();
           
	return $query;
	}

	function ubahStatus($id=null, $sts=null){
		$this->db->trans_begin();
		$sts=($sts=="1"?"0":"1");
		try {
			if ($this->db->where('ID',$id)->update('mst_gaji_fr', array("ISACTIVE"=>$sts))){
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