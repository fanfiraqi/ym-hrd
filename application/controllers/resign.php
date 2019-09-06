<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class resign extends MY_App {
	var $branch = array();
	var $branch2 = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('resign_model');
		$this->config->set_item('mymenu', 'mn2');
		$this->gate_db=$this->load->database('gate', TRUE);
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->config->set_item('mySubMenu', 'mn28');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Daftar Catatan Resign Karyawan');		
		$this->template->load('default','fresign/index',$data);
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			
			$str = "select p.NIK,p.NAMA, p.ID_CABANG,p.ID_DIV,p.ID_JAB, m.*  from pegawai p, resign m  where  p.nik=m.nik ".($this->session->userdata('auth')->id_cabang>1?"  and p.id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and p.id_cabang=".$cabang );
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND (p.NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or  m.nik like '%".mysql_real_escape_string( $_GET['sSearch'] )."%')";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			}else{
				$str .= " ORDER BY TGL_Penetapan desc";
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
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'TANGGAL'=>$row->TGL,
					'ALASAN'=>$row->ALASAN,
					'MENGETAHUI'=>$row->MENGETAHUI,
					'MENYETUJUI'=>$row->MENYETUJUI,
					'ACTION'=>'<a href="'.base_url('resign/view/'.$row->ID).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('resign/edit/'.$row->ID).'"><i class="fa fa-edit" title="Edit"></i></a> '
						//| <a href="javascript:void()" onclick="delResign('.$row->ID.','.$row->NIK.')"><i class="fa fa-trash-o" title="Hapus"></i></a>
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
	
	
	public function create(){
		if($this->input->post()) {		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'keterangan',
					'label' => 'ALASAN',
					'rules' => 'trim|xss_clean|required'
				),				
				array(
					'field' => 'tanggal',
					'label' => 'TANGGAL',
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
						'NIK' => $this->input->post('nik'),
						'ID_CABANG' => $this->input->post('id_cabang'),
						//'NAMA' => $this->input->post('nama'),
						'TGL' => $this->input->post('tanggal'),
						'ALASAN' => $this->input->post('keterangan'),
						//'MENGETAHUI' => $this->input->post('mengetahui'),
						//'MENYETUJUI' => $this->input->post('menyetujui'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->insert('resign', $data)){
						$dataPeg = array(
						'STATUS_AKTIF' => 0
						);
						//update data pegawai
						$this->db->where('NIK',$this->input->post('nik'))->update('pegawai', $dataPeg);
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
		
		$this->template->set('pagetitle','Tambah Data Pengajuan resign/PHK Baru');
		$this->template->load('default','fresign/create');
		
	}
	
	public function edit($id=null){
	
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'keterangan',
					'label' => 'ALASAN',
					'rules' => 'trim|xss_clean|required'
				),
				/*array(
					'field' => 'mengetahui',
					'label' => 'MENGETAHUI',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'menyetujui',
					'label' => 'MENYETUJUI',
					'rules' => 'trim|xss_clean|required'
				),*/
				array(
					'field' => 'tanggal',
					'label' => 'TANGGAL',
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
						'NIK' => $this->input->post('nik'),
						'TGL' => $this->input->post('tanggal'),
						'ALASAN' => $this->input->post('keterangan'),
						'MENGETAHUI' => $this->input->post('mengetahui'),
						//'MENYETUJUI' => $this->input->post('menyetujui'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->where('ID',$this->input->post('id'))->update('resign', $data)){
						$dataPeg = array(
						'STATUS_AKTIF' => 0
						);
						//update data pegawai
						$this->db->where('NIK',$this->input->post('nik'))->update('pegawai', $dataPeg);
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
		
		$this->template->set('pagetitle','Update Data Resign ');
		$rsresign = $this->resign_model->getEdited($id);
		$data['row'] = $rsresign;
		$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rsresign->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rsresign->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rsresign->ID_JAB.") NAMA_JAB ")->row();
		$data['rsmaster'] = $rsmaster;

		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('cabang');
		}
		$this->template->load('default','fresign/edit',$data);
		
	}
	
	
	public function view($id){
		

		$rsresign = $this->resign_model->getEdited($id);
		$data['row'] = $rsresign;
		$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rsresign->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rsresign->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rsresign->ID_JAB.") NAMA_JAB ")->row();
		$data['rsmaster'] = $rsmaster;

		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('cabang');
		}
		if ($this->input->is_ajax_request()){
			$role=$this->input->post('role');
			$data['role']=$role;
			//get sts rekom, utk control tombol
			$data['sts_rekom']="Status Rekomendasi RO ".($rsresign->APPROVED_RO==0?"Belum diproses":($rsresign->APPROVED_RO==1?"Disetujui":"Ditolak"));
			$data['sts_approve']="Status Approval HRD Pusat ".($rsresign->APPROVED_PUSAT==0?"Belum diproses":($rsresign->APPROVED_PUSAT==1?"Disetujui":"Ditolak"));
			$data['stsR']=$rsresign->APPROVED_RO;
			$data['stsApp']=$rsresign->APPROVED_PUSAT;
			$data['id']=$id;
			//$data['formName']=($role== 20|| $role==33?"frmRekomRO":"frmAppHrd");
			$data['myurl']=($role== 20|| $role==33?"approve_rekomRO":"approve_appHrd");
			$data['label']=($role== 20|| $role==33?"Direkomendasikan RO":"Disetujui Pusat");
			$data['title']=($role== 20|| $role==33?"Proses Rekomendasi RO":"Persetujuan HRD Pusat");
			$this->template->load('ajax','fresign/appv_view',$data);
		} else {
			$this->template->set('pagetitle','View Data Resign');
			$this->template->load('default','fresign/view',$data);
		}
		
	
	}
	public function getPosition(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		
		/*$str= "SELECT c.KOTA, d.NAMA_DIV, j.NAMA_JAB, k.NIK, k.NAMA";
		$str.=" FROM  pegawai k, mst_cabang c, mst_divisi d, mst_jabatan j";
		$str.=" where k.id_cabang=c.id_cabang and k.id_div=d.id_div and k.id_jab=j.id_jab and k.status_aktif=1 and (k.NAMA LIKE '%{$keyword}%' or k.nik LIKE '%{$keyword}%')";
		*/
		$str = "SELECT *  FROM pegawai where ".($this->session->userdata('auth')->id_cabang>1?"   id_cabang=".$this->session->userdata('auth')->id_cabang." and ":"")."  `STATUS_AKTIF`=1 AND `NAMA` LIKE '%{$keyword}%' or `NIK` LIKE '%{$keyword}%'";
		$query = $this->db->query($str)->result();

		
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

	public function comboJabByDiv(){
		$id_div = $this->input->post('divisi');
		$id_cabang = 1;
		$query = $this->db->select('j.ID_JAB,j.NAMA_JAB')
			->join('mst_jabatan j','j.id_jab=s.id_jab','left')
			->where(array('s.id_div'=>$id_div,'s.id_cab'=>$id_cabang))
			->get('mst_struktur s')->result();
		$respon = new StdClass();
		$respon->status = 0;
		if (!empty($query)){
			$respon->status = 1;
			$respon->data = $query;
		}
		echo json_encode($respon);
	}
		
	public function delresign(){
		$id=$this->input->post('idx');
		$nik=$this->input->post('nik');
		$res = $this->resign_model->deleteResign($id, $nik);
		return $res;
	}

public function approval()
	{	$this->config->set_item('mymenu', 'mn3');
		$this->config->set_item('mySubMenu', 'mn33');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Persetujuan Permohonan Resign');
		$this->template->set('mn1','pegawai');
		$this->template->set('mn2','manajerop');
		//$this->template->set('mnact','cutiapp');
		$this->template->load('default','fresign/approval',$data);
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
			if ($this->db->where('NO_TRANS',$this->input->post('notrans'))->update('resign', $data)){
				$row = $this->resign_model->getByID($this->input->post('notrans'));
				$cresign = $this->db->query("select * from cuti_resign where nik='".$row->NIK."'")->row();
				$resignd = $this->db->query("SELECT SUM(JML_JAM) JML_JAM FROM resign_d WHERE no_trans='".$row->NO_TRANS."'")->row();
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
			$respon['errormsg'] = $e->getMessage();
			$this->db->trans_rollback();
		}
		echo json_encode($respon);
	}

		public function appv_data(){
		//if ($this->input->is_ajax_request()){
			
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			//$str = "SELECT resign.*, (select nama from pegawai where nik=resign.nik) NAMA, (select id_div from pegawai where nik=resign.nik) ID_DIV, (select id_jab from pegawai where nik=resign.nik) ID_JAB FROM resign WHERE `IS_ACTIVE` = 1 ";
			$str = "SELECT * FROM resign WHERE `IS_ACTIVE` = 1 ";
			
			if (!empty($_GET['cabang'])){
				//cek RO
				$rsku=$this->gate_db->query("select count(*) jml from mst_cabang where id_cabang_parent=".$_GET['cabang'])->row();
				if ($rsku->jml>0){	//RO
					$rsku2=$this->gate_db->query("select id_cabang  from mst_cabang where id_cabang_parent=".$_GET['cabang'])->result();
					$ids = array(); 
					foreach($rsku2 as $row)
					{
						$ids[] = $row->id_cabang; 
					} 
					$idcab=implode(',',$ids);
					$str .= " AND ID_CABANG in (".$idcab.")";
				}else{
					$str .= " AND ID_CABANG = ".$_GET['cabang'];
				}
			}

			if ( $_GET['sSearch'] != "" )	{
				
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
			$sess=$this->session->userdata('gate');
			$role=$sess['group_id'];
            $strku="";
			foreach($query as $row){
				$getDet=$this->db->query("select * from pegawai where nik='".$row->NIK."'")->row();
				$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$getDet->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$getDet->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$getDet->ID_JAB.") NAMA_JAB ");
				$strku.="#SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$getDet->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$getDet->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$getDet->ID_JAB.") NAMA_JAB ";
				if ($rsname->num_rows()>0) {
					$res=$rsname->row();
				$aaData[] = array(
					'ID'=>$row->ID,
					'TGL_TRANS'=>revdate($row->TGL),
					'NIK'=>$row->NIK,
					'NAMA'=>$getDet->NAMA,
					'ASAL'=>$res->NAMA_CABANG.'/'.$res->NAMA_DIV.'/'.$res->NAMA_JAB,
					'REKOM'=>($row->APPROVED_RO==0?"Belum diproses":($row->APPROVED_RO==1?"Disetujui":"Ditolak")),
					'HRD'=>($row->APPROVED_PUSAT==0?"Belum diproses":($row->APPROVED_PUSAT==1?"Disetujui":"Ditolak")),					
					'ACTION'=>(in_array($role, [1, 3,20,33, 66]) ? '<a href="javascript:void(0)" data-base="'.base_url().'" data-url="'.base_url('resign/approve/'.$row->ID).'" data-id="'.$row->ID.'" data-role="'.$role.'" onclick="view(this)" class="btn btn-act btn-success"><i class="fa fa-gear" title=" Approval '.($role== 20|| $role==33?"RO":"Pusat").'"></i>  '.($role== 20|| $role==33?"Rekomendasi RO":"Approval HRD Pusat").'</a>':"-" )
					

				);
				}
			}
			
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"str" => $strku,
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => $aaData
			);
			echo json_encode($output);
		//}
	}


	public function approve_rekomRO(){
		if ($this->input->is_ajax_request()){
		
			$this->load->library('form_validation');
			
			
			$rules = array(
				array(
					'field' => 'id',
					'label' => 'ID',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'role',
					'label' => 'ROLE',
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
						'APPROVED_RO' => 1,
						'KET_RO_REKOMEN' => $this->input->post('rekom_note'),
						'APPROVED_RO_BY' => $this->input->post('rekomendator'),
						'APPROVE_RO_DATE' =>date('Y-m-d H:i:s')
					);
												
						if ($this->db->where('ID',$this->input->post('id'))->update('resign',$data)){
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
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);			
		}			
	}

	public function approve_appHrd(){
		if ($this->input->is_ajax_request()){
		
			$this->load->library('form_validation');
			
			
			$rules = array(
				array(
					'field' => 'id',
					'label' => 'ID',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'role',
					'label' => 'ROLE',
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
						'APPROVED_PUSAT' => 1,						
						'APPROVED_PUSAT_BY' => $this->input->post('rekomendator'),
						'NO_SK' => $this->input->post('no_sk'),
						//'FILE_SK' => $this->input->post(''),
						'IS_ACTIVE' => 0 ,
						'APPROVED_DATE' =>date('Y-m-d H:i:s')
					);
												
						if ($this->db->where('ID',$this->input->post('id'))->update('resign',$data)){
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
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);			
		}			
	}


	public function denied($role){
		if ($this->input->is_ajax_request()){			
			$respon = new StdClass();
			$this->db->trans_begin();
				try {					
					if ($role== 20|| $role==33){
						$data = array(
							'APPROVED_RO' => 2,						
							'IS_ACTIVE' => 0 ,
							'APPROVE_RO_DATE' =>date('Y-m-d H:i:s')
						);
					}else{
						$data = array(
							'APPROVED_PUSAT' => 2,						
							'IS_ACTIVE' => 0 ,
							'APPROVED_DATE' =>date('Y-m-d H:i:s')
						);
					}
												
						if ($this->db->where('ID',$this->input->post('id'))->update('resign',$data)){
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
				$respon->status = 'success';
			
			echo json_encode($respon);			
		}			
	}
	
}
