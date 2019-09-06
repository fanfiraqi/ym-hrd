<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI = & get_instance();

function timenow(){
	return date('Y-m-d H:i:s');
}

function debug($str){
	echo "<pre style='boder:solid 1px #333;background-color:#dedede'>";
	print_r($str);
	echo "</pre>";
}

function debug_last(){
	$CI =& get_instance();
	echo "<pre style='boder:solid 1px #333;background-color:#dedede'>";
	print_r($CI->db->last_query());
	echo "</pre>";
}


function menuActive($str=''){
	global $menu;
	if ($menu==$str) echo "active";
}

function revdate($in,$limiterin='-',$limiterout='-'){
	$date = explode($limiterin, $in);
	$out = null;
	if (count($date)>1){
		$out = $date[2] . $limiterout . $date[1] . $limiterout . $date[0];
	}
	return $out;
}

function errorHandler(){
	$nodisplay = (!validation_errors())? 'no-display':'';
	echo '<div id="errorHandler" class="alert alert-danger '.$nodisplay.'">';
	echo 'Ada Kesalahan. Silakan periksa kembali isian form.<br />';
	echo validation_errors();
	echo '</div>';
}

function flashMessage($str,$type='success'){
	global $CI;
	$CI->session->set_flashdata('flashmsg',$str);
	$CI->session->set_flashdata('flashtype',$type);
}

function activemenu($str,$value){
	//if (@$$str==$value) echo ' class="active" ';
}