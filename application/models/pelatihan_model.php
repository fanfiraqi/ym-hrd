<?php
			
class pelatihan_model extends MY_Model {
	var $table = 'pelatihan';
	var $primaryID = 'ID';
	
	function deletePelatihan($id=null){
		$this->db->trans_begin();
		try {
			if ($this->db->delete('pelatihan', array("ID"=>$id))){
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
							
		$str= "SELECT p.ID, c.KOTA, d.NAMA_DIV, j.NAMA_JAB, k.NIK, k.NAMA, p.NAMA_PELATIHAN, p.KETERANGAN, p.TANGGAL";
		$str.=" FROM `pelatihan` p, pegawai k, mst_cabang c, mst_divisi d, mst_jabatan j";
		$str.=" where p.nik=k.nik and k.id_cabang=c.id_cabang and k.id_div=d.id_div and k.id_jab=j.id_jab and p.id=$id";
		$query = $this->db->query($str)->row();
           
	return $query;
	}

	function ubahStatus($id=null, $sts=null){
		$this->db->trans_begin();
		$sts=($sts=="1"?"0":"1");
		try {
			if ($this->db->where('ID',$id)->update('pelatihan', array("ISACTIVE"=>$sts))){
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
