<?php
			
class common_model extends MY_Model {
    function __construct()
	{
		parent::__construct();		
		$this->gate_db=$this->load->database('gate', TRUE);
	} 
	
	public function comboCabang($empty=''){
		$query = $this->gate_db->select()
			->order_by('KOTA')
			->get('mst_cabang')
			->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'id_cabang','kota',$empty);
		}
		return $combo;
	}
	
    public function comboDivisi(){
		$query = $this->gate_db->select()
			->order_by('nama_div')
			->get('mst_divisi')
			->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'id_div','nama_div');
		}
		return $combo;
	}
	public function comboJabatan(){
		$query = $this->gate_db->select()
			->order_by('NAMA_JAB')
			->get('mst_jabatan')
			->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'id_jab','nama_jab');
		}
		return $combo;
	}
	
	public function comboLevelFO(){
		$query = $this->db->select()
			->order_by('ID')
			->get('mst_gaji_fo')
			->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'ID','LEVEL');
		}
		return $combo;
	}

	public function comboKelompokFR(){
		$query = $this->db->select()
			->order_by('KELOMPOK')
			->get('kelompok_fr')
			->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'KELOMPOK','KELOMPOK');
		}
		return $combo;
	}

	public function getCabang($id){
		$query = $this->gate_db->query("select * from mst_cabang where id_cabang=".$id)->row();		
		return $query;
	}
	public function getDivisi(){
		$query = $this->gate_db->select()
			->order_by('NAMA_DIV')
			->get('mst_divisi');
		return $query;
	}
	public function getDivisi_noDirektur(){
		$query = $this->gate_db->query("select * from mst_divisi where ID_DIV <> 1 order by NAMA_DIV");
		return $query;
	}
	public function getJabatan(){
		$query = $this->gate_db->select()
			->order_by('NAMA_JAB')
			->get('mst_jabatan');
		return $query;
	}
	public function comboReff($reff){
		$query = $this->db->select()
			->where(array('reff'=>$reff))
			->order_by('ID_REFF')
			->get('gen_reff')
			->result();
		$combo = array();
		if (!empty($query)){
			//$combo = $this->commonlib->buildcombo($query,'VALUE2','VALUE1');
			$combo = $this->commonlib->buildcombo($query,'ID_REFF','VALUE1');
		}
		return $combo;
	}

	public function comboReffCuti($reff){
		$query = $this->db->select()
			->where(array('reff'=>$reff))
			->order_by('ID_REFF')
			->get('gen_reff')
			->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'VALUE2','VALUE1');
		}
		return $combo;
	}
	public function comboReffPeg($reff){
		$str="";
		if ($reff=='PENDIDIKAN'){
			$str="select * from gen_reff where reff='".$reff."' and value2 in('SMA', 'SARJANA') order by id";
		}else{
			$str="select * from gen_reff where reff='".$reff."' order by id";
		}
		$query = $this->db->query($str)->result();
		$combo = array();
		if (!empty($query)){
			$combo = $this->commonlib->buildcombo($query,'VALUE2','VALUE1');
		}
		return $combo;
	}
	
	public function getDivChild($parent){
		$row = $this->gate_db->query("SELECT LFT,RGT from mst_divisi where id_div=".$parent."")->row();
		$result = $this->gate_db->query("select * from mst_divisi where lft>=".$row->lft." and rgt<=".$row->rgt."")->result();
		$arr = array();
		foreach($result as $item){
			$arr[]=$item->id_div;
		}
		return $arr;
	}
	
	public function nextcol($cur="A"){ // generate next column di XLS: A,B,C, dst.
		$int = ord($cur);
		$int++;
		$chr = chr($int);
		return $chr;
	}

	function delThis($id=null, $nm_table, $nm_field){
		$this->db->trans_begin();
		$str="";
		try {
			
				$str="delete from $nm_table where $nm_field=".$id;
			

			if ($this->db->query($str) ) {
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
	
	
	public function gencode_nik($tgl){
	    
		$query = $this->db->query("select ifnull(max(nik),0) nik, RIGHT(MAX(nik),3) knn from pegawai where nik like '".substr($tgl,6,4).substr($tgl,3,2)."%' limit 1")->row();
		$old=$query->nik;
		$kanan=$query->knn;
		
		$new="";$num="";
		if ($old=='0'){
		    $new=substr($tgl,6,4).substr($tgl,3,2).'001';
		}else{
		    $num=ltrim($kanan, '0');
		    $idk=intval($num)+1;
		    $new=substr($tgl,6,4).substr($tgl,3,2).(strlen($idk)==1?"00".$idk:(strlen($idk)==2?'0'.$idk:$idk)) ;
		}
		
		
		//return $new."#".intval($num)."#idk=".$idk."#".ltrim($kanan, '0')."#".$old;
		return $new;
	}

	public function getDataGenReff() {
		$query = $this->db->query("Select * from gen_reff where REFF = 'STSPEGAWAI'")->result();
		return $query;
	}
}