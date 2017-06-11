<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Setting
*/
class Wali extends CI_Controller_Modified {
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
		$tempObjectDB = null;
		$tempObjectDBD = null;
		$kode=1;
		$allow=true;
		$tempObjectDBT = false;
		if($this->loginFilter->isLogin($this->owner)){
			$allow=false;
			$this->loadLib("ControlSekolah");
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDB = $controlSekolah->getAllData(null,1);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$allow=false;
			$kode=2;
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
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$kode=3;
		}else{
			$this->reloadCore();
		}
        //$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        //if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
        $this->trueCore("",true);
        $this->load->view("wali",array(
			"kode" => $kode,
            "baseUrl" => base_url(),
			"sekolah" => $tempObjectDB,
			"guru"=>$tempObjectDBT,
			"allow"=> $allow,
			"header" => "Data Wali Murid"
        ));
    }
	public function listNip($identified=""){
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			if(strlen($identified) != 29) $this->errorCore("pilih sekolah yang bersangkutan");
			$identified = substr($identified,3,strlen($identified));
			$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
		}else{
			$this->reloadCore();
		}
		$this->loadLib("ControlSekolah");
		$controlSekolah = new ControlSekolah($this->gateControlModel);
		$tempObjectDB = $controlSekolah->getAllData($identified,1);
		//check if school exist
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			$this->errorCore("sekolah tidak terdaftar");
		}
		
		$this->loadLib("ControlPekerja");
		$this->loadLib("ControlWali");
		$controlWali = new ControlWali($this->gateControlModel);
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		$tempObjectDBE = $controlWali->getAllData($identified);
		$data=array();
		$i=0;
		while($tempObjectDBE && $tempObjectDBE->getNextCursor()){
			$tempObjectDBL = $controlPekerja->getAllData($tempObjectDBE->getPekerja());
			if($tempObjectDBL && $tempObjectDBL->getNextCursor()){
				//$data.= '"'.$tempObjectDBL->getNip().'",';
				$data[$i]=$tempObjectDBL->getNip();
				$i++;
			}
		}
		/* if($data != ""){
			$data[strlen($data)-1]="";
		} */
		$this->trueCore("",true);
		//echo "[".$data."]";
		echo json_encode($data);
	}
	public function getDataByNip($identified=""){
		/* $_POST['nama']="SCH7C04D11E00SWEANAB201F24G17";*/
		//$_POST['nip']="1928374657829387987"; 
		//$this->trueCore($identified." ");
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			if(strlen($identified) != 29) $this->errorCore(json_encode(
			array(
				"disable"=>false
			)));
			$identified = substr($identified,3,strlen($identified));
			$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
		}else{
			$this->reloadCore();
		}
		$this->loadLib("ControlSekolah");
		$controlSekolah = new ControlSekolah($this->gateControlModel);
		$tempObjectDB = $controlSekolah->getAllData($identified,1);
		//check if school exist
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			$this->trueCore(json_encode(
			array(
				"disable"=>false
			)));
		}
		$nip = $this->isNullPost('nip',"nip harus diisi");
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
		$temp = $aktor->getCheckNip($nip,1);
		if(!$temp[0]) $this->trueCore(json_encode(
			array(
				"disable"=>false
			)));
		
		
		
		$this->loadLib("ControlPekerja");
		$this->loadLib("ControlWali");
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		$controlWali = new ControlWali($this->gateControlModel);
		$tempObjectDBT = $controlPekerja->getDataByNip($nip);
		$data = json_encode(
			array(
				"disable"=>false
			)
		);
		if($tempObjectDBT){
			while($tempObjectDBT->getNextCursor()){
				if($tempObjectDB->getKepSek() != $tempObjectDBT->getIdentified()){
					//echo $identified." ".$tempObjectDBT->getIdentified()." ".$tempObjectDBT->getNip()."<br>";
					$tempObjectDBE = $controlWali->getAllData($identified,$tempObjectDBT->getIdentified());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$addNew=false;
						$data = json_encode(
							array(
								"disable"=>true,
								"nama"=>$tempObjectDBT->getNama(),
								"email"=>$tempObjectDBT->getEmail(),
								"idline"=>$tempObjectDBT->getIdLine(),
								"nohp"=>$tempObjectDBT->getNoHp()
							)
						);
					}
				}
			}
		}
		$this->trueCore("",true);
		echo $data;
	}
	public function getListGuru($head=null){
		if(!is_null($head)){
			if($head!= 'no') $head = null;
		}
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
			"guru"=>$data,
			"no"=>$head
        ));
	}
