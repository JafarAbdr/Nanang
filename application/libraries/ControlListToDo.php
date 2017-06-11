<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',base_url());
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlListToDo extends LibrarySupport{
    protected $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
        $this->gateControlModel = $tempGateControlModel;
	}
	public function getAllData($identified=null,$identifiedSekolah=null){
		if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Listtodo');
			$tempObjectDB->setIdentified($identified,true);
			$tempObjectDB->setWhere(1);
			$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
			if(is_null($identifiedSekolah)){
				return $tempObjectDB;
			}else{
				$tempObjectDB->getNextCursor();
				if($tempObjectDB->getGuru() != $identifiedSekolah){					
					$tempObjectDBD = $this->gateControlModel->loadObjectDB('Guru');
					$tempObjectDBD->setSekolah($identifiedSekolah,true);
					$tempObjectDBD->setPekerja($tempObjectDB->getGuru(),true);
					$tempObjectDBD->setWhere(3);
					$tempObjectDBD = $this->gateControlModel->executeObjectDB($tempObjectDBD)->takeData();
					if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
						$tempObjectDB->resetSendRequest();
						return $tempObjectDB;
					}else{
						return false;
					}
				}else{
					$tempObjectDB->resetSendRequest();
					return $tempObjectDB;
				}
				
				
			}
		}else{
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Listtodo');
			return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		}
	}
	public function getBySchool($identified,$status=null){
		if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Guru');
			$tempObjectDB->setSekolah($identified,true);
			$tempObjectDB->setWhere(1);
		}else{
			return false;
		}
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		if(!$tempObjectDB || $tempObjectDB->getCountData() < 1) return false;
		$tempObjectDBD = $this->gateControlModel->loadObjectDB('Listtodo');
		$tempObjectDBT = $this->gateControlModel->loadObjectDB('Listtodo');
		while($tempObjectDB->getNextCursor()){
			$tempObjectDBD = $this->getByAuthor($tempObjectDB->getPekerja(),$status);
			$tempObjectDBT->concateTempValueWithThisClass($tempObjectDBD);
		}
		$tempObjectDBD = $this->getByAuthor($identified,$status);
		$tempObjectDBT->concateTempValueWithThisClass($tempObjectDBD);
		return $tempObjectDBT;
	}
	public function getByAuthor($identified=null,$status=null){
        $tempObjectDB = $this->gateControlModel->loadObjectDB('Listtodo');
        $tempObjectDBT = $this->gateControlModel->loadObjectDB('Listtodo');
        if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setGuru($identified,true);
			$tempObjectDB->setWhere(2);
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(3);
			}
		}else{
			return false;
		}
        return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
    }
	public function generateIdentified(){
		return "MWEANAB".date('Y')."C".date('m')."D".date('d')."E".date('H')."F".date('i')."G".date('s');
	}
	public function getObject(){
		return $this->gateControlModel->loadObjectDB('Listtodo');
	}
    public function addData(ObjectDBModel $tempObjectDB){
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
    }
	public function removeByIdentified($identified=null){
		if(is_null($identified))return false;
		$tempObjectDB = $this->getAllData($identified);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->deleteData();
	}
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		
		$tempObjectDB->setWhere(1);
		//exit($tempObjectDB->getWhere());
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
}