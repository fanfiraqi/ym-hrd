<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Simplival
{
	function Simplival()
	{
		$this->SV =& get_instance();
		$this->SV->load->library('validation');
		$this->SV->load->library(array('loader','auth','encrypt','session'));
	}
	function acceptData($value,$encode=FALSE)
	{
		foreach($value as $key => $val)
		{		
			$data[$val]  = $this->SV->input->post($val,TRUE);
			if(is_array($data[$val])){
					$data[$val] = implode('+',$data[$val]);
				}else{
					$data[$val]  = strip_image_tags($data[$val]);
					$data[$val]  = encode_php_tags($data[$val]);
					$data[$val]  = trim($data[$val]);
					if($val=='password' and $encode==TRUE)
					{
						$data[$val] = $this->SV->encrypt->encode($data[$val]);
					}	
				}
		}		
		return $data;
	}
	function redirectMessage($message,$url,$title,$segment=NULL)
	{
		$data['pesan']=$message;
        $data['url']=$url;
		$data['title']=$title;
        $data['seg']=$segment;
        $this->SV->load->view('redirect_message',$data);
	}
	function redirectMessageWarning($url,$segment=NULL)
	{
        $data['url']=$url;
        $data['seg']=$segment;
        $this->SV->load->view('redirect_message_warning',$data);
	}
	function validatingData($field,$rule)
	{
		$data=$field + $rule;
		foreach($data as $key => $val)
		{	
			if(!is_numeric($key))
			{
				$rules[$key]=$val;
			}else{
				$rules[$val]='';	
			}
		}
		$this->SV->validation->set_rules($rules);
		//$this->SV->validation->set_message('noExist', 'Nomer HP Sudah Masuk Group');
		$this->SV->validation->set_message('required', 'field ini tidak boleh kosong!');
		$this->SV->validation->set_message('valid_email', 'alamat email yang Anda masukkan salah');
		$this->SV->validation->set_message('matches', 'password tidak sama!');
		$this->SV->validation->set_message('validCaptcha', 'captcha tidak sama!');
		$this->SV->validation->set_message('integer', 'Harus berupa angka!');
		$this->SV->validation->set_error_delimiters('<div class="error">', '</div>');
		if($this->SV->validation->run()==FALSE)
		{
			return FALSE;
		}else{
			return TRUE;
		}			
	}
	function setFields($data){
		foreach($data as $key => $val)
		{
			$fields[$val]=$val;			
		}
		$this->SV->validation->set_fields($fields);
	}
	function isTherePost()
	{
		if (count($_POST) == 0)
		{
			return FALSE;
		}
	}
	function valid_date()
	{
		$day=$this->SV->input->post('tanggal',TRUE);
		$month=$this->SV->input->post('bulan',TRUE);
		$year=$this->SV->input->post('tahun',TRUE);
    	if (!checkdate($month,$day,$year))
    	{
          	return FALSE;
     	}
	}
	function validCaptcha()
	{
		$captcha = $this->SV->input->post('captcha',TRUE);
		$expiration = time()-3600;
        $this->SV->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? 
                    AND ip_address = ? AND captcha_time > ?";
        $binds = array($captcha, $this->SV->input->ip_address(), $expiration);
        $query = $this->SV->db->query($sql, $binds);
      	$row = $query->row();

        if ($row->count == 0) 
		{
          	return FALSE;
        }else{
			return TRUE;
		}          
	}
}