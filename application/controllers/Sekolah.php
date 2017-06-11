<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Setting
*/
class Sekolah extends CI_Controller_Modified {
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
        $this->tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($this->tempRequestUrl,'.jsp') === false) header("location:".base_url());
    }
    public function index(){
		if(strpos($this->tempRequestUrl,'index') !== false) header("location:".base_url());
		if($this->loginFilter->isLogin($this->owner)){
			//redirect(base_url());
		}else{
			$this->reloadCore();
		}
        //$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        //if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
        $this->trueCore("",true);
        $this->load->view("sekolah",array(
            "baseUrl"=>base_url(),
			"header"=>"Data Sekolah"
        ));
    }
	public function add(){
		/* $_POST['nama']="SMAN 2 cirebon";
		$_POST['kepsek']="Jafar Abdurrahman Albasyir";
		$_POST['nip']="123456789098765432";
		$_POST['email']="jafarabdurrahmanalbasyir@gmail.com";
		$_POST['nohp']="083869970670";
		$_POST['idline']="";
		$_POST['kodeForm']=""; */
		//$this->errorCore("percobaan");
		if($this->loginFilter->isLogin($this->owner)){
			//redirect(base_url());
		}else{
			$this->reloadCore();
		}
		$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
		$nama = $this->isNullPost('nama',"nama tidak boleh kosong");
		$kepsek = $this->isNullPost('kepsek',"nama kepala sekolah tidak boleh kosong");
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
		$temp = $this->inputJaservFilter->nameSchoolFiltering($nama);
		if(!$temp[0]) $this->errorCore($temp[1]);
		
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
		$this->loadLib("ControlSekolah");
		$this->loadLib("ControlPekerja");
		$controlPengguna = new ControlPengguna($this->gateControlModel);
		$controlSekolah = new ControlSekolah($this->gateControlModel);
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		$tempObjectDB = $controlSekolah->getDataByNama($nama);
		if($tempObjectDB && $tempObjectDB->getNextCursor()) $this->errorCore("Nama sekolah ini sudah terdaftar");
		
		
		$identifiedSekolah = $controlPengguna->generateIdentified(2);
		$identifiedKepSek = $controlPengguna->generateIdentified(3);
		$nick = "KEP-SEK-".date("Ymd-His");
		$nickName = $this->loginFilter->getHashNickName($nick);
		$key = "H".substr(date("Y"),0,2)."E".substr(date("Y"),2,2)."A".date("m")."D".date("d")."a".date("H")."e".date("i")."h".date("s");
		$keyPass = $this->loginFilter->getHashKeyWord($key);
		$emailCI = $this->loadLib("ControlEmail",true);
		$emailCI->pushTarget($email);
		$emailCI->addSubject("Permintaan pembuatan Akun");
		$emailCI->addMessageByView("Accountsekolah.html",array(
			"nickname" => $nick,
			"keypass" => $key,
			"url" => base_url(),
			"nama" => $nama,
			"kepsek" => $kepsek,
			"hari" => date("Y m d")." Pukul ".date("H:i:s")
		));
		//not connect to internet, 
		//$result = $emailCI->send();
		$result = true;
		if(!$result){
			$this->errorCore("email tidak valid");
		}
		$tempObjectDB = $controlPengguna->getObject();
		$tempObjectDB->setIdentified($identifiedSekolah);
		$tempObjectDB->setNickName($nickName);
		$tempObjectDB->setKeyWord($keyPass);
		if(!$controlPengguna->addData($tempObjectDB)){
			$this->errorCore("gagal menambahkan Sekolah");
		}
		$tempObjectDB = $controlSekolah->getObject();
		$tempObjectDB->setIdentified($identifiedSekolah);
		$tempObjectDB->setNama($nama);
		$tempObjectDB->setKepSek($identifiedKepSek);
		if(!$controlSekolah->addData($tempObjectDB)){
			$controlPengguna->removeByIdentified($identifiedSekolah);
			$this->errorCore("gagal menambahkan Sekolah");
		}
		$tempObjectDB = $controlPekerja->getObject();
		$tempObjectDB->setIdentified($identifiedKepSek);
		$tempObjectDB->setNama($kepsek);
		$tempObjectDB->setNip($nip);
		$tempObjectDB->setEmail($email);
		$tempObjectDB->setNoHp($nohp);
		$tempObjectDB->setIdLine($idline);
		if(!$controlSekolah->addData($tempObjectDB)){
			$controlPengguna->removeByIdentified($identifiedSekolah);
			$controlSekolah->removeByIdentified($identifiedSekolah);
			$this->errorCore("gagal menambahkan Sekolah");
		}
		$this->trueCore("Berhasil menambahkan sekolah");
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