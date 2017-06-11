<?php
if(!defined('BASEPATH')) header("location:http://siata.undip.ac.id/");
class CI_Controller_Modified extends CI_Controller{
	private $kodeMessage;
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->kodeMessage = null;
	}
	protected function isNullPost($tempName,$messageError = null, $exit = true){
		if(!is_bool($exit)) $exit = true;
		if($this->input->post($tempName) === NULL){
			if(is_null($messageError)){
				if($exit)
					exit('6'.$tempName." bernilai null");
				else
					return false;
			}else{
				if($exit)
					exit('6'.$messageError);
				else
					return false;
			}
		}
		if($exit)
			return $this->input->post($tempName);
		else
			return true;
	}
	protected function loadMod($nama,$return = false){
		$this->load->model($nama);
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->$nama))
			$tempObject = $this->$nama;
		$this->$nama = null;
		if($return)
			return $tempObject;
	}
	protected function loadHel($nama){
		$this->load->helper($nama);
	}
	protected function loadLib($nama,$return = false){
		$this->load->library($nama);
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->$nama)) 
			$tempObject = $this->$nama;
		$this->$nama = null;
		if($return)
			return $tempObject;
	}
	protected function errorCore($message = "",$disableExit=false){
		$this->kodeMessage = "6";
		if($this->coreMessage($message,$disableExit)){
			exit;
		}
		$this->kodeMessage = null;
	}
	protected function trueCore($message = "",$disableExit=false){
		$this->kodeMessage = "0";
		if($this->coreMessage($message,$disableExit)){
			exit;
		}
		$this->kodeMessage = null;
	}
	protected function reloadCore($message = "",$disableExit=false){
		$this->kodeMessage = "&";
		if($this->coreMessage($message,$disableExit)){
			exit;
		}
		$this->kodeMessage = null;
	}
	protected function coreMessage($message = null,$disableExit=false){
		if(is_null($this->kodeMessage)) return null;
		if(is_null($message)) {
			echo $this->kodeMessage."null pesan";
			if(is_bool($disableExit)){
				if($disableExit){
					return false;
				}else{
					return true;
				}
			}else{
				return true;
			}
		}
		echo $this->kodeMessage."".$message;
		if(is_bool($disableExit)){
			if($disableExit){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
}