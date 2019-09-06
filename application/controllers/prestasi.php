<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class prestasi extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->load->model('prestasi_model');
		$this->config->set_item('mymenu', 'mn2');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->config->set_item('mySubMenu', 'mn24');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Daftar Catatan Prestasi');		
		$this->template->load('default','employee/vprestasi',$data);
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "select pegawai.NIK,pegawai.NAMA, pegawai.ID_CABANG,pegawai.ID_DIV,pegawai.ID_JAB ,p.*  from pegawai, `prestasi` p  where  pegawai.nik=p.nik and pegawai.nik in (select distinct nik from `prestasi`)   ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or nama_penilaian like '%".mysql_real_escape_string( $_GET['sSearch'] )."%'";
				
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
					'NAMA_PENILAIAN'=>$row->NAMA_PENILAIAN,
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

	
	public function saveData(){
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
					'field' => 'nama_penilaian',
					'label' => 'NAMA_PENILAIAN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tgl_dibuat',
					'label' => 'TGL_DIBUAT',
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
						'NAMA_PENILAIAN' => $this->input->post('nama_penilaian'),
						'TANGGAL_DIBUAT' => $this->input->post('tgl_dibuat'),
						'NO_DOKUMEN' => $this->input->post('no_dokumen'),
						'REVISI' => $this->input->post('revisi'),
						'PERIODE_PENILAIAN' => $this->input->post('periode_penilaian'),
						'NILAI_PRESTASI' => $this->input->post('nilai'),
						'EV_KEUNGGULAN' => $this->input->post('keunggulan'),
						'EV_PERBAIKAN' => $this->input->post('diperbaiki'),
						'EV_SARAN' => $this->input->post('saran'),
						'EV_USULAN_PELATIHAN' => $this->input->post('usulan'),
						'TGL_EVALUASI' => $this->input->post('tgl_evaluasi'),
						'TANGGAPAN' => $this->input->post('tanggapan'),
						'PETUGAS_EVALUASI' => $this->input->post('petugas_eval'),
						'TGL_TERIMA' => $this->input->post('tgl_terima'),
						'TERIMA_OLEH' => $this->input->post('petugas_terima'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					
					if($state=="add"){ 
						
						if ($this->db->insert('prestasi',$data)){
							$this->db->trans_commit();
							$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}else{
												
						if ($this->db->where('ID',$state)->update('prestasi',$data)){
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
	

	public function delThis(){
		$id=$this->input->post('idx');
		$nmtable=$this->input->post('proses');
		$field=$this->input->post('field');
		$res = $this->common_model->delThis($id,$nmtable,$field);
		return $res;
	}

	public function editThis(){
		$id = $this->input->post('id');	//id as nik
		$str="select d.*, p.NAMA, p.id_cabang, p.id_div, p.id_jab from prestasi d, pegawai p where p.nik=d.nik and d.id='".$id."'";
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
	
	
}
