<?php
			
class pinjaman_model extends MY_Model {
	var $table = 'pinjaman';
	var $primaryID = 'ID';
	
	function getLastID(){
		$str= "SELECT p.*, k.NAMA FROM pinjaman_header p, pegawai k WHERE p.NIK=k.NIK AND p.ID=$id";
		$query = $this->db->query($str)->row();           
		return $query;
	}
	function deletePinjaman($id=null){
		$this->db->trans_begin();
		try {
			if ($this->db->delete('pinjaman_header', array("ID"=>$id))){
				$this->db->trans_commit();
				$respon->status = 'success';
			} else {
				throw new Exception("gagal simpan");
			}
		} catch (Exception $e) {
			$respon->status = 'error';
			$respon->errormsg = $e->getMessage();
				$this->db->trans_rollback();
		}
	
	return $respon;
	}
	
	function getEdited($id=null){
							
		$str= "SELECT p.*, k.NAMA FROM pinjaman_header p, pegawai k WHERE p.NIK=k.NIK AND p.ID=$id";
		$query = $this->db->query($str)->row();
           
	return $query;
	}

	function ubahStatus($id=null, $sts=null){
		$this->db->trans_begin();
		$sts=($sts=="1"?"0":"1");
		try {
			if ($this->db->where('ID',$id)->update('pinjaman', array("ISACTIVE"=>$sts))){
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

	function setLunasAngsuran($idH=null, $idC=null, $tglB=null, $jmlB=null){
		$this->db->trans_begin();
		
		try {
			if ($this->db->where('ID_HEADER',$idH)->where('CICILAN_KE',$idC)->update('pinjaman_angsuran', array("TGL_BAYAR"=>$tglB, "JML_BAYAR"=>$jmlB))){
				//update status tabel master pinjaman
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

	function getAngsuran($id){
		$str= "SELECT IFNULL(MAX(cicilan_ke)+1, 1) jml_ke FROM pinjaman_angsuran WHERE jml_bayar>0 and id_header=$id";		
		$query = $this->db->query($str)->row();           
		return $query;
	}
	function getPinjaman($id){
		$str= "SELECT * FROM pinjaman_header WHERE id=$id";		
		$query = $this->db->query($str)->row();           
		return $query;
	}

	public function getCabAcc($empty=''){
		$str="select * from rekeningperkiraan where level>4 and (idacc like  '1.1.01.%' or idacc like  '1.1.02.%')  and status=1  and id_cab=".$this->session->userdata('auth')->ID_CABANG."  order by idacc";
		$query=$this->db->query($str)->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'idacc','nama',$empty);
		}
		return $combo;
	}
}
