<?php
			
class Setting_Model extends CI_Model {
	var $table;
	var $primaryID;
	
	function getData(){
		$this->db->select();
		$query = $this->db->get($this->table);
		return $query;
	}
	
	function getById($id=0){
		$query = $this->db->select()
			->where($this->primaryID,$id)
			->get($this->table)->row();
		return $query;
	}
	

}