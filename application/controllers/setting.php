<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setting extends MY_App {

	function __construct()
	{
		parent::__construct();
		$this->config->set_item('mymenu', 'menuSatu');
		$this->auth->authorize();
	}
	
	
	
	public function parameter(){
		$this->template->set('pagetitle','Setting Parameter');
		$this->template->load('default','setting/parameter');
	}
	
	public function json(){
		$this->datatables->select('description,name, value1, value2')
			->from('params');
		echo $this->datatables->generate();
	}
}
