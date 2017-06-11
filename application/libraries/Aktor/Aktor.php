<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
class Aktor{
	protected $levelCode;
	protected $inputJaservFilter;
	public function __CONSTRUCT(){
		$this->levelCode = 0;
		$this->inputJaservFilter = null;
	}
	public function getLevelCode(){
		$tempResult = $this->levelCode;
		return $tempResult;
	}	
	//<--
	public function initial(Inputjaservfilter $tempInputJaservFilter){
		$this->inputJaservFilter = $tempInputJaservFilter;
	}
	//-->>
	//<<--
	public function getCheckNip($tempNip="",$tempCategory = 0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempNip == "")
			return $this->setCategoryPrintMessage($tempCategory, false, "Nip tidak boleh kosong");
		if(!$this->inputJaservFilter->numberFiltering($tempNip)[0])
			return $this->setCategoryPrintMessage($tempCategory, false, "Nip mengandng karakter lain");
		if((strlen($tempNip)>=17)&&(strlen($tempNip) <= 20))
			return $this->setCategoryPrintMessage($tempCategory, true, "valid");
		else 
			return $this->setCategoryPrintMessage($tempCategory, false, "Nip tidak valid");
	}
	public function getCheckNuTelphone($telphone="",$cat=0){if($telphone == "")	return $this->setCategoryPrintMessage($cat, false, "no telefon tidak boleh kosong");	$temp = $this->inputJaservFilter->numberFiltering($telphone);if($temp[0]){if(strlen($telphone) > 9 && strlen($telphone) < 14)return $this->setCategoryPrintMessage($cat, true, "no telefon valid");	else return $this->setCategoryPrintMessage($cat, false, "no telefon tidak valid");}else	return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);}
	public function getCheckEmail($email="",$cat=0){if($email == "")return $this->setCategoryPrintMessage($cat, false, "email tidak boleh kosong");$temp = $this->inputJaservFilter->emailFiltering($email);	return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);}
	public function getCheckName($name="",$cat=0){if($name == "")return $this->setCategoryPrintMessage($cat, false, "nama tidak boleh kosong");	$temp = $this->inputJaservFilter->nameFiltering($name);	return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);}
	//-->>
	protected function setCategoryPrintMessage($cat,$status,$message){if($cat==0){if($status){echo "1".$message;return ;}else{echo "0".$message;	return ;}}else{	return array($status,$message);}}
	/*private*/
}