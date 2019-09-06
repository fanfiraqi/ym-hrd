<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pelatihan extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->load->model('pelatihan_model');
		$this->config->set_item('mymenu', 'mn2');
		$this->auth->authorize();
	}
	
	public function index()
	{	$this->config->set_item('mySubMenu', 'mn25');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Daftar Catatan Pelatihan Karyawan');		
		$this->template->load('default','employee/vpelatihan',$data);
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			
			$str = "select pegawai.NIK,pegawai.NAMA, pegawai.ID_CABANG,pegawai.ID_DIV,pegawai.ID_JAB ,p.*  from pegawai, `pelatihan` p  where  pegawai.nik=p.nik and pegawai.nik in (select distinct nik from pelatihan)   ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or nama_pelatihan like '%".mysql_real_escape_string( $_GET['sSearch'] )."%'";
				
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
					'PELATIHAN'=>$row->NAMA_PELATIHAN,
					'CABANG'=>$rsname->NAMA_CABANG,
					'DIVISI'=>$rsname->NAMA_DIV,
					'JABATAN'=>$rsname->NAMA_JAB,
					'ACTION'=>"<a href='javascript:void(0)' onclick='editThis(this)' data-id='".$row->ID."'><i class='fa fa-edit' title='Edit'></i></a> | <a href='javascript:void()' onclick=\"delThis(".$row->ID.",'".$row->NAMA."')\"><i class='fa fa-trash-o' title='Delete'></i></a>"

					//'ACTION'=>'<a href="'.base_url('pelatihan/view/'.$row->ID).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | <a href="'.base_url('pelatihan/edit/'.$row->ID).'"><i class="fa fa-pencil" title="Edit"></i></a> | <a href="javascript:void()" onclick="delpelatihan('.$row->ID.')"><i class="fa fa-trash-o" title="Delete"></i></a>'
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
	
	public function delThis(){
		$id=$this->input->post('idx');
		$nmtable=$this->input->post('proses');
		$field=$this->input->post('field');
		$res = $this->common_model->delThis($id,$nmtable,$field);
		return $res;
	}

	public function editThis(){
		$id = $this->input->post('id');	//id as nik
		//$str="select peg_pendidikan.*, (select nama from pegawai where nik=peg_pendidikan.nik) namapeg from peg_pendidikan where nik='".$id."'";
		$str="select d.*, p.NAMA, p.id_cabang, p.id_div, p.id_jab from pelatihan d, pegawai p where p.nik=d.nik and d.id='".$id."'";
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
					'field' => 'pelatihan',
					'label' => 'PELATIHAN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'keterangan',
					'label' => 'KETERANGAN',
					'rules' => 'trim|xss_clean|required||callback_comparetime'
				),
				array(
					'field' => 'tanggal',
					'label' => 'TANGGAL',
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
						'NAMA_PELATIHAN' => $this->input->post('pelatihan'),
						'TANGGAL' => $this->input->post('tanggal'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					
					if($state=="add"){ 
						
						if ($this->db->insert('pelatihan',$data)){
							$this->db->trans_commit();
							$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}else{
												
						if ($this->db->where('ID',$state)->update('pelatihan',$data)){
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
