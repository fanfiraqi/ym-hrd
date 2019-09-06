<?php
			
class struktur_model extends MY_Model {
	var $table = 'mst_struktur';
	var $primaryID = 'ID_JAB';
	
	 function __construct()
    {			
		  parent::__construct(); 
          $this->gate_db=$this->load->database('gate', TRUE);
	}
	function cekData($id_cab, $id_div, $id_jab){
		$query = $this->gate_db->select("count(*) JML")
			->from("mst_struktur")
			->where('id_cab',$id_cab)		
			->where('id_div',$id_div)		
			->where('id_jab',$id_jab)		
			->get();           
	return $query->result();
	}

	function cekQ($cab, $div, $jab){
		/*$str= "select M.ID_CAB, C.KOTA, M.ID_DIV, D.NAMA_DIV, M.ID_JAB, J.NAMA_JAB, M.KETERANGAN";
		$str.=" from `mst_struktur` m, mst_cabang c, mst_divisi d,mst_jabatan j";
		$str.=" where m.id_cab =c.id_cabang and m.id_div=d.id_div and m.id_jab=j.id_jab and m.id_cab=$cab and m.id_div=$div and m.id_jab=$jab";*/
		$str="delete from mst_struktur where id_cab=$cab and id_div=$div and id_jab=$jab";
		$query = $this->gate_db->query($str);		 
		return $this->gate_db->affected_rows();
	}
	function getEdited($cab, $div, $jab){
		$str= "select m.ID_CAB, c.KOTA, m.ID_DIV, d.NAMA_DIV, m.ID_JAB, j.NAMA_JAB, m.KETERANGAN";
		$str.=" from `mst_struktur` m, mst_cabang c, mst_divisi d,mst_jabatan j";
		$str.=" where m.id_cab =c.id_cabang and m.id_div=d.id_div and m.id_jab=j.id_jab and m.id_cab=$cab and m.id_div=$div and m.id_jab=$jab";
		$query = $this->gate_db->query($str)->row();
		
	return $query;
	}

	function delStruktur($cab=null, $div=null, $jab=null){
		//$cab."#".$div."#".$jab
		/*		$this->gate_db->trans_begin();

		try {
			if ($this->gate_db->delete('mst_struktur', array("ID_CAB"=>$cab, "ID_DIV"=>$div, "ID_JAB"=>$jab))) {
				$this->gate_db->trans_commit();
				$respon->status = 'success';
			} else {
				throw new Exception("gagal simpan");
			}
		} catch (Exception $e) {
			$respon->status = 'error';
			$respon->errormsg = $e->getMessage();;
				$this->gate_db->trans_rollback();
		}	
	return $respon;*/
		$str="delete from mst_struktur where id_cab=$cab and id_div=$div and id_jab=$jab";
		$this->gate_db->query($str);		 
		return $this->gate_db->affected_rows();
	}

}
