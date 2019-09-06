<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keuReportLoan extends MY_App {

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
		$this->template->set('pagetitle','Informasi Data Pinjaman (View/Cetak)');		
		$this->template->load('default','fkeuReport/index',compact('str'));
	}

	public function personalLoan($param=null)
	{	
		$header=$this->commonlib->reportHeader();
		$footer=$this->commonlib->reportFooter();
		if ($param!=null){
			$arr=explode("_",$param);
			$nik=$arr[0];
			$display=$arr[1];			
			
		}else{
			$display=$this->input->post('display1');
			$nik=$this->input->post('nik');
			
		}
		
		$strMaster="select h.*, p.ID_CABANG, p.ID_DIV, p.ID_JAB, p.NAMA from pinjaman_header h, v_pegawai p  where p.nik=h.nik and h.nik ='$nik' order by h.id desc limit 1";
		$resMaster=$this->db->query($strMaster)->row();

		$rsGate=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$resMaster->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$resMaster->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$resMaster->ID_JAB.") NAMA_JAB ")->row();

				
		$strDetil="select * from pinjaman_angsuran where id_header=".$resMaster->ID;
		$resDetil=$this->db->query($strDetil)->result();

		$data['nik']=$nik;
		$data['title']="Informasi Data Pinjaman Perorangan";
		$data['display']=$display;
		$data['rsGate']=$rsGate;
		$data['resMaster']=$resMaster;
		$data['resDetil']=$resDetil;
		$namafile="data_pinjaman_".$nik;
		if ($display==0){
			$this->template->set('pagetitle','Informasi Data Pinjaman Perorangan (View/Cetak)');		
			$this->template->load('default','fkeuReport/personalLoan',$data);
		}else{
			$html=$header;
			$html.=$this->load->view('fkeuReport/personalLoan', $data, true);
			$html.=$footer;
			$this->ci_pdf->pdf_create($html, $namafile);
		}	
	}
	public function rekapLoan($param=null)
	{	
		$header=$this->commonlib->reportHeader();
		$footer=$this->commonlib->reportFooter();
		if ($param!=null){
			$arr=explode("_",$param);
			$jns_status=str_replace("%20"," ",$arr[0]);
			$display=$arr[1];			
			
		}else{
			$display=$this->input->post('display2');
			$jns_status=$this->input->post('jns_status');
			
		}
		
		$strMaster="SELECT h.ID, p.NIK,p.NAMA, p.ID_CABANG, p.ID_DIV, p.ID_JAB, JUMLAH, LAMA, KEPERLUAN, a.JML_CICILAN, SUM(a.JML_BAYAR) SDH_BAYAR, COUNT(a.JML_BAYAR) JML_ANGS, STATUS
			FROM `pinjaman_header` h, pinjaman_angsuran a, v_pegawai p
			WHERE p.nik=h.nik and h.id=a.id_header and (jml_bayar>0 or jml_bayar<=0 )  AND h.STATUS='".$jns_status."'
			group by p.nik";
		$resMaster=$this->db->query($strMaster)->result();		
		

		$data['strMaster']=$strMaster;
		$data['title']="Data Rekap Pinjaman ".$jns_status;
		$data['display']=$display;
		$data['resMaster']=$resMaster;
		$data['jns_status']=$jns_status;
		//$data['resDetil']=$resDetil;
		$namafile="rekap_pinjaman_".$jns_status;
		if ($display==0){
			$this->template->set('pagetitle',"Data Rekap Pinjaman ".$jns_status." (View/Cetak)");		
			$this->template->load('default','fkeuReport/rekapLoan',$data);
		}else{
			$html=$header;
			$html.=$this->load->view('fkeuReport/rekapLoan', $data, true);
			$html.=$footer;
			$this->ci_pdf->pdf_create_report($html, $namafile, 'a4', 'landscape');
		}	
	}
	public function getPegawai(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$str=" select * from v_pegawai P where  (P.NAMA LIKE '%{$keyword}%' or P.NIK LIKE '%{$keyword}%') and P.NIK  in (select distinct NIK from pinjaman_header ) order by P.NAMA";
		/*$query = $this->db->select()
			->where($where)			
			->order_by('P.NAMA')
			->get('v_pegawai P')
			->result();*/
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
}
