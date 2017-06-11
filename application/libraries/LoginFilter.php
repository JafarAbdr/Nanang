<?php
/*
Directory Library
->LoginFilter.php
-))untuk mengontrol proses login, logout, maupun mengecek apakah sudah login atau belum
--::
-?isLogin
--))untuk mengecek apakah ada user yang login sebelumnya
-?setLogOut
--))untuk menghapus status login user yang aktif
-?setLogIn
--))untuk mengaktifkan status login user

Status Class
level fix 1 - 10
level fix current 5
*/
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Aktor/Aktor.php";
require_once APPPATH."libraries/LibrarySupport.php";
class LoginFilter extends LibrarySupport {
	private $functionOpen;
	private $session;
	private $gateControlModel;
	public function __CONSTRUCT($tempSession = null, GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->session = $tempSession;
		$this->gateControlModel = $tempGateControlModel;
		
	}
	public function getIdentifiedActive(){
		if(is_null($this->session)) return false;
		if(!$this->session->has_userdata('id_active_account')) return false;
		$tempId = $this->session->userdata("id_active_account");
		return $tempId;
	}
	//for sekolah
	public function getWorker(){
		if(is_null($this->session)) return false;
		if(!$this->session->has_userdata('id_worker')) return false;
		$tempId = $this->session->userdata("id_worker");
		return $tempId;
	}
	//for worker
	public function getSekolah(){
		if(is_null($this->session)) return false;
		if(!$this->session->has_userdata('id_sekolah')) return false;
		$tempId = $this->session->userdata("id_sekolah");
		return $tempId;
	}
	public function isGuru(){
		if(is_null($this->session)) return false;
		if(!$this->session->has_userdata('id_is_guru')) return false;
		return true;
	}
	public function isWali(){
		if(is_null($this->session)) return false;
		if(!$this->session->has_userdata('id_is_wali')) return false;
		return true;
	}
	//->end
	public function isLogin(Aktor $tempAktor=null){
		if(is_null($this->session)) return false;
		if(is_null($tempAktor)) return false;
		if(!$this->session->has_userdata('id_active_account')) return false;
		$tempId = $this->session->userdata("id_active_account");
		if($tempId[0] != $tempAktor->getLevelCode()) return false;
		return $this->filterIdentified($tempId);
	}
	public function isPasswordOfThisGuy($keyWord,$identified=null){
		if(is_null($identified)){
			$identified = $this->getIdentifiedActive();
			if(!$identified) return false;
		}
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$tempObjectDB->getNextCursor();
		//exit($tempObjectDB->getKeyWord()." ==== ".$this->getHashKeyWord($keyWord)."<br>");
		if($tempObjectDB->getKeyWord() == $this->getHashKeyWord($keyWord))
			return true;
		else
			return false;
	}
	public function setNewPassword($keyWord,$identified=null){
		if(is_null($identified)){
			$identified = $this->getIdentifiedActive();
			if(!$identified) return false;
		}
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$tempObjectDB->getNextCursor();
		//echo $tempObjectDB->getKeyWord()." ==== ".$this->getHashKeyWord($keyWord)."<br>";
		if($tempObjectDB->getKeyWord() == $this->getHashKeyWord($keyWord))
			return false;
		//echo "kokokoss";
		$tempObjectDB->setKeyWord($this->getHashKeyWord($keyWord));
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function getHashKeyWord($keyWord){
		return md5(sha1(md5($keyWord)).md5(sha1($keyWord)));
	}
	public function getHashNickName($nickName){
		return md5(sha1(md5(sha1(md5($nickName)).sha1("account").md5(sha1($nickName))).sha1("we_na")));
	}
	public function setLogOut(){
		if(is_null($this->session)) return false;
		$this->session->unset_userdata('id_active_account');
		$this->session->unset_userdata('id_sekolah');
		$this->session->unset_userdata('id_is_guru');
		$this->session->unset_userdata('id_is_wali');
		$this->session->unset_userdata('id_worker');
		return true;
	}
	public function setLogIn($nickName=null, $keyWord=null){
		if(is_null($this->session)) return false;
		if(is_null($this->gateControlModel)) return false;
		if(is_null($nickName)) return false;
		if(is_null($keyWord)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempObjectDB->setNickName($this->getHashNickName($nickName),true);
		$tempObjectDB->setKeyWord($this->getHashKeyWord($keyWord),true);
		//echo "username = ".(md5(sha1(md5(sha1(md5($tempUsername)).sha1("account").md5(sha1($tempUsername))).sha1("we_na"))))."<br>password=".(md5(sha1(md5($tempPassword)).md5(sha1($tempPassword))))."<br>";
		$tempObjectDB->setWhere(2);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		if(!$tempObjectDB->getNextCursor()) return false;
		if(is_null($tempObjectDB->getIdentified())) return false;
		$this->setLogOut();
		$this->session->set_userdata('id_active_account',$tempObjectDB->getIdentified());
		switch($tempObjectDB->getIdentified()[0]){
			case 'S':
				$tempObjectDBD = $this->gateControlModel->loadObjectDB('Sekolah');
				$tempObjectDBD->setIdentified($tempObjectDB->getIdentified(),true);
				$tempObjectDBD->setWhere(1);
				$tempObjectDBD = $this->gateControlModel->executeObjectDB($tempObjectDBD)->takeData();
				if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
					$this->setLogOut();
					return false;
				}else{
					$this->session->set_userdata('id_worker',$tempObjectDBD->getKepSek());
				}
			break;
			case 'W':
				$tempObjectDBD = $this->gateControlModel->loadObjectDB('Guru');
				$tempObjectDBD->setPekerja($tempObjectDB->getIdentified(),true);
				$tempObjectDBD->setWhere(2);
				$tempObjectDBD = $this->gateControlModel->executeObjectDB($tempObjectDBD)->takeData();
				if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
					$tempObjectDBD = $this->gateControlModel->loadObjectDB('Wali');
					$tempObjectDBD->setPekerja($tempObjectDB->getIdentified(),true);
					$tempObjectDBD->setWhere(2);
					$tempObjectDBD = $this->gateControlModel->executeObjectDB($tempObjectDBD)->takeData();
					if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
						$this->setLogOut();
						return false;
					}else{
						$this->session->set_userdata('id_sekolah',$tempObjectDBD->getSekolah());
						$this->session->set_userdata('id_is_wali',"true");
					}
				}else{
					$this->session->set_userdata('id_sekolah',$tempObjectDBD->getSekolah());
					$this->session->set_userdata('id_is_guru',"true");
				}
			break;
		}
		return true;
	}
}