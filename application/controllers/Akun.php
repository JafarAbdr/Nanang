<?php
if(!defined('BASEURL_WE_NA'))
	define('BASEURL_WE_NA',"http://localhost/WE_NA");
if(!defined('BASEPATH')) header("location:".BASEURL_WE_NA);
if(!defined('APPPATH')) header("location:".BASEURL_WE_NA);
require_once APPPATH."controllers/CI_Controller_Modified.php";
class Akun extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->loadHel("Url");
		$this->loadHel("Html");
		$this->loadMod('GateControlModel');
		$this->loadLib('LoginFilter');
		$this->loadLib('Inputjaservfilter');
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->load->library('Session');
		$this->gateControlModel = new GateControlModel();
		$this->loginFilter = new LoginFilter($this->session, $this->gateControlModel);
		$this->load->library('Aktor/Owner');
		$this->load->library('Aktor/Sekolah');
		$this->load->library('Aktor/Worker');
        $this->tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($this->tempRequestUrl,'.jsp') === false) header("location:".base_url());
	}
	public function index(){
		if(strpos($this->tempRequestUrl,'index') !== false) header("location:".base_url());
		$dataContent=null;
		if($this->loginFilter->isLogin($this->owner)){
			$this->loadLib('ControlSekolah');
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$dataContent = array(
				"kode" => 1,
				"school" => $controlSekolah->getAllData()
			);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$dataContent = array("kode"=>2);
		}else if($this->loginFilter->isLogin($this->worker)){
			if($this->loginFilter->isGuru())
				$dataContent = array("kode"=>3);
			else
				$dataContent = array("kode"=>4);
		}else{
			$this->reloadCore();
		}
        //$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
      //  if($kodeForm != 'J453RVT3CH@W3N4') $this->errorCore("token diperlukan");
        $this->trueCore("",true);
        $this->load->view("baseakun",$dataContent);
	}
}