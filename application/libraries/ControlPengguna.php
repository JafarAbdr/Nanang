<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',base_url());
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlPengguna extends LibrarySupport{
    protected $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
        $this->gateControlModel = $tempGateControlModel;
	}
	public function getAllData($identified=null){
       
	   $tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
        if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setIdentified($identified,true);
			$tempObjectDB->setWhere(1);
		}
        return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
    }
	public function getIdentifiedAdminCreative(){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
        $tempObjectDB->setIdentified("OWEANAB",true);
		$tempObjectDB->setWhere(5);
        $tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			return $tempObjectDB->getIdentified();
		}else return false;
	}
	public function generateIdentified($kode=null){
		if(is_null($kode)) return false;
		switch($kode){
			case 1 :
				return "OWEANAB".date('Y')."C".date('m')."D".date('d')."E".date('H')."F".date('i')."G".date('s');
			break;
			case 2 :
				return "SWEANAB".date('Y')."C".date('m')."D".date('d')."E".date('H')."F".date('i')."G".date('s');
			break;
			case 3 :
				return "WWEANAB".date('Y')."C".date('m')."D".date('d')."E".date('H')."F".date('i')."G".date('s');
			break;
		}
	}
	public function getObject(){
		return $this->gateControlModel->loadObjectDB('Pengguna');
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