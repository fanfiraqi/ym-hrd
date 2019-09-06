<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pinjaman extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->load->model('pinjaman_model');
		$this->config->set_item('mymenu', 'mn5');
		$this->auth->authorize();
	}
	
	public function index()
	{
		$this->config->set_item('mySubMenu', 'mn51');
		if ($this->session->userdata('auth')->id_cabang=="1"){
			$data['cabang'] =$this->common_model->comboCabang();
		}else{
			$data['cabang'] =$this->common_model->getCabang($this->session->userdata('auth')->id_cabang);
		}
		$this->template->set('pagetitle','Daftar Catatan Pinjaman');		
		$this->template->load('default','fpinjaman/index',$data);
	}
	
	public function json_data(){
		//if ($this->input->is_ajax_request()){
			$cabang = $this->input->get('cabang');
			$start = $this->input->get('iDisplayStart');
			$limit = $this->input->get('iDisplayLength');
			$sortby = $this->input->get('iSortCol_0');
			$srotdir = $this->input->get('sSortDir_0');
			
			$str = "SELECT p.*, k.NAMA FROM pinjaman_header p, pegawai k WHERE p.NIK=k.NIK AND STATUS='Belum Lunas' ".($this->session->userdata('auth')->id_cabang>1?"  and id_cabang=".$this->session->userdata('auth')->id_cabang."  ":"  and id_cabang=".$cabang."  ");
			
			if ( $_GET['sSearch'] != "" )
			{
				
				$str .= " AND k.NAMA like '%".mysql_real_escape_string( $_GET['sSearch'] )."%' ";
				
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
				$rscek=$this->db->query("select count(*) jml from pinjaman_angsuran where id_header=".$row->ID)->row();

				$aaData[] = array(
					'ID'=>$row->ID,					
					'NIK'=>$row->NIK,
					'NAMA'=>$row->NAMA,
					'TGL'=>$row->TGL,
					'JUMLAH'=>"Rp.&nbsp;".number_format($row->JUMLAH,0,',','.'),
					'LAMA'=>$row->LAMA." Kali",
					'KEPERLUAN'=>$row->KEPERLUAN,
					'STATUS'=>$row->STATUS,
					'ACTION'=>"<a href='javascript:void(0)' onclick='editThis(this)' data-id='".$row->ID."'><i class='fa fa-edit' title='Edit'></i></a> ".($rscek->jml<=0?"| <a href='javascript:void()' onclick=\"delThis(".$row->ID.",'".$row->NAMA."')\"><i class='fa fa-trash-o' title='Delete'></i></a>":"")
					/*'ACTION'=>'<a href="'.base_url('pinjaman/view/'.$row->ID).'"><i class="fa fa-eye" title="Lihat Detail"></i></a> | 
						<a href="'.base_url('pinjaman/edit/'.$row->ID).'"><i class="fa fa-pencil" title="Edit"></i></a> | 
						<a href="javascript:void()" onclick="delPinjaman('.$row->ID.')"><i class="fa fa-trash-o" title="Delete"></i></a>'*/
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
	
	public function delThis(){
		$id=$this->input->post('idx');
		$nmtable=$this->input->post('proses');
		$field=$this->input->post('field');
		$res = $this->common_model->delThis($id,$nmtable,$field);
		return $res;
	}

	public function editThis(){
		$id = $this->input->post('id');	//id as nik=>peg_pendidikan
		$query =$this->pinjaman_model->getEdited($id);

		if(empty($query)){
			$respon['status'] = 'error';
			$respon['errormsg'] = 'Invalid Data';
			$respon['isi'] = $this->db->last_query();
		} else {
			$respon['status'] = 'success';
			$respon['data'] = $query;			
		}
		echo json_encode($respon);
	}

	public function delPinjaman(){
		$id=$this->input->post('idx');
		$res = $this->pinjaman_model->deletePinjaman($id);
		return $res;
	}
	
	public function saveData(){
		if($this->input->is_ajax_request())
		{
			$this->load->library('form_validation');
			
			$state=$this->input->post('state');
			$rules = array(
				array(
					'field' => 'nik',
					'label' => 'NAMA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'tanggal',
					'label' => 'TANGGAL',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'jumlah',
					'label' => 'JUMLAH',
					'rules' => 'trim|xss_clean|required||callback_comparetime'
				),
				array(
					'field' => 'lama',
					'label' => 'LAMA',
					'rules' => 'trim|xss_clean|required'
				),
				array(
					'field' => 'keperluan',
					'label' => 'KEPERLUAN',
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
					$lama=$this->input->post('lama');
					$jmlCicilan=($this->input->post('jumlah')/$lama);
					
					
					

					if($state=="add"){ 
						$data = array(
							'NIK' => $this->input->post('nik'),
							'TGL' => $this->input->post('tanggal'),
							'JUMLAH' => $this->input->post('jumlah'),
							'LAMA' => $lama,
							'KEPERLUAN' => $this->input->post('keperluan'),
							'CREATED_BY' =>$this->session->userdata('auth')->id,
							'CREATED_DATE' =>date('Y-m-d H:i:s'),
							'UPDATED_BY' =>$this->session->userdata('auth')->id,
							'UPDATED_DATE' =>date('Y-m-d H:i:s')
						);
						if ($this->db->insert('pinjaman_header', $data)){	
								$insert_id = $this->db->insert_id();
								$this->db->trans_complete();
								//$lastId=$this->pinjaman_model->getLastID();
								for ($i=1; $i<=$lama; $i++){
									$dataAngs=array(
										'ID_HEADER'=>$insert_id,
										'CICILAN_KE'=>$i,
										'JML_CICILAN'=>$jmlCicilan
									);
									$this->db->insert('pinjaman_angsuran', $dataAngs);
								}
								$this->db->trans_commit();
							} else {
								throw new Exception("gagal simpan");
							}
					}else{

						$data = array(
							'NIK' => $this->input->post('nik'),
							'TGL' => $this->input->post('tanggal'),
							'JUMLAH' => $this->input->post('jumlah'),
							'LAMA' => $lama,
							'KEPERLUAN' => $this->input->post('keperluan'),							
							'UPDATED_BY' =>$this->session->userdata('auth')->id,
							'UPDATED_DATE' =>date('Y-m-d H:i:s')
						);					
						if ($this->db->where('ID',$state)->update('pinjaman_header',$data)){
								$this->db->query("delete from pinjaman_angsuran where id_header=".$state);
								$this->db->trans_commit();
								for ($i=1; $i<=$lama; $i++){
									$dataAngs=array(
										'ID_HEADER'=>$state,
										'CICILAN_KE'=>$i,
										'JML_CICILAN'=>$jmlCicilan
									);
									$this->db->insert('pinjaman_angsuran', $dataAngs);
								}
								$this->db->trans_commit();

									$this->db->trans_commit();
									$respon->status = 'success';
						} else {
							throw new Exception("gagal simpan");
						}
					}
				} catch (Exception $e) {
					$respon->status = 'error';
					$respon->errormsg = $e->getMessage();;
					$this->db->trans_rollback();
				}
				$respon->status = 'success';
			} else {
				$respon->status = 'error';
				$respon->errormsg = validation_errors();
				
			}
			echo json_encode($respon);
			
		}
			
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
}
