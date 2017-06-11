<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',base_url());
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlRoom extends LibrarySupport{
    protected $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
        $this->gateControlModel = $tempGateControlModel;
	}
    public function getAllData($guru=null,$wali=null,$status=null){
        $tempObjectDB = $this->gateControlModel->loadObjectDB('Room');
        if(!is_null($guru)){
			if(!$this->filterIdentified($guru)) return false;
			$tempObjectDB->setGuru($guru,true);
			$tempObjectDB->setWhere(1);
			if(!is_null($wali)){
				$tempObjectDB->setPekerja($wali,true);
				$tempObjectDB->setWhere(3);
				if(!is_null($status)){
					$tempObjectDB->setStatus($status,true);
					$tempObjectDB->setWhere(5);
				}
			}else{
				if(!is_null($status)){
					$tempObjectDB->setStatus($status,true);
					$tempObjectDB->setWhere(6);
				}
			}
		}else{
			if(!is_null($wali)){
				$tempObjectDB->setPekerja($wali,true);
				$tempObjectDB->setWhere(2);
				if(!is_null($status)){
					$tempObjectDB->setStatus($status,true);
					$tempObjectDB->setWhere(7);
				}
			}else{
				if(!is_null($status)){
					$tempObjectDB->setStatus($status,true);
					$tempObjectDB->setWhere(4);
				}
			}
		}
        return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
    }
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function getObject(){
		return $this->gateControlModel->loadObjectDB('Room');
	}
    public function addData(ObjectDBModel $tempObjectDB){
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
    }
	public function removeByIdentified($guru,$wali){
		if(is_null($guru))return false;
		if(is_null($wali))return false;
		$tempObjectDB = $this->getAllData($guru,$wali);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		$tempObjectDB->setWhere(3);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->deleteData();
	}
}