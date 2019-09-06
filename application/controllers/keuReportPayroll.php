<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keuReportPayroll extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->load->model('report_model');
		$this->load->helper('file');
		$this->load->library('CI_Pdf');
		$this->load->helper('download');
		$this->config->set_item('mymenu', 'menuEnamDua');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$data['arrBulan'] = $this->arrBulan2;
		$data['arrThn'] = $this->getYearArr();
		//$data['cabang'] = $this->common_model->comboCabang();
		$data['cabang'] = $this->common_model->comboCabang('--- Semua Cabang ---');
		$this->template->set('pagetitle','Laporan Penggajian (View/Cetak)');		
		$this->template->load('default','fkeuReport/payrollFilter',$data);
	}

	public function rekapPayroll($param=null){
		$header=$this->commonlib->reportHeader();
		$footer=$this->commonlib->reportFooter();
		$blnStr=$this->arrBulan2;
		if ($param!=null){
			$arr=explode("_",$param);
			$thn=$arr[0];
			$bln=$arr[1];
			$id_cabang=$arr[2];			
			$display=$arr[3];			
			
		}else{
			$display=$this->input->post('display1');
			$thn=$this->input->post('cbTahun1');
			$bln=$this->input->post('cbBulan1');
			$id_cabang=(!empty($this->input->post('id_cabang'))?$this->input->post('id_cabang'):"0");
			
		}
		
		$nmCabang="Semua Cabang";
		if ($id_cabang!=0){
			$rsCab = $this->db->query("select KOTA from mst_cabang where id_cabang=".$id_cabang)->row();
			$nmCabang=$rsCab ->KOTA;
		}

		$title='Laporan Penggajian Rekap '.$nmCabang.' '.$blnStr[$bln].' '.$thn;
		$data['title']=$title;
		$data['display']=$display;
		$data['thn']=$thn;
		$data['bln']=$bln;
		$data['id_cabang']=$id_cabang;
		$data['strBulan']=$blnStr[$bln];
		$strx="";
		if ($id_cabang=='0'){
			$data['arrCabang']=$this->report_model->getArr_cabang();
		}else{
			$strx = "SELECT distinct mst.ID_CAB, mc.KOTA from mst_struktur mst left join mst_cabang mc on mst.id_cab=mc.id_cabang where mc.id_cabang=$id_cabang	ORDER BY mc.id_cabang ASC";
			$rs= $this->db->query($strx)->result();
			$data['arrCabang']=$rs;
			$data["strx"]=$strx;
			
		}

		$namafile="rekap_payroll_".$nmCabang."_".$thn.$bln;
		if ($display==0){
			$this->template->set('pagetitle',$title.' (View/Cetak)');		
			$this->template->load('default','fkeuReport/rekapPayroll',$data);
		}else{
			$html=$header;
			$html.=$this->load->view('fkeuReport/rekapPayroll', $data, true);
			$html.=$footer;
			$this->ci_pdf->pdf_create_report($html, $namafile, 'a4', 'landscape');
		}	

	}
	
}