<?php
			
class jabatan_model extends MY_Model {
	var $table = 'mst_jabatan';
	var $primaryID = 'ID_JAB';

	 function __construct()
    {			
		  $this->gate_db=$this->load->database('gate', TRUE);
	}
	function getEdited($id=null){
		$query = $this->gate_db->select("a.id_jab, a.nama_jab,a.kelompok_gaji,a.laz_tasharuf, b.nama_jab 'parentname', a.id_jab_parent,a.golongan, a.klaster, a.bobot_jabatan, a.is_active")
			->from("mst_jabatan a")
			->join('mst_jabatan b ','a.id_jab_parent = b.ID_JAB','left')
			->where('a.ID_JAB',$id)		
			->get()->row();
            //->result_array();
	
	return $query;
	}

	function ubahStatus($id=null, $sts=null){
		$this->gate_db->trans_begin();
		$sts=($sts=="1"?"0":"1");
		try {
			if ($this->gate_db->where('ID_JAB',$id)->update('mst_jabatan', array("IS_ACTIVE"=>$sts))){
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
