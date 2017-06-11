<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',base_url());
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlComListToDo extends LibrarySupport{
    protected $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
        $this->gateControlModel = $tempGateControlModel;
	}
	public function getAllData($identified=null){
		if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Comlisttodo');
			$tempObjectDB->setIdentified($identified,true);
			$tempObjectDB->setWhere(1);
			$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
			
		}else{
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Listtodo');
			return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		}
	}
	public function getByListToDo($identified=null){
        $tempObjectDB = $this->gateControlModel->loadObjectDB('Comlisttodo');
        if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setListToDo($identified,true);
			$tempObjectDB->setWhere(2);
		}else{
			return false;
		}
        return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
    }
	public function generateIdentified(){
		return "CWEANAB".date('Y')."C".date('m')."D".date('d')."E".date('H')."F".date('i')."G".date('s');
	}
	public function getObject(){
		return $this->gateControlModel->loadObjectDB('Comlisttodo');
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