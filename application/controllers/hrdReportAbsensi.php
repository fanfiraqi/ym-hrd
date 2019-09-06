<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hrdReportAbsensi extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->load->model('report_model');
		$this->load->helper('file');
		$this->load->library('CI_Pdf');
		$this->load->helper('download');
		$this->config->set_item('mymenu', 'mn6');
		$this->auth->authorize();
	}
	
	public function index()
	{	$this->config->set_item('mySubMenu', 'mn63');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang('--- Semua Cabang ---');
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$data['action']="rekapAbsenRes";
		$data['arrBulan'] = $this->arrBulan2;
		$data['arrThn'] = $this->getYearArr();
		$data['cabang'] = $this->common_model->comboCabang();
		$this->template->set('pagetitle','Laporan Rekap Absensi Staff Bulanan ');		
		$this->template->load('default','fhrdReport/absensiFilter',$data);
	}
	
	public function zisco()
	{	$this->config->set_item('mySubMenu', 'mn64');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang('--- Semua Cabang ---');
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$data['action']="rekapAbsenResZisco";
		$data['arrBulan'] = $this->arrBulan2;
		$data['arrThn'] = $this->getYearArr();
		$data['cabang'] = $this->common_model->comboCabang();
		$this->template->set('pagetitle','Laporan Rekap Absensi Zisco Bulanan ');		
		$this->template->load('default','fhrdReport/absensiFilter',$data);
	}
	public function rekapAbsenRes($param=null){
		$this->config->set_item('mySubMenu', 'mn63');
		$header=$this->commonlib->reportHeader();
		$footer=$this->commonlib->reportFooter();
		$blnStr=$this->arrBulan2;
		$title="Laporan Rekap Absensi Staff Bulanan";
		$cabang='';
		$bln='';
		$thn='';
		if ($param!=null){
			$arr=explode("_",$param);			
			$display=$arr[1];
			$cabang=$arr[0];
			$bln=$arr[2];
			$thn=$arr[3];
			
		}else{
			
			$display=$this->input->post('display');
			$cabang=$this->input->post('cabang');
			$bln=$this->input->post('cbBulan');
			$thn=$this->input->post('cbTahun');
		}
		$arrDivisi=$this->report_model->getArr_divAtCab($cabang);
		$nmCabang=$this->report_model->get_cabang($cabang);
		$data['display']=$display;
		$data['cabang']=$cabang;
		$data['bln']=$bln;
		$data['thn']=$thn;
		$data['arrDivisi']=$arrDivisi;
		$title.=" ".strtoupper($nmCabang->KOTA)." ".$blnStr[$bln]." ".$thn;
		$data['title']=$title;
		$data['strPeriode']=strtoupper($blnStr[$bln]." ".$thn);
		$namafile="rekap_absensi_staf_".$nmCabang->KOTA."_".$thn.$bln;
		if ($display==0){
			$this->template->set('pagetitle',$title);		
			$this->template->load('default','fhrdReport/rekapAbsen',$data);
		}else{
			$html=$header;
			$html.=$this->load->view('fhrdReport/rekapAbsen', $data, true);
			$html.=$footer;
			$this->ci_pdf->pdf_create_report($html, $namafile, 'a4', 'landscape');
		}
		
	}
	public function rekapAbsenResZisco($param=null){
		$this->config->set_item('mySubMenu', 'mn64');
		$header=$this->commonlib->reportHeader();
		$footer=$this->commonlib->reportFooter();
		$blnStr=$this->arrBulan2;
		$title="Laporan Rekap Absensi Zisco Bulanan";
		$cabang='';
		$bln='';
		$thn='';
		if ($param!=null){
			$arr=explode("_",$param);			
			$display=$arr[1];
			$cabang=$arr[0];
			$bln=$arr[2];
			$thn=$arr[3];
			
		}else{
			
			$display=$this->input->post('display');
			$cabang=$this->input->post('cabang');
			$bln=$this->input->post('cbBulan');
			$thn=$this->input->post('cbTahun');
		}
		$arrDivisi=$this->report_model->getArr_zisco_divAtCab($cabang);
		$nmCabang=$this->report_model->get_cabang($cabang);
		$data['display']=$display;
		$data['cabang']=$cabang;
		$data['bln']=$bln;
		$data['thn']=$thn;
		$data['arrDivisi']=$arrDivisi;
		$data['divisi']=$arrDivisi;
		$title.=" ".strtoupper($nmCabang->KOTA)." ".$blnStr[$bln]." ".$thn;
		$data['title']=$title;
		$data['strPeriode']=strtoupper($blnStr[$bln]." ".$thn);
		$namafile="rekap_absensi_zisco_".$nmCabang->KOTA."_".$thn.$bln;
		if ($display==0){
			$this->template->set('pagetitle',$title);		
			$this->template->load('default','fhrdReport/rekapAbsenZisco',$data);
		}else{
			$html=$header;
			$html.=$this->load->view('fhrdReport/rekapAbsenZisco', $data, true);
			$html.=$footer;
			$this->ci_pdf->pdf_create_report($html, $namafile, 'a4', 'landscape');
		}
		
	}
	
}
