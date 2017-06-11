<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Datejaservfilter.php";
require_once APPPATH."libraries/Inputjaservfilter.php";
require_once APPPATH."libraries/Librarian.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class LibrarySupport extends Librarian{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
	}
	protected function filterIdentified($tempId = ""){
		if($tempId == '' || $tempId == ' ') return false;
		if($tempId[0] != 'O'){
			if($tempId[0] != 'S'){
				if($tempId[0] != 'W'){
					if($tempId[0] != 'M'){
						return false;
					}
				}
			}
		}
		$tempId = substr($tempId,1,strlen($tempId)-1);
		$tempId = str_ireplace("WEANAB","",$tempId);
		$tempId = str_ireplace("C","-",$tempId);
		$tempId = str_ireplace("D","-",$tempId);
		$tempId = str_ireplace("E"," ",$tempId);
		$tempId = str_ireplace("F",":",$tempId);
		$tempId = str_ireplace("G",":",$tempId);
		$tempDateJaservFilter = new Datejaservfilter();
		if($tempDateJaservFilter->nice_date($tempId,"Y-m-d H:i:s") == 'Invalid Date') return false;
		return true;
	}
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		$identified = $tempObjectDB->getIdentified();
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		//exit($tempObjectDB->getWhere());
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	protected function setCategoryPrintMessage($cat,$status,$message){if($cat==0){if($status){echo "1".$message;return ;}else{echo "0".$message;	return ;}}else{	return array($status,$message);}}
	
}

class tempObject {
	
}