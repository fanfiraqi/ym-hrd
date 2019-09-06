<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mutasi extends MY_App {
	var $branch = array();
	var $branch2 = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('mutasi_model');
		$this->config->set_item('mymenu', 'mn2');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->config->set_item('mySubMenu', 'mn27');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Daftar Catatan Mutasi Karyawan');		
		$this->template->load('default','fmutasi/index',$data);
	}
	
	public function getPegawai(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$str=" select * from v_pegawai P where  (P.NAMA LIKE '%{$keyword}%' or P.NIK LIKE '%{$keyword}%') and P.NIK not in (select distinct NIK from pinjaman_header where status='Belum Lunas') ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  ")." order by P.NAMA" ;	//pusat bisa all cabang
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
					''
				);
			}
		}
		echo json_encode($data);
	}
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			/*$str = "SELECT  p.NAMA, c.KOTA, d.NAMA_DIV, j.NAMA_JAB ,
						(select kota from mst_cabang where id_cabang=m.old_id_cab) OLDCAB,
						(select nama_div from mst_divisi where id_div=m.old_id_div) OLDDIV,
						(select nama_jab from mst_jabatan where id_jab=m.old_id_jab) OLDJAB,
						m.*
						FROM mutasi m, pegawai p, mst_cabang c, mst_divisi d, mst_jabatan j
						WHERE m.nik=p.nik  and m.id_cab=c.id_cabang and m.id_div=d.id_div and m.id_jab=j.id_jab and m.flag <> 0";*/

			$str = "select p.NIK,p.NAMA, p.ID_CABANG,p.ID_DIV,p.ID_JAB, m.*  from pegawai p, mutasi m  where  p.nik=m.nik and m.flag <> 0 ".($this->session->userdata('auth')->id_cabang>1?"  and p.id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and p.id_cabang=".$cabang );
			
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
				$rsnew=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$row->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$row->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$row->ID_JAB.") NAMA_JAB ")->row();

				$rsold=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$row->OLD_ID_CAB.") OLDCAB, (SELECT nama_div FROM mst_divisi WHERE id_div=".$row->OLD_ID_DIV.") OLDDIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$row->OLD_ID_JAB.") OLDJAB ")->row();

				$aaData[] = array(
					'ID'=>$row->ID,					
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'MUTASI'=>$rsnew->NAMA_CABANG."/".$rsnew->NAMA_DIV."/".$rsnew->NAMA_JAB,
					'DARI'=>$rsold->OLDCAB."/".$rsold->OLDDIV."/".$rsold->OLDJAB,
					'TANGGAL'=>$row->TGL_PENETAPAN,
					'KETERANGAN'=>$row->KETERANGAN,
					'MENGETAHUI'=>$row->MENGETAHUI,
					'MENYETUJUI'=>$row->MENYETUJUI,
					'ACTION'=>'<a href="'.base_url('mutasi/view/'.$row->ID."/".$row->NIK).'"><i class="fa fa-eye" title="Lihat Detail History"></i></a> | 
						<a href="'.base_url('mutasi/edit/'.$row->ID).'"><i class="fa fa-edit" title="Edit"></i></a> '
						//| <a href="javascript:void()" onclick="delMutasi('.$row->ID.')"><i class="fa fa-trash-o" title="Hapus"></i></a>
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
					'label' => 'KETERANGAN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'mengetahui',
					'label' => 'MENGETAHUI',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'menyetujui',
					'label' => 'MENYETUJUI',
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
						'ID_CAB' => $this->input->post('id_cabang'),
						'ID_DIV' => $this->input->post('id_divisi'),
						'ID_JAB' => $this->input->post('id_jabatan'),
						'OLD_ID_CAB' => $this->input->post('old_id_cab'),
						'OLD_ID_DIV' => $this->input->post('old_id_div'),
						'OLD_ID_JAB' => $this->input->post('old_id_jab'),
						'TGL_PENETAPAN' => $this->input->post('tanggal'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'MENGETAHUI' => $this->input->post('mengetahui'),
						'NIK_MENGETAHUI' => $this->input->post('nik_mengetahui'),
						'MENYETUJUI' => $this->input->post('menyetujui'),
						'NIK_MENYETUJUI' => $this->input->post('nik_menyetujui'),
						'FLAG' => 1,
						'CREATED_BY' =>$this->session->userdata('auth')->id,
						'CREATED_DATE' =>date('Y-m-d H:i:s'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->insert('mutasi', $data)){
						$dataPeg = array(
						'ID_CABANG' => $this->input->post('id_cabang'),
						'ID_DIV' => $this->input->post('id_divisi'),
						'ID_JAB' => $this->input->post('id_jabatan'),
						);
						//update data pegawai
						//get idpegawai
						$idpeg=$this->db->query("select id from pegawai where nik='".$this->input->post('nik')."'")->row();
						$this->gate_db->where('id_pegawai',$idpeg->id)->update('users', array("id_cabang"=> $this->input->post('id_cabang')));
						$this->db->where('NIK',$this->input->post('nik'))->update('pegawai', $dataPeg);
						$this->db->where('ID',$this->input->post('id'))->update('mutasi', array('flag'=>0));
						
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
		
		$this->template->set('pagetitle','Data Mutasi Baru');
		$data['cabang'] = $this->common_model->comboCabang();
		$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		$data['jabatan'] = $this->divTreeJab($this->common_model->getJabatan()->result_array());
		$this->template->load('default','fmutasi/create', $data);
		
	}
	
	public function edit($id=null){
	
		if($this->input->post())
		{
		
			$this->load->library('form_validation');
			$rules = array(				
				array(
					'field' => 'keterangan',
					'label' => 'KETERANGAN',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'mengetahui',
					'label' => 'MENGETAHUI',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'menyetujui',
					'label' => 'MENYETUJUI',
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
						'ID_CAB' => $this->input->post('id_cabang'),
						'ID_DIV' => $this->input->post('id_divisi'),
						'ID_JAB' => $this->input->post('id_jabatan'),
						'OLD_ID_CAB' => $this->input->post('old_id_cab'),
						'OLD_ID_DIV' => $this->input->post('old_id_div'),
						'OLD_ID_JAB' => $this->input->post('old_id_jab'),
						'TGL_PENETAPAN' => $this->input->post('tanggal'),
						'KETERANGAN' => $this->input->post('keterangan'),
						'MENGETAHUI' => $this->input->post('mengetahui'),
						'NIK_MENGETAHUI' => $this->input->post('nik_mengetahui'),
						'MENYETUJUI' => $this->input->post('menyetujui'),
						'NIK_MENYETUJUI' => $this->input->post('nik_menyetujui'),
						'UPDATED_BY' =>$this->session->userdata('auth')->id,
						'UPDATED_DATE' =>date('Y-m-d H:i:s')
					);
					if ($this->db->where('ID',$this->input->post('id'))->update('mutasi', $data)){
						$dataPeg = array(
						'ID_CABANG' => $this->input->post('id_cabang'),
						'ID_DIV' => $this->input->post('id_divisi'),
						'ID_JAB' => $this->input->post('id_jabatan'),
						);
						//update data pegawai
						$this->gate_db->where('NIK',$this->input->post('nik'))->update('users', array("id_cabang"=> $this->input->post('id_cabang')));
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
		
		$this->template->set('pagetitle','Update Data Mutasi ');
		$rsmutasi = $this->mutasi_model->getEdited($id);
		$data['row'] = $rsmutasi;
		$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rsmutasi->OLD_ID_CAB.") OLDCAB, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rsmutasi->OLD_ID_DIV.") OLDDIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rsmutasi->OLD_ID_JAB.") OLDJAB ")->row();
		$data['rsold'] = $rsmaster;
		

		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('cabang');
		}
		
		$data['cabang'] = $this->common_model->comboCabang();
		$data['divisi'] = $this->divTree($this->common_model->getDivisi()->result_array());
		$data['jabatan'] = $this->divTreeJab($this->common_model->getJabatan()->result_array());
		$this->template->load('default','fmutasi/edit',$data);
		
	}
	
	public function view($id=null, $nik=null){
		$this->template->set('pagetitle','View Data Mutasi');
		//$arrId=explode("#",$id);
		//$data['row'] = $this->mutasi_model->getEdited($id);
		$rsmutasi = $this->mutasi_model->getEdited($id);
		$data['row'] = $rsmutasi;
		$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rsmutasi->OLD_ID_CAB.") OLDCAB, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rsmutasi->OLD_ID_DIV.") OLDDIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rsmutasi->OLD_ID_JAB.") OLDJAB ")->row();
		$data['rsold'] = $rsmaster;

		$rsmasternew=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$rsmutasi->ID_CAB.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$rsmutasi->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$rsmutasi->ID_JAB.") NAMA_JAB ")->row();
		$data['rsnew'] = $rsmasternew;

		/*$str= "SELECT  p.NAMA, c.KOTA, d.NAMA_DIV, j.NAMA_JAB ,
						(select kota from mst_cabang where id_cabang=m.old_id_cab) OLDCAB,
						(select nama_div from mst_divisi where id_div=m.old_id_div) OLDDIV,
						(select nama_jab from mst_jabatan where id_jab=m.old_id_jab) OLDJAB,
						m.*
						FROM mutasi m, pegawai p, mst_cabang c, mst_divisi d, mst_jabatan j
						WHERE m.nik=p.nik  and m.id_cab=c.id_cabang and m.id_div=d.id_div and m.id_jab=j.id_jab and m.NIK='$nik' order by m.ID desc";*/
		$str= "SELECT  p.NAMA, m.*
						FROM mutasi m, pegawai p
						WHERE m.nik=p.nik  and m.NIK='$nik' order by m.ID desc";
		$data['rowHistory']= $this->db->query($str)->result();
		
		

		//$data['rowHistory'] = $this->mutasi_model->getAllList($arrId[1]);
		
		if (empty($data['row'])){
			flashMessage('Data Invalid','danger');
			redirect('cabang');
		}
		
		$this->template->load('default','fmutasi/view',$data);
	
	}
	public function getPosition(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		
		/*$str= "SELECT c.KOTA, d.NAMA_DIV, j.NAMA_JAB, k.NIK, k.NAMA, k.ID_CABANG, k.ID_DIV, k.ID_JAB";
		$str.=" FROM  pegawai k, mst_cabang c, mst_divisi d, mst_jabatan j";
		$str.=" where k.id_cabang=c.id_cabang and k.id_div=d.id_div and k.id_jab=j.id_jab and (k.NAMA LIKE '%{$keyword}%' or k.nik LIKE '%{$keyword}%')";
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
					'old_id_cab' => $row->ID_CABANG,
					'old_id_div' => $row->ID_DIV,
					'old_id_jab' => $row->ID_JAB,
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
		
	public function delMutasi(){
		$id=$this->input->post('idx');
		$res = $this->mutasi_model->deleteMutasi($id);
		return $res;
	}
	
}
