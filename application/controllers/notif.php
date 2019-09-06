<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notif extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->auth->authorize();
	}
	
	
	function index(){
		//$role=$this->session->userdata('auth')->ROLE;
		$role=$this->config->item('myrole');
		$respon = array();
		$respon['status'] = 0;
		
		if (in_array($role, [1,3, 66])){

			// query cek permohonan ijin baru
			$query = $this->db->query('select count(id) cnt from v_cuti where ISACTIVE=1'.($this->session->userdata('auth')->id_cabang>1?" and    id_cabang=".$this->session->userdata('auth')->id_cabang:""))->row();
			if ($query->cnt > 0){
				$respon['status'] = 1;
				$respon['data']['cuti'] = array(
					'label' => 'Ijin/Cuti',
					'text' => 'Permohonan Ijin/Cuti Baru',
					'count'=> $query->cnt,
					'url'=>base_url('cuti/approval')
				);
			}
			
			// query cek permohonan lembur baru
			$query = $this->db->query('select count(no_trans) cnt from lembur where ISACTIVE=1 '.($this->session->userdata('auth')->id_cabang>1?' and nik in (select nik from pegawai where status_aktif=1 and id_cabang='.$this->session->userdata('auth')->id_cabang.')':'') )->row();
			if ($query->cnt > 0){
				$respon['status'] = 1;
				$respon['data']['lembur'] = array(
					'label' => 'Lembur',
					'text' => 'Permohonan Lembur Baru',
					'count'=> $query->cnt,
					'url'=>base_url('lembur/approval')
				);
			}
		
		
		}
			
		// query cek jml karyawan yg mau ultah
		$query = $this->db->query("select count(distinct nik) cnt  from pegawai where status_aktif=1 and date_format(tgl_lahir,'%m')=date_format(now(), '%m') ".($this->session->userdata('auth')->id_cabang>1?" and  id_cabang=".$this->session->userdata('auth')->id_cabang:""))->row();
		if ($query->cnt > 0){
			$respon['status'] = 1;
			$respon['data']['ultah'] = array(
				'label' => 'Ulang Tahun',
				'text' => 'Pegawai Berulang tahun bulan ini',
				'count'=> $query->cnt,
				'url'=>base_url('sendEmail/ultah_peg')
			);
		}
		
		//notif : 2 mgg sblm kontrak berakhir, pengingat cuti habis/sdh waktunya dpt cuti
		if (in_array($role, [1,3, 66])){

			if ($respon['status']==1){
			?>
			
			<ul class="dropdown-menu dropdown-alerts" id="notifitem">
			<?php 
				foreach ($respon['data'] as $data=>$item){
			?>
				<li>
					<a href="<?php echo $item['url'];?>">
						<div>
							<i class="fa fa-comment fa-fw"></i> <?php echo $item['text'];?>
							<span class="pull-right small"><?php echo $item['count'];?></span>
						</div>
					</a>
				</li>
			<?php } ?>
			</ul>
			<?php
			} else {
				echo 'none';
			}
		}


		
		//if (in_array($role, [1,3, 66])){

			if ($respon['status']==1){
			?>
			
			<ul  class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
			<li>
				<div class="notification-box-head-wrap">
				<span class="notification-box-head pull-left inline-block">notifications</span>
				<div class="clearfix"></div>
				<hr class="light-grey-hr ma-0"/>
				</div>
			</li>
			<li>
			<div class="streamline message-nicescroll-bar">
			<?php 
				foreach ($respon['data'] as $data=>$item){
			?>
				
					<div class="sl-item">
					<a href="<?php echo $item['url'];?>">
					<div class="icon bg-green"><i class="zmdi zmdi-flag"></i></div>
					<div class="sl-content">
						<span class="inline-block capitalize-font  pull-left truncate head-notifications"><?php echo $item['label'];?></span>
						<span class="inline-block font-11  pull-right notifications-time"><?php echo $item['count'];?></span>
						<div class="clearfix"></div><p class="truncate"><?php echo $item['text'];?></p>					
					</div>
					</a>	
					</div>
					<hr class="light-grey-hr ma-0"/>
								
				
			<?php } ?>
			</div>
			</li>
			</ul>
			<?php
			} else {
				echo 'none';
			}
		//}
		//echo json_encode($respon);


	}
	
}