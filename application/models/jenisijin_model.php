<?php
			
class jenisijin_model extends MY_Model {
	var $table = 'gen_reff';
	var $primaryID = 'ID';
	
	
	function getNextIDRef(){
		$query = $this->db->select("max(id_reff)+1 JML")
			->from("gen_reff")
			->where('reff','CUTIKHUSUS')		
			->get();           
	return $query->row();
	}

	function cekQ($cab, $div, $jab){
		
		$str="delete from mst_jenisijin where id_cab=$cab and id_div=$div and id_jab=$jab";
		$query = $this->db->query($str);		 
		return $this->db->affected_rows();
	}
	function getEdited($id){
		$str= "select * from gen_reff where id=$id";		
		$query = $this->db->query($str)->row();		
	return $query;
	}

	function deljenisijin($id=null){		
		$str="delete from gen_reff where id=$id";
		$this->db->query($str);		 
		return $this->db->affected_rows();
	}

}