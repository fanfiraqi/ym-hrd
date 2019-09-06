<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cabang extends MY_App {
	var $branch = array(); var $gate_db;
	function __construct()
	{
		parent::__construct();
		$this->load->model('cabang_model');
		$this->config->set_item('mymenu', 'mn1');
		$this->config->set_item('mySubMenu', 'mn11');
		$this->gate_db=$this->load->database('gate', TRUE);
		$this->auth->authorize();
	}
	
	public function index()
	{	
		
		$this->template->set('breadcrumbs','<li><a href="#">Pengaturan</a></li><li class="active"><span>Cabang</span></li>');
		$this->template->set('pagetitle','Daftar Cabang');		
		$this->template->load('default','fcabang/index',compact('str'));
	}
	
	
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$data['cabang'] =$this->common_model->comboCabang();
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select * from mst_cabang ";
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str.= " where KOTA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or ALAMAT like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
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
			
			$iFilteredTotal = $this->gate_db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->gate_db->query($strfilter)->result();
			
			$aaData = array();
			foreach($query as $row){
				$aaData[] = array(
					'ID_CABANG'=>$row->id_cabang,
					'KOTA'=>$row->kota,
					'KODE'=>$row->kode,
					'ALAMAT'=>$row->alamat,
					'TELEPON'=>$row->telepon,
					'IS_ACTIVE'=>($row->is_active=="1"?"Aktif":"Tidak Aktif"),
					'ACTION'=>'<a href="'.base_url('cabang/view/'.$row->id_cabang).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('cabang/edit/'.$row->id_cabang).'"><i class="fa fa-edit" title="Edit"></i></a> | <a href="javascript:void()" onclick="ubahStatus('.$row->id_cabang.', '.$row->is_active.')"><i class="fa fa-power-off" title="status"></i></a>'
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
	
	
	public function cabangCreate(){
		$data["status"]="";
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'kota',
					'label' => 'KOTA',
					'rules' => 'trim|xss_clean|required'
				),
					array(
					'field' => 'kode',
					'label' => 'KODE',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'alamat',
					'label' => 'ALAMAT',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'telepon',
					'label' => 'TELEPON',
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
						'KOTA' => $this->input->post('kota'),
						'KODE' => $this->input->post('kode'),
						'ALAMAT' => $this->input->post('alamat'),
						'TELEPON' => $this->input->post('telepon'),
						'IS_ACTIVE' => $this->input->post('status'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'created_at' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'updated_at' =>date('Y-m-d H:i:s')
					);
					if ($this->gate_db->insert("mst_cabang", $data)){
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
			$data["status"] =$respon->status;
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Data Cabang Baru');
		$this->template->load('default','fcabang/create', $data);
		
	}
	
	public function edit($id=null){
		$data["status"]="";
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'kota',
					'label' => 'KOTA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'kode',
					'label' => 'KODE',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'alamat',
					'label' => 'ALAMAT',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'telepon',
					'label' => 'TELEPON',
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
						'KOTA' => $this->input->post('kota'),
						'KODE' => $this->input->post('kode'),
						'ALAMAT' =>$this->input->post('alamat'),
						'TELEPON' => $this->input->post('telepon'),
						'IS_ACTIVE' => $this->input->post('status'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'updated_at' =>date('Y-m-d H:i:s')
					);
					if ($this->gate_db->where('ID_CABANG',$this->input->post('id'))->update($this->config->item("front_db").'.mst_cabang', $data)){
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
			$data["status"] =$respon->status;
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Update Data Cabang');
		$data['row'] = $this->cabang_model->getCabangById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('cabang');
		}
		$this->template->load('default','fcabang/edit',$data);
		
	}
	
	public function view($id){
		$this->template->set('pagetitle','View Data Cabang');
		$data['row'] = $this->cabang_model->getCabangById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('cabang');
		}
		
		$this->template->load('default','fcabang/view',$data);
	
	}

	public function ubahStatus(){
		$id=$this->input->post('idx');
		$sts=$this->input->post('status');
		$res = $this->cabang_model->ubahStatus($id, $sts);
		return $res;
	}
}
