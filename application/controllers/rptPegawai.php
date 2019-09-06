<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rptPegawai extends MY_App {
	var $branch = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('rptPegawai_model');
		$this->config->set_item('mymenu', 'menuEnam');
		$this->auth->authorize();
	}
	
}

?>