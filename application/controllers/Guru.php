<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Setting
*/
class Guru extends CI_Controller_Modified {
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
        $this->tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($this->tempRequestUrl,'.jsp') === false) header("location:".base_url());
    }
    public function index(){
		if(strpos($this->tempRequestUrl,'index') !== false) header("location:".base_url());
		$tempObjectDB = null;
		$allow = true;
		if($this->loginFilter->isLogin($this->owner)){
			$this->loadLib("ControlSekolah");
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDB = $controlSekolah->getAllData(null,1);
			$allow = false;
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//redirect(base_url());
		}else{
			$this->reloadCore();
		}
        //$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        //if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
        $this->trueCore("",true);
        $this->load->view("guru",array(
            "baseUrl" => base_url(),
			"sekolah" => $tempObjectDB,
			"allow"=> true,
			"header" => "Data Guru"
        ));
    }
	public function add(){
		/* $_POST['nama']="SCH7C04D11E00SWEANAB201F25G02";
		$_POST['guru']="Jafar Abdurrahman Albasyir";
		$_POST['nip']="123456789098765432";
		$_POST['email']="jafarabdurrahmanalbasyir@gmail.com";
		$_POST['nohp']="083869970670";
		$_POST['idline']="";
		$_POST['kodeForm']="J453RVT3CH@W3N4@FORM";  */
		//$this->errorCore("percobaan");
		$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
		$identified = "";
		if($this->loginFilter->isLogin($this->owner)){
			$identified = $this->isNullPost('nama',"Sekolah tidak boleh kosong");
			if(strlen($identified) != 29) $this->errorCore("pilih sekolah yang bersangkutan");
			$identified = substr($identified,3,strlen($identified));
			$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$identified = $this->loginFilter->getIdentifiedActive();
		}else{
			$this->reloadCore();
		}
		$this->loadLib("ControlSekolah");
		$controlSekolah = new ControlSekolah($this->gateControlModel);
		$tempObjectDB = $controlSekolah->getAllData($identified,1);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			$this->errorCore("sekolah tidak terdaftar");
		}
		
		$kepsek = $this->isNullPost('guru',"nama guru tidak boleh kosong");
		$nip = $this->isNullPost('nip',"nip harus diisi");
		$email = $this->isNullPost('email',"email harus diisi");
		$nohp = $this->isNullPost('nohp',"no handphone harus diisi");
		$idline = $this->isNullPost('idline',"",false);
		if(!$idline){
			$idLine="";
		}else{
			$idline = htmlspecialchars(htmlentities($this->isNullPost('idline')));
		}
		
		$aktor=null;
		if($this->loginFilter->isLogin($this->owner)){
			$aktor=$this->owner;
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$aktor = $this->sekolah;
		}else if($this->loginFilter->isLogin($this->worker)){
			$aktor = $this->worker;
		}else{
			$this->reloadCore();
		}
		
		$aktor->initial($this->inputJaservFilter);
		$temp = $aktor->getCheckName($kepsek,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		
		$temp = $aktor->getCheckNip($nip,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		$temp = $aktor->getCheckEmail($email,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		
		$temp = $aktor->getCheckNuTelphone($nohp,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		$this->loadLib("ControlPengguna");
		$this->loadLib("ControlPekerja");
		$this->loadLib("ControlGuru");
		$controlPengguna = new ControlPengguna($this->gateControlModel);
		$controlGuru = new ControlGuru($this->gateControlModel);
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		$tempObjectDBD = $controlPekerja->getDataByNip($nip);
		$allow = true;
		if($tempObjectDBD){
			while($tempObjectDBD->getNextCursor()){
				$tempObjectDBT = $controlGuru->getAllData($identified,$tempObjectDBD->getIdentified());
				if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
					$allow=false;
				}
			}
		}
		if(!$allow) $this->errorCore("nip ini sudah menjadi guru disekolah");
		
		$identifiedKepSek = $controlPengguna->generateIdentified(3);
		$nick = "GURU-".date("Ymd-His");
		$nickName = $this->loginFilter->getHashNickName($nick);
		$key = "G".substr(date("Y"),0,2)."U".substr(date("Y"),2,2)."R".date("m")."U".date("d")."r".date("H")."u".date("i")."g".date("s");
		$keyPass = $this->loginFilter->getHashKeyWord($key);
		$emailCI = $this->loadLib("ControlEmail",true);
		$emailCI->pushTarget($email);
		$emailCI->addSubject("Permintaan pembuatan Akun");
		$emailCI->addMessageByView("Accountguru.html",array(
			"nama"=>$tempObjectDB->getNama(),
			"nickname" => $nick,
			"keypass" => $key,
			"url" => base_url(),
			"kepsek" => $kepsek,
			"hari" => date("Y m d")." Pukul ".date("H:i:s")
		));
		
		//not connect to internet, 
		//$result = $emailCI->send();
		//exit($emailCI->getMessage());
		$result = true;
		if(!$result){
			$this->errorCore("email tidak valid");
		}
		$tempObjectDB = $controlPengguna->getObject();
		$tempObjectDB->setIdentified($identifiedKepSek);
		$tempObjectDB->setNickName($nickName);
		$tempObjectDB->setKeyWord($keyPass);
		if(!$controlPengguna->addData($tempObjectDB)){
			$this->errorCore("gagal menambahkan Sekolah");
		}
		$tempObjectDB = $controlPekerja->getObject();
		$tempObjectDB->setIdentified($identifiedKepSek);
		$tempObjectDB->setNama($kepsek);
		$tempObjectDB->setNip($nip);
		$tempObjectDB->setEmail($email);
		$tempObjectDB->setNoHp($nohp);
		$tempObjectDB->setIdLine($idline);
		if(!$controlPekerja->addData($tempObjectDB)){
			$controlPengguna->removeByIdentified($identifiedKepSek);
			$this->errorCore("gagal menambahkan Sekolah");
		}
		$tempObjectDB = $controlGuru->getObject();
		$tempObjectDB->setSekolah($identified);
		$tempObjectDB->setPekerja($identifiedKepSek);
		if(!$controlGuru->addData($tempObjectDB)){
			$controlPengguna->removeByIdentified($identifiedKepSek);
			$controlPekerja->removeByIdentified($identifiedKepSek);
			$this->errorCore("gagal menambahkan Guru");
		}
		$this->trueCore("Berhasil menambahkan Guru");
	}
	public function update(){
		
		
		$this->loadLib("ControlPengguna");
		$controlPengguna = new ControlPengguna($this->gateControlModel);
		$tempObjectDB = $controlPengguna->getAllData($this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
		$tempObjectDB->setNama($nama);
		$tempObjectDB->setNip($nip);
		$tempObjectDB->setEmail($email);
		$tempObjectDB->setNoHp($nohp);
		$tempObjectDB->setIdLine($idline);
		//$this->errorCore("gagal merubah");
		if(!$controlPengguna->tryUpdate($tempObjectDB)) $this->errorCore("terjadi kesalahan saat merubah informasi diri");
		$this->trueCore("berhasil merubah inpformasi diri");
		
	}
}