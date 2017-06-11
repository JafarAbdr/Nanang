<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : login
*/
class Login extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->loadHel("Url");
		$this->loadHel("Html");
		$this->loadMod('GateControlModel');
		$this->loadLib('LoginFilter');
		$this->load->library('Session');
		$this->gateControlModel = new GateControlModel();
		$this->loginFilter = new LoginFilter($this->session, $this->gateControlModel);
		$this->load->library('Aktor/Owner');
		$this->load->library('Aktor/Sekolah');
		$this->load->library('Aktor/Worker');
	}
	public function index(){
		//filter Url
		//exit(base_url());
		$tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if($this->loginFilter->isLogin($this->owner)){
			redirect(base_url());
		}else if($this->loginFilter->isLogin($this->sekolah)){
			redirect(base_url());
		}else if($this->loginFilter->isLogin($this->worker)){
			redirect(base_url());
		}
		if(strpos($tempRequestUrl,'index') !== false) header("location:".base_url());
		$this->load->view('login',array(
			"baseUrl" => base_url()
		));
	}
	public function tryValidate(){
		/* $_POST['passWord'] = "G20U17R04U11r00u24g17";
		$_POST['userName'] = "GURU-20170411-002417";
		$_POST['kodeLogin'] = "J453RVT3CH@W3N4@L0G1N"; */
		$kode = $this->isNullPost("kodeLogin","kirimkan token untuk login");
		$nickname = $this->isNullPost("userName","kode pengguna harus diisi");
		$keyword = $this->isNullPost("passWord","kata kunci harus diisi");
		if($kode != "J453RVT3CH@W3N4@L0G1N") $this->errorCore("token login tidak sesuai");
		if(!$this->loginFilter->setLogIn($nickname,$keyword))
			$this->errorCore("Kombinasi tidak tepat");
		if($this->loginFilter->isLogin($this->owner)){
			
		}else if($this->loginFilter->isLogin($this->sekolah)){
			
		}else if($this->loginFilter->isLogin($this->worker)){
			
		}
		$this->reloadCore('mengalihkan');
	}
}
