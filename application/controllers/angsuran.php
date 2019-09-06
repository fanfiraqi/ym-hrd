<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class angsuran extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->load->model('pinjaman_model');
		$this->config->set_item('mymenu', 'mn5');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->config->set_item('mySubMenu', 'mn52');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Daftar Catatan Angsuran Karyawan');		
		$this->template->load('default','fangsuran/index',$data);
	}
	
	public function json_data($pid){
		//if ($this->input->is_ajax_request()){
		
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT a.*, h.id FROM pinjaman_header h, pinjaman_angsuran a WHERE h.ID=a.ID_HEADER AND h.ID=$pid and h.status='Belum Lunas'";
			
			if ( $_GET['sSearch'] != "" )
			{
				
				//$str .= " AND k.NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
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
				$aaData[] = array(
					'ID'=>$row->ID_HEADER,					
					'CICILAN'=>$row->CICILAN_KE,
					'TGL'=>$row->TGL_BAYAR,
					'JUMLAH'=>"Rp.&nbsp;".number_format($row->JML_CICILAN,0,',','.'),
					'STATUS'=>($row->JML_BAYAR >= $row->JML_CICILAN?'Lunas':'Belum Lunas')
					//'ACTION'=>($row->JML_BAYAR >= $row->JML_CICILAN?'-':'<a href="javascript:void()" onclick="lunasi('.$row->ID_HEADER.','.$row->CICILAN_KE.', '.$row->JML_CICILAN.')"><i class="fa fa-pencil" title="Set Lunas"></i>Set Lunas</a>')
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
	
	
	public function setLunasAngsuran(){
		$idH=$this->input->post('idH');
		$idC=$this->input->post('idC');
		$jmlB=$this->input->post('jmlB');
		$tglBayar=date('Y-m-d');
		$res = $this->pinjaman_model->setLunasAngsuran($idH, $idC, $tglBayar, $jmlB);
		return $res;
	}
	public function getView(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		
		$str= "SELECT p.ID, k.ID_CABANG, k.ID_DIV, k.ID_JAB, k.NIK, k.NAMA, p.JUMLAH, p.LAMA, p.STATUS";
		$str.=" FROM `pinjaman_header` p, pegawai k";
		$str.=" where p.nik=k.nik and p.status='Belum Lunas' and  k.NAMA LIKE '%{$keyword}%'";
		$query = $this->db->query($str)->result();

		
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array(
					'pid'=>$row->ID,
					'id'=>$row->NIK,
					'label' => $row->NIK.' - '.$row->NAMA,
					'value' => $row->NAMA,
					'id_cabang' => $row->ID_CABANG,
					'id_div' => $row->ID_DIV,
					'id_jab' => $row->ID_JAB,
					'jumlah' => $row->JUMLAH,
					'lama' => $row->LAMA,
					'status' => $row->STATUS,
					''
				);
			}
		}
		echo json_encode($data);
	}

	public function view($id){
		//$id = $this->input->post('id');
		
		$data['rowAngs'] = $this->pinjaman_model->getAngsuran($id);
		$data['rowHead'] = $this->pinjaman_model->getPinjaman($id);
		//$data['accvia'] =$this->pinjaman_model->getCabAcc();
		
		if ($this->input->is_ajax_request()){
			$this->template->load('ajax','fangsuran/formBayar',$data);
		} else {
			
		}
	}
	public function saveAngsuran($id){
		$rscicil=$this->pinjaman_model->getAngsuran($id);
		$rsheader=$this->pinjaman_model->getPinjaman($id);
		$cicil_ke=$rscicil->jml_ke;
		$respon = new StdClass();
		if ($cicil_ke <= $rsheader->LAMA){
			$dataBayar = array(				
				'TGL_BAYAR' => date('Y-m-d'),
				'JML_BAYAR' => ($rsheader->JUMLAH/$rsheader->LAMA),
				//'ACC_BAYAR_VIA' => $this->input->post('accvia'),
				'CREATED_BY' =>$this->session->userdata('auth')->id,				
				'CREATED_DATE' => date('Y-m-d H:i:s')
			);

			if ($this->db->where('ID_HEADER',$id)->where('CICILAN_KE', $cicil_ke)->update('pinjaman_angsuran',$dataBayar)){
				if ($cicil_ke >= $rsheader->LAMA){
					$this->db->where('ID',$id)->update('pinjaman_header',array('STATUS'=>'Lunas'));
				}

				//entri jurnal
				/*$dataP = array(
								'bulan' => date('m'),
								'tahun' => date('Y'),
								'id_cab'=>$this->session->userdata('auth')->ID_CABANG,
								//'notransaksi' => $this->input->post('id'),
								'tanggal' => date('Y-m-d'),
								'idperkdebet' => $this->input->post('accvia'),
								'idperkkredit' => $rsheader->ACC_ID_PIUTANG,
								'penanda' => 'Pelunasan_Piutang#'.$id.'#ke_'.$cicil_ke,
								'nobuktiref' => '',
								'sumber_data' => 'kasmasuk',
								'keterangan' => 'Buku Pembantu Piutang '.$this->input->post('jnspeminjam').' pelunasan cicilan piutang',
								'jumlah' => ($rsheader->JUMLAH/$rsheader->LAMA),
								'jenis' => 'BKM',
								'uname' => $this->session->userdata('auth')->USERNAME,
								'waktuentri' => date('Y-m-d H:i:s')
							);
							$this->db->insert('ak_jurnal',$dataP);*/
							$this->db->trans_commit();
							$respon->status = 'success';
			}else {
				throw new Exception("gagal simpan");
			}
			
		}
		

		echo json_encode($respon);

	}
}
