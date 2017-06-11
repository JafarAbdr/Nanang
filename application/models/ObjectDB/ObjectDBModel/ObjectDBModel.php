<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ObjectDBModel extends CoreObject{
	//methode
	protected $tempTableName;
	protected $tempDataArray;
	protected $tempDataArrayIndexPrimary;
	protected $tempDataArrayCase;
	protected $tempDataArrayCaseChoose;
	protected $tempDataArrayWhere;
	protected $tempDataArrayWhereChoose;
	protected $tempDataArraySendRequest;
	protected $tempDataArrayIndexSendRequest;
	protected $tempCodeOfWhere;
	protected $sorting;
	protected $sortingData;
	//function
	public function __construct(){
		$this->tempTableName = null;
		$this->resetValue();
		$this->tempDataArrayIndexPrimary = null;
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->sorting = false;
		$this->sortingData = array();
		$this->setCaseData(0);
		$this->tempDataArrayWhere = array(
			""
		);
		$this->setWhere(0);
		$this->tempCodeOfWhere = null;
		$this->tempDataArraySendRequest = null;
		$this->resetSendRequest();
	}
	public function resetValue(){
		$this->tempDataArray = null;
	}
	public function resetSendRequest(){
		$this->tempDataArrayIndexSendRequest = 0;
	}
	public function concateTempValueWithThisClass($tempObjectDBModel){
		$temp1 = get_class($this);
		$temp2 = get_class($tempObjectDBModel);
		if($temp1 != $temp2) return false;
		if(is_null($tempObjectDBModel->getTempValue())) return false;
		if(is_null($this->tempDataArraySendRequest)){
			$this->tempDataArraySendRequest = $tempObjectDBModel->getTempValue();
		}else{
			$tempDataArraySendRequest = array_merge($this->tempDataArraySendRequest, $tempObjectDBModel->getTempValue());
			$this->tempDataArraySendRequest = $tempDataArraySendRequest;
		}
		$this->sorting = false;
		$this->sortingData = array();
		return true;
	}
	public function getTempValue(){
		$temp = $this->tempDataArraySendRequest;
		return $temp;
	}
	public function setNewSendRequest($tempDataArray){
		//var_dump($tempDataArray);
		//exit("jkk".count($tempDataArray));
		if(!is_array($tempDataArray)) return $this->getFailedResult();
		$this->resetValue();
		$this->tempDataArraySendRequest = $tempDataArray;
		$this->tempDataArrayIndexSendRequest = 0;
		//if(!array_key_exists(0,$tempDataArray)) return $this->automaSetContent($tempDataArray);
		return $this->getSuccessResult();
	}
	public function getTableName(){
		$tempResult = $this->tempTableName;
		return $tempResult;
	}
	public function getCountData(){
		if(is_null($this->tempDataArraySendRequest)) return 0;
		else return count($this->tempDataArraySendRequest);
	}
	//-iterate next cursor
	public function getNextCursor(){
		//var_dump($this->tempDataArraySendRequest[$this->tempDataArrayIndexSendRequest]);
		//echo "jjjojo".$this->tempDataArrayIndexSendRequest;
		if(is_array($this->tempDataArraySendRequest)){
			if(array_key_exists($this->tempDataArrayIndexSendRequest, $this->tempDataArraySendRequest)){
				if($this->sorting)
					$this->automaSetContent($this->tempDataArraySendRequest[$this->sortingData[$this->tempDataArrayIndexSendRequest]]);
				else
					$this->automaSetContent($this->tempDataArraySendRequest[$this->tempDataArrayIndexSendRequest]);
				$this->tempDataArrayIndexSendRequest += 1;
				return $this->getSuccessResult();
			}else{
				return $this->getFailedResult();
			}
		}else{
			return $this->getFailedResult();
		}
	}
	public function sortByCoulumn($coulumn,$desc=true){
		if($this->getCountData() < 2) return false;
		if(!array_key_exists($coulumn,$this->tempDataArraySendRequest[0])) return false;
		foreach($this->tempDataArraySendRequest as $key => $row){
			$tempData[$key] = $row[$coulumn];
			$tempKey[$key] = $key;
		}
		if($desc)
			array_multisort($tempData, SORT_DESC, $tempKey);
		else
			array_multisort($tempData, SORT_ASC, $tempKey);
		$this->sortingData = $tempKey;
		$this->sorting = true;
		return true;
	}
	protected function automaSetContent($tempArray){
		//var_dump($tempArray);
		$this->resetValue();
		$this->countArray = count($tempArray);
		if($this->countArray <= 0){ return $this->getFailedResult();}
		foreach($tempArray as $tempIndexArray => $tempValue){
			$this->tempDataArray[$tempIndexArray]['value'] = $tempValue;
			if($this->isOneOfKeyPrimary($tempIndexArray))
				$this->tempDataArray[$tempIndexArray]['asWhere'] = true;
			else
				$this->tempDataArray[$tempIndexArray]['asWhere'] = false;
		}
		return $this->getSuccessResult();
	}
	protected function isOneOfKeyPrimary($tempPrimary){
		foreach($this->tempDataArrayIndexPrimary as $tempValue){
			if($tempValue == $tempPrimary){
				return true;
			}
		}
		return false;
	}
	public function isPrimaryNotNull(){
		$tempResult = $this->getSuccessResult();
		foreach($this->tempDataArrayIndexPrimary as $tempValue){
			if(!array_key_exists($tempValue,$this->tempDataArray)){
				$tempResult = $this->getFailedResult();
			}
		}
		return $tempResult;
	}
	/*
	
	*/
	protected function getData($tempIndex){
		$tempResult = null;
		if(is_null($this->tempDataArray)) return null;
		if(array_key_exists($tempIndex,$this->tempDataArray)){
			$tempResult = $this->tempDataArray[$tempIndex]['value'];
		}
		return $tempResult;
	}
	protected function setData($tempIndex,$tempValue, $tempAsWhere=false,$functionFilter = false){
		$tempResult = $this->getFailedResult(); 
		if(is_bool($functionFilter)) return $tempResult;
		if($functionFilter($tempValue,$this->getSuccessResult())){
			$this->tempDataArray[$tempIndex]['value'] = $tempValue;
			if(!is_bool($tempAsWhere)) $tempAsWhere = false;
			$this->tempDataArray[$tempIndex]['asWhere'] = $tempAsWhere;
			$tempResult = $this->getSuccessResult();
		}
		return $tempResult;
	}
	public function getQueryBuilder(){
		$tempQuery = "";
		if(is_null($this->tempDataArray)) return null;
		foreach($this->tempDataArray as $tempIndex => $tempValue){
			$tempQuery .= $tempIndex."='".$tempValue['value']."',";
		}
		if($tempQuery != "")
			return substr($tempQuery,0,strlen($tempQuery)-1);
		else
			return null;
	}
	public function getArrayBuilder(){
		$tempQuery = null;
		if(is_null($this->tempDataArray)) return null;
		foreach($this->tempDataArray as $tempIndex => $tempValue){
			$tempQuery[$tempIndex] = $tempValue['value'];
		}
		if(count($tempQuery) > 0)
			return $tempQuery;
		else
			return null;
	}
	public function setCaseData($tempData = null){
		if(is_null($tempData)) return $this->getFailedResult();
		$tempData = intval($tempData);
		if(!array_key_exists($tempData,$this->tempDataArrayCase)) return $this->getFailedResult();
		$this->tempDataArrayCaseChoose = $tempData;
		return $this->getSuccessResult();
	}
	public function getCaseData(){
		$tempResult = $this->tempDataArrayCase[$this->tempDataArrayCaseChoose];
		return $tempResult;
	}
	
	protected function automaGetWhereBuilder($string){
		if(is_null($this->tempDataArray)) return "";
		foreach($this->tempDataArray as $tempIndex => $tempValue){
			if($tempValue['asWhere']){
				$string = str_ireplace($this->tempCodeOfWhere[$tempIndex]['kode'], $tempIndex, $string);
				$string = str_ireplace($this->tempCodeOfWhere[$tempIndex]['value'], $tempValue['value'], $string);
			//$tempQuery .= $tempIndex."='".$tempValue['value']."',";	 
			}
		}
		//exit("nilai  : ".$string);
		//echo $string;
		return $string;
	}
	public function setWhere($tempData = null){
		if(is_null($tempData)) return $this->getFailedResult();
		$tempData = intval($tempData);
		if(!array_key_exists($tempData,$this->tempDataArrayWhere)) return $this->getFailedResult();
		$this->tempDataArrayWhereChoose = $tempData;
		return $this->getSuccessResult();
	}
	public function getWhere(){
		//exit("jskajska".$this->tempDataArrayWhereChoose);
		if($this->tempDataArrayWhereChoose == 0){
			return $this->tempDataArrayWhere[$this->tempDataArrayWhereChoose];	
		}
		else{
			//exit($this->tempDataArrayWhere[$this->tempDataArrayWhereChoose]);
			return $this->automaGetWhereBuilder($this->tempDataArrayWhere[$this->tempDataArrayWhereChoose]);	
		}
	}
}