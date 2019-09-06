<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class evaluasi_fo extends MY_App {
	
	function __construct()
	{
		parent::__construct();		
		$this->load->model('evaluasi_fo_model');
		$this->config->set_item('mymenu', 'menuEmpatDua');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->template->set('pagetitle','Evalusi Level Karyawan Zakat Advisor (FO)');		
		$data['cabang'] = $this->common_model->comboCabang();
		//$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		$data['arrBulan'] = $this->arrBulan;
		$data['arrIntBln'] = $this->arrIntBln;
		$data['arrThn'] = $this->getYearArr();
		$this->template->load('default','fevaluasi_fo/filter_form',$data);
	}
	
	public function levelTetap(){
		$nik=$this->input->post('nik');
		$idLevelOld=$this->input->post('idLevelOld');
		$res = $this->evaluasi_fo_model->levelTetap($nik, $idLevelOld);
		return $res;
	}
	public function naikLevel(){
		$nik=$this->input->post('nik');
		$idLevelOld=$this->input->post('idLevelOld');
		$res = $this->evaluasi_fo_model->naikLevel($nik, $idLevelOld);
		return $res;
	}
	public function turunLevel(){
		$nik=$this->input->post('nik');
		$idLevelOld=$this->input->post('idLevelOld');
		$res = $this->evaluasi_fo_model->turunLevel($nik, $idLevelOld);
		return $res;
	}
	public function resignLevel(){
		$nik=$this->input->post('nik');
		//$idLevelOld=$this->input->post('idLevelOld');
		$res = $this->evaluasi_fo_model->resignLevel($nik);
		return $res;
	}
	
	
	public function get_evalList(){
		$id_cabang=$this->input->post('id_cabang');
		$strList="SELECT p.NIK, p.NAMA, ev.ID_LEVEL, mst.LEVEL, mst.TERMIN, mst.TARGET_P*mst.TERMIN  AKM_TARGET_P, mst.TARGET_K*mst.TERMIN AKM_TARGET_K, ev.TGL_MULAI,ev.TGL_AKHIR, DATEDIFF(NOW(), ev.TGL_MULAI) DURASI 
		FROM `evaluasi_fo` ev, pegawai p, mst_gaji_fo mst
		WHERE p.nik=ev.nik and ev.id_level=mst.id and ev.status_eval=1 and p.status_aktif=1 and p.id_jab=14 and p.id_cabang=".$this->input->post('id_cabang');
		/*$interval = date_diff(date_create(), date_create($rsOut->TGL_AKTIF));
		$masaKerja= $interval->format("  %Y Tahun, %M Bulan, %d Hari");*/
		$data['row'] = $this->db->query($strList)->result();
			$data['id_cabang'] = $id_cabang;
			$nmCabang = $this->db->query("select KOTA from mst_cabang where id_cabang=".$this->input->post('id_cabang'))->row();
		if ($this->db->query($strList)->num_rows()>0){
			$data['cek']=1;
			
		}else{
			$data['cek']=0;
		}
		$this->template->set('pagetitle','Evalusi Level Karyawan Zakat Advisor (FO) Cabang '.strtoupper($nmCabang->KOTA));	
		$this->template->load('default','fevaluasi_fo/get_evalList',$data);
	}
	/*
	public function save_perolehan(){
		if($this->input->post()) {
			$this->load->library('form_validation');
			$rules = array();
			for($r=1;$r<=$this->input->post('jmlRow');$r++){				
					array_push($rules, array(
							'field' => 'perolehan_'.$r,
							'label' => 'perolehan_'.$r,
							'rules' => 'trim|xss_clean|required|numeric'));
					array_push($rules, array(
							'field' => 'jml_kunjungan_'.$r,
							'label' => 'jml_kunjungan_'.$r,
							'rules' => 'trim|xss_clean|required|numeric'));
			}
			$this->form_validation->set_rules($rules);			
			$this->form_validation->set_message('required', 'Field %s harus diisi angka.');
			$respon = new StdClass();			
			if ($this->form_validation->run() == TRUE){				
				try {
					$this->db->trans_begin();
					for($r=1;$r<=$this->input->post('jmlRow');$r++){
						if ($this->input->post('flag_'.$r)=="1"){
						$this->db->delete('perolehan_fo', array("NIK"=>$this->input->post('nik_'.$r), 'BLN'=>$this->input->post('bln'), 'THN'=>$this->input->post('thn')));						
							$this->db->trans_commit();
							$data = array(
									'BLN' => $this->input->post('bln'),
									'THN' => $this->input->post('thn'),
									'NIK' => $this->input->post('nik_'.$r),
									'ID_LEVEL' => $this->input->post('id_level_'.$r),
									'BLN_KE' => $this->input->post('bulan_ke_'.$r),
									'PEROLEHAN' => $this->input->post('perolehan_'.$r),
									'JML_KUNJUNGAN' => $this->input->post('jml_kunjungan_'.$r)	
								);
								if ($this->db->insert('perolehan_fo', $data)){
									$this->db->trans_commit();
								} else {
									throw new Exception("gagal simpan");
								}
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
	*/
}
