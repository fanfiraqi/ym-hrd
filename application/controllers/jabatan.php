<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jabatan extends MY_App {
	var $branch = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('jabatan_model');
		$this->config->set_item('mymenu', 'mn1');
		$this->config->set_item('mySubMenu', 'mn13');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Daftar Jabatan ');		
		$this->template->load('default','fjabatan/index',compact('str'));
	}
	
	
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select m.*, (select distinct NAMA_JAB from mst_jabatan where id_jab=m.ID_JAB_PARENT) nama_parent from mst_jabatan m";
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str.= " where nama_jab like '%".mysql_real_escape_string( $_GET['sSearch'] )."%'  ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			}else{ $str.="order by bobot_jabatan desc"; }
			
			
			$strfilter = $str;
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$strfilter .= " LIMIT ". mysql_real_escape_string( $_GET['iDisplayStart'] ) .", ". mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
			
			$iFilteredTotal = $this->gate_db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->gate_db->query($strfilter)->result();
			
			$aaData = array();
			foreach($query as $row){
				$aaData[] = array(
					
					'ID_JAB'=>$row->id_jab,
					'NAMA_JAB'=>$row->nama_jab,
					'GOLONGAN'=>$row->golongan,
					'KLASTER'=>$row->klaster,
					'BOBOT_JABATAN'=>$row->bobot_jabatan,
					'ID_JAB_PARENT'=>$row->id_jab_parent,
					'NAMA_PARENT'=>$row->nama_parent,					
					'IS_ACTIVE'=>($row->is_active=="1"?"Aktif":"Tidak Aktif"),	
					'ACTION'=>'<a href="'.base_url('jabatan/view/'.$row->id_jab).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('jabatan/edit/'.$row->id_jab).'"><i class="fa fa-edit" title="Edit"></i></a>  | <a href="javascript:void()" onclick="ubahStatus('.$row->id_jab.', '.$row->is_active.')"><i class="fa fa-power-off" title="status"></i></a>'
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
	
	
	public function jabCreate(){
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'nama',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'				
				),
				array(
					'field' => 'id_induk',
					'label' => 'INDUK jabatan',
					'rules' => 'trim|xss_clean|required'
				)
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				
				$this->gate_db->trans_begin();
				try {						
					$data = array(						
						'NAMA_JAB'=>$this->input->post('nama'),
						'ID_JAB_PARENT'=>$this->input->post('id_induk'),
						'GOLONGAN' => $this->input->post('golongan'),
						'KLASTER' => $this->input->post('klaster'),
						'BOBOT_JABATAN' => $this->input->post('bobot'),
						'KELOMPOK_GAJI' => $this->input->post('kelompok_gaji'),
						'LAZ_TASHARUF' => $this->input->post('laz_tasharuf'),
						'IS_ACTIVE' => $this->input->post('status'),
						'CREATED_BY'=>$this->session->userdata('auth')->id,
						'CREATED_AT' =>date('Y-m-d H:i:s'),
						'UPDATED_BY'=>$this->session->userdata('auth')->id,
						'UPDATED_AT' =>date('Y-m-d H:i:s')
					);
					if ($this->gate_db->insert('mst_jabatan', $data)){
						$this->gate_db->trans_commit();
					} else {
						throw new Exception("gagal simpan");
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();
					$this->gate_db->trans_rollback();
				}
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			//$respon.=$data;
			echo json_encode($respon);
			exit;
		
		} 
		$data['golongan']=$this->arrGolongan;
		$data['klaster']=$this->arrKlaster;
		$this->template->set('pagetitle','Tambah Data Jabatan Baru');
		$this->template->load('default','fjabatan/create', $data);
		
	}
	
	public function edit($id=null){
	
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'nama',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'				
				),
				array(
					'field' => 'id_induk',
					'label' => 'INDUK jabatan',
					'rules' => 'trim|xss_clean|required'
				)
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				
				$this->gate_db->trans_begin();
				try {
						
					$data = array(
						'NAMA_JAB'=>$this->input->post('nama'),
						'ID_JAB_PARENT'=>$this->input->post('id_induk'),
						'GOLONGAN' => $this->input->post('golongan'),
						'KLASTER' => $this->input->post('klaster'),
						'BOBOT_JABATAN' => $this->input->post('bobot'),
						'KELOMPOK_GAJI' => $this->input->post('kelompok_gaji'),
						'LAZ_TASHARUF' => $this->input->post('laz_tasharuf'),
						'IS_ACTIVE' => $this->input->post('status'),						
						'UPDATED_BY'=>$this->session->userdata('auth')->id,
						'UPDATED_AT' =>date('Y-m-d H:i:s')
					);
					if ($this->gate_db->where('ID_JAB',$this->input->post('id'))->update('mst_jabatan', $data)){
						$this->gate_db->trans_commit();
					} else {
						throw new Exception("gagal simpan");
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();
					$this->gate_db->trans_rollback();
				}
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Update Data jabatan');		
		$data['row'] = $this->jabatan_model->getEdited($id);
		$data['golongan']=$this->arrGolongan;
		$data['klaster']=$this->arrKlaster;
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('jabatan');
		}
		$this->template->load('default','fjabatan/edit',$data);
		
	}
	

	public function view($id){
		$this->template->set('pagetitle','View Data jabatan/Departemen');
		$data['row'] = $this->jabatan_model->getEdited($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('jabatan');
		}
		$data['golongan']=$this->arrGolongan;
		$data['klaster']=$this->arrKlaster;
		$this->template->load('default','fjabatan/view',$data);
	
	}

	public function cariJabatan(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		//$str="select ID_JAB, nama_jab from mst_jabatan where nama_jab like '%$keyword%'";
		//$query = $this->gate_db->query($str)->result();

		$query = $this->gate_db->select()
			->where('nama_jab LIKE',"%{$keyword}%")
			->order_by('nama_jab')
			->get('mst_jabatan')
			->result();

		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array(
					'id'=>$row->id_jab,
					'label' => $row->id_jab.' - '.$row->nama_jab,	

					''
				);
			}
		}
		
		echo json_encode($data);
	}
	public function ubahStatus(){
		$id=$this->input->post('idx');
		$sts=$this->input->post('status');
		$res = $this->jabatan_model->ubahStatus($id, $sts);
		return $res;
	}
}
