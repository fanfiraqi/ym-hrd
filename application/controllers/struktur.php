<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class struktur extends MY_App {
	var $branch = array();
	var $branch2 = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('struktur_model');
		$this->load->helper('array');
		$this->load->database();
		$this->config->set_item('mymenu', 'mn1');
		$this->config->set_item('mySubMenu', 'mn14');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Daftar struktur ');		
		$this->template->load('default','fstruktur/index',compact('str'));
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT m.ID_CAB, c.KOTA, m.ID_DIV, d.NAMA_DIV DIVISI, m.ID_JAB, j.NAMA_JAB JABATAN, m.KETERANGAN
							FROM `mst_struktur` m, mst_cabang c, mst_divisi d,mst_jabatan j
							WHERE m.id_cab=c.id_cabang and m.id_div=d.id_div and m.id_jab=j.id_jab ";
			
						
			if ( $_GET['sSearch'] != "" )
			{
				
				$str.= " and  (kota like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or nama_div like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or nama_jab like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ) ";
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
			
			$iFilteredTotal = $this->gate_db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->gate_db->query($strfilter)->result();
			
			$aaData = array();
			foreach($query as $row){
				$aaData[] = array(					
					'KOTA'=>$row->KOTA,
					'DIVISI'=>$row->DIVISI,
					'JABATAN'=>$row->JABATAN,
					'KETERANGAN'=>$row->KETERANGAN,
					'ACTION'=>'<a href="'.base_url('struktur/view/'.$row->ID_CAB.'/'.$row->ID_DIV.'/'.$row->ID_JAB).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('struktur/edit/'.$row->ID_CAB.'/'.$row->ID_DIV.'/'.$row->ID_JAB).'"><i class="fa fa-edit" title="Edit"></i></a>  | <a href="javascript:void()" onclick="delStruktur('.$row->ID_CAB.', '.$row->ID_DIV.', '.$row->ID_JAB.')"><i class="fa fa-trash-o" title="Hapus"></i></a>'
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
	
	
	public function cekDivisi(){
		$id_cab = $this->input->post('id_cabang');
		$id_div= $this->input->post('id_divisi');
		//cek id_div_parent dari id_divisi, jika ada lalu cek id_div_parent di mst_struktur, j tdk ada mk disable
		$str="select distinct id_div_parent, nama_div, (select nama_div from mst_divisi where id_div=B.id_div_parent) nama_parent from mst_divisi B where id_div=".$id_div." and id_div_parent<>0";
		$parent="";
		$child="";
		if ($this->gate_db->query($str)->num_rows()>0){
			$res=$this->gate_db->query($str)->row();
			$parent=$res->nama_parent;
			$child=$res->nama_div;
			if ($res->id_div_parent==1){
				//Level 1 (id_div&id_cab), lgs bisa terus				
				$data['boleh']=1;
			}else{
				//level anak, cek dulu parentnya di struktur, klo ada boleh, klo tdk ada add dulu parentnya
				$strStruk="select distinct id_div from mst_struktur where id_cab=$id_cab and id_div=".$res->id_div_parent;
				if ($this->gate_db->query($strStruk)->num_rows()>0){
					$data['boleh']=1;
				}else{
					$data['boleh']=0;
				}		
				
			}
		}		
		$data['parent']=$parent;
		$data['child']=$child;
		echo json_encode($data);
	}
	public function strukturCreate(){
		
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'keterangan',
					'label' => 'KETERANGAN',
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
						'ID_CAB'=>$this->input->post('id_cabang'),
						'ID_DIV'=>$this->input->post('id_divisi'),
						'ID_JAB' => $this->input->post('id_jabatan'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'CREATED_BY'=>$this->session->userdata('auth')->id,
						'CREATED_AT' =>date('Y-m-d H:i:s'),
						'UPDATED_BY'=>$this->session->userdata('auth')->id,
						'UPDATED_AT' =>date('Y-m-d H:i:s')
					);
					
					$cek="select count(*) JML from mst_struktur where id_cab=".$this->input->post('id_cabang')." and id_div=".$this->input->post('id_divisi')." and id_jab=". $this->input->post('id_jabatan');
					$rCek=$this->gate_db->query($cek)->row();
					if ($rCek->JML>=1){
							throw new Exception("Data Struktur Sudah Ada, Batal simpan");
					}else{
							if ($this->gate_db->insert('mst_struktur', $data)){
								$this->gate_db->trans_commit();
								$respon->status = 'success';
							} else {
								throw new Exception("gagal simpan");
							}					
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();
					$this->gate_db->trans_rollback();
				}				
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			//$respon.=$data;
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Tambah Data struktur Baru');
		$data['cabang'] = $this->common_model->comboCabang();
		$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		//$data['jabatan'] = $this->common_model->comboJabatan();
		$data['jabatan'] = $this->divTreeJab($this->common_model->getJabatan()->result_array());
		$this->template->load('default','fstruktur/create', $data);
		
	}
	
	public function edit($cab=null, $div=null, $jab=null){
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'keterangan',
					'label' => 'KETERANGAN',
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
						'ID_CAB'=>$this->input->post('id_cabang'),
						'ID_DIV'=>$this->input->post('id_divisi'),
						'ID_JAB' => $this->input->post('id_jabatan'),
						'KETERANGAN' => $this->input->post('keterangan'),						
						'UPDATED_BY'=>$this->session->userdata('auth')->id,
						'UPDATED_AT' =>date('Y-m-d H:i:s')
					);
					if ($this->gate_db->where('ID_CAB',$this->input->post('oldCab'))->where('ID_DIV',$this->input->post('oldDiv'))->where('ID_JAB',$this->input->post('oldJab'))->update('mst_struktur', $data)){
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
		
		$this->template->set('pagetitle','Update Data struktur');		
		$data['row'] = $this->struktur_model->getEdited($cab, $div, $jab);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('struktur');
		}
		$data['cabang'] = $this->common_model->comboCabang();
		$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		$data['jabatan'] = $this->divTreeJab($this->common_model->getJabatan()->result_array());
		$this->template->load('default','fstruktur/edit',$data);
		
	}
	

	public function view($cab=null, $div=null, $jab=null){
		$this->template->set('pagetitle','View Data struktur/Departemen');
		$data['row'] = $this->struktur_model->getEdited($cab, $div, $jab);
		//$str = $this->struktur_model->cekQ($cab, $div, $jab);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('struktur');
		}
		
		$this->template->load('default','fstruktur/view',$data);
	
	}

	
	public function delStruktur(){
		$cab=$this->input->post('id_cab');
		$div=$this->input->post('id_div');
		$jab=$this->input->post('id_jab');
		$res = $this->struktur_model->delStruktur($cab, $div, $jab);
		//$res = $this->struktur_model->cekQ($cab, $div, $jab);
		return $res;
	}

	
}
