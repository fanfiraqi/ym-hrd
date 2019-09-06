<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ubudiah_fr extends MY_App {

	function __construct()
	{
		parent::__construct();		
		$this->config->set_item('mymenu', 'menuEmpatTiga');
		$this->load->helper('array');
		$this->load->helper('download');
		$this->load->dbutil();
	    $this->load->helper('file');
		$this->load->database();
		$this->auth->authorize();
	}
	
	public function index(){
		$this->template->set('pagetitle','Form Entri Penilaian Ubudiah FR Bulanan');		
		$data['cabang'] = $this->common_model->comboCabang();
		//$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		$data['arrBulan'] = $this->arrBulan2;
		$data['arrIntBln'] = $this->arrIntBln;
		$data['arrThn'] = $this->getYearArr();
		$this->template->load('default','fgaji_fr/ubudiahFilter',$data);
	}
	public function comboDivByCab(){
		$id_cab = $this->input->post('id_cabang');
		if ($this->session->userdata('auth')->ROLE=='Direktur Keuangan'or'Manager HRD'){
		$query = $this->db->select('d.ID_DIV,d.NAMA_DIV')
			->join('mst_divisi d','d.id_div=s.id_div','left')
			->where(array('s.id_cab'=>$id_cab))
			->distinct()
			->get('mst_struktur s')->result();
		}else{
			$query = $this->db->query("SELECT DISTINCT `d`.`ID_DIV`, `d`.`NAMA_DIV` FROM `mst_struktur` s LEFT JOIN `mst_divisi` d ON `d`.`id_div`=`s`.`id_div` WHERE `s`.`id_cab` =  '$id_cab' AND `d`.`ID_DIV` <> 1 ")->result();
		}
		$respon = new StdClass();
		$respon->status = 0;
		if (!empty($query)){
			$respon->status = 1;
			$respon->data = $query;
		}else{
			$respon->status = 0;
		}
		echo json_encode($respon);
		//echo $this->db->last_query()."#".var_dump($query);
	}
	public function ubudiahEntri(){
		$bln=$this->input->post('cbBulan');
		$thn=$this->input->post('cbTahun');
		$id_cab=$this->input->post('id_cabang');
		//$id_div=$this->input->post('id_divisi');
		$blnStr=$this->arrBulan2;
		$blnIdk=$this->arrIntBln;
		$nmCabang = $this->db->query("select KOTA from mst_cabang where id_cabang=".$this->input->post('id_cabang'))->row();
		//$rsnmdiv=$this->db->query("select NAMA_DIV from mst_divisi where id_div=$id_div")->row();
		if ($bln==1){
			$bln_pre=12;
			$thn_pre=$thn-1;
		}else{
			$bln_pre=$blnIdk[intval($bln)-1];
			$thn_pre=$thn;
		}
		$strCek="select count(*) CEK from ubudiah_fr where bln='".$bln."' and thn='$thn' and nik in (select distinct nik from pegawai where id_cabang=$id_cab and status_aktif=1 and  id_jab =13)";
		$rsCek = $this->db->query($strCek)->row();
		
		$strList = "SELECT p.*, j.NAMA_JAB, period_diff( date_format( now( ) , '%Y%m' ) , date_format( tgl_aktif, '%Y%m' ) ) SELISIH from pegawai p, mst_jabatan j where p.id_jab=j.id_jab and status_aktif=1 and id_cabang=$id_cab and  p.id_jab=13 ";
		$data['row'] = $this->db->query($strList)->result();
		$data['strBulan'] = $blnStr[$bln];
		$data['digitBln'] = $bln;
		$data['id_cabang'] = $id_cab;
		//$data['id_divisi'] = $id_div;
		$data['thn'] = $thn;

		if ($rsCek->CEK<=0 && $thn.$bln>=date('Ym')){
			$this->template->set('pagetitle','Form Entri Penilaian Ubudiah FR Bulanan (NEW) '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));	
			$this->template->load('default','fgaji_fr/ubudiahEntri',$data);
		}else{

			$tgl1=strtotime($thn_pre."-".$bln_pre."-26");
			$tgl2=strtotime($thn."-".$bln."-31");
			$data['cekTgl']=$tgl1."#".$tgl2;
			if (strtotime(date('Y-m-d'))>=$tgl1 && strtotime(date('Y-m-d'))<=$tgl2){	//cek sysdate antara 26-bln-1 s.d 25-bln 
				//boleh edit, ambil data master
				$this->template->set('pagetitle','Form Entri Penilaian Ubudiah FR Bulanan (EDIT) '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));	
				$this->template->load('default','fgaji_fr/ubudiahEntri',$data);
			}else{
				$strDR = "SELECT p.*, dr.JML_HARI,  j.NAMA_JAB, period_diff( date_format( now( ) , '%Y%m' ) , date_format( tgl_aktif, '%Y%m' ) ) SELISIH from pegawai p, mst_jabatan j, ubudiah_fr dr where p.nik=dr.nik and thn='$thn' and bln='$bln' and p.id_jab=j.id_jab and status_aktif=1 and id_cabang=$id_cab and p.id_jab =13 ";
				$data['row'] = $this->db->query($strDR)->result();
				$this->template->set('pagetitle','Form Entri Penilaian Ubudiah FR Bulanan (DISABLED) '.$blnStr[$bln]." ".$thn." Cabang ".strtoupper($nmCabang->KOTA));	
				$this->template->load('default','fgaji_fr/ubudiahEntri_disabled',$data);
			}
		}
	}


	public function save_ubudiahEntri(){
		if ($this->input->is_ajax_request()){
			$this->load->library('form_validation');
			$rules = array();
			for($r=1;$r<=$this->input->post('jmlRow');$r++){	
				array_push($rules, array(
							'field' => 'jmlHari_'.$r,
							'label' => 'jmlHari_'.$r,
							'rules' => 'trim|xss_clean|required|numeric'));
				}
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi angka.');
			$respon = new StdClass();
			if ($this->form_validation->run() == TRUE){
				try {
					$this->db->trans_begin();
					for($r=1;$r<=$this->input->post('jmlRow');$r++){
						$this->db->delete('ubudiah_fr', array("NIK"=>$this->input->post('nik_'.$r), 'BLN'=>$this->input->post('bln'), 'THN'=>$this->input->post('thn')));
						$this->db->trans_commit();
						$data = array(
									'BLN' => $this->input->post('bln'),
									'THN' => $this->input->post('thn'),
									'NIK' => $this->input->post('nik_'.$r),
									'JML_HARI' => $this->input->post('jmlHari_'.$r),
									'CREATED_BY' =>'admin',
									'CREATED_DATE' =>date('Y-m-d H:i:s'),
									'UPDATED_BY' =>'admin',
									'UPDATED_DATE' =>date('Y-m-d H:i:s')
							);
						if ($this->db->insert('ubudiah_fr', $data)){
							$this->db->trans_commit();
						} else {
									throw new Exception("gagal simpan");
						}
					}
				}	catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();
					$this->db->trans_rollback();
				}
				$respon->status = 'success';
			}else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);
			//echo json_encode($respon)."<br>".$xGets;
			exit;

		}
		$this->template->set('pagetitle','Saving...');

	}

}