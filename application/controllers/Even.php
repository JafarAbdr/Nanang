<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Setting
*/
class Even extends CI_Controller_Modified {
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
		$this->load->library('Aktor/Worker');
		$this->load->library('Aktor/Owner');
		$this->load->library('Aktor/Sekolah');
        $this->tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($this->tempRequestUrl,'.jsp') === false) header("location:".base_url());
    }
	public function index(){
		if(strpos($this->tempRequestUrl,'index') !== false) header("location:".base_url());
		$tempObjectDB = null;
		$allow = true;
		//var_dump($this->loginFilter->isLogin($this->owner));
		if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$this->trueCore("",true);
			$this->load->view('baseevent',array(
				"kode"=>3
			));
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$this->loadLib('ControlGuru');
			$this->loadLib('ControlPekerja');
			$controlGuru = new ControlGuru($this->gateControlModel);
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$tempObjectDB = $controlGuru->getAllData($this->loginFilter->getIdentifiedActive(),null,1);
			$this->trueCore("",true);
			$i = 0;
			$tempObjectDBD = $controlPekerja->getObject();
			if($tempObjectDB){
				while($tempObjectDB->getNextCursor()){
					$tempObjectDBD->concateTempValueWithThisClass($controlPekerja->getAllData($tempObjectDB->getPekerja()));
				}
			}
			$this->load->view('baseevent',array(
				"data" => $tempObjectDBD,
				"kode" => 2,
				"identified"=>$this->loginFilter->getIdentifiedActive()
			));
		}else if($this->loginFilter->isLogin($this->owner)){
			$this->loadLib('ControlSekolah');
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDBS = $controlSekolah->getAllData(null,1);
			$idSchool = "";
			if($tempObjectDBS && $tempObjectDBS->getNextCursor()){
				$this->loadLib('ControlGuru');
				$this->loadLib('ControlPekerja');
				$controlGuru = new ControlGuru($this->gateControlModel);
				$controlPekerja = new ControlPekerja($this->gateControlModel);
				$tempObjectDB = $controlGuru->getAllData($tempObjectDBS->getIdentified(),null,1);
				$idSchool = $tempObjectDBS->getIdentified();
				$this->trueCore("",true);
				$i = 0;
				$tempObjectDBD = $controlPekerja->getObject();
				if($tempObjectDB){
					while($tempObjectDB->getNextCursor()){
						$tempObjectDBD->concateTempValueWithThisClass($controlPekerja->getAllData($tempObjectDB->getPekerja()));
					}
				}
				$tempObjectDBS->resetSendRequest();
			}
			$this->load->view('baseevent',array(
				"school" => $tempObjectDBS,
				"data" => $tempObjectDBD,
				"kode" => 1,
				"identified"=>$this->loginFilter->getIdentifiedActive()
			));
		}else{
			$this->reloadCore();
		}
	}
	public function update(){
		if($this->loginFilter->isLogin($this->owner)){
			
		}else if($this->loginFilter->isLogin($this->sekolah)){
			
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			
		}else{
			$this->reloadCore();
		}
		$identifiedMessage = $this->isNullPost('id',"anda melakukan debugging");
		if(strlen($identifiedMessage) != 33) $this->errorCore("anda melakukan debugging");
		$identifiedMessage = substr($identifiedMessage,7,strlen($identifiedMessage)-7);
		$identifiedMessage = substr($identifiedMessage,10,10)."".substr($identifiedMessage,0,10)."".substr($identifiedMessage,20,6);
		//echo $identifiedMessage;
		$judul = $this->isNullPost('judul',"judul harus diisi");
		$deskripsi = $this->isNullPost('deskripsi',"deskripsi harus diisi");
		$status = $this->isNullPost('kategori',"status harus diisi");
		$judul = $this->inputJaservFilter->stringFiltering($judul);
		$deskripsi = $this->inputJaservFilter->stringFiltering($deskripsi);
		$status = intval($status);
		if($judul == "" || $judul == " ") $this->errorCore("judul harus diisi");
		if($deskripsi == "" || $deskripsi == " ") $this->errorCore("deskripsi harus diisi");
		//$this->errorCore($status);
		if($status < 1 || $status > 5) $this->errorCore("maaf status anda tidak terdaftar");
		//$this->errorCore("berhasil");
		$this->loadLib("ControlListToDo");
		$controlListToDo = new ControlListToDo($this->gateControlModel);
		$tempObjectDB = $controlListToDo->getAllData($identifiedMessage);
		$content = false;
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			if($tempObjectDB->getGuru() == $this->loginFilter->getIdentifiedActive()){
				$tempObjectDB->setTitle($judul);
				$tempObjectDB->setDeskripsi($deskripsi);
				$tempObjectDB->setStatus($status);
				$tempObjectDB->setLastEdit(date("Y-m-d H:i:s"));
				$tempObjectDB->setUpTime(date("Y-m-d H:i:s"));
				if($controlListToDo->tryUpdate($tempObjectDB)) $this->trueCore("Berhasil merubah event");
			}
		}
		$this->errorCore('maaf even anda tidak terdaftar');
	}
	public function getFormEdit(){
		//$_POST['id']='MESSAGE7C04D27E10MWEANAB201F22G20';
		if($this->loginFilter->isLogin($this->owner)){
			
		}else if($this->loginFilter->isLogin($this->sekolah)){
			
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			
		}else{
			$this->reloadCore();
		}
		$identifiedMessage = $this->isNullPost('id',"anda melakukan debugging");
		if(strlen($identifiedMessage) != 33) $this->errorCore("anda melakukan debugging");
		$identifiedMessage = substr($identifiedMessage,7,strlen($identifiedMessage)-7);
		$identifiedMessage = substr($identifiedMessage,10,10)."".substr($identifiedMessage,0,10)."".substr($identifiedMessage,20,6);
		//echo $identifiedMessage;
		$this->loadLib("ControlListToDo");
		$controlListToDo = new ControlListToDo($this->gateControlModel);
		$tempObjectDB = $controlListToDo->getAllData($identifiedMessage);
		$content = false;
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			if($tempObjectDB->getGuru() == $this->loginFilter->getIdentifiedActive()){
				$content = true;
			}
		}
		if($content){
			$this->trueCore("",true);
			$this->load->view('updatebaseevent',array(
				"data"=>$tempObjectDB,
				"baseUrl"=>base_url(),
				"header"=>"Ubah informasi perencanaan",
				"disable"=>true,
				"disabled"=>""
			));
		}else{
			$this->errorCore('maaf even anda tidak terdaftar');
		}
	}
	//guru
	public function getListData($section=null){
		if(is_null($section)){
			$this->errorCore("Maaf Anda melakukan debugging");
		}
		//$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        //if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
		$identified = "";
		$identifiedGuru = "";
		$ownerFilter = false;
		if($this->loginFilter->isLogin($this->owner)){
			$identified = $this->loginFilter->getIdentifiedActive();
			//Guru teach
			$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) == 31){
				$identifiedSekolah = $this->isNullPost('sekolah',"Sekolah tidak boleh kosong");
				$identifiedSekolah = substr($identifiedSekolah,3,strlen($identifiedSekolah));
				$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
				$identifiedSekolah = substr($identifiedSekolah,10,10)."".substr($identifiedSekolah,0,10)."".substr($identifiedSekolah,20,6); 
				$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); 
				$this->loadLib("ControlGuru");
				$controlGuru = new ControlGuru($this->gateControlModel);
				//echo $identified." ".$identifiedGuru;
				$tempObjectDB = $controlGuru->getAllData($identifiedSekolah,$identifiedGuru,1);
				//check if teach exist
				if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
					$this->errorCore("Guru tidak terdaftar");
				}
			}else if(strlen($identifiedGuru) == 29){
				$identifiedGuru = substr($identifiedGuru,3,strlen($identifiedGuru));
				$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); 
				if($identifiedGuru != $identified) $this->errorCore("anda melakukan debugging");
			}else {
				$identifiedSekolah = $this->isNullPost('sekolah',"Sekolah tidak boleh kosong");
				$identifiedSekolah = substr($identifiedSekolah,3,strlen($identifiedSekolah));
				$identifiedSekolah = substr($identifiedSekolah,10,10)."".substr($identifiedSekolah,0,10)."".substr($identifiedSekolah,20,6);
				$this->loadLib('ControlSekolah');
				$controlSekolah = new ControlSekolah($this->gateControlModel);
				$tempObjectDB = $controlSekolah->getAllData($identifiedSekolah,1);
				if($tempObjectDB && $tempObjectDB->getNextCursor()){
					$identifiedGuru = $tempObjectDB->getIdentified();
				}else
					$this->errorCore("pilih guru yang bersangkutan");
			}
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
			//Guru teach
			$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) == 31){
				$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
				$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); 
				$this->loadLib("ControlGuru");
				$controlGuru = new ControlGuru($this->gateControlModel);
				//echo $identified." ".$identifiedGuru;
				$tempObjectDB = $controlGuru->getAllData($identified,$identifiedGuru,1);
				//check if teach exist
				if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
					$this->errorCore("Guru tidak terdaftar");
				}
			}else if(strlen($identifiedGuru) == 29){
				$identifiedGuru = substr($identifiedGuru,3,strlen($identifiedGuru));
				$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); 
				if($identifiedGuru != $identified) $this->errorCore("anda melakukan debugging");
			}else $this->errorCore("pilih guru yang bersangkutan");
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
			$identifiedGuru = $this->loginFilter->getIdentifiedActive();
			
			$this->loadLib("ControlSekolah");
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDB = $controlSekolah->getAllData($identified,1);
			//check if school exist
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
				$this->errorCore("sekolah tidak terdaftar");
			}
			$this->loadLib("ControlGuru");
			$controlGuru = new ControlGuru($this->gateControlModel);
			//echo $identified." ".$identifiedGuru;
			$tempObjectDB = $controlGuru->getAllData($identified,$identifiedGuru,1);
			//check if teach exist
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
				$this->errorCore("Guru tidak terdaftar");
			}
			
			
			
		}else{
			$this->reloadCore();
		}
		$keyword = $this->isNullPost("keyword","anda melakukan debugging");
		if($keyword == "" || $keyword == " ") $keyword = '*';
		$this->loadLib('ControlListToDo');
		$controlListToDo = new ControlListToDo($this->gateControlModel);
		$tempObjectDB = false;
		$kode=true;
		$kodeD = "";
		switch($section){
			default :
			$this->errorCore("Maaf Anda melakukan debugging");
			break;
			case 'allPlan' :
			$tempObjectDB = $controlListToDo->getByAuthor($identifiedGuru);
			$kode = false;
			break;
			case 'listOfPlan' :
			$tempObjectDB = $controlListToDo->getByAuthor($identifiedGuru,1);
			$kodeD="planning";
			break;
			case 'doingOfPlan' :
			$tempObjectDB = $controlListToDo->getByAuthor($identifiedGuru,2);
			$kodeD="on doing";
			break;
			case 'delayOfPlan' :
			$tempObjectDB = $controlListToDo->getByAuthor($identifiedGuru,3);
			$kodeD="on delaying";
			break;
			case 'dissmisOfPlan' :
			$tempObjectDB = $controlListToDo->getByAuthor($identifiedGuru,4);
			$kodeD="on fail";
			break;
			case 'finishOfPlan' :
			$tempObjectDB = $controlListToDo->getByAuthor($identifiedGuru,5);
			$kodeD="on finish";
			break;
		}
		$data['jumlah']=0;
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				if($keyword == "*" || !is_bool(strpos(strtolower($tempObjectDB->getTitle()),strtolower($keyword)))){
					$data['jumlah']+=1;
					$data[$data['jumlah']]['operation'] = 'false';
					if($tempObjectDB->getGuru() == $this->loginFilter->getIdentifiedActive()){
						$data[$data['jumlah']]['operation'] = 'true';
					}
					$schId = $tempObjectDB->getIdentified();
					$data[$data['jumlah']]['id'] = "MESSAGE".substr($schId,10,10)."".substr($schId,0,10)."".substr($schId,20,6);
					$data[$data['jumlah']]['judul'] = $tempObjectDB->getTitle();
					$data[$data['jumlah']]['deskripsi'] = $tempObjectDB->getDeskripsi();
					if($kode){
						$data[$data['jumlah']]['status'] = $kodeD;
					}else{
						$data[$data['jumlah']]['status'] = $this->getKode($tempObjectDB->getStatus());
					}
				}
			}
		}
		$this->trueCore("",true);
		echo json_encode($data);
	}
	protected function getKode($kode){
		switch($kode){
			case 1 : return "planning";
			case 2 : return "on doing";
			case 3 : return "on delaying";
			case 4 : return "on fail";
			case 5 : return "on finish";
		}
	}
}