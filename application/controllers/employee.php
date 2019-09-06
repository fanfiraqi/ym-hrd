<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class employee extends MY_App {
	public $branch;
	function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->config->set_item('mymenu', 'mn2');		
		$this->auth->authorize();
	}
	
	public function sendEmail(){
		$str="select * from pegawai where status_aktif=1 and nik='".$this->input->get('nik')."'";
		$count = $this->db->query($str)->num_rows();
		
		if ($count>0){		
			$result = $this->db->query($str)->row();
			switch ($this->input->get('kunci')){
				case "ultah":	//send to hrd manager
					$emailTo="deniknh@gmail.com";
					$subject="Karyawan Ultah";
					$msg="Sistem Notifikasi Email. Karyawan atau Anggota Keluarga Karyawan dari ".$result->NIK." - ".$result->NAMA." Berulang Tahun pada bulan ini";
					break;
				case "kontrak":	//send to hrd manager
					$emailTo="deniknh@gmail.com";
					$subject="Karyawan Ultah";
					$msg="Sistem notifikasi menjelang Jatuh tempo Masa Kontrak. Karyawan  ".$result->NIK." - ".$result->NAMA." Akan Berakhir pada";
					break;
			}
			
			$data['status']=$this->singleEmail($emailTo, $subject,$msg);
		}else{
			$data['status']=0;
		}

		
		echo json_encode($data);
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Daftar Karyawan');
		$this->config->set_item('mySubMenu', 'mn21');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang('--- Semua Cabang ---');
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		
		$data['divisi'] = array();		
		$this->template->load('default','employee/index',$data);
	}
	
	public function copydata(){
		if($this->input->post())
		{
			if ($this->input->post('nikasal')==''){
				$respon['status'] = 'error';
				$respon['errormsg'] = '<p>NIK Pegawai yang disalin tidak valid</p>';
				echo json_encode($respon);
				exit;
			}
			$this->load->library('form_validation');
			$rules = array(
				array(
					'field' => 'nama',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'kotalahir',
					'label' => 'TEMPAT LAHIR',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tgllahir',
					'label' => 'TANGGAL LAHIR',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'alamatktp',
					'label' => 'ALAMAT KTP',
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
				),
				array(
					'field' => 'email',
					'label' => 'EMAIL',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'rekening',
					'label' => 'REKENING',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'cabang',
					'label' => 'CABANG',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				array(
					'field' => 'divisi',
					'label' => 'DIVISI',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				/*array(
					'field' => 'ID_PEG',
					'label' => 'ID_PEG',
					'rules' => 'trim|xss_clean|required'
				),*/
				array(
					'field' => 'jabatan',
					'label' => 'JABATAN',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				array(
					'field' => 'tglaktif',
					'label' => 'TANGGAL AKTIF',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'stspegawai',
					'label' => 'STATUS KARYAWAN',
					'rules' => 'trim|xss_clean|required'
				)/*,
				array(
					'field' => 'TGL_AKHIR_KONTRAK',
					'label' => 'TGL_AKHIR_KONTRAK',
					'rules' => 'trim|xss_clean|required'
				),*/
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				
				$this->db->trans_begin();
				try {
					
					
					$tglaktif = revdate($this->input->post('tglaktif'));
					if ($this->input->post('stspegawai')=="1"){
						$tglawal=$tglaktif;
						$tglakhir='';
					}else{
						$tglawal = revdate($this->input->post('tglawal'));
						$tglakhir = revdate($this->input->post('tglakhir'));
					}

					$tgllahir = revdate($this->input->post('tgllahir'));
					//$kelompok_fr=($this->input->post('jabatan')=='13'?$this->input->post('levelfo'):"NULL");	//kel fr pakai cb levelfo
					//$nik = $this->commonlib->gencode('NIK',$tglaktif);
					$nik = $this->input->post('nik');
					$data = array(
						'NIK' => $nik,
						'NAMA' => $this->input->post('nama'),
						'NAMA_PANGGILAN' => $this->input->post('nama_panggilan'),
						'ID_CABANG' => $this->input->post('cabang'),
						'ID_DIV' => $this->input->post('divisi'),
						'ID_PEG' => 0,
						'TGL_AKTIF' => $tglaktif,
						'TGL_AWAL_KONTRAK' => $tglawal,
						'TGL_AKHIR_KONTRAK' => $tglakhir,
						'ID_JAB' =>  $this->input->post('jabatan'),
						//'ID_FO' => ($this->input->post('jabatan')==14)?$this->input->post('levelfo'):null,
						'SEX' => $this->input->post('sex'),
						'TEMPAT_LAHIR' => $this->input->post('kotalahir'),
						'TGL_LAHIR' => $tgllahir,
						'ALAMAT' => $this->input->post('alamat'),
						'ALAMATKTP' => $this->input->post('alamatktp'),
						'NO_KTP' => $this->input->post('no_ktp'),
						'STATUS_NIKAH' => $this->input->post('nikah'),
						'STATUS_PEGAWAI' => $this->input->post('stspegawai'),
						'PENDIDIKAN' => $this->input->post('pendidikan'),
						'REKENING' => $this->input->post('rekening'),
						'STATUS_AKTIF' => 1,
						'STATUS_PPH' => 1,
						'ID_AGAMA' => 1,
						'EMAIL' => $this->input->post('email'),
						'TELEPON' => $this->input->post('telepon'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s'),
						'NAMA_KONTAK_KELUARGA' =>$this->input->post('nama_kontak_keluarga'),
						'JUMLAH_ANAK' =>$this->input->post('jml_anak'),
						'TELP_KELUARGA' =>$this->input->post('no_telp')
					);
					if ($this->db->insert('pegawai', $data)){
					
						$mutasi = array(
							'NIK' => $nik,
							'ID_CAB' => $this->input->post('cabang'),
							'ID_DIV' => $this->input->post('divisi'),
							'ID_JAB' => $this->input->post('jabatan'),
							'TGL_PENETAPAN' => $tglaktif,
							'KETERANGAN' => 'data pertama',
							'MENGETAHUI' => '',
							'MENYETUJUI' => '',
							'CREATED_BY' => 'admin',
							'CREATED_DATE' => timenow()
							);
						
						$kontrak = array(
							'NIK' => $nik,
							'ID_CAB' => $this->input->post('cabang'),
							'ID_DIV' => $this->input->post('divisi'),
							'ID_JAB' => $this->input->post('jabatan'),
							'TGL_PENETAPAN' => $tglaktif,
							'JENIS' => $this->input->post('stspegawai'),
							'TGL_AWAL' => $this->input->post('tglawal'),
							'TGL_AKHIR' => $this->input->post('tglakhir'),
							'CREATED_BY' => 'admin',
							'CREATED_DATE' => timenow(),
						);
						//$dbklg = $this->db->query('INSERT INTO adm_hubkel (NIK,ID_HUBKEL,ANAK_KE,NAMA,SEX,TEMPAT_LAHIR,TGL_LAHIR,PEKERJAAN,ID_PENDIDIKAN) SELECT '.$nik.' as NIK,ID_HUBKEL,ANAK_KE,NAMA,SEX,TEMPAT_LAHIR,TGL_LAHIR,PEKERJAAN,ID_PENDIDIKAN FROM adm_hubkel where NIK="'.$this->input->post('nikasal').'"');
						$this->db->insert('kontrak', $kontrak);
						if ($this->db->insert('mutasi', $mutasi)){						
							$this->db->trans_commit();
						} else {
							throw new Exception("gagal simpan");
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
		$this->template->set('pagetitle','Salin Data Karyawan');
		$data['cabang'] = $this->common_model->comboCabang('[ Pilih Cabang ]');
		$data['pendidikan'] = $this->common_model->comboReffPeg('PENDIDIKAN');
		$data['nikah'] = $this->common_model->comboReffPeg('NIKAH');
		$data['sex'] = $this->common_model->comboReff('SEX');
		$data['stspegawai'] = $this->common_model->comboReff('STSPEGAWAI');
		$data['divisi'] = array();
		//$data['levelfo'] = $this->common_model->comboLevelFO();
		$this->template->load('default','employee/copydata',$data);
	}
	
	public function lookupemp(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$query = $this->db->select("P.*,date_format(P.TGL_LAHIR,'%d-%m-%Y') TGLLAHIR",false)
			->join('v_pegawai P','P.nik=R.nik','left')
			->where('P.NAMA LIKE',"%{$keyword}%")
			->or_where('P.NIK LIKE',"%{$keyword}%")
			->order_by('P.NAMA')
			->get('resign R')
			->result();
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
					'pegawai' => $row,
					''
				);
			}
		}
		echo json_encode($data);
	}
	

	public function json_data(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			
			$str = "SELECT `ID`, `NIK`,`NAMA`, ID_CABANG, ID_DIV, ID_JAB
				FROM v_pegawai 
				WHERE `STATUS_AKTIF` = 1 ";
			
			if (!empty($_GET['cabang'])){
				$str .= " AND ID_CABANG = ".$_GET['cabang'];
			}
			
			if (!empty($_GET['divisi']) || @$_GET['divisi']==1){
				$divs = $this->common_model->getDivChild($_GET['divisi']);
				$str .= " AND ID_DIV in (".implode(',',$divs).") ";
			}
			
			if ( @$_GET['sSearch'] != "" )
			{	
				$str .= " and (NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR NIK like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' )";
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
				$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$row->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".($row->ID_DIV=="" || empty($row->ID_DIV)?1:$row->ID_DIV).") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".($row->ID_JAB==""|| empty($row->ID_JAB)?36:$row->ID_JAB).") NAMA_JAB ")->row();
				$aaData[] = array(
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'NAMA_CABANG'=>$rsname->NAMA_CABANG,
					'NAMA_DIV'=>$rsname->NAMA_DIV,
					'NAMA_JAB'=>$rsname->NAMA_JAB,
					'ACTION'=>'<a href="'.base_url('employee/view/'.$row->ID).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('employee/edit/'.$row->ID).'"><i class="fa fa-pencil" title="Edit"></i></a>'
				);
			}
			
			$output = array(
				"sEcho" => @intval($_GET['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => $aaData
			);
			echo json_encode($output);
		//}
	}
	
	public function json_family($nik){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT a.*,didik.VALUE1 PENDIDIKAN, kel.VALUE1, kel.VALUE2, kel.VALUE3,sex.VALUE1 JNSKEL
				FROM adm_hubkel a
				left join gen_reff didik on didik.ID_REFF=a.ID_PENDIDIKAN
				left join gen_reff kel on kel.ID_REFF=a.ID_HUBKEL
				left join gen_reff sex on sex.ID_REFF=a.SEX
				WHERE didik.reff='PENDIDIKAN'
				AND kel.reff='KELUARGA'
				AND sex.reff='SEX'
				AND a.NIK='".$nik."' ";
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND a.NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				//$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			} else {
				$str .= " ORDER BY ID_HUBKEL ASC";
			}
			$str .= " ORDER BY ID_HUBKEL, ANAK_KE ASC";
			
			$strfilter = $str;
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$strfilter .= " LIMIT ". mysql_real_escape_string( $_GET['iDisplayStart'] ) .", ". mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
			
			$iFilteredTotal = $this->db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->db->query($strfilter)->result();
			//debug_last();
			$aaData = array();
			foreach($query as $row){
				$anakke = $row->ID_HUBKEL==2?$row->ANAK_KE:'';
				$hubkel = $row->ID_HUBKEL==1?($row->SEX==1?$row->VALUE2:$row->VALUE3):$row->VALUE1;
				if ($_GET['state']=='edit'){
					$action = '<a href="javascript:void(0)" onclick="delfam(this)" data-id="'.$row->ID.'"><i class="fa fa-trash-o" title="Hapus '.$row->NAMA.'"></i></a> | 
						<a href="javascript:void(0)" onclick="editfam(this)" data-id="'.$row->ID.'"><i class="fa fa-pencil" title="Edit '.$row->NAMA.'"></i></a>';
				} else {
					$action='';
				}
				$aaData[] = array(
					'HUBKEL'=>$hubkel,
					'ANAK_KE'=>$anakke,
					'NAMA'=>$row->NAMA,
					'SEX'=>$row->JNSKEL,
					'KOTA'=>$row->TEMPAT_LAHIR,
					'TGL_LAHIR'=>revdate($row->TGL_LAHIR),
					'PENDIDIKAN'=>$row->PENDIDIKAN,
					'PEKERJAAN'=>$row->PEKERJAAN,
					'ACTION'=>$action
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
	
	public function json_kontrak($nik){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT a.*,kon.VALUE1 JENIS, peg.ID_CABANG , peg.ID_DIV, peg.ID_JAB
				FROM kontrak a
				left join pegawai peg on peg.nik=a.nik				
				left join gen_reff kon on kon.ID_REFF=a.JENIS
				WHERE kon.reff='STSPEGAWAI'
				AND a.NIK='".$nik."' ";
			
			

			if ( $_GET['sSearch'] != "" )
			{
				
				//$str .= " AND a.NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				//$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			} else {
				$str .= " ORDER BY TGL_AWAL ASC";
			}
			
			
			$strfilter = $str;
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$strfilter .= " LIMIT ". mysql_real_escape_string( $_GET['iDisplayStart'] ) .", ". mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
			
			$iFilteredTotal = $this->db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$query = $this->db->query($strfilter)->result();
			//debug_last();
			$aaData = array();
			foreach($query as $row){
				$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$row->ID_CABANG.") NAMA_CAB, (SELECT nama_div FROM mst_divisi WHERE id_div=".$row->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$row->ID_JAB.") NAMA_JAB ")->row();
				$aaData[] = array(
					'TGLTETAP'=>revdate($row->TGL_PENETAPAN),
					'JENIS'=>$row->JENIS,
					'CABANG'=>$rsname->NAMA_CAB,
					'DIVISI'=>$rsname->NAMA_DIV,
					'JABATAN'=>$rsname->NAMA_JAB,
					'TGLAWAL'=>revdate($row->TGL_AWAL),
					'TGLAKHIR'=>revdate($row->TGL_AKHIR),
					'ACTION'=>'<a href="'.base_url('employee/cetakKontrak/'.$row->ID).'"><i class="fa fa-file-text" title="Cetak Kontrak"></i></a>'
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
	
	public function json_view_emp($val){
		//if ($this->input->is_ajax_request()){
			$keyval=explode('_', $val);
			$proses=$keyval[0];
			$nik=$keyval[1];

			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			$tbname=""; $fsearch="";
			switch ($proses){
				case "kerja": 
					$tbname="peg_pengalaman_kerja";
					$fsearch="keterangan";
					break;
				case "organisasi": 
					$tbname="peg_organisasi";
					$fsearch="keterangan";
					break;
				case "pendidikan": 
					$tbname="peg_pendidikan";
					$fsearch="pf_terakhir";
					break;
				case "pelatihan": 
					$tbname="pelatihan";
					$fsearch="nama_pelatihan";
					break;
				case "prestasi": 
					$tbname="prestasi";
					$fsearch="nama_penilaian";
					break;
				case "pelanggaran": 
					$tbname="pelanggaran";
					$fsearch="nama_pelanggaran";
					break;
			}
			$str = "select  @nom:=@nom+1 as NO, v.*, p.NAMA, p.ID_CABANG, p.ID_DIV, p.ID_JAB from pegawai p, ".$tbname." v where p.nik=v.nik and p.nik = '".$nik."'";
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND p.NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or v.".$fsearch." like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
			} 
			/*else {
				$str .= " ORDER BY ID_HUBKEL ASC";
			}
			$str .= " ORDER BY ID_HUBKEL, ANAK_KE ASC";*/
			
			$strfilter = $str;
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$strfilter .= " LIMIT ". mysql_real_escape_string( $_GET['iDisplayStart'] ) .", ". mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
			
			$iFilteredTotal = $this->db->query($str)->num_rows();
			$iTotal = $iFilteredTotal;
			$this->db->query("set @nom=0;");
			$query = $this->db->query($strfilter)->result();
			//debug_last();
			$aaData = array();

			switch ($proses){
				case "kerja": 					
				case "organisasi": 
					foreach($query as $row){				
						$aaData[] = array(
							'NO'=>$row->NO,
							'KETERANGAN'=>$row->KETERANGAN
						);

					}
					break;
				case "pendidikan": 
					foreach($query as $row){				
						$aaData[] = array(
							'NO'=>$row->NO,
							'FORMAL'=>"Pendidikan Terakhir : ".$row->pf_terakhir."<br>Jurusan/Universitas : ".$row->pf_jur_univ."<br>Nilai/IPK : ".$row->pf_ipk,
							'INFORMAL'=>"I : ".$row->pinf_1."<br>II : ".$row->pinf_2."<br>III : ".$row->pinf_3."<br>IV : ".$row->pinf_4
						);
					}
					break;
				case "pelatihan": 
					foreach($query as $row){				
						$aaData[] = array(
							'NO'=>$row->NO,
							'NAMA_PELATIHAN'=>$row->NAMA_PELATIHAN,
							'TANGGAL'=>$row->TANGGAL,
							'KETERANGAN'=>$row->KETERANGAN
						);
					}
					break;
				case "prestasi": 
					foreach($query as $row){				
						$aaData[] = array(
							'NO'=>$row->NO,
							'NAMA_PENILAIAN'=>$row->NAMA_PENILAIAN,
							'DETIL_DOKUMEN'=>"No. Dokumen : ".$row->NO_DOKUMEN."<br>Revisi : ".$row->REVISI."<br>Tanggal dibuat : ".$row->TANGGAL_DIBUAT."<br>Periode Penilaian : ".$row->PERIODE_PENILAIAN,
							'DETIL_EVALUASI'=>"Nilai Prestasi : ".$row->NILAI_PRESTASI."<br>Keunggulan : ".$row->EV_KEUNGGULAN."<br>Hal Yang perlu diperbaiki : ".$row->EV_PERBAIKAN."<br>Saran : ".$row->EV_SARAN."<br>Usulan Pelatihan : ".$row->EV_USULAN_PELATIHAN,
							'INFO_VALIDASI'=>"Tanggal Evaluasi : ".$row->TGL_EVALUASI."<br>Dievaluasi oleh : ".$row->PETUGAS_EVALUASI."<br>Tanggal terima : ".$row->TGL_TERIMA."<br>Diterima Oleh : ".$row->TERIMA_OLEH,
							'TANGGAPAN'=>$row->TANGGAPAN
						);
					}
					break;
				case "pelanggaran": 
					foreach($query as $row){				
						$aaData[] = array(
							'NO'=>$row->NO,
							'NAMA_PELANGGARAN'=>$row->NAMA_PELANGGARAN,
							'TANGGAL'=>$row->TANGGAL,
							'KETERANGAN'=>$row->KETERANGAN
						);
					}
					break;
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

	public function genNik(){		
		//$nik=$this->commonlib->gencode('NIK',$this->input->post('tgl'));
		$tgl=$this->input->post('tgl');
		$nik=$this->common_model->gencode_nik($tgl);
		$respon['cek']="select ifnull(max(nik),'') nik from pegawai where nik like '".substr($tgl,6,4).substr($tgl,3,2)."%' limit 1";
		$respon['status'] = 'success';
		$respon['nik'] = $nik;
		$respon['tgl'] = $this->input->post('tgl');
		echo json_encode($respon);
	}
	public function create(){
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
					'field' => 'kotalahir',
					'label' => 'TEMPAT LAHIR',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tgllahir',
					'label' => 'TANGGAL LAHIR',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'alamat',
					'label' => 'ALAMAT',
					'rules' => 'trim|xss_clean|required'
				),				
				array(
					'field' => 'email',
					'label' => 'EMAIL',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'rekening',
					'label' => 'REKENING',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'cabang',
					'label' => 'CABANG',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				/*
				array(
					'field' => 'telepon',
					'label' => 'TELEPON',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'divisi',
					'label' => 'DIVISI',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				array(
					'field' => 'ID_PEG',
					'label' => 'ID_PEG',
					'rules' => 'trim|xss_clean|required'
				),*/
				array(
					'field' => 'jabatan',
					'label' => 'JABATAN',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				array(
					'field' => 'tglaktif',
					'label' => 'TANGGAL AKTIF',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'stspegawai',
					'label' => 'STATUS KARYAWAN',
					'rules' => 'trim|xss_clean|required'
				)/*,
				array(
					'field' => 'TGL_AKHIR_KONTRAK',
					'label' => 'TGL_AKHIR_KONTRAK',
					'rules' => 'trim|xss_clean|required'
				),*/
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				
				$this->db->trans_begin();
				try {
					
					$tglakhir='';$tglawal='';
					$tglaktif = revdate($this->input->post('tglaktif'));
					if ($this->input->post('stspegawai')=="6"){
						$tglawal=$tglaktif;
						$tglakhir='';
					}else{
						$tglawal = revdate($this->input->post('tglawal'));
						$tglakhir = revdate($this->input->post('tglakhir'));
					}
					
					$tgllahir = revdate($this->input->post('tgllahir'));
					//$nik = $this->commonlib->gencode('NIK',$tglaktif);
					$nik = $this->input->post('nik');
					//$kelompok_fr=($this->input->post('jabatan')=='13'?$this->input->post('levelfo'):"NULL");	//kel fr pakai cb levelfo

					$data = array(
						'NIK' => $nik,
						'NAMA' => $this->input->post('nama'),
						'NAMA_PANGGILAN' => $this->input->post('nama_panggilan'),
						'ID_CABANG' => $this->input->post('cabang'),
						'ID_DIV' => $this->input->post('divisi'),
						'ID_PEG' => $nik,
						'ID_JAB' =>  $this->input->post('jabatan'),
						'TGL_AKTIF' => $tglaktif,
						'TGL_AWAL_KONTRAK' => $tglawal,
						'TGL_AKHIR_KONTRAK' => $tglakhir,						
						//'ID_FO' => ($this->input->post('jabatan')==14)?$this->input->post('levelfo'):null,
						'SEX' => $this->input->post('sex'),
						'TEMPAT_LAHIR' => $this->input->post('kotalahir'),
						'TGL_LAHIR' => $tgllahir,
						'ALAMAT' => $this->input->post('alamat'),
						'ALAMATKTP' => $this->input->post('alamatktp'),
						'TELEPON' => $this->input->post('telepon'),
						'EMAIL' => $this->input->post('email'),
						'NO_KTP' => $this->input->post('no_ktp'),
						'STATUS_NIKAH' => $this->input->post('nikah'),
						'STATUS_PEGAWAI' => $this->input->post('stspegawai'),
						'STATUS_AKTIF' => 1,
						'STATUS_PPH' => 1,
						'PENDIDIKAN' => $this->input->post('pendidikan'),
						'REKENING' => $this->input->post('rekening'),
						'ID_AGAMA' => 1,						
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s'),
						'NAMA_KONTAK_KELUARGA' =>$this->input->post('nama_kontak_keluarga'),
						'JUMLAH_ANAK' =>$this->input->post('jml_anak'),
						'TELP_KELUARGA' =>$this->input->post('no_telp')
						
					);
					if ($this->db->insert('pegawai', $data)){
						//pindahan commonlib->gencode -edit dulu
						$datacode = array(
							'REFF' => 'NIK',
							'TAHUN' => substr($tglaktif,0,4),
							'BULAN' => substr($tglaktif,5,2),
							'TANGGAL' => substr($tglaktif,8,2),
							'NOMOR' => intval(substr($nik, 6,3)),
							'VALUE' => $nik
						);

						$this->db->insert('codegen_d',$datacode);
						
						$mutasi = array(
							'NIK' => $nik,
							'ID_CAB' => $this->input->post('cabang'),
							'ID_DIV' => $this->input->post('divisi'),
							'ID_JAB' => $this->input->post('jabatan'),
							'TGL_PENETAPAN' => $tglaktif,
							'KETERANGAN' => 'data pertama',
							'MENGETAHUI' => '',
							'MENYETUJUI' => '',
							'CREATED_BY' => $this->session->userdata('auth')->id,
							'CREATED_DATE' => timenow()
							);
						
						$kontrak = array(
							'NIK' => $nik,
							'ID_CAB' => $this->input->post('cabang'),
							'ID_DIV' => $this->input->post('divisi'),
							'ID_JAB' => $this->input->post('jabatan'),
							'TGL_PENETAPAN' => $tglaktif,
							'JENIS' => $this->input->post('stspegawai'),
							'TGL_AWAL' => $tglawal,
							'TGL_AKHIR' => $tglakhir,
							'CREATED_BY' => $this->session->userdata('auth')->id,
							'CREATED_DATE' => timenow(),
						);
						$this->db->insert('kontrak', $kontrak);
						$data['pesanku']="simpan kontrak<br>";
						if ($this->db->insert('mutasi', $mutasi)){	
							$data['pesanku']="simpan mutasi<br>";
							$this->db->trans_commit();
						} else {
							throw new Exception("gagal simpan");
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
		
		$this->template->set('pagetitle','Tambah Data Personal Karyawan Baru');
		$data['cabang'] = $this->common_model->comboCabang('[ Pilih Cabang ]');
		$data['pendidikan'] = $this->common_model->comboReffPeg('PENDIDIKAN');
		$data['nikah'] = $this->common_model->comboReffPeg('NIKAH');
		$data['sex'] = $this->common_model->comboReff('SEX');
		$data['stspegawai'] = $this->common_model->comboReff('STSPEGAWAI');
		$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		//$data['levelfo'] = $this->common_model->comboLevelFO();
		$this->template->load('default','employee/create',$data);
		
	}
	
	public function edit($id){
	
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
					'field' => 'kotalahir',
					'label' => 'TEMPAT LAHIR',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tgllahir',
					'label' => 'TANGGAL LAHIR',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'alamat',
					'label' => 'ALAMAT',
					'rules' => 'trim|xss_clean|required'
				),
				
				array(
					'field' => 'email',
					'label' => 'EMAIL',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'rekening',
					'label' => 'REKENING',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'cabang',
					'label' => 'CABANG',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				/*
				array(
					'field' => 'telepon',
					'label' => 'TELEPON',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'divisi',
					'label' => 'DIVISI',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				array(
					'field' => 'ID_PEG',
					'label' => 'ID_PEG',
					'rules' => 'trim|xss_clean|required'
				),*/
				array(
					'field' => 'jabatan',
					'label' => 'JABATAN',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				array(
					'field' => 'stspegawai',
					'label' => 'STATUS KARYAWAN',
					'rules' => 'trim|xss_clean|required'
				)/*,
				array(
					'field' => 'TGL_AKHIR_KONTRAK',
					'label' => 'TGL_AKHIR_KONTRAK',
					'rules' => 'trim|xss_clean|required'
				),*/
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				
				$this->db->trans_begin();
				try {
					$tglaktif = revdate($this->input->post('tglaktif'));
					if ($this->input->post('stspegawai')=="6"){
						$tglawal=$tglaktif;
						$tglakhir='';
					}else{
						$tglawal = revdate($this->input->post('tglawal'));
						$tglakhir = revdate($this->input->post('tglakhir'));
					}
					$tgllahir = revdate($this->input->post('tgllahir'));
					//$kelompok_fr=($this->input->post('jabatan')=='13'?$this->input->post('levelfo'):"NULL");	//kel fr pakai cb levelfo

					$data = array(
						'NIK' => $this->input->post('nik'),
						'NAMA' => $this->input->post('nama'),
						'NAMA_PANGGILAN' => $this->input->post('nama_panggilan'),
						'ID_CABANG' => $this->input->post('cabang'),
						'ID_DIV' => $this->input->post('divisi'),
						'ID_JAB' => $this->input->post('jabatan'),
						'ID_PEG' => $this->input->post('nik'),
						'TGL_AKTIF' => $tglaktif,
						'TGL_AWAL_KONTRAK' => $tglawal,
						'TGL_AKHIR_KONTRAK' => $tglakhir,
						//'ID_FO' => ($this->input->post('jabatan')==14)?$this->input->post('levelfo'):null,
						'SEX' => $this->input->post('sex'),
						'TEMPAT_LAHIR' => $this->input->post('kotalahir'),
						'TGL_LAHIR' => $tgllahir,
						'ALAMAT' => $this->input->post('alamat'),
						'ALAMATKTP' => $this->input->post('alamatktp'),
						'NO_KTP' => $this->input->post('no_ktp'),
						'STATUS_NIKAH' => $this->input->post('nikah'),
						'STATUS_PEGAWAI' => $this->input->post('stspegawai'),						
						'REKENING' => $this->input->post('rekening'),
						'STATUS_AKTIF' => 1,
						'STATUS_PPH' => 1,
						'ID_AGAMA' => 1,
						'EMAIL' => $this->input->post('email'),
						'TELEPON' => $this->input->post('telepon'),
						'NAMA_KONTAK_KELUARGA' => $this->input->post('nama_kontak_keluarga'),
						'JUMLAH_ANAK' => $this->input->post('jml_anak'),
						'TELP_KELUARGA' => $this->input->post('no_telp'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s'),
						
					);
					if ($this->db->where('ID',$this->input->post('id'))->update('pegawai', $data)){
						
						$this->db->trans_commit();
						$respon->status = 'success';
						$respon->qry = $this->db->last_query();
					} else {
						throw new Exception("gagal simpan");
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();;
					$this->db->trans_rollback();
				}
				
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);
			exit;
		
		} 
		
		$this->template->set('pagetitle','Update Data Karyawan');
		$data['row'] = $this->emp_model->getById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('employee');
		}
		$data['cabang'] = $this->common_model->comboCabang('[ Pilih Cabang ]');
		$data['pendidikan'] = $this->common_model->comboReffPeg('PENDIDIKAN');
		$data['nikah'] = $this->common_model->comboReffPeg('NIKAH');
		$data['sex'] = $this->common_model->comboReff('SEX');
		$data['hubkel'] = $this->common_model->comboReff('KELUARGA');
		$data['stspegawai'] = $this->common_model->comboReff('STSPEGAWAI');
		$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		//$data['levelfo'] = $this->common_model->comboLevelFO();
		//$data['datafo'] = $this->db->query("SELECT * FROM evaluasi_fo WHERE nik='".$data['row']->NIK."' AND status_eval=1")->row();
		//$data['kelFR'] = $this->db->query("SELECT * FROM pegawai WHERE ID=$id")->row();
		$this->template->load('default','employee/edit',$data);
		
	}
	
	public function view($id){
		$this->template->set('pagetitle','Data Karyawan');
		$rsEmp=$this->emp_model->emp_data($id);
		$data['arrStsNikah'] = $this->arrStsNikah;
		$data['row'] = $rsEmp;
		$data['rsmaster'] = $this->emp_model->master_data($rsEmp->ID_CABANG, $rsEmp->ID_DIV, $rsEmp->ID_JAB);
		$data['program_jht'] = $this->db->query("SELECT * FROM pegawai WHERE id=$id")->row();
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('employee');
		}
		
		$this->template->load('default','employee/view',$data);
	
	}
	
	function divTree($datas, $parent = 0, $depth = 0){
		global $branch;
		if($depth > 1000) return ''; // Make sure not to have an endless recursion
		
		for($i=0, $ni=count($datas); $i < $ni; $i++){
			if($datas[$i]['id_div_parent'] == $parent){
				$val = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
				$val .= $depth==0?'':'&raquo; ';
				$val .= $datas[$i]['nama_div'];
				$branch[$datas[$i]['id_div']] = $val;
				$tree = $this->divTree($datas, $datas[$i]['id_div'], $depth+1);
			}
		}
		return $branch;
	}
	function divTree2($datas, $parent = 0, $depth = 0){
		global $branch;
		if($depth > 1000) return ''; // Make sure not to have an endless recursion
		
		for($i=0, $ni=count($datas); $i < $ni; $i++){
			if($datas[$i]['id_div_parent'] == $parent){
				$val = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
				$val .= $depth==0?'':'&raquo; ';
				$val .= $datas[$i]['nama_div'];
				$branch->id_div = $datas[$i]['id_div'];
				$branch->nama_div = $val;
				$tree = $this->divTree2($datas, $datas[$i]['id_div'], $depth+1);
			}
		}
		return $branch;
	}
	
	public function comboDivByCab($emptyval=true){
		$id_cabang = $this->input->post('cabang');
		//$id_cabang = 1;
		$query = $this->gate_db->select('j.ID_DIV,j.NAMA_DIV')
			->join('mst_divisi j','j.id_div=s.id_div','left')
			->where(array('s.id_cab'=>$id_cabang))
			->group_by('s.id_div')
			->get('mst_struktur s')->result_array();
		//debug_last();
		$respon = new StdClass();
		$respon->status = 0;
		if (!empty($query)){
			if (!$emptyval){
				array_unshift($query,array('ID_DIV'=>0,'NAMA_DIV'=>'--- Semua Divisi ---'));
			}
			$respon->status = 1;
			$respon->data = $query;
		}
		echo json_encode($respon);
	}
	
	public function comboJabByDiv(){
		$id_cabang = $this->input->post('cabang');
		$id_div = $this->input->post('divisi');
		//$id_cabang = 1;
		$query = $this->gate_db->select('j.ID_JAB,j.NAMA_JAB')
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
	public function fillLevelFO(){
		$query =$this->db->select()
			->order_by('ID')
			->get('mst_gaji_fo')
			->result();
		$respon = new StdClass();
		$respon->status = 0;
		if (!empty($query)){
			$respon->status = 1;
			$respon->data = $query;
		}
		echo json_encode($respon);
	}
	public function fillKelompokFR(){
		$query=$this->db->select()
			->where('isactive', '1')
			->order_by('KELOMPOK')
			->get('kelompok_fr')
			->result();
		$respon = new StdClass();
		$respon->status = 0;
		if (!empty($query)){
			$respon->status = 1;
			$respon->data = $query;
		}
		echo json_encode($respon);
	}
	public function addfam(){
		if ($this->input->is_ajax_request()){
			$state = $this->input->post('state');
			$data = array(
				'NIK' => $this->input->post('nik'),
				'ID_HUBKEL' => $this->input->post('hubkel'),
				'ANAK_KE' => $this->input->post('anak'),
				'NAMA' => $this->input->post('namakel'),
				'SEX' => $this->input->post('sexkel'),
				'TEMPAT_LAHIR' => $this->input->post('tempatlahirkel'),
				'TGL_LAHIR' => revdate($this->input->post('tgllahirkel')),
				'PEKERJAAN' => $this->input->post('pekerjaankel'),
				'ID_PENDIDIKAN' => $this->input->post('pendidikankel')
			);
			if ($state=='add'){
				$data = array_merge($data,
					array(
						'CREATED_BY' => $this->input->post('admin'),
						'CREATED_DATE' => timenow()
					)
				);
			} else {
				$data = array_merge($data,
					array(
						'UPDATED_BY' => $this->input->post('admin'),
						'UPDATED_DATE' => timenow()
					)
				);
			}
			
			$this->db->trans_begin();
				$respon = new StdClass();
				try {
					if ($state=='add'){
						if ($this->db->insert('adm_hubkel',$data)){
							$this->db->trans_commit();
							$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					} else {
						if ($this->db->where('id',$state)->update('adm_hubkel',$data)){
							$this->db->trans_commit();
							$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}
					
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();;
					$this->db->trans_rollback();
				}
				
			echo json_encode($respon);
		} else {
			redirect('/');
		}
	}
	
	function getfam(){
		$id = $this->input->post('id');
		$query = $this->db->where('id',$id)->get('adm_hubkel')->row();
		$query->TGL_LAHIR = revdate($query->TGL_LAHIR);
		if(empty($query)){
			$respon['status'] = 'error';
			$respon['errormsg'] = 'Invalid Data';
		} else {
			$respon['status'] = 'success';
			$respon['data'] = $query;
		}
		echo json_encode($respon);
	}
	
	function cetakKontrak($id){
		
	
		$data = $this->db->select('k.*,p.ALAMAT,p.NAMA,p.SEX,p.id_div,p.id_jab')
			->join('pegawai p','p.NIK=k.NIK','left')
			->where('k.id',$id)
			->get('kontrak k')
			->row();
		
		$this->load->library('PHPWord');
		$word = new PHPWord();
		$tglspk = $this->commonlib->dateformat1($data->TGL_PENETAPAN);
		$tertglspk = $this->commonlib->dateformat1($data->TGL_PENETAPAN,1);
		$durasispk = $this->commonlib->dateformat1($data->TGL_AWAL).' - '.$this->commonlib->dateformat1($data->TGL_AKHIR);
		//debug($data->JENIS);
	    if ($data->ID_JAB==36){
				$template = $word->loadTemplate('./assets/files/template/SPK-FO-01.docx');
			} else {
				$template = $word->loadTemplate('./assets/files/template/SPK-01.docx');
			}
	
		
		//$template = $word->loadTemplate('./assets/files/template/SPK-FO-01.docx');
		$template->setValue('TGL_SPK', $tglspk);
		$template->setValue('TERTGL_SPK', $tertglspk);
		$template->setValue('PANGGILAN', $data->SEX==1?'Saudara':'Saudari');
		$template->setValue('NAMA', $data->NAMA);
		$template->setValue('ALAMAT', $data->ALAMAT);
		$template->setValue('DURASI', $durasispk);
		$template->setValue('DIVISI', $data->NAMA_DIV);
		$template->setValue('JABATAN', $data->NAMA_JAB);
		
	
		$filename = 'SPK_'.strtotime(date("Ymdhis")).'.docx';
		$template->save($filename);
		header('Content-Description: File Transfer');
		header('Content-type: application/force-download');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($filename));
		readfile($filename);
		@unlink($filename);/**/
	}

	function cetak_datapeg($id){
		$arrStsNikah=$this->arrStsNikah;
		$data = $query = $this->db->select()->from('v_pegawai')->where('ID',$id)
				->get()
				->row();
		
		$this->load->library('PHPWord');
		$word = new PHPWord();
		/*$tglspk = $this->commonlib->dateformat1($data->TGL_PENETAPAN);
		$tertglspk = $this->commonlib->dateformat1($data->TGL_PENETAPAN,1);
		$durasispk = $this->commonlib->dateformat1($data->TGL_AWAL).' - '.$this->commonlib->dateformat1($data->TGL_AKHIR);*/
		$template = $word->loadTemplate('./assets/files/template/Data-Karyawan.docx');
		$template->setValue('TGLTERBIT', date('d-m-Y'));
		$template->setValue('CABANG', $data->NAMA_CABANaG);
		$template->setValue('DIVISI', $data->NAMA_DIV);
		$template->setValue('JABATAN', $data->NAMA_JAB);
		$template->setValue('NAMA', $data->NAMA);
		$template->setValue('TGLAKTIF', $data->TGL_AKTIF);		
		$template->setValue('ALAMAT', $data->ALAMAT);
		$template->setValue('TEMTALA', $data->TEMPAT_LAHIR."/".$data->TGL_LAHIR);
		$template->setValue('NOHP', $data->TELEPON);
		$template->setValue('EMAIL', $data->EMAIL);
		$template->setValue('STATUS', $arrStsNikah[$data->STATUS_NIKAH]);
		$template->setValue('NOREK', $data->REKENING);
		$template->setValue('PENDIDIKAN', $data->NAMA_DIDIK);
		
		$str = "SELECT a.*,didik.VALUE1 PENDIDIKAN, kel.VALUE1, kel.VALUE2, kel.VALUE3,sex.VALUE1 JNSKEL
				FROM adm_hubkel a
				left join gen_reff didik on didik.ID_REFF=a.ID_PENDIDIKAN
				left join gen_reff kel on kel.ID_REFF=a.ID_HUBKEL
				left join gen_reff sex on sex.ID_REFF=a.SEX
				WHERE didik.reff='PENDIDIKAN'
				AND kel.reff='KELUARGA'
				AND sex.reff='SEX'
				AND a.NIK='".$nik."' ";
		$query = $this->db->query($str)->result();

		/*$template->setValue('NAMA2', $data->ALAMAT);
		$template->setValue('TEMTALA2', $data->ALAMAT);
		$template->setValue('PEKERJAAN', $data->ALAMAT);
		*/
		$filename = 'DATA_KARY_'.strtotime($data->NIK).'.docx';
		$template->save($filename);
		header('Content-Description: File Transfer');
		header('Content-type: application/force-download');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($filename));
		readfile($filename);
		@unlink($filename);
	}

function xlsx(){
		$str = "select * from pegawai where status_aktif=1 ";
		$cabang=$this->input->get('cabang');
		$search=$this->input->get('search');
		if (!empty($cabang)){
			$str .= " AND ID_CABANG=".$cabang." ";
		}
	/*	if (!empty($divisi) && $divisi!='null'){
			$divs = $this->common_model->getDivChild($divisi);
			$str .= " AND ID_DIV in (".implode(',',$divs).") ";
		}*/
		if (!empty($search)){
			$str .= " AND NAMA like '%".$search."%' ";
		}
		$result = $this->db->query($str)->result();
		echo print_r($result)."<br><br>";
		$mydata=array();
		$i=0;
		foreach($result as $hasil){ 
			$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$hasil->ID_CABANG.") NAMA_CABANG, (SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$hasil->ID_JAB.") NAMA_JAB ")->row();
			$mydata[$i]=array("NIK" => $hasil->NIK, "NAMA" => $hasil->NAMA, "NAMA_CABANG" => $rsname->NAMA_CABANG, "NAMA_JAB" => $rsname->NAMA_JAB);
			$i++;
		}
		$arr=(object)$mydata;
		//echo print_r($mydata);
	    //judul file XLS
		$title = "DATA PEGAWAI YATIM MANDIRI";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'CABANG',
			//'DIVISI',
			'JABATAN'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(
			'NIK',
			'NAMA',
			'NAMA_CABANG',
			//'NAMA_DIV',
			'NAMA_JAB'
		);
		$xlsfile = "rekappeg.xls";
		
		if (!empty($result)){
			//$this->commonlib->printXLS($title,$arr,$headertext,$rowitem,$xlsfile);
			echo print_r($arr);
		} else {
			echo "XLSX Failed. No Valid Data";
		}
		
}
	function xlsx_(){
		$cabang = $this->input->get('cabang');
		//$divisi = $this->input->get('divisi');
		$search = $this->input->get('search');
		
		$str = "select * from v_pegawai where status_aktif=1 ";
		if (!empty($cabang)){
			$str .= " AND ID_CABANG=".$cabang." ";
		}
	/*	if (!empty($divisi) && $divisi!='null'){
			$divs = $this->common_model->getDivChild($divisi);
			$str .= " AND ID_DIV in (".implode(',',$divs).") ";
		}*/
		if (!empty($search)){
			$str .= " AND NAMA like '%".$search."%' ";
		}
		$result = $this->db->query($str)->result();
		
		//judul file XLS
		$title = "DATA PEGAWAI YATIM MANDIRI";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'CABANG',
			//'DIVISI',
			'JABATAN'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(
			'NIK',
			'NAMA',
			'NAMA_CABANG',
			//'NAMA_DIV',
			'NAMA_JAB'
		);
		$xlsfile = "rekappeg.xls";
		
		if (!empty($result)){
			$this->commonlib->printXLS($title,$result,$headertext,$rowitem,$xlsfile);
		} else {
			echo "XLSX Failed. No Valid Data";
		}
		
	}
	
	public function upgradeKontrak(){
		if ($this->input->is_ajax_request()){
			$nik = $this->input->post('nik');
			$result = $this->emp_model->getNIK($nik);
			$kontrak = $result->STATUS_PEGAWAI;
			$lastdate = $result->TGL_AKHIR_KONTRAK;
			$startdate = date('Y-m-d',strtotime($lastdate.' +1 day'));
			if($kontrak<2){
				$upg = $kontrak + 1;	//kontrak 2
				$enddate = date('Y-m-d',strtotime($startdate.' +3 month'));
			} elseif($kontrak<4){
				$upg = $kontrak + 1;	//kontrak 3 & 4
				$enddate = date('Y-m-d',strtotime($startdate.' +18 month'));
			} elseif($kontrak<5){	
				$upg = $kontrak + 1;	//kontrak 5
				$enddate = date('Y-m-d',strtotime($startdate.' +24 month'));
			} elseif($kontrak<6){	
				$upg = $kontrak + 1;	//kontrak 6
				$enddate = null;
			} 
			$data = array(
				'STATUS_PEGAWAI'=>$upg,
				'TGL_AWAL_KONTRAK'=>$startdate,
				'TGL_AKHIR_KONTRAK'=>$enddate,
				'UPDATED_BY' => $this->session->userdata('auth')->id,
				'UPDATED_DATE' => timenow(),
			);
			if($this->db->where('NIK',$nik)->update('pegawai',$data)){
				$this->db->where('NIK',$nik)->where('ISACTIVE',1)->update('kontrak',array('ISACTIVE'=>0));
				$this->db->trans_commit();
				$kontrak = array(
					'NIK' => $nik,
					'ID_CAB' => $result->ID_CABANG,
					'ID_DIV' => $result->ID_DIV,
					'ID_JAB' => $result->ID_JAB,
					'TGL_PENETAPAN' => timenow(),
					'JENIS' => $upg,
					'TGL_AWAL' => $startdate,
					'TGL_AKHIR' => $enddate,
					'ISACTIVE' => 1,
					'CREATED_BY' => $this->session->userdata('auth')->id,
					'CREATED_DATE' => timenow(),
				);
				if ($this->db->insert('kontrak', $kontrak)) {
					$msg['status']='success';
					$this->db->trans_commit();
					echo json_encode($msg);
				}
			}
		}
	}
}
