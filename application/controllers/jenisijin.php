<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class jenisijin extends MY_App {
	var $branch = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('jenisijin_model');
		$this->load->helper('array');
		$this->load->database();
		$this->config->set_item('mymenu', 'mn1');
		$this->config->set_item('mySubMenu', 'mn16');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Daftar Kelompok Jenis Ijin Cuti/Sakit ');		
		$this->template->load('default','fjenisijin/index',compact('str'));
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select *
					from gen_reff 
					where reff='JATAHCUTI'
					union
					select *
					from gen_reff 
					where reff='CUTIKHUSUS'   ";
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str.= " and  value1 like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ) ";
				//$str.= " ";
				
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
					'REFF'=>($row->REFF=='JATAHCUTI'?'CUTI TAHUNAN':'CUTI KHUSUS'),
					'VALUE1'=>($row->REFF=='JATAHCUTI'?'-':$row->VALUE1),
					'VALUE2'=>($row->REFF=='JATAHCUTI'?$row->VALUE1:$row->VALUE2),
					'VALUE3'=>$row->VALUE3,
					'ACTION'=>'<a href="'.base_url('jenisijin/view/'.$row->ID).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('jenisijin/edit/'.$row->ID).'"><i class="fa fa-edit" title="Edit"></i></a>  '
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
	
	
	public function jenisijinCreate(){
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'nama',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'				
				),
				array(
					'field' => 'durasi',
					'label' => 'DURASI',
					'rules' => 'trim|xss_clean|required'				
				),
				array(
					'field' => 'satuan',
					'label' => 'SATUAN',
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
						'REFF'=>$this->input->post('reff'),
						'ID_REFF'=>$this->input->post('id_ref'),
						'VALUE1' => $this->input->post('nama'),
						'VALUE2' => $this->input->post('durasi'),
						'VALUE3' => $this->input->post('satuan'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'MODIFIED_BY' =>$this->session->userdata('auth')->id,
						'MODIFIED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->insert('gen_reff', $data)){
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
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			//$respon.=$data;
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Tambah Data Item Cuti Khusus');
		$data['idref'] = $this->jenisijin_model->getNextIDRef();		
		$this->template->load('default','fjenisijin/create', $data);
		
	}
	
	public function edit($id=null){
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(				
				
				array(
					'field' => 'durasi',
					'label' => 'DURASI',
					'rules' => 'trim|xss_clean|required'				
				),
				array(
					'field' => 'satuan',
					'label' => 'SATUAN',
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
						'REFF'=>($this->input->post('reff')=="JATAHCUTI"?'JATAHCUTI':$this->input->post('reff')),
						'ID_REFF'=>($this->input->post('reff')=="JATAHCUTI"?'':$this->input->post('id_ref')),
						'VALUE1' => ($this->input->post('reff')=="JATAHCUTI"?$this->input->post('durasi'):$this->input->post('nama')),
						'VALUE2' => ($this->input->post('reff')=="JATAHCUTI"?'':$this->input->post('durasi')),
						'VALUE3' => $this->input->post('satuan'),
						'MODIFIED_BY' =>$this->session->userdata('auth')->id,
						'MODIFIED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->where('ID',$this->input->post('id'))->update('gen_reff', $data)){
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
		
		$this->template->set('pagetitle','Update Data Item Cuti');		
		$data['row'] = $this->jenisijin_model->getEdited($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('jenisijin');
		}
		$data['cabang'] = $this->common_model->comboCabang();
		$data['divisi'] = $this->common_model->comboDivisi();
		$data['jabatan'] = $this->common_model->comboJabatan();
		$this->template->load('default','fjenisijin/edit',$data);
		
	}
	

	public function view($id=null){
		$this->template->set('pagetitle','View Data Item Cuti');
		$data['row'] = $this->jenisijin_model->getEdited($id);
		//$str = $this->jenisijin_model->cekQ($cab, $div, $jab);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('jenisijin');
		}
		
		$this->template->load('default','fjenisijin/view',$data);
	
	}

	
	public function deljenisijin(){
		$cab=$this->input->post('id_cab');
		$div=$this->input->post('id_div');
		$jab=$this->input->post('id_jab');
		$res = $this->jenisijin_model->deljenisijin($cab, $div, $jab);
		//$res = $this->jenisijin_model->cekQ($cab, $div, $jab);
		return $res;
	}
}
