<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class divisi extends MY_App {
	var $branch = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('divisi_model');
		$this->config->set_item('mymenu', 'mn1');
		$this->config->set_item('mySubMenu', 'mn12');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Daftar Divisi/Departemen');		
		$this->template->load('default','fdivisi/index',compact('str'));
	}
	
	
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select m.id_div_parent, m.id_div, nama_div,keterangan, is_active, (select DISTINCT nama_div from mst_divisi where id_div=m.id_div_parent) nama_parent from mst_divisi m";
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str.= " where nama_div like '%".mysql_real_escape_string( $_GET['sSearch'] )."%'  ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			}else{
				$str.=" order by ID_DIV_PARENT, ID_DIV ";
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
					'ID_DIV_PARENT'=>$row->id_div_parent,
					'NAMA_PARENT'=>$row->nama_parent,
					'ID_DIV'=>$row->id_div,
					'NAMA_DIV'=>$row->nama_div,
					'KETERANGAN'=>$row->keterangan,						
					'ISACTIVE'=>($row->is_active=="1"?"Aktif":"Tidak Aktif"),	
					'ACTION'=>'<a href="'.base_url('divisi/view/'.$row->id_div).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('divisi/edit/'.$row->id_div).'"><i class="fa fa-edit" title="Edit"></i></a>  | <a href="javascript:void()" onclick="ubahStatus('.$row->id_div.', '.$row->is_active.')"><i class="fa fa-power-off" title="status"></i></a>'
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
	
	
	public function divCreate(){
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'nama',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'
				),
					array(
					'field' => 'keterangan',
					'label' => 'NAMA DIVISI',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'id_induk',
					'label' => 'INDUK DIVISI',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'id_lama',
					'label' => 'ID LAMA',
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
						'NAMA_DIV'=>$this->input->post('nama'),
						'KETERANGAN'=>$this->input->post('keterangan'),
						'ID_DIV_PARENT'=>$this->input->post('id_induk'),
						'ID_OLD'=>$this->input->post('id_lama'),
						'IS_ACTIVE' => $this->input->post('status'),
						'CREATED_BY'=>$this->session->userdata('auth')->id,
						'CREATED_AT' =>date('Y-m-d H:i:s'),
						'UPDATED_BY'=>$this->session->userdata('auth')->id,
						'UPDATED_AT' =>date('Y-m-d H:i:s')
					);
					if ($this->gate_db->insert('mst_divisi', $data)){
						$this->tree();
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
		
		$this->template->set('pagetitle','Data Divisi Baru');
		$this->template->load('default','fdivisi/create');
		
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
					'field' => 'keterangan',
					'label' => 'NAMA DIVISI',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'id_induk',
					'label' => 'INDUK DIVISI',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'id_lama',
					'label' => 'ID LAMA',
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
						'NAMA_DIV'=>$this->input->post('nama'),
						'KETERANGAN'=>$this->input->post('keterangan'),
						'ID_DIV_PARENT'=>$this->input->post('id_induk'),
						'ID_OLD'=>$this->input->post('id_lama'),
						'IS_ACTIVE' => $this->input->post('status'),
						'UPDATED_BY'=>$this->session->userdata('auth')->id,
						'UPDATED_AT' =>date('Y-m-d H:i:s')
					);
					if ($this->gate_db->where('ID_div',$this->input->post('id'))->update('mst_divisi', $data)){
						$this->tree();
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
		
		$this->template->set('pagetitle','Update Data Divisi');		
		$data['row'] = $this->divisi_model->getEdited($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('divisi');
		}
		$this->template->load('default','fdivisi/edit',$data);
		
	}
	

	public function view($id){
		$this->template->set('pagetitle','View Data Divisi/Departemen');
		$data['row'] = $this->divisi_model->getEdited($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('divisi');
		}
		
		$this->template->load('default','fdivisi/view',$data);
	
	}

	public function cariDivisi(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		//$str="select id_div, nama_div from mst_divisi where nama_div like '%$keyword%'";
		//$query = $this->gate_db->query($str)->result();

		$query = $this->gate_db->select()
			->where('NAMA_DIV LIKE',"%{$keyword}%")
			->order_by('NAMA_DIV')
			->get('mst_divisi')
			->result();

		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array(
					'id'=>$row->id_div,
					'label' => $row->id_div.' - '.$row->nama_div,

					

					''
				);
			}
		}
		echo json_encode($data);
	}
	public function ubahStatus(){
		$id=$this->input->post('idx');
		$sts=$this->input->post('status');
		$res = $this->divisi_model->ubahStatus($id, $sts);
		return $res;
	}
	
	function rebuild_tree($parent,$left) {
        $right = $left+1;
		$str = "select * from mst_divisi where id_div_parent=".$parent."";
		$result = $this->gate_db->query($str)->result();
		foreach ($result as $row){
			$right = $this->rebuild_tree($row->ID_DIV,$right);
		}
		$str2 = "UPDATE mst_divisi SET lft=".$left.", rgt=".$right." where id_div=".$parent."";
		$result2 = $this->gate_db->query($str2);
		return $right+1;
    }
	
	function tree(){
		$this->rebuild_tree(0,0);
	}
}
