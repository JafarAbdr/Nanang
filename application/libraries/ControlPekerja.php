<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',base_url());
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlPekerja extends LibrarySupport{
    protected $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
        $this->gateControlModel = $tempGateControlModel;
	}
    public function getAllData($identified=null){
        $tempObjectDB = $this->gateControlModel->loadObjectDB('Pekerja');
        if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setIdentified($identified,true);
			$tempObjectDB->setWhere(1);
		}
        return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
    }
	public function getDataByNip($nip=null){
		if(is_null($nip)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pekerja');
		$tempObjectDB->setNip($nip,true);
		$tempObjectDB->setWhere(2);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		
		$tempObjectDB->setWhere(1);
		//exit($tempObjectDB->getWhere());
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function getObject(){
		return $this->gateControlModel->loadObjectDB('Pekerja');
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