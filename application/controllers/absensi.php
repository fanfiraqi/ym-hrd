<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class absensi extends MY_App {
	
	function __construct()
	{
		parent::__construct();
		$this->auth->authorize();
		$this->load->model('emp_model');
		$this->config->set_item('mymenu', 'mn4');
		
	}
	
	public function index()
	{	
		$this->config->set_item('mySubMenu', 'mn41');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
			$this->template->set('pagetitle','Daftar Karyawan');		
			$this->template->load('default','absensi/index',$data);		
	}
	
	public function upload()
	{

		$this->template->set('pagetitle','Upload Data Absensi');
		$this->config->set_item('mySubMenu', 'mn41');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}

		//$data['cabang'] = $this->common_model->comboCabang();
		$data['arrBulan'] = $this->arrBulan2;
		$data['arrThn'] = $this->getYearArr();
		$this->template->load('default','absensi/upload_view',$data);
	}
	
	public function doupload()
	{
		$file = 'xlsfile'; //id/nama element dile
        $filename = $file;

        $filepath = './assets/files/temp/';

        //
        $config['upload_path'] = $filepath;
        $config['allowed_types'] = 'csv|xls|xlsx';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1800';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['overwrite'] = TRUE;
	
        $ret = $this->commonlib->fileupload($config, $file);
		if ($ret['status']=='error'){
			echo json_encode($ret);
			exit;
		}

		$this->load->library('PHPExcel');
		$xlsfile = $filepath . $ret['msg']['file_name'];
		$inputFileType = PHPExcel_IOFactory::identify($xlsfile);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setDelimiter(";");
		$objPHPExcel = $objReader->load($xlsfile);
		$objWorksheet = $objPHPExcel->getSheet(0);
		
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$data = array();
		
		$str="select count(*) JML from absensi where ID_CABANG=".$this->input->post('cabang')." and TANGGAL like '%/".$this->input->post('cbBulan')."/".$this->input->post('cbTahun')."' ";
		$rcek=$this->db->query($str)->row();
		$ret['str']=$str;
		$ret['cek']=$rcek->JML;
		
		if ($rcek->JML>0){
			$this->db->query("delete from absensi where ID_CABANG=".$this->input->post('cabang')." and TANGGAL like '%/".$this->input->post('cbBulan')."/".$this->input->post('cbTahun')."' ");
			$this->db->trans_commit();
		}

		for ($row = 2; $row <= $highestRow; ++$row) {

			$data[]=array(
				'ID_CABANG' => $this->input->post('cabang'),
				'NIK' => $objWorksheet->getCellByColumnAndRow(2, $row)->getValue(),
				'TANGGAL' => $objWorksheet->getCellByColumnAndRow(4, $row)->getValue(),
				'JAM_MASUK' => $objWorksheet->getCellByColumnAndRow(5, $row)->getValue(),
				'JAM_PULANG' => $objWorksheet->getCellByColumnAndRow(6, $row)->getValue(),
				'SCAN_MASUK' => $objWorksheet->getCellByColumnAndRow(7, $row)->getValue(),
				'SCAN_PULANG' => $objWorksheet->getCellByColumnAndRow(8, $row)->getValue(),
				'TERLAMBAT' => $objWorksheet->getCellByColumnAndRow(9, $row)->getValue(),		
				'PULANG_CEPAT' => $objWorksheet->getCellByColumnAndRow(10, $row)->getValue(),
				'LEMBUR' => $objWorksheet->getCellByColumnAndRow(11, $row)->getValue(),
				'LEMBUR_LIBUR' => $objWorksheet->getCellByColumnAndRow(12, $row)->getValue(),	
				'CREATED_BY' => $this->session->userdata('auth')->id,
				'CREATED_DATE' =>timenow()
			);
		}
		
		if($this->db->insert_batch('absensi',$data)){
			$ret['status']='success';
			$ret['msg']='Data CSV Absensi berhasil disimpan';
			$ret['msg']='Data Absensi berhasil disimpan';
		}		
		
		//$ret['isi']=$isi;
		$ret['status']='success';
		echo json_encode($ret);
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			
			$str = "SELECT p.NAMA,p.ID_JAB, p.ID_DIV,p.ID_CABANG, a.*
				FROM absensi a, pegawai p
				WHERE  a.nik=p.nik  ".($this->session->userdata('auth')->id_cabang>1?"  and p.id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and p.id_cabang=".$cabang."  ");
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				//$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
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
					'KOTA' => $rsname->NAMA_CABANG,
					'NIK' => $row->NIK,
					'NAMA' => $row->NAMA,
					'TANGGAL' => $row->TANGGAL,
					'JAM_MASUK' => $row->JAM_MASUK,
					'SCAN_MASUK' => $row->SCAN_MASUK,
					'TERLAMBAT' => $row->TERLAMBAT
					
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

	public function rekap_list_zisco(){
		$bln=$this->input->post('cbBulan');
		$thn=$this->input->post('cbTahun');
		$id_cab=$this->input->post('id_cabang');
		$blnStr=$this->arrBulan;
		$blnIdk=$this->arrIntBln;
		
		//cek var bln tahun 
		if ($bln==1){
			$bln_pre=12;
			$thn_pre=$thn-1;
		}else{
			$bln_pre=$blnIdk[$bln-1];
			$thn_pre=$thn;
		}
		//cek tabel validasi_rekap
		$sCek="select count(*) CEK, VALIDASI  from rekap_validasi_zisco where periode='".$thn.$blnIdk[$bln]."' and id_cab=$id_cab";
		$rsCek=$this->db->query($sCek)->row();
		if ($id_cab==1){
			$start_date=$thn_pre.'-'.$bln_pre.'-21';
			$end_date=$thn.'-'.$blnIdk[$bln].'-20';
		}else{
			$start_date=$thn_pre.'-'.$bln_pre.'-26';
			$end_date=$thn.'-'.$blnIdk[$bln].'-25';
		}
		$jmlhari=$this->getWorkingDays($start_date,$end_date);	//ambil dari fingerprint

		//liburnas
		$strLib="select count(*) LIBNAS FROM mst_harilibur where (TGL_AWAL BETWEEN '" . $start_date . "' AND '" . $end_date . "') and DAYOFWEEK(TGL_AWAL)<>7 and isactive=1";
		$rsLibnas=$this->db->query($strLib)->row();
		//$viewNew="";
		
		$strList="select  *	from  pegawai 	where id_cabang=$id_cab and id_jab  in (35,36) and status_aktif=1  order by NAMA  ";
		//$viewNew="rekap_absen_entri";
		

		$rsList=$this->db->query($strList)->result();
		
		$data['cek'] = $rsCek;
		$data['sCek'] = $sCek;
		$data['strList'] = $strList;
		
		$data['row'] = $rsList;
		$data['strBulan'] = $blnStr[$bln];
		$data['digitBln'] = $blnIdk[$bln];
		$data['thn'] = $thn;
		$data['id_cabang'] = $id_cab;
		$data['strLib'] = $strLib;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['libnas'] = $rsLibnas->LIBNAS;
		$data['jmlhari'] = $jmlhari;
		//$data['jmlHariKerja'] = $jmlhari-$rsLibnas->LIBNAS;
		$data['jmlHariKerja'] = 25;	//default YM

		$nmCabang = $this->gate_db->query("select KOTA from mst_cabang where id_cabang=".$this->input->post('id_cabang'))->row();
		//$rsnmdiv=$this->db->query("select NAMA_DIV from mst_divisi where id_div=$id_div")->row();

		if ($rsCek->CEK<=0){
			$this->template->set('pagetitle','Rekap Absensi Zisco (NEW)  '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));		
			$this->template->load('default','absensi/rekap_absen_zisco',$data);
		
		}else{
			//boleh edit, ambil data rekap_absensi
			$strm="select * from rekap_validasi_zisco where periode='".$thn.$blnIdk[$bln]."' and id_cab=".$id_cab;
			$strd="select p.NIK, p.NAMA, r.* from rekap_absensi_zisco r, pegawai p where r.nik=p.nik and periode='".$thn.$blnIdk[$bln]."'  and p.id_jab  in (35,36) and id_cab=".$id_cab."  and p.status_aktif=1 order by p.NAMA";
			$rsVal=$this->db->query($strm)->row();
			$data["row_master"]=$rsVal;
			$data["row_detil"]=$this->db->query($strd)->result();
			$data['start_date'] = $rsVal->MINDATE;
			$data['end_date'] = $rsVal->MAXDATE;
			$data['jmlhari'] = $rsVal->JML_HARI_EFEKTIF;
			$data['jmlHariKerja'] = $rsVal->JML_HARI_KERJA;
			$data['libnas'] = $rsVal->JML_LIBNAS;
			//$data['row'] = $this->db->query($strRes)->result();
			//$data['rsVal'] = $rsVal;

			if ($data['thn'].$data['digitBln']==date('Ym') && $rsCek->VALIDASI !=1){				
				$data["status"]="OPEN";
				$this->template->set('pagetitle','Rekap Absensi Zisco (OPEN) '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));		
				$this->template->load('default','absensi/rekap_absen_zisco_edit',$data);
			}else{
				//$data['strRepVal'] = $strRepVal;
				//$data['strRes'] = $strRes;
				$data["status"]="CLOSED";				
				//tdk boleh edit, ambil data transaksi gaji_fo smua  
				$this->template->set('pagetitle','Rekap Absensi Zisco (CLOSED) '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));	
				$this->template->load('default','absensi/rekap_absen_zisco_disabled',$data);
			}
		}
	}

	public function rekap_list(){
		$bln=$this->input->post('cbBulan');
		$thn=$this->input->post('cbTahun');
		$id_cab=$this->input->post('id_cabang');
		$opsi=$this->input->post('opsi');
		//$id_div=$this->input->post('id_divisi');
		$blnStr=$this->arrBulan;
		$blnIdk=$this->arrIntBln;
		
		//cek var bln tahun (tgl 26 pre s.d 25 bln
		if ($bln==1){
			$bln_pre=12;
			$thn_pre=$thn-1;
		}else{
			$bln_pre=$blnIdk[$bln-1];
			$thn_pre=$thn;
		}
		//cek tabel validasi_rekap
		$sCek="select count(*) CEK, VALIDASI  from rekap_validasi where periode='".$thn.$blnIdk[$bln]."' and id_cab=$id_cab";
		$rsCek=$this->db->query($sCek)->row();
		if ($id_cab==1){
			$start_date=$thn_pre.'-'.$bln_pre.'-21';
			$end_date=$thn.'-'.$blnIdk[$bln].'-20';
		}else{
			$start_date=$thn_pre.'-'.$bln_pre.'-26';
			$end_date=$thn.'-'.$blnIdk[$bln].'-25';
		}
		$jmlhari=$this->getWorkingDays($start_date,$end_date);	//ambil dari fingerprint


		//liburnas
		$strLib="select count(*) LIBNAS FROM mst_harilibur where (TGL_AWAL BETWEEN '" . $start_date . "' AND '" . $end_date . "') and DAYOFWEEK(TGL_AWAL)<>7 and isactive=1";
		$rsLibnas=$this->db->query($strLib)->row();
		$viewNew="";
		if ($opsi=="Fingerprint"){
		//daftar dari fingerprint (tabel absensi)
		$strList="select  a.NIK, p.NAMA, COUNT(*) J_MASUK,  ROUND(SUM(TIME_TO_SEC(CAST(TERLAMBAT AS TIME)))/60,0) J_TERLAMBAT, IFNULL(ROUND(SUM(TIME_TO_SEC(CAST(PULANG_CEPAT AS TIME)))/60,0),0) J_MENIT_PULANG_CEPAT
				from absensi a, pegawai p
				where a.nik=p.nik 
				and a.id_cabang=p.id_cabang				
				and p.id_cabang=$id_cab
				and p.status_aktif=1
				and a.scan_masuk is not null
				and (str_to_date(a.tanggal, '%d/%m/%Y') between '$start_date' and '$end_date')
				group by p.NAMA  order by p.NAMA  ";
			$viewNew="rekap_absen";
		}else{
			$strList="select  *	from  pegawai 	where id_cabang=$id_cab and id_jab not in (35,36) and status_aktif=1  order by NAMA  ";
			$viewNew="rekap_absen_entri";
		}

		$rsList=$this->db->query($strList)->result();
		
		$data['cek'] = $rsCek;
		$data['sCek'] = $sCek;
		$data['strList'] = $strList;
		
		$data['row'] = $rsList;
		$data['strBulan'] = $blnStr[$bln];
		$data['digitBln'] = $blnIdk[$bln];
		$data['thn'] = $thn;
		$data['id_cabang'] = $id_cab;
		//$data['id_divisi'] = $id_div;
		$data['strLib'] = $strLib;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['libnas'] = $rsLibnas->LIBNAS;
		$data['jmlhari'] = $jmlhari;
		//$data['jmlHariKerja'] = $jmlhari-$rsLibnas->LIBNAS;
		$data['jmlHariKerja'] = 25;	//default YM

		$nmCabang = $this->gate_db->query("select KOTA from mst_cabang where id_cabang=".$this->input->post('id_cabang'))->row();
		//$rsnmdiv=$this->db->query("select NAMA_DIV from mst_divisi where id_div=$id_div")->row();

		if ($rsCek->CEK<=0){
			$this->template->set('pagetitle','Rekap Absensi Staff (NEW)  '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));		
			$this->template->load('default','absensi/'.$viewNew,$data);
		
		}else{
			//boleh edit, ambil data rekap_absensi
			$strm="select * from rekap_validasi where periode='".$thn.$blnIdk[$bln]."' and id_cab=".$id_cab;
			$strd="select p.NIK, p.NAMA, r.* from rekap_absensi r, pegawai p where r.nik=p.nik and periode='".$thn.$blnIdk[$bln]."' and id_cab=".$id_cab."  and p.status_aktif=1 order by p.NAMA";
			$rsVal=$this->db->query($strm)->row();
			$data["row_master"]=$rsVal;
			$data["row_detil"]=$this->db->query($strd)->result();
			$data['start_date'] = $rsVal->MINDATE;
			$data['end_date'] = $rsVal->MAXDATE;
			$data['jmlhari'] = $rsVal->JML_HARI_EFEKTIF;
			$data['jmlHariKerja'] = $rsVal->JML_HARI_KERJA;
			$data['libnas'] = $rsVal->JML_LIBNAS;
			//$data['row'] = $this->db->query($strRes)->result();
			//$data['rsVal'] = $rsVal;

			if ($data['thn'].$data['digitBln']==date('Ym') && $rsCek->VALIDASI !=1){				
				$data["status"]="OPEN";
				$this->template->set('pagetitle','Rekap Absensi Staff (OPEN) '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));		
				$this->template->load('default','absensi/rekap_absen_edit',$data);
			}else{
				//$data['strRepVal'] = $strRepVal;
				//$data['strRes'] = $strRes;
				$data["status"]="CLOSED";				
				//tdk boleh edit, ambil data transaksi gaji_fo smua  
				$this->template->set('pagetitle','Rekap Absensi Staff (CLOSED/VIEW ONLY) '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));	
				$this->template->load('default','absensi/rekap_absen_disabled',$data);
			}
		}
	}
	
	//===========
	public function rekap_save(){
		if($this->input->post()) {
			$this->load->library('form_validation');
			$rules = array();
			for($r=1;$r<=$this->input->post('jmlRow');$r++){				
					array_push($rules, array(
							'field' => 'jml_masuk_'.$r,
							'label' => 'jml_masuk_'.$r,
							'rules' => 'trim|xss_clean|required|numeric'));
					array_push($rules, array(
							'field' => 'alpa_'.$r,
							'label' => 'alpa_'.$r,
							'rules' => 'trim|xss_clean|required|numeric'));
			}
			
			$this->form_validation->set_rules($rules);
			//$out=$this->form_validation->run();
			$this->form_validation->set_message('required', 'Field %s harus diisi angka.');
			$respon = new StdClass();
			//$xGets="mulai";
			if ($this->form_validation->run() == TRUE){
				//$xGets.="masuk run";
				try {
					$this->db->trans_begin();
					$thnbln=$this->input->post('thn').$this->input->post('bln');
					//insert master rekap
					$this->db->delete('rekap_validasi', array('PERIODE'=>$thnbln, 'ID_CAB'=>$this->input->post('id_cabang')));
					$this->db->trans_commit();
					$dataMaster = array(
									'PERIODE' => $thnbln,
									'ID_CAB' => $this->input->post('id_cabang'),
									//'ID_DIV' => $this->input->post('id_divisi'),
									'MINDATE' => $this->input->post('mindate'),
									'MAXDATE' => $this->input->post('maxdate'),
									'JML_HARI_EFEKTIF' => $this->input->post('jmlefektif'),
									'JML_LIBNAS' => $this->input->post('jml_libnas'),									
									'JML_HARI_KERJA' => $this->input->post('jml_harikerja'),									
									//'VALIDASI' => 1,									
									'CREATED_BY' =>$this->session->userdata('auth')->id,
									'CREATED_DATE' =>date('Y-m-d H:i:s'),
									'UPDATED_BY' =>$this->session->userdata('auth')->id,
									'UPDATED_DATE' =>date('Y-m-d H:i:s')
								);
					$this->db->insert('rekap_validasi', $dataMaster);
					//$this->db->trans_commit();
					for($r=1;$r<=$this->input->post('jmlRow');$r++){						
						$this->db->delete('rekap_absensi', array("NIK"=>$this->input->post('nik_'.$r), 'PERIODE'=>$thnbln));
						//$xGets.="<br>".$this->db->last_query();
							$this->db->trans_commit();
							$data = array(
									'PERIODE' => $thnbln,
									'NIK' => $this->input->post('nik_'.$r),
									'ID_CAB' => $this->input->post('id_cabang'),
									'JML_MASUK' => $this->input->post('jml_masuk_'.$r),
									'JML_CUTI' => $this->input->post('cuti_'.$r),
									'JML_IJIN' => $this->input->post('ijin_'.$r),
									'JML_SAKIT' => $this->input->post('sakit_'.$r),
									'T10_1' => $this->input->post('t101_'.$r),
									'T10_2' => $this->input->post('t102_'.$r),
									'T10_3' => $this->input->post('t103_'.$r),
									'PULANG_AWAL_JML' => $this->input->post('pc_hari_'.$r),
									'PULANG_AWAL_MENIT' => $this->input->post('pc_menit_'.$r),
									'JAM_LEMBUR' => $this->input->post('lembur_'.$r),
									'JML_ALPA' => $this->input->post('alpa_'.$r),									
									'CREATED_BY' =>$this->session->userdata('auth')->id,
									'CREATED_DATE' =>date('Y-m-d H:i:s'),
									'UPDATED_BY' =>$this->session->userdata('auth')->id,
									'UPDATED_DATE' =>date('Y-m-d H:i:s')
								);
								if ($this->db->insert('rekap_absensi', $data)){								
									$this->db->trans_commit();
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
			//echo json_encode($respon)."<br>".$xGets;
			exit;
		}

		$this->template->set('pagetitle','Saving...');

	}

	//===========
public function rekap_save_zisco(){
		if($this->input->post()) {
			$this->load->library('form_validation');
			$rules = array();
			for($r=1;$r<=$this->input->post('jmlRow');$r++){				
					array_push($rules, array(
							'field' => 'jml_masuk_'.$r,
							'label' => 'jml_masuk_'.$r,
							'rules' => 'trim|xss_clean|required|numeric'));
					array_push($rules, array(
							'field' => 'jml_masuk_tidak_'.$r,
							'label' => 'jml_masuk_tidak_'.$r,
							'rules' => 'trim|xss_clean|required|numeric'));
			}
			
			$this->form_validation->set_rules($rules);
			//$out=$this->form_validation->run();
			$this->form_validation->set_message('required', 'Field %s harus diisi angka.');
			$respon = new StdClass();
			//$xGets="mulai";
			if ($this->form_validation->run() == TRUE){
				//$xGets.="masuk run";
				try {
					$this->db->trans_begin();
					$thnbln=$this->input->post('thn').$this->input->post('bln');
					//insert master rekap
					$this->db->delete('rekap_validasi_zisco', array('PERIODE'=>$thnbln, 'ID_CAB'=>$this->input->post('id_cabang')));
					$this->db->trans_commit();
					$dataMaster = array(
									'PERIODE' => $thnbln,
									'ID_CAB' => $this->input->post('id_cabang'),									
									'MINDATE' => $this->input->post('mindate'),
									'MAXDATE' => $this->input->post('maxdate'),
									'JML_HARI_EFEKTIF' => $this->input->post('jmlefektif'),
									'JML_LIBNAS' => $this->input->post('jml_libnas'),									
									'JML_HARI_KERJA' => $this->input->post('jml_harikerja'),																										
									'CREATED_BY' =>$this->session->userdata('auth')->id,
									'CREATED_DATE' =>date('Y-m-d H:i:s'),
									'UPDATED_BY' =>$this->session->userdata('auth')->id,
									'UPDATED_DATE' =>date('Y-m-d H:i:s')
								);
					$this->db->insert('rekap_validasi_zisco', $dataMaster);
					//$this->db->trans_commit();
					for($r=1;$r<=$this->input->post('jmlRow');$r++){						
						$this->db->delete('rekap_absensi_zisco', array("NIK"=>$this->input->post('nik_'.$r), 'PERIODE'=>$thnbln));
						//$xGets.="<br>".$this->db->last_query();
							$this->db->trans_commit();
							$data = array(
									'PERIODE' => $thnbln,
									'NIK' => $this->input->post('nik_'.$r),
									'ID_CAB' => $this->input->post('id_cabang'),
									'JML_MASUK' => $this->input->post('jml_masuk_'.$r),
									'JML_TIDAK_MASUK' => $this->input->post('jml_masuk_tidak_'.$r),
									'JML_ALPA' => $this->input->post('jml_alpa_'.$r),							
									'JML_CUTI' => $this->input->post('jml_cuti_'.$r),							
									'JML_SAKIT' => $this->input->post('jml_sakit_'.$r),							
									'CREATED_BY' =>$this->session->userdata('auth')->id,
									'CREATED_DATE' =>date('Y-m-d H:i:s'),
									'UPDATED_BY' =>$this->session->userdata('auth')->id,
									'UPDATED_DATE' =>date('Y-m-d H:i:s')
								);
								if ($this->db->insert('rekap_absensi_zisco', $data)){								
									$this->db->trans_commit();
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
			//echo json_encode($respon)."<br>".$xGets;
			exit;
		}

		$this->template->set('pagetitle','Saving...');

	}

	//===========
	public function getWorkingDays($startDate, $endDate){
		$begin=strtotime($startDate);
		$end=strtotime($endDate);
		if($begin>$end){
			$msg="startdate is in the future! <br />";
			return 0;
		}else{
		$no_days=0;
		$weekends=0;
		while($begin<=$end){
			$no_days++; // no of days in the given interval
			$what_day=date('N',$begin);
			 if($what_day>6) { //  7 are weekend days
				  $weekends++;
			 };
			$begin+=86400; // +1 day
		}
		$working_days=$no_days-$weekends;
		return $working_days;
		}
	}
	public function rekapAbsen(){
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Rekap Absensi Bulanan');	
		$this->config->set_item('mySubMenu', 'mn42');
		//$data['cabang'] = $this->common_model->comboCabang();
		$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		$data['arrBulan'] = $this->arrBulan;
		$data['arrIntBln'] = $this->arrIntBln;
		$data['arrThn'] = $this->getYearArr();
		$this->template->load('default','absensi/setFilter',$data);
	}
	public function rekapAbsenzisco(){
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Rekap Absensi Bulanan');	
		$this->config->set_item('mySubMenu', 'mn43');
		$data['arrBulan'] = $this->arrBulan;
		$data['arrIntBln'] = $this->arrIntBln;
		$data['arrThn'] = $this->getYearArr();
		$this->template->load('default','absensi/setFilterZisco',$data);
	}
	public function json_rekapAbsen(){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT a.NIK, NAMA, COUNT( TANGGAL ) JMLMASUK
					FROM `absensi` a, pegawai p
					WHERE a.nik = p.nik
					GROUP BY a.nik  ";
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND p.NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
			}
			
			
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				//$str .= " ORDER BY ".$_GET['mDataProp_'.$_GET['iSortCol_0']]." ".$_GET['sSortDir_0'];
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
			$i=1;
			foreach($query as $row){				
				$aaData[] = array(
					'NO'=>$i,
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'JMLMASUK'=>$row->JMLMASUK,
					'JMLCUTI'=>0,
					'JMLLEMBUR'=>0,
					'JMLTERLAMBAT'=>0
					
				);
				$i++;
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

	
	public function validasirekap_zisco(){
		$cabang=$this->input->post('cabang');
		$periode=$this->input->post('periode');
		$respon = new StdClass();
		$respon->status = 'error';
		if ($this->db->query("update rekap_validasi_zisco set validasi=1 where id_cab =$cabang and periode='".$periode."'")){
			$respon->status = 'success';
		}
		echo json_encode($respon);
	}
	public function validasirekap(){
		$cabang=$this->input->post('cabang');
		$periode=$this->input->post('periode');
		$respon = new StdClass();
		$respon->status = 'error';
		if ($this->db->query("update rekap_validasi set validasi=1 where id_cab =$cabang and periode='".$periode."'")){
			$respon->status = 'success';
		}
		echo json_encode($respon);
	}
	public function resetTableAbsen(){
		$id=$this->input->post('cabang');
		$respon = new StdClass();
		$respon->status = 'error';
		if ($this->db->query("delete from absensi where id_cabang=$id")){
			$respon->status = 'success';
		}
		echo json_encode($respon);
	}
}
