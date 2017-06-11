<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."controllers/CI_Controller_Modified.php";
/*
	Namaclass : Globe
*/
class Globe extends CI_Controller_Modified {
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
	public function Index(){
		if(strpos($this->tempRequestUrl,'index') !== false) header("location:".base_url());
		if($this->loginFilter->isLogin($this->owner)){
			$this->loadLib("ControlSekolah");
			$controlSekolah = new ControlSekolah($this->gateControlModel);
			$tempObjectDB = $controlSekolah->getAllData(null,1);
		}else if($this->loginFilter->isLogin($this->sekolah)){
			$kode=2;
			$this->loadLib("ControlGuru");
			$controlGuru = new ControlGuru($this->gateControlModel);
			$tempObjectDBD = $controlGuru->getAllData($identified,null,1);
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$kode=3;
		}else{
			$this->reloadCore();
		}
	}
	protected function getDataOwner(){
		
	}
	//get nummber 
	public function getListItem($identified=""){
		//$_POST['kode'] = '1';
		//$_POST['key'] = '';
		//$_POST['keypage'] = '1';
		//<--
		$previous = 0;
		$next = 0;
		$s = true;
		$n = 1;
		$z = 1;
		$koko = 0;
		$trueCon = false;
		$tempD = null;
		$total=0;
		//<--
		$kode = intval($this->isNullPost('kode',"Anda melakukan debugging"));
		//filterkeypage
		$keyPage = intval($this->isNullPost('keypage',"Anda melakukan debugging"));
		$keyPage = intval($keyPage);
		if($keyPage <= 0){
			$keyPage = 1;
		}
		//filter kode
		if($kode < 1 || $kode > 5){
			$this->errorCore("Maaf anda meakukan debugging");
		}
		$key = $this->isNullPost('key',"Anda Melakukan debugging");
		$this->loadLib("ControlSekolah");
		$this->loadLib("ControlGuru");
		$this->loadLib("ControlPekerja");
		$this->loadLib("ControlRoom");
		$this->loadLib("ControlWali");
		$controlSekolah = new ControlSekolah($this->gateControlModel);
		$controlGuru = new ControlGuru($this->gateControlModel);
		$controlRoom = new ControlRoom($this->gateControlModel);
		$controlWali = new ControlWali($this->gateControlModel);
		$controlPekerja = new ControlPekerja($this->gateControlModel);
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			if($identified != ""){
				if(strlen($identified) == 29){
					$identified = substr($identified,3,strlen($identified));
					$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
				}else{
					$identified = "";
				}
			}
			$tempObjectDB=null;
			if($identified == ""){
				$tempObjectDB = $controlSekolah->getAllData();
			}else{
				$tempObjectDB = $controlSekolah->getAllData($identified);
			}
			while($tempObjectDB && $tempObjectDB->getNextCursor()){
				if($kode == 1 || $kode == 2){
					if($key == "" || !is_bool(strpos(strtolower($tempObjectDB->getNama()),strtolower($key)))){
						$tempObjectDBD = $controlPekerja->getAllData($tempObjectDB->getKepSek());
						$tempObjectDBD->getNextCursor();
						$total+=1;
						if($n <= 8 && $z == $keyPage){
							$trueCon;
							if($s){
								$tempD = array(
									"id" => array('SCH'.substr($tempObjectDB->getIdentified(),10,10)."".substr($tempObjectDB->getIdentified(),0,10)."".substr($tempObjectDB->getIdentified(),20,6)),
									"name" => array($tempObjectDB->getNama()),
									"notelp" => array($tempObjectDBD->getNoHp()),
									"email" => array($tempObjectDBD->getEmail()),
									"idline" => array($tempObjectDBD->getIdLine())
								);
								$s = false;
							}else{
								$tempY = array(
									"id" => array('SCH'.substr($tempObjectDB->getIdentified(),10,10)."".substr($tempObjectDB->getIdentified(),0,10)."".substr($tempObjectDB->getIdentified(),20,6)),
									"name" => array($tempObjectDB->getNama()),
									"notelp" => array($tempObjectDBD->getNoHp()),
									"email" => array($tempObjectDBD->getEmail()),
									"idline" => array($tempObjectDBD->getIdLine())
								);
								$tempD['id'] = array_merge($tempD['id'],$tempY['id']);
								$tempD['name'] = array_merge($tempD['name'],$tempY['name']);
								$tempD['notelp'] = array_merge($tempD['notelp'],$tempY['notelp']);
								$tempD['email'] = array_merge($tempD['email'],$tempY['email']);
								$tempD['idline'] = array_merge($tempD['idline'],$tempY['idline']);
							}
							$koko ++;
							$n++;
						}else if($n == 8 && $z < $keyPage){
							$n = 1;
							$z++;
						}else{
							$n++;
						}
					}
				}
				if($kode == 1 || $kode == 3){
					$tempObjectDBD = $controlGuru->getAllData($tempObjectDB->getIdentified());
					while($tempObjectDBD && $tempObjectDBD->getNextCursor()){
						$tempObjectDBT = $controlPekerja->getAllData($tempObjectDBD->getPekerja());
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							if($key == "" || !is_bool(strpos(strtolower($tempObjectDBT->getNama()),strtolower($key)))){
								$total+=1;
								if($n <= 8 && $z == $keyPage){
									$trueCon;
									if($s){
										$tempD = array(
											"id" => array('TEACH'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$s = false;
									}else{
										$tempY = array(
											"id" => array('TEACH'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$tempD['id'] = array_merge($tempD['id'],$tempY['id']);
										$tempD['name'] = array_merge($tempD['name'],$tempY['name']);
										$tempD['notelp'] = array_merge($tempD['notelp'],$tempY['notelp']);
										$tempD['email'] = array_merge($tempD['email'],$tempY['email']);
										$tempD['idline'] = array_merge($tempD['idline'],$tempY['idline']);
									}
									$koko ++;
									$n++;
								}else if($n == 8 && $z < $keyPage){
									$n = 1;
									$z++;
								}else{
									$n++;
								}
							}
						}
					}
				}
				if($kode == 1 || $kode == 4){
					$tempObjectDBD = $controlWali->getAllData($tempObjectDB->getIdentified());
					while($tempObjectDBD && $tempObjectDBD->getNextCursor()){
						$tempObjectDBT = $controlPekerja->getAllData($tempObjectDBD->getPekerja());
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							if($key == "" || !is_bool(strpos(strtolower($tempObjectDBT->getNama()),strtolower($key)))){
								$total+=1;
								if($n <= 8 && $z == $keyPage){
									$trueCon;
									if($s){
										$tempD = array(
											"id" => array('PARENT'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$s = false;
									}else{
										$tempY = array(
											"id" => array('PARENT'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$tempD['id'] = array_merge($tempD['id'],$tempY['id']);
										$tempD['name'] = array_merge($tempD['name'],$tempY['name']);
										$tempD['notelp'] = array_merge($tempD['notelp'],$tempY['notelp']);
										$tempD['email'] = array_merge($tempD['email'],$tempY['email']);
										$tempD['idline'] = array_merge($tempD['idline'],$tempY['idline']);
									}
									$koko ++;
									$n++;
								}else if($n == 8 && $z < $keyPage){
									$n = 1;
									$z++;
								}else{
									$n++;
								}
							}
						}
					}
				}
			}
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
			$tempObjectDB = $controlSekolah->getAllData($identified);
			
			$i = 0;
			$data = array();
			while($tempObjectDB && $tempObjectDB->getNextCursor()){
				if($kode == 1 || $kode == 3){
					$tempObjectDBD = $controlGuru->getAllData($tempObjectDB->getIdentified());
					while($tempObjectDBD && $tempObjectDBD->getNextCursor()){
						$tempObjectDBT = $controlPekerja->getAllData($tempObjectDBD->getPekerja());
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							if($key == "" || !is_bool(strpos(strtolower($tempObjectDBT->getNama()),strtolower($key)))){
								
								$total+=1;
								if($n <= 8 && $z == $keyPage){
									$trueCon;
									if($s){
										$tempD = array(
											"id" => array('TEACH'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$s = false;
									}else{
										$tempY = array(
											"id" => array('TEACH'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$tempD['id'] = array_merge($tempD['id'],$tempY['id']);
										$tempD['name'] = array_merge($tempD['name'],$tempY['name']);
										$tempD['notelp'] = array_merge($tempD['notelp'],$tempY['notelp']);
										$tempD['email'] = array_merge($tempD['email'],$tempY['email']);
										$tempD['idline'] = array_merge($tempD['idline'],$tempY['idline']);
									}
									$koko ++;
									$n++;
								}else if($n == 8 && $z < $keyPage){
									$n = 1;
									$z++;
								}else{
									$n++;
								}
							}
						}
					}
				}
				if($kode == 1 || $kode == 4){
					$tempObjectDBD = $controlWali->getAllData($tempObjectDB->getIdentified());
					while($tempObjectDBD && $tempObjectDBD->getNextCursor()){
						$tempObjectDBT = $controlPekerja->getAllData($tempObjectDBD->getPekerja());
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							if($key == "" || !is_bool(strpos(strtolower($tempObjectDBT->getNama()),strtolower($key)))){
								$total+=1;
								if($n <= 8 && $z == $keyPage){
									$trueCon;
									if($s){
										$tempD = array(
											"id" => array('PARENT'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$s = false;
									}else{
										$tempY = array(
											"id" => array('PARENT'.substr($tempObjectDBT->getIdentified(),10,10)."".substr($tempObjectDBT->getIdentified(),0,10)."".substr($tempObjectDBT->getIdentified(),20,6)),
											"name" => array($tempObjectDBT->getNama()),
											"notelp" => array($tempObjectDBT->getNoHp()),
											"email" => array($tempObjectDBT->getEmail()),
											"idline" => array($tempObjectDBT->getIdLine())
										);
										$tempD['id'] = array_merge($tempD['id'],$tempY['id']);
										$tempD['name'] = array_merge($tempD['name'],$tempY['name']);
										$tempD['notelp'] = array_merge($tempD['notelp'],$tempY['notelp']);
										$tempD['email'] = array_merge($tempD['email'],$tempY['email']);
										$tempD['idline'] = array_merge($tempD['idline'],$tempY['idline']);
									}
									$koko ++;
									$n++;
								}else if($n == 8 && $z < $keyPage){
									$n = 1;
									$z++;
								}else{
									$n++;
								}
							}
						}
					}
				}
			}
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
			$tempObjectDB = $controlSekolah->getAllData($identified);
			
			$i = 0;
			$data = array();
			if($tempObjectDB && $tempObjectDB->getNextCursor()){
				if($kode == 4){
					$tempObjectDBD = $controlWali->getAllData($tempObjectDB->getIdentified());
					while($tempObjectDBD && $tempObjectDBD->getNextCursor()){
						$tempObjectDBT = $controlRoom->getAllData($this->loginFilter->getIdentifiedActive(),$tempObjectDBD->getPekerja());
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							$tempObjectDBE = $controlPekerja->getAllData($tempObjectDBD->getPekerja());
							if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
								if($key == "" || !is_bool(strpos(strtolower($tempObjectDBE->getNama()),strtolower($key)))){
									$total+=1;
									if($n <= 8 && $z == $keyPage){
										$trueCon;
										if($s){
											$tempD = array(
												"id" => array('PARENT'.substr($tempObjectDBE->getIdentified(),10,10)."".substr($tempObjectDBE->getIdentified(),0,10)."".substr($tempObjectDBE->getIdentified(),20,6)),
												"name" => array($tempObjectDBE->getNama()),
												"notelp" => array($tempObjectDBE->getNoHp()),
												"email" => array($tempObjectDBE->getEmail()),
												"idline" => array($tempObjectDBE->getIdLine())
											);
											$s = false;
										}else{
											$tempY = array(
												"id" => array('PARENT'.substr($tempObjectDBE->getIdentified(),10,10)."".substr($tempObjectDBE->getIdentified(),0,10)."".substr($tempObjectDBE->getIdentified(),20,6)),
												"name" => array($tempObjectDBE->getNama()),
												"notelp" => array($tempObjectDBE->getNoHp()),
												"email" => array($tempObjectDBE->getEmail()),
												"idline" => array($tempObjectDBE->getIdLine())
											);
											$tempD['id'] = array_merge($tempD['id'],$tempY['id']);
											$tempD['name'] = array_merge($tempD['name'],$tempY['name']);
											$tempD['notelp'] = array_merge($tempD['notelp'],$tempY['notelp']);
											$tempD['email'] = array_merge($tempD['email'],$tempY['email']);
											$tempD['idline'] = array_merge($tempD['idline'],$tempY['idline']);
										}
										$koko ++;
										$n++;
									}else if($n == 8 && $z < $keyPage){
										$n = 1;
										$z++;
									}else{
										$n++;
									}
								}
							}
						}
					}
				}
			}
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isWali()){
			$room = 0;
			$tempObjectDBT = $controlRoom->getAllData(null,$this->loginFilter->getIdentifiedActive(),1);
			while($tempObjectDBT && $tempObjectDBT->getNextCursor()){
				$tempObjectDBE = $controlGuru->getAllData($this->loginFilter->getSekolah(),$tempObjectDBT->getGuru());
				if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
					$tempObjectDBL = $controlPekerja->getAllData($tempObjectDBT->getGuru());
					if($tempObjectDBL && $tempObjectDBL->getNextCursor()){
						if($key == "" || !is_bool(strpos(strtolower($tempObjectDBL->getNama()),strtolower($key)))){
							$total+=1;
							if($n <= 8 && $z == $keyPage){
								$trueCon;
								if($s){
									$tempD = array(
										"id" => array('TEACH'.substr($tempObjectDBL->getIdentified(),10,10)."".substr($tempObjectDBL->getIdentified(),0,10)."".substr($tempObjectDBL->getIdentified(),20,6)),
										"name" => array($tempObjectDBL->getNama()),
										"notelp" => array($tempObjectDBL->getNoHp()),
										"email" => array($tempObjectDBL->getEmail()),
										"idline" => array($tempObjectDBL->getIdLine())
									);
									$s = false;
								}else{
									$tempY = array(
										"id" => array('TEACH'.substr($tempObjectDBL->getIdentified(),10,10)."".substr($tempObjectDBL->getIdentified(),0,10)."".substr($tempObjectDBL->getIdentified(),20,6)),
										"name" => array($tempObjectDBL->getNama()),
										"notelp" => array($tempObjectDBL->getNoHp()),
										"email" => array($tempObjectDBL->getEmail()),
										"idline" => array($tempObjectDBL->getIdLine())
									);
									$tempD['id'] = array_merge($tempD['id'],$tempY['id']);
									$tempD['name'] = array_merge($tempD['name'],$tempY['name']);
									$tempD['notelp'] = array_merge($tempD['notelp'],$tempY['notelp']);
									$tempD['email'] = array_merge($tempD['email'],$tempY['email']);
									$tempD['idline'] = array_merge($tempD['idline'],$tempY['idline']);
								}
								$koko ++;
								$n++;
							}else if($n == 8 && $z < $keyPage){
								$n = 1;
								$z++;
							}else{
								$n++;
							}
						}
					}
				}
			}
		}else{
			$this->reloadCore();
		}
		if($keyPage == 1){
			if($koko == 8){
				$previous = 0;
				$next = 1;
			}else{
				$previous = 0;
				$next = 0;
			}
		}else{
			if($koko == 8){
				$previous = 1;
				$next = 1;
			}else{
				$previous = 1;
				$next = 0;
			}
		}
		$this->trueCore("",true);
		if(is_null($tempD)){
			echo json_encode(array(
				"next" => $next,
				"previous" => $previous,
				"data" => "",
				"result" => 0
			));
		}else{
			echo json_encode(array(
				"next" => $next,
				"previous" => $previous,
				"data" => $tempD,
				"result" => $total
			));
		}
	}
	public function getCoulumn($identified=""){
		$this->loadLib("ControlSekolah");
		$this->loadLib("ControlGuru");
		$this->loadLib("ControlRoom");
		$this->loadLib("ControlWali");
		$controlSekolah = new ControlSekolah($this->gateControlModel);
		$controlGuru = new ControlGuru($this->gateControlModel);
		$controlRoom = new ControlRoom($this->gateControlModel);
		$controlWali = new ControlWali($this->gateControlModel);
		if($this->loginFilter->isLogin($this->owner)){
			//Sekolah
			if($identified != ""){
				if(strlen($identified) == 29){
					$identified = substr($identified,3,strlen($identified));
					$identified = substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);
				}else{
					$identified = "";
				}
			}
			$tempObjectDB=null;
			if($identified == ""){
				$tempObjectDB = $controlSekolah->getAllData();
			}else{
				$tempObjectDB = $controlSekolah->getAllData($identified);
			}
			$kepalasekolah = $tempObjectDB->getCountData();
			$guru=0;
			$wali=0;
			while($tempObjectDB && $tempObjectDB->getNextCursor()){
				$tempObjectDBD = $controlGuru->getAllData($tempObjectDB->getIdentified());
				$guru += $tempObjectDBD->getCountData();
				$tempObjectDBD = $controlWali->getAllData($tempObjectDB->getIdentified());
				$wali += $tempObjectDBD->getCountData();
			}
			$this->trueCore("",true);
			echo json_encode(array(
				"all"=>($kepalasekolah + $guru + $wali),
				"kepsek" => $kepalasekolah,
				"guru" => $guru,
				"wali" => $wali
			));
		}else if($this->loginFilter->isLogin($this->sekolah)){
			//Sekolah
			$identified = $this->loginFilter->getIdentifiedActive();
			$tempObjectDB = $controlSekolah->getAllData($identified);
			$guru=0;
			$wali=0;
			while($tempObjectDB && $tempObjectDB->getNextCursor()){
				$tempObjectDBD = $controlGuru->getAllData($tempObjectDB->getIdentified());
				$guru += $tempObjectDBD->getCountData();
				$tempObjectDBD = $controlWali->getAllData($tempObjectDB->getIdentified());
				$wali += $tempObjectDBD->getCountData();
			}
			$this->trueCore("",true);
			echo json_encode(array(
				"all"=>($guru + $wali),
				"guru" => $guru,
				"wali" => $wali
			));
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isGuru()){
			$identified  = $this->loginFilter->getSekolah();
			$tempObjectDB = $controlSekolah->getAllData($identified);
			$wali=0;
			if($tempObjectDB && $tempObjectDB->getNextCursor()){
				$tempObjectDBD = $controlWali->getAllData($tempObjectDB->getIdentified());
				while($tempObjectDBD && $tempObjectDBD->getNextCursor()){
					$tempObjectDBT = $controlRoom->getAllData($this->loginFilter->getIdentifiedActive(),$tempObjectDBD->getPekerja());
					$wali+=$tempObjectDBT->getCountData();
				}
			}
			$this->trueCore("",true);
			echo json_encode(array(
				"wali" => $wali
			));
		}else if($this->loginFilter->isLogin($this->worker) && $this->loginFilter->isWali()){
			$room = 0;
			
			$tempObjectDBT = $controlRoom->getAllData(null, $this->loginFilter->getIdentifiedActive(),1);
			while($tempObjectDBT && $tempObjectDBT->getNextCursor()){
				$tempObjectDBE = $controlGuru->getAllData($this->loginFilter->getSekolah(),$tempObjectDBT->getGuru());
				$room += $tempObjectDBE->getCountData();
			}
			$this->trueCore("",true);
			echo json_encode(array(
				"room" => $room
			));
		}else{
			$this->reloadCore();
		}
	}
}