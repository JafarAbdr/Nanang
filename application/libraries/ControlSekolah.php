<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',base_url());
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlSekolah extends LibrarySupport{
    protected $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
        $this->gateControlModel = $tempGateControlModel;
	}
	public function isAvailableThisNamaSekolah($identified=null,$nama=null){
		if(is_null($identified)) return false;
		if(is_null($nama)) return false;
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sekolah');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setNama($nama,true);
		$tempObjectDB->setWhere(5);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
    public function getAllData($identified=null,$status=null){
        $tempObjectDB = $this->gateControlModel->loadObjectDB('Sekolah');
        if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setIdentified($identified,true);
			$tempObjectDB->setWhere(1);
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(2);
			}
		}else{
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(4);
			}
		}
        return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
    }
	/* public function tryUpdate(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setWhere(1);
		$tempObjectDB->setIdentified($tempObjectDB->getIdentified(),true);
		//exit($tempObjectDB->getIdentified());
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	} */
	public function getDataByNama($nama=null){
		if(is_null($nama)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sekolah');
		$tempObjectDB->setNama($nama,true);
		$tempObjectDB->setWhere(3);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function getObject(){
		return $this->gateControlModel->loadObjectDB('Sekolah');
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
}