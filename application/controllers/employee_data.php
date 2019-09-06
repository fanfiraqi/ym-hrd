<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class employee_data extends MY_App {
	var $branch = array(); var $gate_db;
	function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->config->set_item('mymenu', 'mn2');		
		$this->gate_db=$this->load->database('gate', TRUE);
		$this->auth->authorize();
	}
	
	public function pendidikan()
	{	
		$this->config->set_item('mySubMenu', 'mn291');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('breadcrumbs','<li><a href="#">Pegawai</a></li><li class="active"><span>Pendidikan</span></li>');
		$this->template->set('pagetitle','Kelola Data pendidikan Pegawai');		
		$this->template->load('default','employee/vpendidikan',$data);
	}
	
	public function organisasi()
	{	
		$this->config->set_item('mySubMenu', 'mn292');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->config->set_item('mySubMenu', 'mn292');
		$this->template->set('breadcrumbs','<li><a href="#">Pegawai</a></li><li class="active"><span>Pengalaman Organisasi</span></li>');
		$this->template->set('pagetitle','Kelola Data Pengalaman Organisasi Pegawai');		
		$this->template->load('default','employee/vorganisasi',$data);
	}
	
	public function pengalaman_kerja()
	{	
		$this->config->set_item('mySubMenu', 'mn293');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->config->set_item('mySubMenu', 'mn293');
		$this->template->set('breadcrumbs','<li><a href="#">Pegawai</a></li><li class="active"><span>Pengalaman Kerja</span></li>');
		$this->template->set('pagetitle','Kelola Data Pengalaman Kerja Pegawai');		
		$this->template->load('default','employee/vpengalaman',$data);
	}
	public function getLabelMaster(){
		
		$id_cabang = $this->input->post('id_cabang');
		$id_div = $this->input->post('id_div');
		$id_jab = $this->input->post('id_jab');
		
		$query=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$id_cabang.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$id_div.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$id_jab.") NAMA_JAB ")->row();

		if(empty($query)){
			$respon['str'] = $str;
			$respon['status'] = 'error';
			$respon['errormsg'] = 'Invalid Data';
		} else {
			$respon['status'] = 'success';
			$respon['data'] = $query;
			
		}
		
		echo json_encode($respon);
	}

	public function getPeg(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$data['pesan'] = 'Data karyawan yang dicari tidak ada';
		
		$str = "SELECT *  FROM pegawai where ".($this->session->userdata('auth')->id_cabang>1?"   id_cabang=".$this->session->userdata('auth')->id_cabang." and ":"")."  `STATUS_AKTIF`=1 AND `NAMA` LIKE '%{$keyword}%' or `NIK` LIKE '%{$keyword}%'";
		$query = $this->db->query($str)->result();
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['pesan'] = ''; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array(
					'id'=>$row->NIK,
					'label' => $row->NIK.' - '.$row->NAMA,
					'value' => $row->NAMA,					
					'id_cabang' => $row->ID_CABANG,
					'id_div' => $row->ID_DIV,
					'id_jab' => $row->ID_JAB,
					''
				);
			}
		}
		echo json_encode($data);
	}
	public function getPegToEdu(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$data['pesan'] = 'Data pendidikan karyawan sudah ditambahkan atau data karyawan yang dicari tidak ada';
		
		$str = "SELECT *  FROM pegawai where nik not in (select distinct nik from peg_pendidikan)   ".($this->session->userdata('auth')->id_cabang>1?" and    id_cabang=".$this->session->userdata('auth')->id_cabang:"")." and `STATUS_AKTIF`=1 AND `NAMA` LIKE '%{$keyword}%' or `NIK` LIKE '%{$keyword}%'";
		$query = $this->db->query($str)->result();
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['pesan'] = ''; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array(
					'id'=>$row->NIK,
					'label' => $row->NIK.' - '.$row->NAMA,
					'value' => $row->NAMA,					
					'id_cabang' => $row->ID_CABANG,
					'id_div' => $row->ID_DIV,
					'id_jab' => $row->ID_JAB,
					''
				);
			}
		}
		echo json_encode($data);
	}
	
	public function json_data_pendidikan(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select * from pegawai  where  nik in (select distinct nik from peg_pendidikan)   ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str.= "  and  nama like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or nik like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			}
			
			
			$strfilter = $str;
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$strfilter .= " LIMIT ". mysql_real_escape_string( $_GET['iDisplayStart'] ) .", ". mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
			
			$iFilteredTotal = $this->db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->db->query($strfilter)->result();
			
			$aaData = array();
			foreach($query as $row){
				$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$row->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$row->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$row->ID_JAB.") NAMA_JAB ")->row();
				$aaData[] = array(
					'nik'=>$row->NIK,
					'nama'=>$row->NAMA,
					'cabang'=>$rsname->NAMA_CABANG,
					'divisi'=>$rsname->NAMA_DIV,
					'jabatan'=>$rsname->NAMA_JAB,
					'action'=>"<a href='javascript:void(0)' onclick='editThis(this)' data-id='".$row->NIK."'><i class='fa fa-edit' title='Edit'></i></a> | <a href='javascript:void()' onclick=\"delThis(".$row->NIK.",'".$row->NAMA."')\"><i class='fa fa-trash-o' title='Delete'></i></a>"
				);
			}
			
			$output = array(
			    "str" => $strfilter,
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => $aaData
			);
			echo json_encode($output);
		//}
	}	
	
	
	public function savePendidikan(){
		$isi="awal<br>";
		if ($this->input->is_ajax_request()){	
			$this->load->library('form_validation');
			$state=$this->input->post('state');
			
				$rules = array(				
					array(
						'field' => 'pddk_terakhir',
						'label' => 'PENDIDIKAN_TERAKHIR',
						'rules' => 'trim|xss_clean|required'
					)
				);
			

			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){	
				
				$this->db->trans_begin();
				try {						
					$data = array(
							'nik' => $this->input->post('nik'),
							'pf_terakhir' =>$this->input->post('pddk_terakhir'),													
							'pf_jur_univ' =>$this->input->post('jur_univ'),													
							'pf_ipk' =>$this->input->post('ipk'),													
							'pinf_1' =>$this->input->post('pddk_inf1'),													
							'pinf_2' =>$this->input->post('pddk_inf2'),													
							'pinf_3' =>$this->input->post('pddk_inf3'),
							'pinf_4' =>$this->input->post('pddk_inf4')
						);
							
					if($state=="add"){ 
						
						if ($this->db->insert('peg_pendidikan',$data)){
							$this->db->trans_commit();
							$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}else{
												
						if ($this->db->where('nik',$state)->update('peg_pendidikan',$data)){
									$this->db->trans_commit();
									$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}
					
					
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();
					$this->db->trans_rollback();
				}
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			$respon->data=$isi;	
			echo json_encode($respon);
			
			//redirect('employee_data/index');
		//} 
		
		}
	}
	public function delThis(){
		$id=$this->input->post('idx');
		$nmtable=$this->input->post('proses');
		$field=$this->input->post('field');
		$res = $this->common_model->delThis($id,$nmtable,$field);
		return $res;
	}

	public function editThis(){
		$id = $this->input->post('id');	//id as nik=>peg_pendidikan
		$nmtable=$this->input->post('tabel');
		$field=$this->input->post('field');
		//$str="select peg_pendidikan.*, (select nama from pegawai where nik=peg_pendidikan.nik) namapeg from peg_pendidikan where nik='".$id."'";
		$str="select d.*, p.NAMA, p.id_cabang, p.id_div, p.id_jab from ".$nmtable." d, pegawai p where p.nik=d.nik and d.".$field."='".$id."'";
		$query = $this->db->query($str)->row();		

		if(empty($query)){
			$respon['status'] = 'error';
			$respon['errormsg'] = 'Invalid Data';
		} else {
			//label master
			$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$query->id_cabang.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$query->id_div.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$query->id_jab.") NAMA_JAB ")->row();
			$respon['status'] = 'success';
			$respon['data'] = $query;
			$respon['master'] = $rsname;
			
		}
		echo json_encode($respon);
	}
	
	public function json_data_organisasi(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
						
			$str = "select pegawai.NIK,pegawai.NAMA, pegawai.ID_CABANG,pegawai.ID_DIV,pegawai.ID_JAB ,p.*  from pegawai, `peg_organisasi` p  where  pegawai.nik=p.nik and pegawai.nik in (select distinct nik from `peg_organisasi`)   ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or keterangan like '%".mysql_real_escape_string( $_GET['sSearch'] )."%'";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			}
			
			
			$strfilter = $str;
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$strfilter .= " LIMIT ". mysql_real_escape_string( $_GET['iDisplayStart'] ) .", ". mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
			
			$iFilteredTotal = $this->db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->db->query($strfilter)->result();
			$aaData = array();
			foreach($query as $row){
				$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$row->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$row->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$row->ID_JAB.") NAMA_JAB ")->row();
				$aaData[] = array(
					'ID'=>$row->ID,					
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'KETERANGAN'=>$row->KETERANGAN,
					'CABANG'=>$rsname->NAMA_CABANG,
					'DIVISI'=>$rsname->NAMA_DIV,
					'JABATAN'=>$rsname->NAMA_JAB,
					'ACTION'=>"<a href='javascript:void(0)' onclick='editThis(this)' data-id='".$row->ID."'><i class='fa fa-edit' title='Edit'></i></a> | <a href='javascript:void()' onclick=\"delThis(".$row->ID.",'".$row->NAMA."')\"><i class='fa fa-trash-o' title='Delete'></i></a>"

					
				);
			}
			
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"str" => $str,
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => $aaData
			);
			echo json_encode($output);
		//}
	}

	public function json_data_kerja(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
						
			$str = "select pegawai.NIK,pegawai.NAMA, pegawai.ID_CABANG,pegawai.ID_DIV,pegawai.ID_JAB ,p.*  from pegawai, `peg_pengalaman_kerja` p  where  pegawai.nik=p.nik and pegawai.nik in (select distinct nik from `peg_pengalaman_kerja`)   ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or keterangan like '%".mysql_real_escape_string( $_GET['sSearch'] )."%'";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			}
			
			
			$strfilter = $str;
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$strfilter .= " LIMIT ". mysql_real_escape_string( $_GET['iDisplayStart'] ) .", ". mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
			
			$iFilteredTotal = $this->db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->db->query($strfilter)->result();
			$aaData = array();
			foreach($query as $row){
				$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$row->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$row->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$row->ID_JAB.") NAMA_JAB ")->row();
				$aaData[] = array(
					'ID'=>$row->ID,					
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'KETERANGAN'=>$row->KETERANGAN,
					'CABANG'=>$rsname->NAMA_CABANG,
					'DIVISI'=>$rsname->NAMA_DIV,
					'JABATAN'=>$rsname->NAMA_JAB,
					'ACTION'=>"<a href='javascript:void(0)' onclick='editThis(this)' data-id='".$row->ID."'><i class='fa fa-edit' title='Edit'></i></a> | <a href='javascript:void()' onclick=\"delThis(".$row->ID.",'".$row->NAMA."')\"><i class='fa fa-trash-o' title='Delete'></i></a>"

					
				);
			}
			
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => $aaData
			);
			echo json_encode($output);
		//}
	}
	

	public function saveData_organisasi(){
		if ($this->input->is_ajax_request()){
		
			$this->load->library('form_validation');
			$state=$this->input->post('state');
			
			$rules = array(
				array(
					'field' => 'nik',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'keterangan',
					'label' => 'PENGALAMAN_ORGANISASI',
					'rules' => 'trim|xss_clean|required'
				)
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$this->form_validation->set_message('greater_than', 'Field %s harus lebih besar dari 0.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				
				$this->db->trans_begin();
				try {
					
					$data = array(
						'NIK' => $this->input->post('nik'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					
					if($state=="add"){ 
						
						if ($this->db->insert('peg_organisasi',$data)){
							$this->db->trans_commit();
							$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}else{
												
						if ($this->db->where('ID',$state)->update('peg_organisasi',$data)){
									$this->db->trans_commit();
									$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();
					$this->db->trans_rollback();
				}
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);
			
		}
			
	}


	public function saveData_kerja(){
		if ($this->input->is_ajax_request()){
		
			$this->load->library('form_validation');
			$state=$this->input->post('state');
			
			$rules = array(
				array(
					'field' => 'nik',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'keterangan',
					'label' => 'PENGALAMAN_KERJA',
					'rules' => 'trim|xss_clean|required'
				)
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$this->form_validation->set_message('greater_than', 'Field %s harus lebih besar dari 0.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				
				$this->db->trans_begin();
				try {
					
					$data = array(
						'NIK' => $this->input->post('nik'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					
					if($state=="add"){ 
						
						if ($this->db->insert('peg_pengalaman_kerja',$data)){
							$this->db->trans_commit();
							$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}else{
												
						if ($this->db->where('ID',$state)->update('peg_pengalaman_kerja',$data)){
									$this->db->trans_commit();
									$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();
					$this->db->trans_rollback();
				}
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);
			
		}
			
	}
}
