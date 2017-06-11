<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : login
*/
class Home extends CI_Controller_Modified {
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
		$tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($tempRequestUrl,'index') !== false) header("location:".base_url());
		if(strpos($tempRequestUrl,'home') !== false) header("location:".base_url());
		$dataLayout = null;
		$level = 4;
		if($this->loginFilter->isLogin($this->owner)){
			$level =1;
			$this->loadLib("ControlPekerja");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$tempObjectDB = $controlPekerja->getAllData($this->loginFilter->getIdentifiedActive());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$dataLayout =array(
				"title"=>"Admin",
				"head"=>"Space Control"
			);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$this->loadLib("ControlSekolah");
			$this->loadLib("ControlPekerja");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDB = $controlSekolah->getAllData($this->loginFilter->getIdentifiedActive());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$tempObjectDB = $controlPekerja->getAllData($tempObjectDB->getKepSek());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$level =2;
			$dataLayout =array(
				"title"=>"Kepala Sekolah",
				"head"=>"Space Management"
			);
		}else if($this->loginFilter->isLogin($this->worker)){
			if($this->loginFilter->isGuru()) $level =3;
			$this->loadLib("ControlPekerja");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$tempObjectDB = $controlPekerja->getAllData($this->loginFilter->getIdentifiedActive());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$dataLayout =array(
				"title"=>"Informant",
				"head"=>"Space Activity"
			);
		}else{
			redirect(base_url()."Login");
		}
		$this->load->view('dashboard',array(
			"baseUrl" => base_url(),
			"dataContent"=>$tempObjectDB,
			"dataLayout"=>$dataLayout,
			"levelCode"=>$level
		));
	}
	public function logOut(){
		$tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($tempRequestUrl,'home') !== false) header("location:".base_url());
		if($this->loginFilter->isLogin($this->owner)){
			//redirect(base_url());
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//redirect(base_url());
		}else if($this->loginFilter->isLogin($this->worker)){
			//redirect(base_url());
		}
		$this->loginFilter->setLogOut();
		redirect(base_url());
	}
}