<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tes extends MY_App {

	function __construct()
	{
		parent::__construct();
		
	}
	
	
	function table(){
		$data['pendidikan'] = $this->common_model->comboReff('PENDIDIKAN');
		$data['nikah'] = $this->common_model->comboReff('NIKAH');
		$data['sex'] = $this->common_model->comboReff('SEX');
		$data['hubkel'] = $this->common_model->comboReff('KELUARGA');
		$data['stspegawai'] = $this->common_model->comboReff('STSPEGAWAI');
		$this->template->load('blank','tes',$data);
	}
	
	function rebuild_tree($parent,$left) {
        $right = $left+1;
		$str = "select * from mst_divisi where id_div_parent=".$parent."";
		$result = $this->db->query($str)->result();
		foreach ($result as $row){
			$right = $this->rebuild_tree($row->ID_DIV,$right);
		}
		$str2 = "UPDATE mst_divisi SET lft=".$left.", rgt=".$right." where id_div=".$parent."";
		$result2 = $this->db->query($str2);
		return $right+1;
    }
	
	
	function val(){
		$query = $this->db->query("SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='nhayat' 
    AND `TABLE_NAME`='pegawai'")->result();
	$str = "array( ";
	$str .= "<br />";
	foreach ($query as $item){
		$str .= "\t"."array(";
		$str .= "<br />";
		$str .= "\t\t"."'field' => '{$item->COLUMN_NAME}',";
		$str .= "<br />";
		$str .= "\t\t"."'label' => '{$item->COLUMN_NAME}',";
		$str .= "<br />";
		$str .= "\t\t"."'rules' => 'trim|xss_clean|required'";
		$str .= "<br />";
		$str .= "\t"."),";
		$str .= "<br />";
	}
	$str .= ")";
	echo "<pre>";
	echo $str;
	}
	
	function index(){
		$c = "Y";
		$headertext = array(
			'NO.',
			'NIK',
			'NAMA',
			'CABANG',
			'DIVISI',
			'JABATAN'
		);
		debug($this->nextcol());
		foreach($headertext as $item){
			echo $c.". ".$item."<br />";
			$c = $this->nextcol($c);
			
		}/**/
	}
	
	function nextcol($cur="A"){
		$int = ord($cur);
		$int++;
		$chr = chr($int);
		return $chr;
	}
	
	function respon(){
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		$respon = new StdClass();
		$respon->status = 'error';
		$respon->errormsg = 'ini adalah error';
		echo json_encode($respon);
	}
	
	function notif(){
		$respon = array();
		$respon['status'] = 0;
		
		// query cek permohonan ijin baru
		$query = $this->db->query('select count(id) cnt from cuti where approved=0')->row();
		if ($query->cnt > 0){
			$respon['status'] = 1;
			$respon['data']['cuti'] = array(
				'text' => 'Permohonan Ijin/Cuti Baru',
				'count'=> $query->cnt,
				'url'=>base_url('cuti/approval')
			);
		}
		
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
		//echo json_encode($respon);
	}
	
	function email($emailto,$pdf=null){
		$config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'payrollnurulhayat@gmail.com',
            'smtp_pass' => 'bambangheriyanto',
            'mailtype' => 'html'
        );
 
        // recipient, sender, subject, and you message
        $to = $emailto;
        $from = "payrollnurulhayat@gmail.com";
        $subject = "Absensi CSV ".date('dmYHis');
        $message = "This is a test email using CodeIgniter. If you can view this email, it means you have successfully send an email using CodeIgniter.";
 
        
        $this->load->library('email', $config);
        $this->email->attach('./assets/files/template/absensi.csv');
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'No Reply');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
		
 
        // send your email. if it produce an error it will print 'Fail to send your message!' for you
        if($this->email->send()) {
           return 1;
        }
        else {
            return 0;
        }
	}
	
	function doemail(){
		$this->template->set('pagetitle','Mass Email');
		$data=array();
		$this->template->load('default','tes',$data);
	}
	
	function emailcount(){
		$cabang = 2;
		$str = "SELECT p.`NIK`,p.`NAMA`,p.`NAMA_CABANG`,p.`ID_CABANG`,p.`EMAIL` 
			FROM set_gaji_staff s
			LEFT JOIN v_pegawai p ON p.`NIK`=s.`NIK`
			WHERE p.`ID_CABANG`=".$cabang."
			GROUP BY s.`NIK` ORDER BY s.`NIK` ";
		$cnt = $this->input->get('cnt');
		$step = $this->input->get('step');
		if (empty($step)){
			$count = $this->db->query($str)->num_rows();
			if ($count>0){
				$data['status']=1;
				$data['jumlah']=$count;
			} else {
				$data['status']=0;
			}
			echo json_encode($data);
		} else {
			$str .= " LIMIT ".($step-1).",1 ";
			$result = $this->db->query($str)->row();
			if (!empty($result)){
				$this->email($result->EMAIL);
				$data['status']=1;
				$data['nextstep']=$step+1;
				$data['complete']=0;
				$data['percent']= number_format((float)($step/$cnt*100), 0, '.', '');
			} else {
				$data['status']=1;
				$data['complete']=1;
			}
			sleep(2);
			echo json_encode($data);
		}
	}
	
	
	
}