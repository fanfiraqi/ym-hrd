<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cuti extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->load->model('cuti_model');
		$this->config->set_item('mymenu', 'mn2');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->config->set_item('mySubMenu', 'mn22');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		/*$data['cuti'] = $this->common_model->comboReff('JENISCUTI');
		$data['subcuti'] = $this->common_model->comboReff('CUTIKHUSUS');
		$data['limitcuti'] = json_encode($this->db->select('ID_REFF,VALUE2')
				->where('REFF','CUTIKHUSUS')
				->get('gen_reff')->result());*/
		$this->template->set('pagetitle','Daftar Permohonan Ijin/Cuti');		
		$this->template->load('default','cuti/index',$data);
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT *
				FROM v_cuti
				WHERE `ISACTIVE` = 1  ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
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
					
					'NO_TRANS'=>$row->NO_TRANS,
					'TGL_TRANS'=>revdate($row->TGL_TRANS),
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'CABANG'=>$rsname->NAMA_CABANG.'/'.$rsname->NAMA_DIV.'/'.$rsname->NAMA_JAB,
					'TGL_IJIN'=>revdate($row->TGL_AWAL).' s/d '.revdate($row->TGL_AKHIR),
					'KETERANGAN'=>$row->KETERANGAN,		
					'ACTION'=>'<a href="'.base_url('cuti/view/'.$row->ID).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('cuti/edit/'.$row->ID).'"><i class="fa fa-pencil" title="Edit"></i></a>'
				);
			}
			
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $iTotal,
				"qry" => $str,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => $aaData
			);
			echo json_encode($output);
		//}
	}
	
	
	public function appv_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT *
				FROM v_cuti
				WHERE `ISACTIVE` = 1".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
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
					'NO_TRANS'=>$row->NO_TRANS,
					'TGL_TRANS'=>revdate($row->TGL_TRANS),
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'CABANG'=>$rsname->NAMA_CABANG.'/'.$rsname->NAMA_DIV.'/'.$rsname->NAMA_JAB,
					'TGL_IJIN'=>revdate($row->TGL_AWAL).' s/d '.revdate($row->TGL_AKHIR),
					'KETERANGAN'=>$row->KETERANGAN,
					'ACTION'=>'<a href="javascript:void(0)" data-base="'.base_url().'" data-url="'.base_url('cuti/approve/'.$row->ID).'" data-id="'.$row->ID.'" onclick="detail(this)" class="btn btn-act btn-success"><i class="fa fa-gear" title="Validasi"></i></a>'
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
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(
				array(
					'field' => 'nik',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tglawal',
					'label' => 'TANGGAL AWAL IJIN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tglakhir',
					'label' => 'TANGGAL AKHIR IJIN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'sisacuti',
					'label' => 'SISA CUTI',
					'rules' => 'trim|xss_clean|required|greater_than[-1]'
				),
				array(
					'field' => 'keterangan',
					'label' => 'KETERANGAN',
					'rules' => 'trim|xss_clean|required'
				)
			);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('required', 'Field %s harus diisi.');
			$this->form_validation->set_message('greater_than', 'Field %s tidak boleh kurang dari 0.');
			$respon = new StdClass();
			
			if ($this->form_validation->run() == TRUE){
				
				
				$this->db->trans_begin();
				try {
					
					
					$tglawal = revdate($this->input->post('tglawal'));
					$tglakhir = revdate($this->input->post('tglakhir'));
					$notrans = $this->commonlib->gencode('IJIN');
					$nik=$this->input->post('nik');

					$data = array(
						'NO_TRANS' => $notrans,
						'NIK' => $nik,
						'JENIS_CUTI' => $this->input->post('cuti'),
						'SUB_CUTI' => $this->input->post('subcuti'),
						'TGL_AWAL' => $tglawal,
						'TGL_AKHIR' => $tglakhir,
						'JML_HARI' =>  $this->input->post('jmlhari'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					//debug($data);$this->db->trans_rollback();exit;
					if ($tglawal=="00-00-0000" ||$tglakhir =="00-00-0000"){
						$respon->status = 'error';
						throw new Exception("gagal simpan. Tanggal awal & akhir tidak boleh kosong/nol");
					}else{
						if ($this->db->insert('cuti', $data)){
							//simpan codegen_d
								//pindahan commonlib->gencode -edit dulu
								$datacode = array(
									'REFF' => 'IJIN',
									'TAHUN' => substr($notrans,0,4),
									'BULAN' => substr($notrans,5,2),
									'TANGGAL' => date('d'),
									'NOMOR' => intval(substr($notrans, 13,3)),
									'VALUE' => $notrans
								);
							$this->db->trans_commit();
						} else {
							throw new Exception("gagal simpan");
						}
						//nambahkan row di cuti_saldo
						if ($this->input->post('cuti')==1){
							$ccek=$this->db->query("select * from cuti_saldo where nik ='".$nik."' order by tahun desc limit 1")->row();
							if (sizeof($ccek)<=0){
								$this->db->query("insert into cuti_saldo (TAHUN, NIK, SISACUTI, UPDATED_DATE) values(".date('Y').", '".$nik."', 12, '".date ('Y-m-d H:i:s ')."') ");
								
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
			exit;
		}
			else
		{
			$this->template->set('pagetitle','Pengajuan Ijin/Cuti');
			
			
			$data['cuti'] = $this->common_model->comboReff('JENISCUTI');
			$data['subcuti'] = $this->common_model->comboReff('CUTIKHUSUS');
			$data['limitcuti'] = json_encode($this->db->select('ID_REFF,VALUE2')
				->where('REFF','CUTIKHUSUS')
				->get('gen_reff')->result());
			$this->template->load('default','cuti/create',$data);
		}
	}
	
	public function edit($id=null){
		if($this->input->post())
		{
			$this->load->library('form_validation');
			$rules = array(
				array(
					'field' => 'nik',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tglawal',
					'label' => 'TANGGAL AWAL IJIN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tglakhir',
					'label' => 'TANGGAL AKHIR IJIN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'sisacuti',
					'label' => 'SISA CUTI',
					'rules' => 'trim|xss_clean|required|greater_than[0]'
				),
				array(
					'field' => 'keterangan',
					'label' => 'KETERANGAN',
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
					
					
					$tglawal = revdate($this->input->post('tglawal'));
					$tglakhir = revdate($this->input->post('tglakhir'));
					$notrans = $this->input->post('notrans');
					
					$data = array(
						'NO_TRANS' => $notrans,
						'NIK' => $this->input->post('nik'),
						'JENIS_CUTI' => $this->input->post('cuti'),
						'SUB_CUTI' => $this->input->post('subcuti'),
						'TGL_AWAL' => $tglawal,
						'TGL_AKHIR' => $tglakhir,
						'JML_HARI' =>  $this->input->post('jmlhari'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					
					if ($this->db->where('no_trans', $notrans)->update('cuti',$data)){
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
			else
		{
			$this->template->set('pagetitle','Edit Pengajuan Ijin/Cuti');
			$rsCuti=$this->cuti_model->getById($id);
			$data['row'] = $rsCuti;
			$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rsCuti->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rsCuti->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rsCuti->ID_JAB.") NAMA_JAB ")->row();
			$data['rsmaster'] = $rsmaster;
			if (empty($data['row'])){
				flashMessage('Data Invalid','danger');
				redirect('cuti');
			}
			$emp = $this->db->select('JATAHCUTI,CUTILEMBUR')->where('NIK',$data['row']->NIK)->get('v_pegawai')->row();
			$data['jatahcuti'] = $emp->JATAHCUTI;
			$data['cutilembur'] = $emp->CUTILEMBUR;
			$data['cuti'] = $this->common_model->comboReff('JENISCUTI');
			$data['subcuti'] = $this->common_model->comboReff('CUTIKHUSUS');
			$data['limitcuti'] = json_encode($this->db->select('ID_REFF,VALUE2')
				->where('REFF','CUTIKHUSUS')
				->get('gen_reff')->result());
			$this->template->load('default','cuti/edit',$data);
		}
	}
	
	public function lookupemp(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		
		/*$str = "SELECT * from (SELECT p.*, IF (DATE_ADD(p.tgl_aktif,INTERVAL 15 MONTH) <= DATE_FORMAT(SYSDATE(),'%Y-%m-%d'),'TRUE','FALSE') CUTIOK  FROM v_pegawai p 
WHERE p.tgl_aktif IS NOT NULL AND p.`STATUS_AKTIF`=1 AND p.`NAMA` LIKE '%{$keyword}%' OR p.`NIK` LIKE '%{$keyword}%') ss where ss.CUTIOK='TRUE'"*/

		$str = "SELECT IF (DATE_ADD(p.tgl_aktif,INTERVAL 15 MONTH) <= DATE_FORMAT(SYSDATE(),'%Y-%m-%d'),'TRUE','FALSE') CUTIOK, IFNULL((SELECT sisacuti FROM cuti_saldo WHERE nik=p.`NIK` ORDER BY tahun DESC LIMIT 1),0 ) SISA_CUTI,  p.* FROM v_pegawai p  WHERE p.tgl_aktif IS NOT NULL AND p.`STATUS_AKTIF`=1  AND p.`NAMA` LIKE '%{$keyword}%' OR p.`NIK` LIKE '%{$keyword}%' ";
		$query = $this->db->query($str)->result();
		$data['squery']=$str;


		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['pesan'] = '';
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{	/*if($row->CUTIOK=='FALSE'){
					$data['pesan'] = 'karyawan belum dapat jatah cuti atau jatah cuti habis';
				}else{
					$data['pesan'] = ''; //Set response
				}*/
				$data['message'][] = array(
					'id'=>$row->NIK,
					'label' => $row->NIK.' - '.$row->NAMA,
					'value' => $row->NAMA,
					'id_cabang' => $row->ID_CABANG,
					'id_div' => $row->ID_DIV,
					'id_jab' => $row->ID_JAB,
					'jatahcuti' => $row->SISA_CUTI,
					'cutilembur' => $row->CUTILEMBUR,
					'stsCutiOk' => $row->CUTIOK,
					'pesanTeks' => ($row->CUTIOK=='FALSE'?'karyawan belum dapat jatah cuti atau jatah cuti habis':''),
					''
				);
			}
		}
		echo json_encode($data);
	}
	public function cariPeg(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$data['pesan'] = 'karyawan belum dapat jatah cuti atau jatah cuti habis';
		/*$query = $this->db->select("p.*,IF (DATE_ADD(tgl_aktif,INTERVAL 15 MONTH) <= DATE_FORMAT(SYSDATE(),'%Y-%m-%d'),'TRUE','FALSE') CUTIOK ",false)
			->where('P.NAMA LIKE',"%{$keyword}%")
			->or_where('P.NIK LIKE',"%{$keyword}%")
			->order_by('P.NAMA')
			->get('v_pegawai P')
			->result();*/
		$str = "SELECT * FROM v_pegawai p WHERE p.tgl_aktif IS NOT NULL AND p.`STATUS_AKTIF`=1 AND p.`NAMA` LIKE '%{$keyword}%' OR p.`NIK` LIKE '%{$keyword}%'";
		$query = $this->db->query($str)->result();
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['pesan'] = ''; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array(
					'id'=>$row->NIK,
					'label' => $row->NIK.' - '.$row->NAMA,
					'value' => $row->NAMA,
					'cabang' => $row->NAMA_CABANG,
					'divisi' => $row->NAMA_DIV,
					'jabatan' => $row->NAMA_JAB,
					'jatahcuti' => $row->JATAHCUTI,
					''
				);
			}
		}
		echo json_encode($data);
	}
	public function calcday(){		
		$startDatein = revdate($this->input->post('startdate'));
		$endDatein = revdate($this->input->post('enddate'));
		//$jmlhari = $this->workdays($startDatein,$endDatein);
		$jmlhari = $this->getWorkingDays($startDatein,$endDatein);
		$data = array();
		$data['response'] = 'true';
		$data['jmlhari'] = $jmlhari;
		echo json_encode($data);
	}
	
	public function getCutiVal(){
		$id = $this->input->post('id');
		$query=$this->db->query("select value2 isi from gen_reff where REFF='CUTIKHUSUS' and ID_reff=".$id)->row();
		$respon=array();
		if(empty($query)){			
			$respon['str'] = "select value2 isi from gen_reff where REFF='CUTIKHUSUS' and ID_reff=".$id;
			$respon['status'] = 'error';
			$respon['errormsg'] = 'Invalid Data';
		} else {
			$respon['status'] = 'success';
			$respon['value'] = $query->isi;
			
		}
		
		echo json_encode($respon);
	}
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
		$holiday=0;
		$strfilter="select count(*) JML from mst_harilibur where (TGL_AWAL BETWEEN '" . $startDate . "' AND '" . $endDate . "') and DAYOFWEEK(TGL_AWAL)<>1 and isactive=1";
		if ($this->db->query($strfilter)->num_rows()>0){
			$holidays = $this->db->query($strfilter)->row();
			$holiday=$holidays->JML;
		}

		return ($working_days-$holiday);
		}

	}
	public function workdays($startDatein, $endDatein, $holyDate = true) {
		
        
		// do strtotime calculations just once
		$endDate = strtotime($endDatein);
		$startDate = strtotime($startDatein);


		//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
		//We add one to inlude both dates in the interval.
		$days = ($endDate - $startDate) / 86400 + 1;

		$no_full_weeks = floor($days / 7);
		$no_remaining_days = fmod($days, 7);

		//It will return 1 if it's Monday,.. ,7 for Sunday
		$the_first_day_of_week = date("N", $startDate);
		$the_last_day_of_week = date("N", $endDate);
		//---->The two can be equal in leap years when february has 29 days, the equal sign is added here
		//In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
		if ($the_first_day_of_week <= $the_last_day_of_week) {
			//if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
			if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
		}
		else {
			// (edit by Tokes to fix an edge case where the start day was a Sunday
			// and the end day was NOT a Saturday)

			// the day of the week for start is later than the day of the week for end
			if ($the_first_day_of_week == 7) {
				// if the start date is a Sunday, then we definitely subtract 1 day
				$no_remaining_days--;

				/*if ($the_last_day_of_week == 6) {
					// if the end date is a Saturday, then we subtract another day
					$no_remaining_days--;
				}*/
			}
			else {
				// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
				// so we skip an entire weekend and subtract 2 days
				$no_remaining_days -= 1;
			}
		}

		//The no. of business days is: (number of weeks between the two dates) * (6 working days) + the remainder
		//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
		$workingDays = $no_full_weeks * 6;
		if ($no_remaining_days > 0 )
		{
		  $workingDays += $no_remaining_days;
		}

        if ($holyDate == true) {
			$strfilter="select count(*) JML from mst_harilibur where (TGL_AWAL BETWEEN '" . $startDatein . "' AND '" . $endDatein . "') and DAYOFWEEK(TGL_AWAL)<>7 and isactive=1";
			$holidays = $this->db->query($strfilter)->row();
			$workingDays=$workingDays-$holidays->JML;
            /* $holidays = $this->db->select('COUNT(*) JML')
						->where("(TGL_AWAL BETWEEN '" . $startDatein . "' AND '" . $endDatein . "') and DAYOFWEEK(TGL_AWAL)<>7 and isactive=1 ")
						//->where("CUTIBSM = 0")
						->get('mst_harilibur')->result();
			
           foreach ($holidays as $holiday) {
                $time_stamp = strtotime($holiday->TGL_AWAL);
                if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 7)
            $workingDays--;
            }*/
        }
        return $workingDays;
    }
	
	public function approval()
	{	$this->config->set_item('mymenu', 'mn3');
		$this->config->set_item('mySubMenu', 'mn31');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Persetujuan Permohonan Ijin/Cuti');
		$this->template->set('mn1','pegawai');
		$this->template->set('mn2','manajerop');
		$this->template->set('mnact','cutiapp');
		$this->template->load('default','cuti/approval', $data);
	}
	
	public function approve($id){
		$this->config->set_item('mySubMenu', 'mn31');
		$this->db->trans_begin();
		$sts=($this->input->post('approve')=='true'?1:0);
		
		//approve sekaligus set cuti_saldo, & cek bila pindah tahun maka insert cuti_saldo tahun baru, jg onchange cuti tahunan

		$respon['sts']=$sts;
		$str = "SELECT *
				FROM v_cuti
				WHERE ID = ".$id;
		$rsCek=$this->db->query($str)->row();
		try {
			$data = array(
				'APPROVED' => $sts,
				'APPROVED_DATE' => ($sts==1?timenow():'0000-00-00'),
				'APPROVED_BY' => ($sts==1?$this->session->userdata('auth')->name:''),
				'ISACTIVE' => 0,
				'UPDATED_DATE' => timenow(),
				'UPDATED_BY' => $this->session->userdata('auth')->name
			);
			if ($this->db->where('ID',$id)->update('cuti', $data)){				
				$this->db->trans_commit();				
				$respon['status'] = 'success';
			} else {
				throw new Exception("gagal simpan");
			}

			if($rsCek->JENIS_CUTI==1){
				//cek di cuti_saldo, klo blm ada isi, klo sdh ada cek tahun apakah sama dgn thn skr
				$ccek=$this->db->query("select * from cuti_saldo where nik ='".$rsCek->NIK."' order by tahun desc limit 1")->row();
				if (sizeof($ccek)>=1){
					if (substr($rsCek->TGL_TRANS,0,4)==date('Y')){
						$this->db->query("update cuti_saldo set sisacuti=sisacuti-".$rsCek->JML_HARI." where NIK='".$rsCek->NIK."' and TAHUN=".$rsCek->TAHUN) ;
					}else {
						$sisacuti = 12 - $rsCek->JML_HARI;
						$this->db->query("insert into cuti_saldo (TAHUN, NIK, SISACUTI, UPDATED_DATE) values(".date('Y').", '".$rsCek->NIK."', $sisacuti, '".date ('Y-m-d H:i:s ')."') ");
					}
				}
				
			}


			if($rsCek->ID_REFF==10  && $sts==1){
					$isi=array(
						'THN'=>substr($rsCek->NO_TRANS,0,4),
						'BLN'=>substr($rsCek->NO_TRANS,4,2),
						'NIK'=>$rsCek->NIK,
						'TGL_AWAL'=>$rsCek->TGL_AWAL,
						'TGL_AKHIR'=>$rsCek->TGL_AKHIR,
						'TANGGAL'=>($sts==1?timenow():'0000-00-00'),
						'JML_HARI'=>$rsCek->JML_HARI
						
					);
					$this->db->insert('ijin_khusus_alpa',$isi);
				}
				$this->db->trans_commit();
		} catch (Exception $e) {
			$respon['status'] = 'error';
			$respon['errormsg'] = $e->getMessage();;
			$this->db->trans_rollback();
		}
		echo json_encode($respon);
	}


	/*public function view($id){
		$this->template->set('pagetitle','View Data Cuti');
		$data['row'] = $this->cuti_model->getById($id);
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('cabang');
		}
		
		$this->template->load('default','cuti/view',$data);
	
	}
	*/
	public function view($id){
		//$id = $this->input->post('id');
		
		 $rsCuti=$this->cuti_model->getById($id);
		$data['row'] = $rsCuti;
		$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rsCuti->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rsCuti->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rsCuti->ID_JAB.") NAMA_JAB ")->row();
		$data['rsmaster'] = $rsmaster;
		$emp = $this->db->select('JATAHCUTI')->where('NIK',$data['row']->NIK)->get('v_pegawai')->row();
		$data['jatah'] = $emp->JATAHCUTI;
		$start = revdate($data['row']->TGL_AWAL);
		$end = revdate($data['row']->TGL_AWAL);
		$data['jmlhari'] = $data['row']->JML_HARI;
		if ($data['row']->JENIS_CUTI==2){
			if ($data['jmlhari']-$data['row']->LIMITCUTI > 0 && $data['row']->SUB_CUTI!=9){
				$data['sisacuti'] = $data['jatah'] - ($data['jmlhari'] - $data['row']->LIMITCUTI);
			} else {
				$data['sisacuti'] = $data['jatah'];
			}
		} else {
			$data['sisacuti'] = $data['jatah'] - $data['jmlhari'];
		}
		if ($this->input->is_ajax_request()){
			$this->template->load('ajax','cuti/view',$data);
		} else {
			$this->template->set('pagetitle','Detail Permohonan Ijin');
			$this->template->load('default','cuti/view',$data);
		}
	}
}
