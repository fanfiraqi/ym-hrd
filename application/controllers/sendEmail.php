<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sendEmail extends MY_App {

	function __construct()
	{
		parent::__construct();		
		$this->config->set_item('mymenu', 'menuLima');
		$this->auth->authorize();
	}

	public function ultah_peg(){
		// query Alert Ultah
		/*		$strUltah="SELECT p.NIK COL1, p.NAMA COL2, p.TGL_LAHIR, concat('Karyawan cabang : ', mc.kota,' - ', md.nama_div,' - ', mj.nama_jab) KET, p.email
							FROM pegawai p, mst_cabang mc, mst_divisi md, mst_jabatan mj
							WHERE p.id_cabang=mc.id_cabang and p.status_aktif=1 and
							p.id_div=md.id_div and
							p.id_jab=mj.id_jab and
							date_format(tgl_lahir, '%m')='".date('m')."'
							UNION
							SELECT ' 'COL1, adm.NAMA COL1, adm.TGL_LAHIR, concat( gen.value1, ' dari ', p.NAMA, '-', p.NIK ) KET, p.email
							FROM pegawai p, adm_hubkel adm, gen_reff gen 
							WHERE p.nik = adm.nik and p.status_aktif=1 
							AND gen.id_reff = adm.id_hubkel
							AND gen.reff = 'KELUARGA'
							AND date_format( adm.tgl_lahir, '%m' ) = '".date('m')."'";
				$data['cekUltah']=0;
				if ($this->db->query($strUltah)->num_rows()>0){
					$data['cekUltah']=1;
					$data['rowUltah'] = $this->db->query($strUltah)->result();
				}

			$this->template->set('pagetitle','Karyawan - Keluarga yang Berulang Tahun');			
			$this->template->load('default','user/ultahMail',$data);*/
	}
}
	
