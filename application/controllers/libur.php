<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class libur extends MY_App {
	var $branch = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('libur_model');
		$this->config->set_item('mymenu', 'mn1');
		$this->config->set_item('mySubMenu', 'mn15');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Daftar Libur Nasional');		
		$this->template->load('default','flibur/index',compact('str'));
	}
	
	
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select * from mst_harilibur ";
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str.= " where nama_libur like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
			}
			
			//$str .= " ORDER BY id_libur desc, tgl_awal asc";

			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			}else{
				$str .= " ORDER BY  tgl_awal asc";
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
				$aaData[] = array(
					'ID_LIBUR'=>$row->ID_LIBUR,
					'TGL_AWAL'=>$row->TGL_AWAL,
					'NAMA_LIBUR'=>$row->NAMA_LIBUR,					
					'ISACTIVE'=>($row->ISACTIVE=="1"?"Aktif":"Tidak Aktif"),					
					'ACTION'=>'<a href="'.base_url('libur/view/'.$row->ID_LIBUR).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('libur/edit/'.$row->ID_LIBUR).'"><i class="fa fa-edit" title="Edit"></i></a> | <a href="javascript:void()" onclick="ubahStatus('.$row->ID_LIBUR.', '.$row->ISACTIVE.')"><i class="fa fa-power-off" title="status"></i></a>'
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
	
	
	public function liburCreate(){
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'tgl_awal',
					'label' => 'TGL_AWAL',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'nama',
					'label' => 'NAMA_LIBUR',
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
						'TGL_AWAL' => $this->input->post('tgl_awal'),
						'NAMA_LIBUR' => $this->input->post('nama'),
						'ISACTIVE' => $this->input->post('status'),
						'CREATED_BY' =>'admin',
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>'admin',
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->insert('`mst_harilibur`', $data)){
						$this->db->trans_commit();
					} else {
						throw new Exception("gagal simpan");
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();;
					$this->db->trans_rollback();
				}
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Tambah Data Hari Libur Nasional');
		$this->template->load('default','flibur/create');
		
	}
	
	public function edit($id=null){
	
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'tgl_awal',
					'label' => 'TGL_AWAL',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'nama',
					'label' => 'NAMA_LIBUR',
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
						'TGL_AWAL' => $this->input->post('tgl_awal'),
						'NAMA_LIBUR' => $this->input->post('nama'),
						'ISACTIVE' => $this->input->post('status'),
						'UPDATED_BY' =>'admin',
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->where('ID_LIBUR',$this->input->post('id'))->update('`mst_harilibur`', $data)){
						$this->db->trans_commit();
					} else {
						throw new Exception("gagal simpan");
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
			exit;
		
		} 
		
		$this->template->set('pagetitle','Update Data libur');
		$data['row'] = $this->libur_model->getById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('libur');
		}
		$this->template->load('default','flibur/edit',$data);
		
	}
	
	public function view($id){
		$this->template->set('pagetitle','View Data libur');
		$data['row'] = $this->libur_model->getById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('libur');
		}
		
		$this->template->load('default','flibur/view',$data);
	
	}

	public function ubahStatus(){
		$id=$this->input->post('idx');
		$sts=$this->input->post('status');
		$res = $this->libur_model->ubahStatus($id, $sts);
		return $res;
	}
}
