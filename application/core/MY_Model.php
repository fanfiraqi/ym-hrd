<?php
			
class MY_Model extends CI_Model {
	var $table;
	var $primaryID;
	var $gate_db;
	

	public function __construct() 
     {
           parent::__construct(); 
           $this->gate_db=$this->load->database('gate', TRUE);
           
     }

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
	
	function getByNama($keyword=''){
		$query = $this->db->select()
			->where('P.NAMA LIKE',"%{$keyword}%")
			->or_where('P.NIK LIKE',"%{$keyword}%")
			->order_by('P.NAMA')
			->get('v_pegawai P')
			->result();
		return $query;
	}

}