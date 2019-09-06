<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lembur extends MY_App {
	var $role;
	function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->load->model('lembur_model');
		$this->config->set_item('mymenu', 'mn2');
		$this->auth->authorize();
		$this->role=$this->config->item('myrole');
	}
	
	public function index()
	{
		$this->config->set_item('mySubMenu', 'mn23');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Daftar Permohonan Lembur');		
		$this->template->load('default','lembur/index',$data);
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT *
				FROM v_lembur
				WHERE `ISACTIVE` = 1  ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
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
					'NO_TRANS'=>$row->NO_TRANS,
					'TGL_TRANS'=>revdate($row->TGL_TRANS),
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'CABANG'=>$rsname->NAMA_CABANG.'/'.$rsname->NAMA_DIV.'/'.$rsname->NAMA_JAB,					
					'ACTION'=>'<a href="javascript:void(0)" data-url="'.base_url('lembur/view').'" data-id="'.$row->NO_TRANS.'" onclick="view(this)"><i class="fa fa-eye" title="Lihat"></i></a> | 
						<a href="'.base_url('lembur/edit?notrans='.$row->NO_TRANS).'"><i class="fa fa-pencil" title="Edit"></i></a>'
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
	
	
	public function appv_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$status= $this->input->get('status');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT *
				FROM v_lembur
				WHERE ".($status==1?' `ISACTIVE` = 0 ':' `ISACTIVE` = 1 ').($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."   and approved= ".$status);
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
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
					'NO_TRANS'=>$row->NO_TRANS,
					'TGL_TRANS'=>revdate($row->TGL_TRANS),
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'CABANG'=>$rsname->NAMA_CABANG.'/'.$rsname->NAMA_DIV.'/'.$rsname->NAMA_JAB,
					'ACTION'=>'<a href="javascript:void(0)" data-url="'.base_url('lembur/view/'.$row->NO_TRANS).'" data-id="'.$row->NO_TRANS.'" data-isactive="'.$row->ISACTIVE.'" data-sts="'.$status.'" onclick="view(this)" class="btn btn-act btn-success"><i class="fa '.($status==1?" fa-eye ":" fa-gear ").'" title="Validasi"></i></a>'

				);
			}
			
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $iTotal,
				"strfilter" => $strfilter,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => $aaData
			);
			echo json_encode($output);
		//}
	}
	
	public function create(){
		if($this->input->post())
		{
			
			$this->load->library('form_validation');
			
			
			$rules = array(
				array(
					'field' => 'nik',
					'label' => 'NAMA',
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
					
					
					$tgllembur = revdate($this->input->post('tgllembur'));
					$notrans = $this->commonlib->gencode('LEMBUR');
					
					$data = array(
						'NO_TRANS' => $notrans,
						'NIK' => $this->input->post('nik'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					
					
					
					if ($this->db->insert('lembur', $data)){
						//simpan codegen_d
						//pindahan commonlib->gencode -edit dulu
						$datacode = array(
							'REFF' => 'LEMBUR',
							'TAHUN' => substr($notrans,0,4),
							'BULAN' => substr($notrans,5,2),
							'TANGGAL' => date('d'),
							'NOMOR' => intval(substr($notrans, 13,3)),
							'VALUE' => $notrans
						);

						//if (empty($query)){
						$this->db->insert('codegen_d',$datacode);

						$detail = array();
						$cnt = 0;
						$tanggal = $this->input->post('tanggal');
						$mulai_h = $this->input->post('mulai_h');
						$mulai_m = $this->input->post('mulai_m');
						$selesai_h = $this->input->post('selesai_h');
						$selesai_m = $this->input->post('selesai_m');
						$alasan = $this->input->post('alasan');
						foreach($tanggal as $row){
							
							$tgl = revdate($row);
							$jam_mulai = $tgl . ' ' . $mulai_h[$cnt] . ':' . $mulai_m[$cnt];
							$jam_selesai = $tgl . ' ' . $selesai_h[$cnt] . ':' . $selesai_m[$cnt];
							$totaljam = (strtotime($jam_selesai) - strtotime($jam_mulai))/(60*60);
							$detail[] = array(
								'NO_TRANS' => $notrans,
								'TGL_LEMBUR' => $tgl,
								'JAM_MULAI' => $jam_mulai,
								'JAM_SELESAI' => $jam_selesai,
								'JML_JAM'=>$totaljam,
								'KETERANGAN'=>$alasan[$cnt]
							);
							$cnt++;
						}
						if ($this->db->insert_batch('lembur_d',$detail)){
							/*//$str="update cuti_lembur set sisa_jam=sisa_jam+".$totaljam." where nik='".$this->input->post('nik')."'";
							//$this->db->query($str);
							if ($this->db->query("select * from cuti_lembur where nik='".$this->input->post('nik')."'")->num_rows()<=0){
								$isi=array('NIK'=>$this->input->post('nik'),
									"SISA_JAM"=>$totaljam,
									"SISA_HARI"=>($totaljam>7?floor($totaljam/7):0)
									);
								$this->db->insert('cuti_lembur', $isi);
							}else{
								$this->db->where('NIK',$this->input->post('id'))->update('cuti_lembur', array('SISA_JAM'=>'SISA_JAM+'.$totaljam, "SISA_HARI"=>($totaljam>7?'SISA_HARI+'.floor($totaljam/7):0)));

							}*/
							$this->db->trans_commit();
							$respon->status = 'success';
						}
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
			echo json_encode($respon);
			exit;
		}
			else
		{
			$this->template->set('pagetitle','Pengajuan Lembur');
			
			$data = array();
			$data['cek']= $this->commonlib->gencode('LEMBUR');
			$this->template->load('default','lembur/create',$data);
		}
	}
	
	function comparetime($awal,$selesai){
		$tgllembur = revdate($this->input->post('tgllembur'));
		$jam_mulai = strtotime($tgllembur." ".$this->input->post('mulai_h').":".$this->input->post('mulai_m'));
		$jam_selesai = strtotime($tgllembur." ".$this->input->post('selesai_h').":".$this->input->post('selesai_m'));
		if (($jam_selesai-$jam_mulai) <= 0){
			$this->form_validation->set_message('comparetime', 'Durasi Jam Lembur salah.');
			return false;
		} else {
			return true;
		}
	}
	
	public function edit(){
		if($this->input->post())
		{
			$this->load->library('form_validation');
			$rules = array(
				array(
					'field' => 'nik',
					'label' => 'NAMA',
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
					
					
					$tgllembur = revdate($this->input->post('tgllembur'));
					$notrans = $this->input->post('no_trans');
					
					$data = array(
						'NO_TRANS' => $notrans,
						'NIK' => $this->input->post('nik'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					
					if ($this->db->where('NO_TRANS', $notrans)->update('lembur',$data)){
						$detail = array();
						$cnt = 0;
						$tanggal = $this->input->post('tanggal');
						$mulai_h = $this->input->post('mulai_h');
						$mulai_m = $this->input->post('mulai_m');
						$selesai_h = $this->input->post('selesai_h');
						$selesai_m = $this->input->post('selesai_m');
						$alasan = $this->input->post('alasan');
						foreach($tanggal as $row){
							
							$tgl = revdate($row);
							$jam_mulai = $tgl . ' ' . $mulai_h[$cnt] . ':' . $mulai_m[$cnt];
							$jam_selesai = $tgl . ' ' . $selesai_h[$cnt] . ':' . $selesai_m[$cnt];
							$totaljam = (strtotime($jam_selesai) - strtotime($jam_mulai))/(60*60);
							$detail[] = array(
								'NO_TRANS' => $notrans,
								'TGL_LEMBUR' => $tgl,
								'JAM_MULAI' => $jam_mulai,
								'JAM_SELESAI' => $jam_selesai,
								'JML_JAM'=>$totaljam,
								'KETERANGAN'=>$alasan[$cnt]
							);
							$cnt++;
						}
						$this->db->delete('lembur_d',array('NO_TRANS'=>$notrans));
						if ($this->db->insert_batch('lembur_d',$detail)){
							$this->db->trans_commit();
							$respon->status = 'success';
						}
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
			else
		{
			$this->template->set('pagetitle','Edit Pengajuan Lembur');
			$rslembur = $this->lembur_model->getByID($this->input->get('notrans'));			
			$data['row'] = $rslembur;
			$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rslembur->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rslembur->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rslembur->ID_JAB.") NAMA_JAB ")->row();
			$data['rsmaster'] = $rsmaster;
			$data['rowd'] = $this->lembur_model->lembur_d($this->input->get('notrans'));
			if (empty($data['row'])){
				flashMessage('Data Invalid','danger');
				redirect('lembur');
			}
			$this->template->load('default','lembur/edit',$data);
		}
	}
	
	public function view(){
		$this->template->set('pagetitle','Data Pengajuan Lembur');
		$data['row'] = $this->db->select()->where('no_trans',$this->input->get('notrans'))->get('v_lembur')->row();
		$data['rowd'] = $this->db->select()
			->where('no_trans',$this->input->get('notrans'))
			->order_by('TGL_LEMBUR')
			->get('lembur_d')->result();
		
		$rslembur = $this->lembur_model->getByID($this->input->get('notrans'));			
		$data['row'] = $rslembur;
		$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rslembur->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rslembur->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rslembur->ID_JAB.") NAMA_JAB ")->row();
		$data['rsmaster'] = $rsmaster;
		$data['rowd'] = $this->lembur_model->lembur_d($this->input->get('notrans'));
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('lembur');
		}
		if ($this->input->is_ajax_request()){
			$this->template->load('ajax','lembur/view',$data);
		} else {
			$this->template->load('default','lembur/view',$data);
		}
	}


	public function lookupemp(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		//$query = $this->emp_model->getByNama($keyword);
		$query = $this->db->query("select * from pegawai where id_jab not in (35,36,37) and `NAMA` LIKE '%{$keyword}%' OR `NIK` LIKE '%{$keyword}%' ")->result();
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
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
	
	public function approval()
	{	$this->config->set_item('mymenu', 'mn3');
		$this->config->set_item('mySubMenu', 'mn32');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Persetujuan Permohonan Lembur');
		$this->template->set('mn1','pegawai');
		$this->template->set('mn2','manajerop');
		$this->template->set('mnact','cutiapp');
		$this->template->load('default','lembur/approval',$data);
	}
	
	public function approve(){
		$this->config->set_item('mySubMenu', 'mn32');
		$this->db->trans_begin();
		$sts=($this->input->post('approve')=='true'?1:0);
		$respon['sts']=$sts;
		try {
			$data = array(
				'APPROVED' => $sts,
				'APPROVED_DATE' => ($sts==1?timenow():''),
				'APPROVED_BY' => ($sts==1?$this->session->userdata('auth')->name:''),
				'ISACTIVE' => 0,
				'UPDATED_DATE' => timenow(),
				'UPDATED_BY' => $this->session->userdata('auth')->name
			);
			if ($this->db->where('NO_TRANS',$this->input->post('notrans'))->update('lembur', $data)){
				$row = $this->lembur_model->getByID($this->input->post('notrans'));
				$clembur = $this->db->query("select * from cuti_lembur where nik='".$row->NIK."'")->row();
				$lemburd = $this->db->query("SELECT SUM(JML_JAM) JML_JAM FROM lembur_d WHERE no_trans='".$row->NO_TRANS."'")->row();
				if (empty($clembur)){
					//belum ada data maka insert
					if ($lemburd->JML_JAM<7){
						$sisa_jam =$lemburd->JML_JAM;
						$sisa_hari = 0;
					}else{
					$sisa_jam = round($lemburd->JML_JAM % 7);
					$sisa_hari = floor($lemburd->JML_JAM/7);
					}
					$data2 = array(
						'NIK' => $row->NIK,
						'SISA_JAM' => $sisa_jam,
						'SISA_HARI' => $sisa_hari
					);
					$this->db->insert('cuti_lembur',$data2);
				} else {
					//sudah ada data maka update
					$jml = $clembur->SISA_JAM + $lemburd->JML_JAM; // jml jam lembur ditambah sisa jml jam 
					if ($jml<7){
						$sisa_jam =$jml;
						$sisa_hari = $clembur->SISA_HARI;
					}else{
					$sisa_jam = $jml % 7;
					$jhr = floor($jml/7);
					$sisa_hari = $clembur->SISA_HARI + $jhr;
					}
					$data2 = array(
						'NIK' => $row->NIK,
						'SISA_JAM' => $sisa_jam,
						'SISA_HARI' => $sisa_hari
					);
					$this->db->where('NIK', $row->NIK)->update('cuti_lembur',$data2);
				}
				$this->db->trans_commit();
				$respon['status'] = 'success';
			} else {
				throw new Exception("gagal simpan");
			}
		} catch (Exception $e) {
			$respon['status'] = 'error';
			$respon['errormsg'] = $e->getMessage();;
			$this->db->trans_rollback();
		}
		echo json_encode($respon);
	}
}
