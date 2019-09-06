<?php
			
class mutasi_model extends MY_Model {
	var $table = 'mutasi';
	var $primaryID = 'ID';
	

	function deleteMutasi($id=null){
		$this->db->trans_begin();
		try {
			if ($this->db->delete('mutasi', array("ID"=>$id))){
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
	
	function getAllList($nik=null){
	$str= "SELECT  p.NAMA, c.KOTA, d.NAMA_DIV, j.NAMA_JAB , (select kota from mst_cabang where id_cabang=m.old_id_cab) OLDCAB, (select nama_div from mst_divisi where id_div=m.old_id_div) OLDDIV, select nama_jab from mst_jabatan where id_jab=m.old_id_jab) OLDJAB, m.*
						FROM mutasi m, pegawai p, mst_cabang c, mst_divisi d, mst_jabatan j
						WHERE m.nik=p.nik  and m.id_cab=c.id_cabang and m.id_div=d.id_div and m.id_jab=j.id_jab and m.NIK='$nik' order by m.ID desc";
		$query = $this->db->query($str)->row();
           
	return $query;
	}
	function getEdited($id=null){
							
		//$str= "SELECT M.*, P.NAMA, C.KOTA, D.NAMA_DIV, J.NAMA_JAB FROM mutasi m, pegawai p, mst_cabang c, mst_divisi d, mst_jabatan j WHERE m.nik=p.nik  and p.id_cabang=c.id_cabang and p.id_div=d.id_div and p.id_jab=j.id_jab and m.ID=$id";
		/*$str= "SELECT  p.NAMA, c.KOTA, d.NAMA_DIV, j.NAMA_JAB ,
						(select kota from mst_cabang where id_cabang=m.old_id_cab) OLDCAB,
						(select nama_div from mst_divisi where id_div=m.old_id_div) OLDDIV,
						(select nama_jab from mst_jabatan where id_jab=m.old_id_jab) OLDJAB,
						m.*
						FROM mutasi m, pegawai p, mst_cabang c, mst_divisi d, mst_jabatan j
						WHERE m.nik=p.nik  and m.id_cab=c.id_cabang and m.id_div=d.id_div and m.id_jab=j.id_jab and m.flag <> 0 and m.ID=$id";*/
		
		$str = "select p.NIK,p.NAMA, p.ID_CABANG,p.ID_DIV,p.ID_JAB, m.*  from pegawai p, mutasi m  where  p.nik=m.nik and m.flag <> 0 and m.ID=$id";

		$query = $this->db->query($str)->row();
           
	return $query;
	}

	
}
