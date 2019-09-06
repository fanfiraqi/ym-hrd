<?php
			
class resign_model extends MY_Model {
	var $table = 'resign';
	var $primaryID = 'ID';
	

	function deleteResign($id=null, $nik=null){
		$this->db->trans_begin();
		try {
			if ($this->db->delete('resign', array("ID"=>$id))){
				/*$dataPeg = array(
						'STATUS_AKTIF' => 1
						);*/
						//update data pegawai
				$this->db->where('NIK',$nik)->update('pegawai', array('STATUS_AKTIF'=>1));
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
							
		$str= "SELECT m.*, p.NAMA, p.ID_CABANG, p.ID_DIV, p.ID_JAB  FROM resign m, pegawai p WHERE m.nik=p.nik  and m.ID=$id";
		$query = $this->db->query($str)->row();
           
	return $query;
	}

	
}
