<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hrdReportRekapHRD extends MY_App {

	function __construct()
	{
		parent::__construct();		
		$this->load->model('report_model');
		$this->load->model('emp_model');
		$this->load->helper('file');
		$this->load->library('CI_Pdf');
		$this->load->helper('download');
		$this->config->set_item('mymenu', 'mn6');
		$this->auth->authorize();
	}
	
	
	public function rekapFilter()
	{	if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$arrayO=array(
			'cuti'=>'Permohonan Cuti/Ijin',
			'lembur'=>'Permohonan Lembur',
			//'peg_organisasi'=>'Pengalaman Organisasi',
			//'peg_pengalaman_kerja'=>'Pengalaman Kerja',
			'prestasi'=>'Data Prestasi',
			'pelatihan'=>'Data Pelatihan',
			'pelanggaran'=>'Data Pelanggaran',
			'mutasi'=>'Data Karyawan Mutasi',
			'resign'=>'Data Karyawan Resign'
		);
		$this->config->set_item('mySubMenu', 'mn62');
		$data['arrBulan'] = $this->arrBulan2;
		$data['arrThn'] = $this->getYearArr();
		$data['options'] = $arrayO;
		$this->template->set('pagetitle','Rekap HRD Bulanan ');		
		$this->template->load('default','fhrdReport/rekapFilter',$data);
	}
	
	
	public function rekapResultMap($param=null){
		$this->config->set_item('mySubMenu', 'mn62');
		$header=$this->commonlib->reportHeader();
		$footer=$this->commonlib->reportFooter();
		$blnStr=$this->arrBulan2;
		$cabang="";
		if ($param!=null){
			$arr=explode("_",$param);
			$jenis=$arr[0];
			$cabang=$arr[1];
			$display=$arr[2];
			$bln=$arr[3];
			$thn=$arr[4];
			
		}else{
			$jenis=$this->input->post('cbJenis');
			$display=$this->input->post('display');
			$cabang=$this->input->post('cabang');
			$bln=$this->input->post('cbBulan');
			$thn=$this->input->post('cbTahun');
		}
		
		$data['jenis']=$jenis;
		$data['bln']=$bln;
		$data['thn']=$thn;
		$rsmaster="";
		if ($cabang==""){
		    $rsmaster=$this->report_model->getArr_cabang();
		    $data['$arrCabang']=$rsmaster;
		}else{
		    
    		$rsmaster=$this->report_model->get_cabang($cabang);
    		$data['cabang']=$rsmaster;
		}
		
		//$rsmaster=$this->emp_model->master_data($rscabang->ID_CABANG, $rscabang->ID_DIV, $rscabang->ID_JAB);
		//$data['arrCabang']=$this->report_model->getArr_cabang();
		
		
		$data['arrDivisi']=$this->report_model->getArr_divisi();
		switch ($jenis){
			case "cuti":	
				$arrCaption=array('NIK','NAMA', 'POSISI', 'TGL PENGAJUAN', 'JENIS CUTI', 'TGL AWAL CUTI', 'TGL AKHIR CUTI', 'JML HARI', 'KETERANGAN', 'APPROVED STATUS');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".($rsmaster->KOTA==""|| empty($rsmaster->KOTA)?"":$rsmaster->KOTA)."','-', '".($rsmaster->KOTA==""|| empty($rsmaster->KOTA)?"":$rsmaster->KOTA)."') POSISI",'TGL_TRANS', 'JENISCUTI1, JENISCUTI2', 'TGL_AWAL', 'TGL_AKHIR', 'JML_HARI', 'KETERANGAN', 'APPROVED, APPROVED_BY, APPROVED_DATE');
				//$nmTable="v_cuti";
				$nmTable=" (SELECT i.nik, CAST(`i`.`CREATED_DATE` AS DATE) AS `TGL_TRANS`, TGL_AWAL, TGL_AKHIR, JML_HARI, KETERANGAN, APPROVED, APPROVED_BY, APPROVED_DATE, `i`.`JENIS_CUTI`    AS `JENIS_CUTI`, `i`.`SUB_CUTI`      AS `SUB_CUTI`,   `t`.`VALUE1`        AS `JENISCUTI1`,   IF (`t`.`ID_REFF`>1, `t2`.`VALUE1`, '')       AS `JENISCUTI2`,   `t2`.`ID_REFF`      AS `ID_REFF` FROM `cuti` `i`      LEFT JOIN `gen_reff` `t`       ON `t`.`ID_REFF` = `i`.`JENIS_CUTI`    RIGHT JOIN `gen_reff` `t2`      ON `t2`.`ID_REFF` = `i`.`SUB_CUTI` WHERE `t`.`REFF` = 'JENISCUTI'        AND `t2`.`REFF` = 'CUTIKHUSUS') ";
				$fieldKey=array('TGL_AWAL','TGL_AKHIR');
				$title="Rekap HRD Data Permohonan Cuti";
				$namafile="rekap_cuti_".$thn."_".$bln;
				break;
			case "lembur":
				$arrCaption=array('NIK','NAMA','POSISI', 'TGL PENGAJUAN', 'TGL LEMBUR', 'JAM MULAI', 'JAM SELESAI', 'JML JAM', 'KETERANGAN', 'APPROVED STATUS');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".$rsmaster->KOTA."','-', '".$rsmaster->KOTA."') POSISI",'l.CREATED_DATE', 'TGL_LEMBUR, JAM_MULAI', 'JAM_SELESAI', 'JML_JAM','KETERANGAN', 'APPROVED, APPROVED_BY, APPROVED_DATE');
				$nmTable="lembur l, lembur_d d";
				$fieldKey=array('TGL_LEMBUR');
				$title="Rekap Data Permohonan Lembur";
				$namafile="rekap_lembur_".$thn."_".$bln;
				break;
			case "prestasi":	
				$arrCaption=array('NIK','NAMA', 'POSISI','JENIS PENILAIAN', 'DETIL DOKUMEN', 'DETIL EVALUASI', 'INFO VALIDASI', 'TANGGAPAN');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".$rsmaster->KOTA."','-', '".$rsmaster->KOTA."') POSISI",'TANGGAL', 'NAMA_PRESTASI', 'KETERANGAN');
				$nmTable="prestasi";
				$fieldKey=array('TANGGAL');
				$title="Rekap Data Prestasi Karyawan";
				$namafile="rekap_prestasi_".$thn."_".$bln;
				break;
			case "pelatihan":	
				$arrCaption=array('NIK','NAMA', 'POSISI','TANGGAL', 'NAMA PELATIHAN', 'KETERANGAN');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".$rsmaster->KOTA."','-', '".$rsmaster->KOTA."') POSISI",'TANGGAL', 'NAMA_PELATIHAN', 'KETERANGAN');
				$nmTable="pelatihan";
				$fieldKey=array('TANGGAL');
				$title="Rekap Data Pelatihan Karyawan";
				$namafile="rekap_pelatihan_".$thn."_".$bln;
				break;
			case "pelanggaran":	
				$arrCaption=array('NIK','NAMA','POSISI', 'TANGGAL', 'NAMA PELANGGARAN', 'KETERANGAN');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".$rsmaster->KOTA."','-', '".$rsmaster->KOTA."') POSISI",'TANGGAL', 'NAMA_PELANGGARAN', 'KETERANGAN');
				$nmTable="pelanggaran";
				$fieldKey=array('TANGGAL');
				$title="Rekap Data Pelanggaran Karyawan";
				$namafile="rekap_pelanggaran_".$thn."_".$bln;
				break;
			case "mutasi":	
				$arrCaption=array('NIK','NAMA','MUTASI KE', 'DARI', 'TGL PENETAPAN','KETERANGAN', 'MENGETAHUI', 'MENYETUJUI');
				$arrField=array('P.NIK','P.NAMA',"YYYYY",'XXXXX',"YYYYY",'XXXXX', 'MENGETAHUI', 'MENYETUJUI');
				$nmTable="mutasi";
				$fieldKey=array('TGL_PENETAPAN');
				$title="Rekap Data Mutasi Karyawan";
				$namafile="rekap_mutasi_".$thn."_".$bln;
				break;
			case "resign":	
				$arrCaption=array('NIK','NAMA', 'POSISI','TGL', 'ALASAN', 'MENGETAHUI', 'MENYETUJUI');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".$rsmaster->KOTA."','-', '".$rsmaster->KOTA."') POSISI",'TGL', 'ALASAN', 'APPROVED_RO_BY', 'APPROVED_PUSAT_BY');
				$nmTable="resign";
				$fieldKey=array('TGL');
				$title="Rekap Data Karyawan Resign";
				$namafile="rekap_resign_".$thn."_".$bln;
				break;
			/*case "peg_organisasi":	
				$arrCaption=array('NIK','NAMA','POSISI',  'KETERANGAN');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".$rsmaster->KOTA."','-', '".$rsmaster->KOTA."') POSISI", 'KETERANGAN');
				$nmTable="peg_organisasi";
				$fieldKey=array('P.NIK');
				$title="Rekap Data Pengalaman Organisasi";
				$namafile="rekap_pelanggaran_".$thn."_".$bln;
				break;
			case "pelanggaran":	
				$arrCaption=array('NIK','NAMA','POSISI',  'KETERANGAN');
				$arrField=array('P.NIK','P.NAMA',"CONCAT ('".$rsmaster->KOTA."','-', '".$rsmaster->KOTA."') POSISI", 'KETERANGAN');
				$nmTable="pelanggaran";
				$fieldKey=array('TANGGAL');
				$title="Rekap Data Pengalaman Kerja";
				$namafile="rekap_pelanggaran_".$thn."_".$bln;
				break;*/
		}
		$title.=" ".$blnStr[$bln]." ".$thn;
		$data['title']=$title;
		$data['display']=$display;
		$data['arrCaption']=$arrCaption;
		$data['arrField']=$arrField;
		$data['nmTable']=$nmTable;
		$data['fieldKey']=$fieldKey;

		if ($display==0){
			$this->template->set('pagetitle',$title);		
			$this->template->load('default','fhrdReport/rekapResultMap',$data);
		}else{
			$html=$header;
			$html.=$this->load->view('fhrdReport/rekapResultMap', $data, true);
			$html.=$footer;
			$this->ci_pdf->pdf_create($html, $namafile);
		}
		
	}
	



}
