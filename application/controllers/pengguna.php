<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pengguna extends MY_App {
	var $branch = array();
	

	function __construct()
	{
		parent::__construct();
		$this->load->model('pengguna_model');
		$this->config->set_item('mymenu', 'menuSatu');
		$this->auth->authorize('login','logout','dologin');
		
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Daftar Pengguna Aplikasi');		
		$this->template->load('default','fpengguna/index',compact('str'));
		
	}
	
	
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select * from mst_user";
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " where `nik` like '%".mysql_real_escape_string( $_GET['sSearch'] )."' or `username` like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
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
				$aaData[] = array(
					'ID'=>$row->ID,
					'USERNAME'=>$row->USERNAME,
					'PASSWORD'=>"***",
					'NIK'=>$row->NIK,
					'ROLE_AKSES'=>$row->ROLE,
					'ISACTIVE'=>($row->ISACTIVE=="1"?"Aktif":"Tidak Aktif"),
					'ACTION'=>'<a href="'.base_url('pengguna/view/'.$row->ID).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('pengguna/edit/'.$row->ID).'"><i class="fa fa-edit" title="Edit"></i></a> | 
						<a href="javascript:void()" onclick="delUser('.$row->ID.')"><i class="fa fa-trash-o" title="Delete"></i></a>'
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
	
	public function delUser(){
		$id=$this->input->post('idx');
		$res = $this->pengguna_model->deleteUser($id);
		return $res;
	}
	public function userCreate(){
		$respon = new StdClass();
		$respon->status="";
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'username',
					'label' => 'USERNAME',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'password',
					'label' => 'PASSWORD',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'nik',
					'label' => 'NIK',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'status',
					'label' => 'STATUS',
					'rules' => 'trim|xss_clean|required'
				)
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			
			if ($this->form_validation->run() == TRUE){
				
				$this->db->trans_begin();
				try {						
					$data = array(
						'USERNAME' => $this->input->post('username'),
						'PASSWORD' => md5($this->input->post('password')),
						'NIK' => $this->input->post('nik'),
						'ROLE' => $this->input->post('role'),
						'ISACTIVE' => $this->input->post('status'),						
						'CREATED_BY' =>'admin',
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>'admin',
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->insert('mst_user', $data)){
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
		
		$this->template->set('pagetitle','Data Pengguna Baru');
		$this->template->load('default','fpengguna/create', $respon);
		
	}
	
	public function edit($id=null){
		
		$data["status"]="";
		if($this->input->post())
		{	
			$respon = new StdClass();
			$role=$this->session->userdata('auth')->ROLE;
			$this->load->library('form_validation');
			if ($role=='Admin'){
				$rules = array(				
					array(
						'field' => 'username',
						'label' => 'USERNAME',
						'rules' => 'trim|xss_clean|required'
					),
					array(
						'field' => 'password',
						'label' => 'PASSWORD',
						'rules' => 'trim|xss_clean|required'
					),
					array(
						'field' => 'nik',
						'label' => 'NIK',
						'rules' => 'trim|xss_clean|required'
					)
				);
			}else{
				$rules = array(			
					
					array(
						'field' => 'password',
						'label' => 'PASSWORD',
						'rules' => 'trim|xss_clean|required'
					),
					array(
						'field' => 'nik',
						'label' => 'NIK',
						'rules' => 'trim|xss_clean|required'
					)
				);
			}
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			if ($this->form_validation->run() == TRUE){
				
				$this->db->trans_begin();
				try {
						
					if ($role=='Admin'){
						$data = array(
							'USERNAME' => $this->input->post('username'),
							'PASSWORD' => md5($this->input->post('password')),
							'NIK' => $this->input->post('nik'),
							'ROLE' => $this->input->post('role'),
							'ISACTIVE' => $this->input->post('status'),			
							'UPDATED_BY' =>'admin',
							'UPDATED_DATE' =>date('Y-m-d H:i:s')
						);
					}else{
						$data = array(							
							'PASSWORD' => md5($this->input->post('password')),
							'NIK' => $this->input->post('nik'),								
							'UPDATED_BY' =>'admin',
							'UPDATED_DATE' =>date('Y-m-d H:i:s')
						);
					}	
					if ($this->db->where('ID',$this->input->post('id'))->update('mst_user', $data)){
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
			$data["status"] =$respon->status;
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Update Data Pengguna');
		$data['row'] = $this->pengguna_model->getById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('pengguna');
		}
		$this->template->load('default','fpengguna/edit',$data);
		
	}
	
	public function view($id){
		$this->template->set('pagetitle','View Data Pengguna');
		$data['row'] = $this->pengguna_model->getById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('pengguna');
		}
		
		$this->template->load('default','fpengguna/view',$data);
	
	}
	
	public function login(){
		if ($this->auth->is_login()){
			redirect('/');
		}
		
		$this->load->view('login');
	}
	
	public function dologin(){
		if ($this->input->is_ajax_request()){
			$user = trim(strip_tags($this->input->post('username')));
			$password = md5(stripslashes(trim($this->input->post('password'))));
			if($this->auth->do_login($user,$password)){
				$data['response']='true';
			} else {
				$data['response']='false';
			}
			echo json_encode($data); 
		} else {
			redirect('/');
		}
	}
	
	public function logout(){
		$this->auth->logout();
		//redirect('/');
		redirect($this->config->item('gate_link')."/keluar");
	}
}
