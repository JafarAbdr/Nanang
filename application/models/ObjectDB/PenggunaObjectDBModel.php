<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PenggunaObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'pengguna';
		$this->tempDataArrayIndexPrimary = array(
			'identified'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identified%>='<|identified|>'",
			"<%nickname%>='<|nickname|>' AND <%keyword%>='<|keyword|>'",
			"<%identified%> NOT LIKE 'A%'",
			"<%identified%> NOT LIKE 'A%' AND  <%id%> NOT LIKE 'H%'",
			"<%identified%> LIKE 'O%'",
			"<%identified%> LIKE 'H%'",
			"<%identified%> LIKE 'W%'"
		);
		$this->tempCodeOfWhere = array(
			"identified" => array(
				'kode' => "<%identified%>",
				'value' => "<|identified|>"
			),
			"nickname" => array(
				'kode' => "<%nickname%>",
				'value' => "<|nickname|>"
			),
			"keyword" => array(
				'kode' => "<%keyword%>",
				'value' => "<|keyword|>"
			),
			"failedlogin" => array(
				'kode' => "<%failedlogin%>",
				'value' => "<|failedlogin|>"
			)
		);
	}
	public function resetValue(){parent::resetValue();}
	public function getIdentified(){ return $this->getData('identified'); }
	public function getNickName(){ return $this->getData('nickname'); }
	public function getKeyWord(){ return $this->getData('keyword'); }
	public function getFailedLogin(){ return $this->getData('failedlogin'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identified',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setNickName($tempData,$tempAsWhere = false){
		return $this->setData('nickname',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setKeyWord($tempData,$tempAsWhere = false){
		return $this->setData('keyword',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setFailedLogin($tempData,$tempAsWhere = false){
		return $this->setData('failedlogin',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
}