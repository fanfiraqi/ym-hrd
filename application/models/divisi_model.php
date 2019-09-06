<?php
			
class divisi_model extends MY_Model {
	
	var $table;
	var $primaryID = 'ID_div';

	 function __construct()
    {			
		  parent::__construct(); 
          $this->gate_db=$this->load->database('gate', TRUE);
	}
	function getEdited($id=null){
		/*$this->load->database();
		$strfilter="SELECT A.ID_DIV, A.NAMA_DIV, COALESCE(B.NAMA_DIV,'-') AS 'PARENTNAME', A.KETERANGAN, A.ID_DIV_PARENT, A.ID_OLD
					FROM mst_divisi AS a LEFT JOIN mst_divisi AS b on a.id_div_parent = b.ID_div and a.id_div=$id";
		$query = $this->gate_db->query($strfilter);*/				
		$query = $this->gate_db->select("a.ID_DIV, a.NAMA_DIV, b.NAMA_DIV 'PARENTNAME', a.KETERANGAN, a.ID_DIV_PARENT, a.ID_OLD, a.IS_ACTIVE")
			->from("mst_divisi a")
			->join('mst_divisi b ','a.id_div_parent = b.ID_div','left')
			->where('a.id_div',$id)		
			->get()->row();
            //->result_array();
	
	return $query;
	}

	function ubahStatus($id=null, $sts=null){
		$this->gate_db->trans_begin();
		$sts=($sts=="1"?"0":"1");
		try {
			if ($this->gate_db->where('ID_DIV',$id)->update('mst_divisi', array("IS_ACTIVE"=>$sts))){
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
	
	return $respon;
	}
}
