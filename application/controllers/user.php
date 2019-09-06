<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends MY_App {
	
	function __construct()
	{
		parent::__construct();
		$this->auth->authorize('index');
		
	}
	
	
	public function index()
	{
		if ($this->auth->is_login()){
			// query cek permohonan ijin baru
				$data['cekCuti']=0;
				if ($this->db->query('SELECT * FROM v_cuti  WHERE `ISACTIVE` = 1 '.($this->session->userdata('auth')->id_cabang>1?" and    id_cabang=".$this->session->userdata('auth')->id_cabang:"") )->num_rows()>0){
					$data['cekCuti']=1;
					$data['rowCuti'] = $this->db->query('SELECT * FROM v_cuti  WHERE `ISACTIVE` = 1'.($this->session->userdata('auth')->id_cabang>1?" and    id_cabang=".$this->session->userdata('auth')->id_cabang:""))->result();				
				}
				
				// query cek permohonan lembur baru
				$strLembur="SELECT p.NIK, p.NAMA, m.NO_TRANS, d.TGL_LEMBUR, d.JML_JAM, DATE_FORMAT(d.JAM_MULAI,'%H:%i:%s') MULAI, DATE_FORMAT(d.JAM_SELESAI,'%H:%i:%s') SELESAI
					FROM lembur m, `lembur_d` d, pegawai p
					WHERE m.no_trans=d.no_trans and p.nik=m.nik and m.`ISACTIVE` = 1".($this->session->userdata('auth')->id_cabang>1?" and  id_cabang= ".$this->session->userdata('auth')->id_cabang:"");
				$data['cekLembur']=0;
				
				if ($this->db->query($strLembur)->num_rows()>0){
					$data['therole']=$this->config->item('myrole');
					$data['cekLembur']=1;
					$data['rowLembur'] = $this->db->query($strLembur)->result();
				}
								
				$data['therole']=$this->config->item('myrole');
				
				// query Alert Masa Kontrak Menjelang (2 mgg) Habis
				
				$strKontrak = "SELECT p.NIK, p.NAMA, JENIS,g.VALUE1, TGL_AWAL_KONTRAK, TGL_AKHIR_KONTRAK TGL_AKHIR, DATEDIFF(TGL_AKHIR_KONTRAK, NOW()) SISA
						FROM pegawai p, kontrak k, gen_reff g
						WHERE p.NIK=k.NIK 
						AND k.JENIS=g.ID_REFF
						AND g.REFF='STSPEGAWAI'
						AND STATUS_AKTIF=1
						AND k.ISACTIVE=1
						AND (DATEDIFF(TGL_AKHIR_KONTRAK, NOW()) >=1 AND DATEDIFF(TGL_AKHIR_KONTRAK, NOW())<=14) ".($this->session->userdata('auth')->id_cabang>1?" and    p.id_cabang=".$this->session->userdata('auth')->id_cabang:"");

				$data['cekKontrak']=0;
				$data['strKontrak'] = $strKontrak;
				if ($this->db->query($strKontrak)->num_rows()>0){
					$data['cekKontrak']=1;
					$data['rowKontrak'] = $this->db->query($strKontrak)->result();
					
				}

				// query Alert Jatah Cuti
				$strJatahCuti="SELECT p.NIK, NAMA, TGL_AKTIF,  period_diff(date_format(now(),'%Y%m'),DATE_FORMAT(tgl_aktif, '%Y%m')),'' KET
							FROM pegawai p
							WHERE   p.nik not in (select distinct nik from cuti) and status_aktif=1 ".($this->session->userdata('auth')->id_cabang>1?" and    id_cabang=".$this->session->userdata('auth')->id_cabang:"")."
							and (period_diff(date_format(now(),'%Y%m'), date_format(tgl_aktif, '%Y%m'))) > 15 order by TGL_AKTIF desc ";
							//kondisi >3 bln, belum pernah ambil cuti, atau sdh cuti tapi sisa cuti=12
				$data['cekJatahCuti']=0;
				if ($this->db->query($strJatahCuti)->num_rows()>0){
					$data['cekJatahCuti']=1;
					$data['rowJatahCuti'] = $this->db->query($strJatahCuti)->result();
				}
				
			
				// query Alert Ultah
				$strUltah="SELECT p.NIK COL1, p.NAMA COL2, p.TGL_LAHIR, '' KET, p.email
							FROM pegawai p
							WHERE p.status_aktif=1 and date_format(tgl_lahir, '%m')='".date('m')."'
							UNION
							SELECT ' ' COL1, adm.NAMA COL2, adm.TGL_LAHIR, concat( gen.value1, ' dari ', p.NAMA, '-', p.NIK ) KET, p.email
							FROM pegawai p, adm_hubkel adm, gen_reff gen 
							WHERE p.nik = adm.nik and p.status_aktif=1 
							AND gen.id_reff = adm.id_hubkel
							AND gen.reff = 'KELUARGA' 
							AND date_format( adm.tgl_lahir, '%m' ) = '".date('m')."' ".($this->session->userdata('auth')->id_cabang>1?" and    id_cabang=".$this->session->userdata('auth')->id_cabang:"");
				$data['cekUltah']=0;
				if ($this->db->query($strUltah)->num_rows()>0){
					$data['cekUltah']=1;
					$data['rowUltah'] = $this->db->query($strUltah)->result();
				}

			$this->template->set('pagetitle','Dashboard');			
			$this->template->load('default','user/index',$data);
		} else {
			$this->load->helper('cookie');
    		$this->load->library('session');
			//$APIUrl = 'https://gate-app.yatimmandiri.org/api/';
			$APIUrl = 'http://ym-gate.yatimmandiri.test/api/';
			$urlRequest = 'pengguna/sso'; // contoh endpoint
			$apiKey = 'YAt1MmaNdIR1aPiK3y';
			$secret = 'LTjyJ82Owpz1GVWV4';
			$data = array(
				'CODE' => get_cookie('code')
			);
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $APIUrl . $urlRequest);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'API-KEY: ' . $apiKey,
				'SECRET: ' . $secret
				
			]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
			$response = curl_exec($ch);
			curl_close($ch);
			echo print_r ($response);
			//$session = array();
			//$session['auth'] = json_decode($response, TRUE);
			//$this->CI->session->set_userdata($session);
			
			$arrSes=json_decode($response, TRUE);
			$user_id= $arrSes["data"] ["user_id"];
			//$user_id= 11;
			$status= $arrSes["status"] ;
			echo var_dump($arrSes)."<br>".$status."<br>".$user_id."<br>";
			

			//redirect($this->config->item('gate_link')."/keluar");
		}
	}


	public function xlsCuti_(){
		// query cek permohonan ijin baru			
		$result = $this->db->query('SELECT * FROM v_cuti  WHERE `ISACTIVE` = 1')->result();		
		$mydata=array();
		$i=0;
		foreach($result as $hasil){ 
			$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$hasil->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$hasil->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$hasil->ID_JAB.") NAMA_JAB ")->row();
			$mydata[$i]=array("NIK" => $hasil->NIK, "NAMA" => $hasil->NAMA, "NAMA_CABANG" => $rsname->NAMA_CABANG, "NAMA_DIV" => $rsname->NAMA_DIV, "NAMA_JAB" => $rsname->NAMA_JAB, "TGL_AWAL" => $hasil->TGL_AWAL, "TGL_AKHIR" => $hasil->TGL_AKHIR, "JENISCUTI2" => $hasil->JENISCUTI2);
			$i++;
		}
		$arr=(object)$mydata;
		//judul file XLS
		$title = "DATA PERMOHONAN CUTI";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'CABANG',
			'DIVISI',
			'JABATAN',
			'TGL IJIN AWAL',
			'TGL IJIN AKHIR',
			'KETERANGAN'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(
			'NIK',
			'NAMA',
			'NAMA_CABANG',
			'NAMA_DIV',
			'NAMA_JAB',
			'TGL_AWAL',
			'TGL_AKHIR',
			'JENISCUTI2'
		);
		$xlsfile = "DATA_CUTI.xls";
		
		if (!empty($result)){
			$this->commonlib->printXLS($title,$arr,$headertext,$rowitem,$xlsfile);
		} else {
			echo "XLSX Failed. No Valid Data";
		}

	}


	public function xlsCuti(){

		$result = $this->db->query('SELECT * FROM v_cuti  WHERE `ISACTIVE` = 1')->result();		
		$mydata=array();
		$i=0;
		foreach($result as $hasil){ 
			$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$hasil->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$hasil->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$hasil->ID_JAB.") NAMA_JAB ")->row();
			$mydata[$i]=array("NIK" => $hasil->NIK, "NAMA" => $hasil->NAMA, "NAMA_CABANG" => $rsname->NAMA_CABANG, "NAMA_DIV" => $rsname->NAMA_DIV, "NAMA_JAB" => $rsname->NAMA_JAB, "TGL_AWAL" => $hasil->TGL_AWAL, "TGL_AKHIR" => $hasil->TGL_AKHIR, "JENISCUTI2" => $hasil->JENISCUTI2);
			$i++;
		}
		$arr=(object)$mydata;
		//judul file XLS
		$title = "DATA PERMOHONAN CUTI";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'CABANG',
			'DIVISI',
			'JABATAN',
			'TGL IJIN AWAL',
			'TGL IJIN AKHIR',
			'KETERANGAN'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(
			'NIK',
			'NAMA',
			'NAMA_CABANG',
			'NAMA_DIV',
			'NAMA_JAB',
			'TGL_AWAL',
			'TGL_AKHIR',
			'JENISCUTI2'
		);
		$xlsfile = "DATA_CUTI.xls";

		//$CI =& get_instance();
		$this->load->library('PHPExcel');
		$xls = new PHPExcel();
		$xls->setActiveSheetIndex(0);
		$sheet = $xls->getActiveSheet();
		$sheet->mergeCells('A1:Z1');
		$sheet->setCellValue('A1',$title);
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$col = "A";
		$row = 2;
		foreach($headertext as $item){
			$sheet->setCellValue($col.$row,$item);
			$sheet->getColumnDimension($col)->setAutoSize(true);
			$sheet->getStyle($col.$row)->getFont()->setBold(true);
			$col = $this->common_model->nextcol($col);
			
		}
		$row = 3;
		$rownum=1;
		foreach($result as $data){
			$col = 0;
			$sheet->getCellByColumnAndRow($col,$row)->setValueExplicit($rownum, PHPExcel_Cell_DataType::TYPE_NUMERIC);
			$col++;
			foreach($rowitem as $item){
				$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$hasil->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$hasil->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$hasil->ID_JAB.") NAMA_JAB ")->row();
				if (in_array($item, ['NAMA_CABANG','NAMA_DIV', 'NAMA_JAB'])){
					$sheet->getCellByColumnAndRow($col,$row)->setValueExplicit($rsname->$item, PHPExcel_Cell_DataType::TYPE_STRING);$col++;				
				}else{
					$sheet->getCellByColumnAndRow($col,$row)->setValueExplicit($data->$item, PHPExcel_Cell_DataType::TYPE_STRING);$col++;				
				}
			}
			$row++;
			$rownum++;
		}
		$col--;
		$row--;
		$sheet->getStyle('A2:'.chr($col+65).$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$xlsfile.'"');
		header('Cache-Control: max-age=0');
		$xlsoutput = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
		$xlsoutput->save('php://output');
	}
	


	public function xlsLembur(){
		$strLembur="SELECT p.NIK, p.NAMA, m.NO_TRANS, d.TGL_LEMBUR, d.JML_JAM, DATE_FORMAT(d.JAM_MULAI,'%H:%i:%s') MULAI, DATE_FORMAT(d.JAM_SELESAI,'%H:%i:%s') SELESAI
		FROM lembur m, `lembur_d` d, pegawai p
		WHERE m.no_trans=d.no_trans and p.nik=m.nik and m.`ISACTIVE` = 1";
				
		$result = $this->db->query($strLembur)->result();					

		//judul file XLS
		$title = "DATA PERMOHONAN LEMBUR";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'TGL LEMBUR',
			'MULAI',
			'SELESAI',
			'JML JAM'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(
			'NIK',
			'NAMA',
			'TGL_LEMBUR',
			'MULAI',
			'SELESAI',
			'JML_JAM'
		);
		$xlsfile = "DATA_LEMBUR.xls";
		
		if (!empty($result)){
			$this->commonlib->printXLS($title,$result,$headertext,$rowitem,$xlsfile);
		} else {
			echo "XLSX Failed. No Valid Data";
		}

	}

	public function xlsUltah(){
		$strUltah="SELECT p.NIK COL1, p.NAMA COL2, p.TGL_LAHIR, concat('Karyawan cabang : ', mc.kota,' - ', md.nama_div,' - ', mj.nama_jab) KET, p.EMAIL
							FROM pegawai p, mst_cabang mc, mst_divisi md, mst_jabatan mj
							WHERE p.id_cabang=mc.id_cabang and p.status_aktif=1 and
							p.id_div=md.id_div and
							p.id_jab=mj.id_jab and
							date_format(tgl_lahir, '%m')='".date('m')."'
							UNION
							SELECT ' ' COL1, adm.NAMA COL2, adm.TGL_LAHIR, concat( gen.value1, ' dari ', p.NAMA, '-', p.NIK ) KET, p.EMAIL
							FROM pegawai p, adm_hubkel adm, gen_reff gen 
							WHERE p.nik = adm.nik and p.status_aktif=1 
							AND gen.id_reff = adm.id_hubkel
							AND gen.reff = 'KELUARGA'
							AND date_format( adm.tgl_lahir, '%m' ) = '".date('m')."'";
			
		$result = $this->db->query($strUltah)->result();					

		//judul file XLS
		$title = "DATA KARYAWAN ULANG TAHUN";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'TGL LAHIR',
			'KETERANGAN',
			'EMAIL'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(		
			'COL1',
			'COL2',
			'TGL_LAHIR',
			'KET',
			'EMAIL'
		);
		$xlsfile = "DATA_ULTAH_".date('m').".xls";
		
		if (!empty($result)){
			$this->commonlib->printXLS($title,$result,$headertext,$rowitem,$xlsfile);
		} else {
			echo "XLSX Failed. No Valid Data";
		}

	}

	public function xlsJatahCuti(){
		$strJatahCuti="SELECT p.NIK, NAMA, TGL_AKTIF,  period_diff(date_format(now(),'%Y%m'), date_format(tgl_aktif, '%Y%m')) MASA,concat('Karyawan cabang : ', mc.kota,' - ', md.nama_div,' - ', mj.nama_jab) KET
							FROM pegawai p, mst_cabang mc, mst_divisi md, mst_jabatan mj
							WHERE  p.id_cabang=mc.id_cabang and p.id_div=md.id_div and
							p.id_jab=mj.id_jab and p.nik not in (select distinct nik from cuti) and status_aktif=1
							and (period_diff(date_format(now(),'%Y%m'), date_format(tgl_aktif, '%Y%m'))) > 15 order by TGL_AKTIF desc ";
		$result = $this->db->query($strJatahCuti)->result();					

		//judul file XLS
		$title = "DATA KARYAWAN MULAI DAPAT JATAH CUTI (15 BLN DARI TGL MASUK)";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'POSISI',
			'TGL MULAI KERJA',
			'MASA KERJA(BLN)'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(		
			'NIK',
			'NAMA',
			'KET',
			'TGL_AKTIF',
			'MASA'
		);
		$xlsfile = "DATA_DAPAT_JATAH_CUTI.xls";
		
		if (!empty($result)){
			$this->commonlib->printXLS($title,$result,$headertext,$rowitem,$xlsfile);
		} else {
			echo "XLSX Failed. No Valid Data";
		}

	}

	public function xlsKontrak(){
		$strKontrak = "SELECT P.NIK, P.NAMA, JENIS,g.VALUE1, TGL_AWAL_KONTRAK, TGL_AKHIR_KONTRAK TGL_AKHIR, DATEDIFF(TGL_AKHIR_KONTRAK, NOW()) SISA
						FROM pegawai P, kontrak K, gen_reff g
						WHERE P.NIK=K.NIK 
						AND K.JENIS=g.ID_REFF
						AND g.REFF='STSPEGAWAI'
						AND STATUS_AKTIF=1
						AND K.ISACTIVE=1
						AND (DATEDIFF(TGL_AKHIR_KONTRAK, NOW()) >=1 AND DATEDIFF(TGL_AKHIR_KONTRAK, NOW())<=14) ";
					
		$result = $this->db->query($strKontrak)->result();					

		//judul file XLS
		$title = "DATA JATUH TEMPO & UPGRADE MASA KONTRAK";
		
		// header tabel
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'JENIS KONTRAK',
			'TGL AKHIR',
			'SISA HARI'
		);
		
		//nama field yg akan ditampilkan. Kolom NO. pada header otomatis (+1)
		$rowitem = array(		
			'NIK',
			'NAMA',
			'VALUE1',
			'TGL_AKHIR',
			'SISA'
		);
		$xlsfile = "DATA_DAPAT_JATAH_CUTI.xls";
		
		if (!empty($result)){
			$this->commonlib->printXLS($title,$result,$headertext,$rowitem,$xlsfile);
		} else {
			echo "XLSX Failed. No Valid Data";
		}

	}
	
}
