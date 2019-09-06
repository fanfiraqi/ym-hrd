<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$menu="pengguna";
class MY_App extends CI_Controller {
	public $arrBulan=array("1"=>"Januari", 
			"2"=>"Februari",
			"3"=>"Maret",
			"4"=>"April",
			"5"=>"Mei",
			"6"=>"Juni",
			"7"=>"Juli",
			"8"=>"Agustus",
			"9"=>"September",
			"10"=>"Oktober",
			"11"=>"November",
			"12"=>"Desember"
			);
	public $arrBulan2=array("01"=>"Januari", 
			"02"=>"Februari",
			"03"=>"Maret",
			"04"=>"April",
			"05"=>"Mei",
			"06"=>"Juni",
			"07"=>"Juli",
			"08"=>"Agustus",
			"09"=>"September",
			"10"=>"Oktober",
			"11"=>"November",
			"12"=>"Desember"
			);
	public $arrIntBln=array("1"=>"01",
				"2"=>"02",
				"3"=>"03",
				"4"=>"04",
				"5"=>"05",
				"6"=>"06",
				"7"=>"07",
				"8"=>"08",
				"9"=>"09",
				"10"=>"10",
				"11"=>"11",
				"12"=>"12"
				);
	public $arrGolongan=array("GOL I"=>"GOL I",
				"GOL II"=>"GOL II",
				"GOL III"=>"GOL III",
				"GOL IV"=>"GOL IV"
				);
	public $arrStsNikah=array("SN"=>"MENIKAH",
				"BN"=>"BELUM MENIKAH",
				"JN"=>"JANDA",
				"DN"=>"DUDA"
				);
	public $arrKlaster=array("PELAKSANA"=>"PELAKSANA",
				"STAFF"=>"STAFF",
				"SENIOR STAFF"=>"SENIOR STAFF",
				"MANAGER MADYA"=>"MANAGER MADYA",
				"MIDLE MANAGER"=>"MIDLE MANAGER",
				"SENIOR MANAGER"=>"SENIOR MANAGER",
				"DIREKSI"=>"DIREKSI"
				);
	function __construct()
    {
        parent::__construct();
		//$this->initdata();
		$this->load->model('common_model');
		$this->gate_db=$this->load->database('gate', TRUE);
		
		//$this->auth->authorize();
    }
	
	function getYearArr(){
		$now=date('Y');
		//$j=0;
		for ($i=date('Y')-10; $i<=date('Y')+10; $i++) {	
			$year[$i]=$i;
			

		}
		return $year;
	}

	function initdata(){
		$first = $this->session->userdata('1stvisit');
		//if (!$first){
			$this->session->set_userdata('param_company',$this->param_model->get('company'));
			$this->session->set_userdata('1stvisit',true);
		//}
	}

	function divTree($datas, $parent = 0, $depth = 0){
		global $branch;
		if($depth > 1000) return ''; // Make sure not to have an endless recursion
		
		for($i=0, $ni=count($datas); $i < $ni; $i++){
			if($datas[$i]['id_div_parent'] == $parent){
				$val = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
				$val .= $depth==0?'':'&raquo; ';
				$val .= $datas[$i]['nama_div'];
				$branch[$datas[$i]['id_div']] = $val;
				$tree = $this->divTree($datas, $datas[$i]['id_div'], $depth+1);
			}
		}
		return $branch;
	}
	function divTreeJab($datas, $parent = 0, $depth = 0){
		global $branch2;
		if($depth > 1000) return ''; // Make sure not to have an endless recursion
		
		for($i=0, $ni=count($datas); $i < $ni; $i++){
			if($datas[$i]['id_jab_parent'] == $parent){
				$val = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
				$val .= $depth==0?'':'&raquo; ';
				$val .= $datas[$i]['nama_jab'];
				$branch2[$datas[$i]['id_jab']] = $val;
				$tree = $this->divTreeJab($datas, $datas[$i]['id_jab'], $depth+1);
			}
		}
		return $branch2;
	}
	
	function slipEmail($emailTo, $subject, $message, $attach){
		$config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'payrollnurulhayat@gmail.com',
            'smtp_pass' => 'bambangheriyanto',
            'mailtype' => 'html'
        );
 
        // recipient, sender, subject, and you message
        $to = $emailTo;
        $from = "payrollnurulhayat@gmail.com";
        //$subject = $subject;
        //$message = "This is a test email using CodeIgniter. If you can view this email, it means you have successfully send an email using CodeIgniter.";
 
        
        $this->load->library('email', $config);
        $this->email->attach($attach);
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
	
	function singleEmail($emailto,$subject,$message){
		
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
        $from = "deniknh@gmail.com";
        //$subject = $subject;
        //$message = "This is a test email using CodeIgniter. If you can view this email, it means you have successfully send an email using CodeIgniter.";
 
        
        $this->load->library('email', $config);
        //$this->email->attach('./assets/files/template/absensi.csv');
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
            return $this->email->print_debugger();
            //return 0;
        }
	}
	
	function createPath($type,$id_cab,$id_div, $thn, $bln){
		$path="assets/report/".$type;		

		switch ($type){
			case "csv":	
			case "csv_thr":	
				$path.="/".$id_cab;
				if (!is_dir($path)){
					mkdir($path, 0777);
				}
				$path.="/".$id_div;
				if (!is_dir($path)){
					mkdir($path, 0777);
				}
				$path.="/".$thn;
				if (!is_dir($path)){
					mkdir($path, 0777);
				}
				break;
			case "slip":
				$path.="/".$thn;
				if (!is_dir($path)){
					mkdir($path, 0777);
				}
				$path.="/".$bln;
				if (!is_dir($path)){
					mkdir($path, 0777);
				}
				break;
			case "slip_thr":
				$path.="/".$thn;
				if (!is_dir($path)){
					mkdir($path, 0777);
				}
				break;
			case "management":
				break;
		}

		return $path;
		
	}

}
