<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlCIInstance{
	protected $CI;
	public function __CONSTRUCT(){
		$this->CI = &get_instance();
	}
	/*form-session*/
	protected function loadMod($nama,$return = false){
		$this->CI->load->model($nama);
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->CI->$nama))
			$tempObject = $this->CI->$nama;
		$this->CI->$nama = null;
		if($return)
			return $tempObject;
	}
	protected function loadHel($nama){
		$this->CI->load->helper($nama);
	}
	protected function loadLib($nama,$return = false,$config=null){
		if(!is_null($config)){
			$this->CI->load->library($nama,$config);
		}else{
			$this->CI->load->library($nama);
		}
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->CI->$nama)) 
			$tempObject = $this->CI->$nama;
		$this->CI->$nama = null;
		if($return)
			return $tempObject;
	}
	protected function setCategoryPrintMessage($cat,$status,$message){if($cat==0){if($status){echo "1".$message;return ;}else{echo "0".$message;	return ;}}else{	return array($status,$message);}}
	/*private*/
}