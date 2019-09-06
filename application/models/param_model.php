<?php
			
class param_model extends MY_Model {
	
	public function get($name,$all=false){
		$query = $this->db->select()
			->where('LOWER(name)',strtolower($name))
			->get('params')
			->row();
		if ($all){
			return $query;
		} else {
			return $query->value1;
		}
	}
	
}