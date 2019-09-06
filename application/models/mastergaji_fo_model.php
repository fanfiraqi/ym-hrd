<?php
			
class mastergaji_fo_model extends MY_Model {
	var $table = 'mst_gaji_fo';
	var $primaryID = 'ID';
	
	function deletePelatihan($id=null){
		$this->db->trans_begin();
		try {
			if ($this->db->delete('mst_gaji_fo', array("ID"=>$id))){
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
							
		$str= "SELECT * from mst_gaji_fo where id=$id";		
		$query = $this->db->query($str)->row();
           
	return $query;
	}

	function ubahStatus($id=null, $sts=null){
		$this->db->trans_begin();
		$sts=($sts=="1"?"0":"1");
		try {
			if ($this->db->where('ID',$id)->update('mst_gaji_fo', array("ISACTIVE"=>$sts))){
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

	function naikLevel($nik=null, $idLevelOld=null){
		//cek level, level atasnya, update status_eval sblmnya =0, insert level baru dg status_eval=1, lalu edit query getView krn status
		$stmtNext = $this->db->query("SELECT * FROM mst_gaji_fo WHERE id > $idLevelOld ORDER BY id LIMIT 1;");
		$respon = new StdClass();
		if ($stmtNext->num_rows()>0){
			$rsNext=$stmtNext->row();	//dilevel next
			$stmtCurr = $this->db->query("SELECT evaluasi_fo.*, DATE_ADD(TGL_AKHIR, INTERVAL ".$rsNext->TERMIN." Month) TGLBARU FROM evaluasi_fo WHERE NIK='$nik' and id_level=$idLevelOld and status_eval=1");
			$rsCurr=$stmtCurr->row();	//dilevel current			
			$tglMulai_new=$rsCurr->TGL_AKHIR;
			$tglakhir_new=$rsCurr->TGLBARU;
			
			$this->db->trans_begin();			
			try {

				if ($this->db->where('NIK',$nik)->where('ID_LEVEL',$idLevelOld)->where('STATUS_EVAL',1)->update('evaluasi_fo', array("STATUS_EVAL"=>0))){
					$this->db->trans_commit();
					$data = array(
						'NIK' => $nik,
						'ID_LEVEL' => $rsNext->ID,
						'STATUS_EVAL' => 1,
						'TGL_MULAI' => $tglMulai_new,
						'TGL_AKHIR' => $tglakhir_new,
						'CREATED_BY' =>'admin',
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>'admin',
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					$this->db->insert('evaluasi_fo', $data);
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
		}
		
	
	return $respon;
	}
	function levelTetap($nik=null, $idLevelOld=null){
		//cek level current ambil termin, update status_eval sblmnya =0, insert level baru dg status_eval=1
		$stmtNext = $this->db->query("SELECT * FROM mst_gaji_fo WHERE id = $idLevelOld ORDER BY id LIMIT 1;");
		$respon = new StdClass();
		if ($stmtNext->num_rows()>0){
			$rsNext=$stmtNext->row();	//dilevel next
			$idLevelx=$rsNext->ID;
			$stmtCurr = $this->db->query("SELECT evaluasi_fo.*, DATE_ADD(TGL_AKHIR, INTERVAL ".$rsNext->TERMIN." Month) TGLBARU FROM evaluasi_fo WHERE NIK='$nik' and id_level=$idLevelOld and status_eval=1");
			$rsCurr=$stmtCurr->row();	//dilevel current			
			$tglMulai_new=$rsCurr->TGL_AKHIR;
			$tglakhir_new=$rsCurr->TGLBARU;
			
			$this->db->trans_begin();			
			try {

				if ($this->db->where('NIK',$nik)->where('ID_LEVEL',$idLevelOld)->where('STATUS_EVAL',1)->update('evaluasi_fo', array("STATUS_EVAL"=>0))){
					$this->db->trans_commit();
					$data = array(
						'NIK' => $nik,
						'ID_LEVEL' => $idLevelx,
						'STATUS_EVAL' => 1,
						'TGL_MULAI' => $tglMulai_new,
						'TGL_AKHIR' => $tglakhir_new,
						'CREATED_BY' =>'admin',
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>'admin',
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					$this->db->insert('evaluasi_fo', $data);
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
		}
	
	return $respon;
	}

	function turunLevel($nik=null, $idLevelOld=null){
		//cek level, level atasnya, update status_eval sblmnya =0, insert level baru dg status_eval=1, lalu edit query getView krn status
		$stmtNext = $this->db->query("SELECT * FROM mst_gaji_fo WHERE id < $idLevelOld ORDER BY id LIMIT 1;");
		$respon = new StdClass();
		if ($stmtNext->num_rows()>0){
			$rsNext=$stmtNext->row();	//dilevel next
			$stmtCurr = $this->db->query("SELECT evaluasi_fo.*, DATE_ADD(TGL_AKHIR, INTERVAL ".$rsNext->TERMIN." Month) TGLBARU FROM evaluasi_fo WHERE NIK='$nik' and id_level=$idLevelOld and status_eval=1");
			$rsCurr=$stmtCurr->row();	//dilevel current			
			$tglMulai_new=$rsCurr->TGL_AKHIR;
			$tglakhir_new=$rsCurr->TGLBARU;
			
			$this->db->trans_begin();			
			try {

				if ($this->db->where('NIK',$nik)->where('ID_LEVEL',$idLevelOld)->where('STATUS_EVAL',1)->update('evaluasi_fo', array("STATUS_EVAL"=>0))){
					$this->db->trans_commit();
					$data = array(
						'NIK' => $nik,
						'ID_LEVEL' => $rsNext->ID,
						'STATUS_EVAL' => 1,
						'TGL_MULAI' => $tglMulai_new,
						'TGL_AKHIR' => $tglakhir_new,
						'CREATED_BY' =>'admin',
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>'admin',
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					$this->db->insert('evaluasi_fo', $data);
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
		}
	
	return $respon;
	}
}