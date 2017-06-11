<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Setting
*/
class Schedule extends CI_Controller_Modified {
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
    public function index($me=null){
		if(strpos($this->tempRequestUrl,'index') !== false) header("location:".base_url());
		$tempObjectDB = null;
		$tempObjectDBD = null;
		$kode=1;
		$disGuru = false;
		$allow=true;
		$tempObjectDBT = false;
		if($this->loginFilter->isLogin($this->owner)){
			$allow=false;
			$kode=1;
			if($me == 'us'){
				$tempObjectDBT = null;
				$allow=true;
			}else if($me == 'kepSek'){
				$this->loadLib("ControlSekolah");
				$controlSekolah = new ControlSekolah($this->gateControlModel);
				$tempObjectDB = $controlSekolah->getAllData(null,1);
				$disGuru = true;
			}else{
				$this->loadLib("ControlSekolah");
				$controlSekolah = new ControlSekolah($this->gateControlModel);
				$tempObjectDB = $controlSekolah->getAllData(null,1);
			}
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$allow=false;
			$kode=2;
			if($me != 'us' && is_null($me)) {
				$this->loadLib("ControlGuru");
				$this->loadLib("ControlPekerja");
				$controlGuru = new ControlGuru($this->gateControlModel);
				$controlPekerja = new ControlPekerja($this->gateControlModel);
				$tempObjectDBD = $controlGuru->getAllData($this->loginFilter->getIdentifiedActive(),null,1);
				$i=0;
				while($tempObjectDBD && $tempObjectDBD->getNextCursor()){
					$tempObject = $controlPekerja->getAllData($tempObjectDBD->getPekerja());
					if($tempObject && $tempObject->getNextCursor()){
						$tempObjectDBT[$i]['identified'] = $tempObject->getIdentified();
						$tempObjectDBT[$i]['nama'] = $tempObject->getNama();
						$i+=1;
					}
				}
			}else{
				$tempObjectDBT = null;
				$allow=true;
			}
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$kode=3;
		}else{
			$this->reloadCore();
		}
        //$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        //if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
        $this->trueCore("",true);
        $this->load->view("schedule",array(
			"kode" => $kode,
            "baseUrl" => base_url(),
			"sekolah" => $tempObjectDB,
			"guru"=>$tempObjectDBT,
			"allow"=> $allow,
			"header" => "Perencanaan baru",
			"disGuru"=>$disGuru
        ));
    }
	public function getListGuru(){
		/* $_POST['nama']="SCH7C04D11E00SWEANAB201F24G17";
		$_POST['kodeForm']="J453RVT3CH@W3N4@FORM"; */
		$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
		if($this->loginFilter->isLogin($this->owner)){
			$identified = $this->isNullPost('nama',"Sekolah tidak boleh kosong");
			if(strlen($identified) != 29) $this->errorCore("pilih sekolah yang bersangkutan");
			$identified = substr($identified,3,strlen($identified));
			$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
		}else{
			$this->reloadCore();
		}
		$this->loadLib("ControlGuru");
		$this->loadLib("ControlPekerja");
		$controlGuru = new ControlGuru($this->gateControlModel);
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		$tempObjectDB = $controlGuru->getAllData($identified,null,1);
		$i=0;
		$data = null;
		while($tempObjectDB && $tempObjectDB->getNextCursor()){
			$tempObjectDBD = $controlPekerja->getAllData($tempObjectDB->getPekerja());
			if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
				$data[$i]['identified'] = $tempObjectDBD->getIdentified();
				$data[$i]['nama'] = $tempObjectDBD->getNama();
				$i++;
			}
		}
		$this->trueCore("",true);
		 $this->load->view("listwali",array(
			"guru"=>$data
        ));
	}
