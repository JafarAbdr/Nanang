<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Setting
*/
class Setting extends CI_Controller_Modified {
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
		$identifiedActive = null;
		if($this->loginFilter->isLogin($this->owner)){
			$identifiedActive = $this->loginFilter->getIdentifiedActive();
			$this->loadLib("ControlPekerja");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$tempObjectDB = $controlPekerja->getAllData($identifiedActive);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$this->trueCore("",true);
			$this->load->view("profile",array(
				"baseUrl"=>base_url(),
				"dataContent"=>$tempObjectDB,
				"header"=>"Info data diri anda"
			));
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//echo "ll";
			$this->loadLib("ControlSekolah");
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDBS = $controlSekolah->getAllData($this->loginFilter->getIdentifiedActive());
			$tempObjectDBS->getNextCursor();
			$identifiedActive = $tempObjectDBS->getKepSek();
			$this->loadLib("ControlPekerja");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$tempObjectDB = $controlPekerja->getAllData($identifiedActive);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$this->trueCore("",true);
			$this->load->view("profileS",array(
				"baseUrl"=>base_url(),
				"dataContent"=>$tempObjectDB,
				"dataContentS"=>$tempObjectDBS,
				"header"=>"Info data diri anda"
			));
		}else if($this->loginFilter->isLogin($this->worker)){
			$identifiedActive = $this->loginFilter->getIdentifiedActive();
			$this->loadLib("ControlPekerja");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$tempObjectDB = $controlPekerja->getAllData($identifiedActive);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$this->trueCore("",true);
			$this->load->view("profile",array(
				"baseUrl"=>base_url(),
				"dataContent"=>$tempObjectDB,
				"header"=>"Info data diri anda"
			));
		}else{
			$this->reloadCore();
		}
    }
	public function update(){
		/* $_POST['nama'] = "jafar abdurrahman albasyir";
		$_POST['namas'] = "SMAN 1 PALIMANAN";
		$_POST['email'] = "jafarabdurrahman@gmail.com";
		$_POST['emails'] = "sman1palimanan@palimanan.sch.id";
		$_POST['nohp'] = "093869970670";
		$_POST['nohps'] = "089182918291";
		$_POST['kodes'] = "739182012-3239293";
		$_POST['alamats'] = "jalan mojokerto 678";
		$_POST['nip'] = "1293784626374898376";
		$_POST['idline'] = "jafarAL";
		$_POST['kodeForm'] = "J453RVT3CH@W3N4@FORM";  */
		$tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($tempRequestUrl,'.jsp') === false) header("location:".base_url());
		$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
		$nama = $this->isNullPost('nama',"nama tidak bolehs kosong");
		
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
		$identifiedActive = null;
		if($this->loginFilter->isLogin($this->owner)){
			$aktor=$this->owner;
			$identifiedActive = $this->loginFilter->getIdentifiedActive();
			$aktor->initial($this->inputJaservFilter);
			$temp = $aktor->getCheckName($nama,1);
			if(!$temp[0]) $this->errorCore($temp[1]);
			$temp = $aktor->getCheckEmail($email,1);
			if(!$temp[0]) $this->errorCore($temp[1]);
			$temp = $aktor->getCheckNip($nip,1);
			if(!$temp[0]) $this->errorCore($temp[1]);			
			$temp = $aktor->getCheckNuTelphone($nohp,1);
			if(!$temp[0]) $this->errorCore($temp[1]);
			$this->loadLib("ControlPekerja");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$tempObjectDB = $controlPekerja->getAllData($identifiedActive);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$tempObjectDB->setNama($nama);
			$tempObjectDB->setNip($nip);
			$tempObjectDB->setEmail($email);
			$tempObjectDB->setNoHp($nohp);
			$tempObjectDB->setIdLine($idline);
			if(!$controlPekerja->tryUpdate($tempObjectDB)) $this->errorCore("terjadi kesalahan saat merubah informasi diri");
			$this->trueCore("berhasil merubah inpformasi diri");
		}else if($this->loginFilter->isLogin($this->sekolah)){			
			$namas = $this->isNullPost('namas',"nama sekolah harus diisi");
			$emails = $this->isNullPost('emails',"email sekolah harus diisi");
			$nohps = $this->isNullPost('nohps',"no handphone sekolah harus diisi");
			$alamats = $this->inputJaservFilter->stringFiltering($this->isNullPost('alamats',"alamat sekolah harus diisi"));
			$kodes = $this->inputJaservFilter->stringFiltering($this->isNullPost('kodes',"kode sekolah harus diisi"));
			$aktor = $this->sekolah;
			$identifiedActive = $this->loginFilter->getIdentifiedActive();
			$temp = $this->inputJaservFilter->nameSchoolFiltering($nama); //nama sekolah
			if(!$temp[0]) $this->errorCore($temp[1]);
			$aktor->initial($this->inputJaservFilter);
			$temp = $aktor->getCheckName($nama,1); //nama kepsek
			if(!$temp[0]) $this->errorCore($temp[1]);
			$temp = $aktor->getCheckEmail($email,1); //wmail kepsek
			if(!$temp[0]) $this->errorCore($temp[1]);
			$temp = $aktor->getCheckEmail($emails,1); //wmail sekolah
			if(!$temp[0]) $this->errorCore($temp[1]);
			$temp = $aktor->getCheckNip($nip,1);
			if(!$temp[0]) $this->errorCore($temp[1]);	
			$temp = $aktor->getCheckNuTelphone($nohp,1);//no hp kepsek	
			if(!$temp[0]) $this->errorCore($temp[1]);	
			$temp = $aktor->getCheckNuTelphone($nohps,1);//no hp sekolah
			if(!$temp[0]) $this->errorCore($temp[1]);
			$this->loadLib("ControlPekerja");
			$this->loadLib("ControlSekolah");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			
			$tempObjectDBS = $controlSekolah->isAvailableThisNamaSekolah($identifiedActive,$namas);
			
			if($tempObjectDBS && $tempObjectDBS->getNextCursor()){
				$this->errorCore("nama sekolah ini sudah tersedia di tempat lain");
			}
			$tempObjectDB =  $controlSekolah->getAllData($identifiedActive);
			$tempObjectDB->getNextCursor();
			
			$tempObjectDB = $controlPekerja->getAllData($tempObjectDB->getKepSek());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			$tempObjectDBS->setIdentified($identifiedActive);
			$tempObjectDBS->setKode($kodes);
			$tempObjectDBS->setNama($namas);
			$tempObjectDBS->setAlamat($alamats);
			$tempObjectDBS->setNoHp($nohps);
			$tempObjectDBS->setEmail($emails);
			//echo "ll";
			if(!$controlSekolah->tryUpdate($tempObjectDBS)) $this->errorCore("Gagal merupah data sekolah");
			//echo "nn";
			$tempObjectDB->setNama($nama);
			$tempObjectDB->setNip($nip);
			$tempObjectDB->setEmail($email);
			$tempObjectDB->setNoHp($nohp);
			$tempObjectDB->setIdLine($idline);
			if(!$controlPekerja->tryUpdate($tempObjectDB)) $this->errorCore("terjadi kesalahan saat merubah informasi diri");
			$this->trueCore("berhasil merubah inpformasi diri");
		}else if($this->loginFilter->isLogin($this->worker)){
			$aktor = $this->worker;
			$identifiedActive = $this->loginFilter->getIdentifiedActive();
			$aktor->initial($this->inputJaservFilter);
			$temp = $aktor->getCheckName($nama,1);
			if(!$temp[0]) $this->errorCore($temp[1]);
			$temp = $aktor->getCheckEmail($email,1);
			if(!$temp[0]) $this->errorCore($temp[1]);
			$temp = $aktor->getCheckNip($nip,1);
			if(!$temp[0]) $this->errorCore($temp[1]);			
			$temp = $aktor->getCheckNuTelphone($nohp,1);
			if(!$temp[0]) $this->errorCore($temp[1]);
			$this->loadLib("ControlPekerja");
			$this->loadLib("ControlGuru");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$controlGuru = new ControlGuru($this->gateControlModel);
			$tempObjectDB = $controlPekerja->getAllData($identifiedActive);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) $this->errorCore("anda melakukan debugging");
			
			
			
			$tempObjectDBD = $controlPekerja->getDataByNip($nip);
			$allow = true;
			if($tempObjectDBD){
				while($tempObjectDBD->getNextCursor()){
					if($identifiedActive != $tempObjectDBD->getIdentified()){
						$tempObjectDBT = $controlGuru->getAllData($this->loginFilter->getSekolah(),$tempObjectDBD->getIdentified());
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							$allow=false;
						}	
					}
				}
			}
			if(!$allow) $this->errorCore("nip ini sudah menjadi guru disekolah");
			
			
			
			$tempObjectDB->setNama($nama);
			$tempObjectDB->setNip($nip);
			$tempObjectDB->setEmail($email);
			$tempObjectDB->setNoHp($nohp);
			$tempObjectDB->setIdLine($idline);
			if(!$controlPekerja->tryUpdate($tempObjectDB)) $this->errorCore("terjadi kesalahan saat merubah informasi diri");
			$this->trueCore("berhasil merubah inpformasi diri");
		}else{
			$this->reloadCore();
		}
	}
}