//	public function get
	public function add(){
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
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			$identified = $this->isNullPost('nama',"Sekolah tidak boleh kosong");
			if(strlen($identified) != 29) $this->errorCore("pilih sekolah yang bersangkutan");
			$identified = substr($identified,3,strlen($identified));
			$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
			//Guru
			$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
			$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
			$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
			//Guru
			$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
			$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
			$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6);
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
			$identifiedGuru = $this->loginFilter->getIdentifiedActive();
		}else{
			$this->reloadCore();
		}
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
		$tempObjectDBD = $controlGuru->getAllData($identified,$identifiedGuru,1);
		//check if teach exist
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			$this->errorCore("Guru tidak terdaftar");
		}
		//filter kontent
		$wali = $this->isNullPost('wali',"nama wali tidak boleh kosong");
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
		$temp = $aktor->getCheckName($wali,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		
		$temp = $aktor->getCheckNip($nip,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		$temp = $aktor->getCheckEmail($email,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		
		$temp = $aktor->getCheckNuTelphone($nohp,1);
		if(!$temp[0]) $this->errorCore($temp[1]);
		$this->loadLib("ControlPengguna");
		$this->loadLib("ControlPekerja");
		$this->loadLib("ControlWali");
		$this->loadLib("ControlRoom");
		$controlPengguna = new ControlPengguna($this->gateControlModel);
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		$controlWali = new ControlWali($this->gateControlModel);
		$controlRoom = new ControlRoom($this->gateControlModel);
		$tempObjectDBT = $controlPekerja->getDataByNip($nip);
		//addNewWorker
		$addNew = true;
		$isWithThisTeacher = false;
		$tempObjectDBE=null;
		$isSekolah=false;
		$tempIdForAvailable="";
		if($tempObjectDBT){
			while($tempObjectDBT->getNextCursor()){
				if($tempObjectDB->getKepSek() != $tempObjectDBT->getIdentified()){
					//echo $identified." ".$tempObjectDBT->getIdentified()." ".$tempObjectDBT->getNip()."<br>";
					$tempObjectDBE = $controlWali->getAllData($identified,$tempObjectDBT->getIdentified());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$addNew=false;
						$tempIdForAvailable = $tempObjectDBT->getIdentified(); 
					}
					$tempObjectDBL = $controlRoom->getAllData($identifiedGuru,$tempObjectDBT->getIdentified());
					if($tempObjectDBL && $tempObjectDBL->getNextCursor()){
						$isWithThisTeacher = true;
					}
				}
			}
		}
		
		if($isWithThisTeacher){
			$this->errorCore("maaf nip ini sudah masuk kedalam ruang guru ini");
		}
		if($addNew){
			$identifiedWali = $controlPengguna->generateIdentified(3);
			$nick = "WALI-".date("Ymd-His");
			$nickName = $this->loginFilter->getHashNickName($nick);
			$key = "W".substr(date("Y"),0,2)."A".substr(date("Y"),2,2)."L".date("m")."I".date("d")."l".date("H")."a".date("i")."w".date("s");
			$keyPass = $this->loginFilter->getHashKeyWord($key);
			$emailCI = $this->loadLib("ControlEmail",true);
			$emailCI->pushTarget($email);
			$emailCI->addSubject("Permintaan pembuatan Akun");
			$emailCI->addMessageByView("Accountwali.html",array(
				"nama"=>$tempObjectDB->getNama(),
				"nickname" => $nick,
				"keypass" => $key,
				"url" => base_url(),
				"kepsek" => $wali,
				"hari" => date("Y m d")." Pukul ".date("H:i:s")
			));
			
			//not connect to internet, 
			//$result = $emailCI->send();
			//exit($emailCI->getMessage());
			$result = true;
			if(!$result){
				$this->errorCore("email tidak valid");
			}
			//add username and password
			$tempObjectDB = $controlPengguna->getObject();
			$tempObjectDB->setIdentified($identifiedWali);
			$tempObjectDB->setNickName($nickName);
			$tempObjectDB->setKeyWord($keyPass);
			if(!$controlPengguna->addData($tempObjectDB)){
				$this->errorCore("gagal menambahkan wali");
			}
			//add informasi of worker
			$tempObjectDB = $controlPekerja->getObject();
			$tempObjectDB->setIdentified($identifiedWali);
			$tempObjectDB->setNama($wali);
			$tempObjectDB->setNip($nip);
			$tempObjectDB->setEmail($email);
			$tempObjectDB->setNoHp($nohp);
			$tempObjectDB->setIdLine($idline);
			if(!$controlPekerja->addData($tempObjectDB)){
				$controlPengguna->removeByIdentified($identifiedWali);
				$this->errorCore("gagal menambahkan wali");
			}
			//add status wali on this school
			$tempObjectDB = $controlWali->getObject();
			$tempObjectDB->setSekolah($identified);
			$tempObjectDB->setPekerja($identifiedWali);
			if(!$controlWali->addData($tempObjectDB)){
				$controlPengguna->removeByIdentified($identifiedWali);
				$controlPekerja->removeByIdentified($identifiedWali);
				$this->errorCore("gagal menambahkan wali");
			}
			//add room for this teach
			$tempObjectDB = $controlRoom->getObject();
			$tempObjectDB->setGuru($identifiedGuru);
			$tempObjectDB->setPekerja($identifiedWali);
			if(!$controlRoom->addData($tempObjectDB)){
				$controlPengguna->removeByIdentified($identifiedWali);
				$controlPekerja->removeByIdentified($identifiedWali);
				$controlWali->removeByIdentified($identified, $identifiedWali);
				$this->errorCore("gagal menambahkan Wali");
			}
			$this->trueCore("Berhasil menambahkan Wali");
		}else{
			//add room for this teach
			$tempObjectDB = $controlRoom->getObject();
			$tempObjectDB->setGuru($identifiedGuru);
			$tempObjectDB->setPekerja($tempIdForAvailable);
			if(!$controlRoom->addData($tempObjectDB)){
				$this->errorCore("gagal menambahkan Wali");
			}
			$this->trueCore("Berhasil menambahkan Wali");
		}
	}/* 
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
		
	} */
}