//	public function get
	public function add(){
		/* $_POST['judul']="ini judul";
		$_POST['deskripsi']="ini isi deskripsi";
		$_POST['kategori']="1";
		$_POST['kodeForm']="J453RVT3CH@W3N4@FORM";   */
		/* $_POST['nama']="SCH7C04D11E00SWEANAB201F24G17";
		$_POST['guru']="TEACH7C04D11E20WWEANAB201F34G05";
		$_POST['wali']="Abdul Aziz";
		$_POST['nip']="1928374657829387987";
		$_POST['email']="jafarabdurrahmanalbasyir@gmail.com";
		$_POST['nohp']="083869970670";
		$_POST['idline']="";
		$_POST['kodeForm']="J453RVT3CH@W3N4@FORM";   */
		//$this->errorCore("percobaan");
		$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
		$identified = "";
		$identifiedGuru = "";
		$kodeadd = 0;
		$checkGuru = true;
		$checkSchool = true;
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolahhis
			$kodeadd = 3;
			$tempKodeAdd = intval($this->isNullPost("kodeAdd","anda melakukan debugging"));
			switch($tempKodeAdd){
				case 1 :
				$checkGuru = false;
				$checkSchool = false;
				$identifiedGuru = $this->loginFilter->getIdentifiedActive();
				break;
				case 2 :
					$checkGuru = false;
					$identified = $this->isNullPost('nama',"Sekolah tidak boleh kosong");
					if(strlen($identified) != 29) $this->errorCore("pilih sekolah yang bersangkutan");
					$identified = substr($identified,3,strlen($identified));
					$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
					$identifiedGuru = $identified;
				break;
				case 3 :
					$identified = $this->isNullPost('nama',"Sekolah tidak boleh kosong");
					if(strlen($identified) != 29) $this->errorCore("pilih sekolah yang bersangkutan");
					$identified = substr($identified,3,strlen($identified));
					$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
					$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
					if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
					$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
					$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6);
				break;
			}
			
			//Guru
			
			
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$kodeadd = 2;
			$identified = $this->loginFilter->getIdentifiedActive();
			//Guru
			if($this->isNullPost('me',"",false)){
				if($this->isNullPost('me')== "J453RVT3CH@W3N4@FORMME"){
					$identifiedGuru = $this->loginFilter->getIdentifiedActive();
					$checkGuru = false;
				}else{
					$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
					if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
					$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
					$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6);
				}
			}else{
				$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
				if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
				$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
				$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6);
			}
			
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$kodeadd = 1;
			$identified  = $this->loginFilter->getSekolah();
			$identifiedGuru = $this->loginFilter->getIdentifiedActive();
		}else{
			$this->reloadCore();
		}
		if($checkSchool){
			$this->loadLib("ControlSekolah");
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDB = $controlSekolah->getAllData($identified,1);
			//check if school exist
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
				$this->errorCore("sekolah tidak terdaftar");
			}
		}
		if($checkGuru){
			$this->loadLib("ControlGuru");
			$controlGuru = new ControlGuru($this->gateControlModel);
			//echo $identified." ".$identifiedGuru;
			$tempObjectDB = $controlGuru->getAllData($identified,$identifiedGuru,1);
			//check if teach exist
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
				$this->errorCore("Guru tidak terdaftar");
			}
		}
		//filter kontent
		
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
		$tempObjectDB = $controlListToDo->getObject();
		$tempObjectDB->setIdentified($controlListToDo->generateIdentified());
		$tempObjectDB->setGuru($identifiedGuru);
		$tempObjectDB->setLastEdit(date("Y-m-d H:i:s"));
		$tempObjectDB->setUpTime(date("Y-m-d H:i:s"));
		$tempObjectDB->setTitle($judul);
		$tempObjectDB->setDeskripsi($deskripsi);
		$tempObjectDB->setStatus($status);
		$tempObjectDB->setKodeAdd($kodeadd);
		if($controlListToDo->addData($tempObjectDB)) $this->trueCore("berhasil menambahkan perencanaan");
		else $this->trueCore("gagal menambahkan perencanaan");
	}
}