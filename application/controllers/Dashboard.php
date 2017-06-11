<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Setting
*/
class Dashboard extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
        $this->loadHel("Url");
		$this->loadHel("Html");
		$this->loadMod('GateControlModel');
		$this->loadLib('LoginFilter');
		$this->loadLib('Inputjaservfilter');
		$this->loadLib('Datejaservfilter');
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->dateJaservFilter = new Datejaservfilter();
		$this->load->library('Session');
		$this->gateControlModel = new GateControlModel();
		$this->loginFilter = new LoginFilter($this->session, $this->gateControlModel);
		$this->load->library('Aktor/Worker');
		$this->load->library('Aktor/Owner');
		$this->load->library('Aktor/Sekolah');
        $this->tempRequestUrl = strtolower($_SERVER['REQUEST_URI']);
		if(strpos($this->tempRequestUrl,'.jsp') === false) header("location:".base_url());
    }
	public function getListData($section=null){
		if(is_null($section)){
			$this->errorCore("Maaf Anda melakukan debugging");
		}
		//$_POST['keyword'] = "";
		//$kodeForm = $this->isNullPost('kodeForm',"anda melakukan debugging");
        //if($kodeForm != 'J453RVT3CH@W3N4@FORM') $this->errorCore("token diperlukan");
		$identified = "";
		$waliFilter = false;
		$ownerFilter = false;
		$identifiedGuru = "";
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			$ownerFilter = true;
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
			/* //Guru
			$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
			$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru));
			$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); */
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
		}elseif($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isWali()){
			$waliFilter=true;
			$identified  = $this->loginFilter->getSekolah();
		}else{
			$this->reloadCore();
		}
		
		$keyword = $this->isNullPost("keyword","anda melakukan debugging");
		if($keyword == "" || $keyword == " ") $keyword = '*';
		$this->loadLib("ControlSekolah");
		$controlSekolah = new ControlSekolah($this->gateControlModel);
		if(!$ownerFilter){
			$tempObjectDB = $controlSekolah->getAllData($identified,1);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
				$this->errorCore("sekolah tidak terdaftar");
			}
		}
		
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
			$all=null;
			$kode = false;
			break;
			case 'listOfPlan' :
			$all=1;
			$kodeD="planning";
			break;
			case 'doingOfPlan' :
			$all=2;
			$kodeD="on doing";
			break;
			case 'delayOfPlan' :
			$all=3;
			$kodeD="on delaying";
			break;
			case 'dissmisOfPlan' :
			$all=4;
			$kodeD="on fail";
			break;
			case 'finishOfPlan' :
			$all=5;
			$kodeD="on finish";
			break;
		}
		if($ownerFilter){
			$tempObjectDB = $controlListToDo->getObject();
			$tempObjectDBT = $controlListToDo->getByAuthor($this->loginFilter->getIdentifiedActive(),$all);
			if($tempObjectDBT)
				$tempObjectDB->concateTempValueWithThisClass($tempObjectDBT);
			$tempObjectDBL = $controlSekolah->getAllData(null,1);
			if($tempObjectDBL){
				while($tempObjectDBL->getNextCursor()){
					//echo $tempObjectDBL->getIdentified()."<br>";
					
					$tempObjectDBS = $controlListToDo->getBySchool($tempObjectDBL->getIdentified(),$all);
					if($tempObjectDBS)
						$tempObjectDB->concateTempValueWithThisClass($tempObjectDBS);

				}
			}
			//exit("ssss");
		}else if($waliFilter){
			$tempObjectDB = $controlListToDo->getObject();
			$this->loadLib('ControlRoom');
			$controlRoom = new ControlRoom($this->gateControlModel);
			//echo  $this->loginFilter->getIdentifiedActive();
			$tempObjectDBD = $controlRoom->getAllData(null, $this->loginFilter->getIdentifiedActive(),1);
			//echo $tempObjectDBD->getCountData();
			if($tempObjectDBD){
				while($tempObjectDBD->getNextCursor()){
					$tempObjectDBT = $controlListToDo->getByAuthor($tempObjectDBD->getGuru(),$all);
					if($tempObjectDBT)
						$tempObjectDB->concateTempValueWithThisClass($tempObjectDBT);
				}
			}
		}else{			
			$tempObjectDB = $controlListToDo->getBySchool($identified,$all);
			$this->loadLib("ControlPengguna");
			$idAdminCreative = (new ControlPengguna($this->gateControlModel))->getIdentifiedAdminCreative();
			if($idAdminCreative){
				$tempObjectDBT = $controlListToDo->getByAuthor($idAdminCreative,$all);
				if($tempObjectDBT)
					$tempObjectDB->concateTempValueWithThisClass($tempObjectDBT);
			}
		}
		
		$this->loadLib("ControlPekerja");
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		$data['jumlah']=0;
		if($tempObjectDB){
			$tempObjectDB->sortByCoulumn('uptime');
			while($tempObjectDB->getNextCursor()){
				if($keyword == "*" || !is_bool(strpos(strtolower($tempObjectDB->getTitle()),strtolower($keyword)))){
					$data['jumlah']+=1;
					$schId = $tempObjectDB->getIdentified();
					$data[$data['jumlah']]['id'] = "MESSAGE".substr($schId,10,10)."".substr($schId,0,10)."".substr($schId,20,6);
					$data[$data['jumlah']]['judul'] = $tempObjectDB->getTitle();
					$data[$data['jumlah']]['deskripsi'] = $tempObjectDB->getDeskripsi();
					
					$data[$data['jumlah']]['update'] = $this->dateJaservFilter->setDate($tempObjectDB->getLastEdit(),true)->getInformasiFromNow();
					$worker = $tempObjectDB->getGuru();
					if($worker[0] == 'O'){
						$data[$data['jumlah']]['author'] = "Admin Creative";
					}else if($worker[0] == 'S'){
						$data[$data['jumlah']]['author'] = "Kepala Sekolah";
					}else if($worker[0] == 'W'){
						$tempObjectDBT = $controlPekerja->getAllData($worker);
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							$data[$data['jumlah']]['author'] = $tempObjectDBT->getNama();
						}else{
							$data[$data['jumlah']]['author'] = "Anonymous";
						}
					}
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
	//guru
	public function addCommentOfThis(){
		//$_POST['id'] = "MESSAGE7C04D22E08MWEANAB201F53G55";
		//$_POST['comment'] = "hello ini comment nya ya ";
		$filterWali = false;
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			$identified = null;
			//Guru
			/* $identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
			$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru)-5);
			$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); */
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
			//Guru/* 
			/*$identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
			$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru)-5);
			$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); */
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
			$identifiedGuru = $this->loginFilter->getIdentifiedActive();
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isWali()){
			$identified  = $this->loginFilter->getSekolah();
			$identifiedGuru = $this->loginFilter->getIdentifiedActive();
			$filterWali = true;
		}else{
			$this->reloadCore();
		}
		$identifiedMessage = $this->isNullPost('id',"anda melakukan debugging");
		if(strlen($identifiedMessage) != 33) $this->errorCore("anda melakukan debugging");
		$content = $this->inputJaservFilter->stringFiltering($this->isNullPost('comment',"maaf anda melakukan debugging"));
		$identifiedMessage = substr($identifiedMessage,7,strlen($identifiedMessage)-7);
		$identifiedMessage = substr($identifiedMessage,10,10)."".substr($identifiedMessage,0,10)."".substr($identifiedMessage,20,6);
		//echo $identifiedMessage;
		/* $this->loadLib("ControlListToDo");
		$controlListToDo = new ControlListToDo($this->gateControlModel);
		$tempObjectDB = $controlListToDo->getAllData($identifiedMessage,$identified); */
		$this->loadLib("ControlPengguna");
		$idAdminCreative = (new ControlPengguna($this->gateControlModel))->getIdentifiedAdminCreative();		
		$this->loadLib("ControlListToDo");
		$controlListToDo = new ControlListToDo($this->gateControlModel);
		$tempObjectDB = $controlListToDo->getAllData($identifiedMessage,null);
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			if($tempObjectDB->getGuru() == $idAdminCreative){
				$tempObjectDB->resetSendRequest();
			}else{
				$tempObjectDB = $controlListToDo->getAllData($identifiedMessage,$identified);
			}
		}else
			$tempObjectDB = $controlListToDo->getAllData($identifiedMessage,$identified);
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			if($filterWali){
				$this->loadLib('ControlRoom');
				$controlRoom = new ControlRoom($this->gateControlModel);
				$tempObjectDBL = $controlRoom->getAllData($tempObjectDB->getGuru(), $this->loginFilter->getIdentifiedActive(),1);
				if(!$tempObjectDBL || !$tempObjectDBL->getNextCursor()){
					$this->errorCore("pesan ini bukan untuk anda");
				}
			}
			$tempObjectDB->setUpTime(date("Y-m-d H:i:s"));			
			$this->loadLib("ControlComListToDo");
			$controlComListToDo = new ControlComListToDo($this->gateControlModel);
			$tempObjectDBD = $controlComListToDo->getObject();
			$tempObjectDBD->setIdentified($controlComListToDo->generateIdentified());
			$tempObjectDBD->setListToDo($tempObjectDB->getIdentified());
			$tempObjectDBD->setPekerja($this->loginFilter->getIdentifiedActive());
			$tempObjectDBD->setTime(date("Y-m-d H:i:s"));
			$tempObjectDBD->setContent($content);
			if($controlComListToDo->addData($tempObjectDBD)){
				$controlListToDo->tryUpdate($tempObjectDB);
				$this->trueCore('berhasil menambahkan komentar');
			}else{
				$this->errorCore('gagal menambahkan komentar');
			}
		}else{
			$this->errorCore('even perencanaan telah dihapus');
		}
	}
	public function getCommentOfThis(){
		//$_POST['id'] = "MESSAGE7C05D12E17MWEANAB201F17G49";
		$filterWali = false;
		$filterOwner = false;
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			$filterOwner = true;
			$identified = null;
			//Guru
			/* $identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");ru
			$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru)-5);
			$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); */
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
			//Guru
			/* $identifiedGuru = $this->isNullPost('guru',"Guru tidak boleh kosong");
			if(strlen($identifiedGuru) != 31) $this->errorCore("pilih guru yang bersangkutan");
			$identifiedGuru = substr($identifiedGuru,5,strlen($identifiedGuru)-5);
			$identifiedGuru = substr($identifiedGuru,10,10)."".substr($identifiedGuru,0,10)."".substr($identifiedGuru,20,6); */
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
			$identifiedGuru = $this->loginFilter->getIdentifiedActive();
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isWali()){
			$identified  = $this->loginFilter->getSekolah();
			$identifiedGuru = $this->loginFilter->getIdentifiedActive();
			$filterWali = true;
		}else{
			$this->reloadCore();
		}
		
		$identifiedMessage = $this->isNullPost('id',"anda melakukan debugging");
		if(strlen($identifiedMessage) != 33) $this->errorCore("anda melakukan debugging");
		$identifiedMessage = substr($identifiedMessage,7,strlen($identifiedMessage)-7);
		$identifiedMessage = substr($identifiedMessage,10,10)."".substr($identifiedMessage,0,10)."".substr($identifiedMessage,20,6);
		//echo $identifiedMessage;
		
		
		$this->loadLib("ControlPengguna");
		$idAdminCreative = (new ControlPengguna($this->gateControlModel))->getIdentifiedAdminCreative();		
		$this->loadLib("ControlListToDo");
		$controlListToDo = new ControlListToDo($this->gateControlModel);
		$tempObjectDB = $controlListToDo->getAllData($identifiedMessage,null);
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			if($tempObjectDB->getGuru() == $idAdminCreative){
				$tempObjectDB->resetSendRequest();
			}else{
				$tempObjectDB = $controlListToDo->getAllData($identifiedMessage,$identified);
			}
		}else
			$tempObjectDB = $controlListToDo->getAllData($identifiedMessage,$identified);
		$arrayConf = array(
			"judul"=>"What are you looking for?",
			"author"=>"unknown",
			"update"=>"",
			"comment"=>"",
			"deskripsi"=>"",
			"jumlah"=>0,
		);
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			if($filterWali){
				$this->loadLib('ControlRoom');
				$controlRoom = new ControlRoom($this->gateControlModel);
				$tempObjectDBL = $controlRoom->getAllData($tempObjectDB->getGuru(), $this->loginFilter->getIdentifiedActive(),1);
				if(!$tempObjectDBL || !$tempObjectDBL->getNextCursor()){
					$this->errorCore("pesan ini bukan untuk anda");
				}
			}
			
			$this->loadLib("ControlPekerja");
			$this->loadLib("Datejaservfilter");
			$controlPekerja = new ControlPekerja($this->gateControlModel);
			$dateJaservFilter = new Datejaservfilter();
			$worker = $tempObjectDB->getGuru();
			if($worker[0] == 'O'){
				$arrayConf['author'] = "Admin Creative";
			}else if($worker[0] == 'S'){
				$arrayConf['author'] = "Kepala Sekolah";
			}else if($worker[0] == 'W'){
				$tempObjectDBD = $controlPekerja->getAllData($worker);
				if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
					$arrayConf['author'] = $tempObjectDBD->getNama();
				}else{
					$arrayConf['author'] = "Anonymous";
				}
			}
			$arrayConf['update'] = $dateJaservFilter->setDate($tempObjectDB->getLastEdit(),true)->getInformasiFromNow();
			$arrayConf['judul'] = $tempObjectDB->getTitle();
			$arrayConf['deskripsi'] = $tempObjectDB->getDeskripsi();
			$this->loadLib("ControlComListToDo");
			$tempObjectDBT = (new ControlComListToDo($this->gateControlModel))->getByListToDo($tempObjectDB->getIdentified());
			if($tempObjectDBT){
				$arrayConf['jumlah']=$tempObjectDBT->getCountData();
				$tempComment = array();
				$i=0;
				$tempObjectDB->sortByCoulumn('time');
				$this->loadLib('ControlGuru');
				$controlGuru = new ControlGuru($this->gateControlModel);
				while($tempObjectDBT->getNextCursor()){
					$i += 1;
					$tempComment[$i]['deskripsi'] = $tempObjectDBT->getContent();
					$tempComment[$i]['update'] = $this->dateJaservFilter->setDate($tempObjectDBT->getTime(),true)->getInformasiFromNow();
					$tempComment[$i]['author'] = "not set". $tempObjectDBT->getPekerja();
					$worker = $tempObjectDBT->getPekerja();
					
					if($worker[0] == 'O'){
						$tempComment[$i]['icon'] = 1;
						$tempComment[$i]['author'] = "Admin Creative";
					}else if($worker[0] == 'S'){
						$tempComment[$i]['icon'] = 2;
						$tempComment[$i]['author'] = "Kepala Sekolah";
					}else if($worker[0] == 'W'){
						if($controlGuru->getAllData(null, $worker, null)->getNextCursor()){
							$tempComment[$i]['icon'] = 3;
						}else{
							$tempComment[$i]['icon'] = 4;
						}
						$tempObjectDBD = $controlPekerja->getAllData($worker);
						if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
							$tempComment[$i]['author'] = $tempObjectDBD->getNama();
						}else{
							$tempComment[$i]['author'] = "Anonymous";
						}
					}
					if($worker == $this->loginFilter->getIdentifiedActive()) $tempComment[$i]['icon'] = 5;
				}
				$arrayConf['comment']=$tempComment;
			}
		}else{
			$this->errorCore('even perencanaan telah dihapus');
		}
		$this->trueCore("",true);
		$this->load->view("evencomment",$arrayConf);
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