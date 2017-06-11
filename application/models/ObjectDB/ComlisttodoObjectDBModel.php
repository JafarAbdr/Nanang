<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ComlisttodoObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'comlisttodo';
		$this->tempDataArrayIndexPrimary = array(
			'identified'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identified%>='<|identified|>'",
			"<%listtodo%>='<|listtodo|>'"
		);
		$this->tempCodeOfWhere = array(
			"identified" => array(
				'kode' => "<%identified%>",
				'value' => "<|identified|>"
			),
			"listtodo" => array(
				'kode' => "<%listtodo%>",
				'value' => "<|listtodo|>"
			),
			"pekerja" => array(
				'kode' => "<%pekerja%>",
				'value' => "<|pekerja|>"
			),
			"time" => array(
				'kode' => "<%time%>",
				'value' => "<|time|>"
			),
			"content" => array(
				'kode' => "<%content%>",
				'value' => "<|content|>"
			)
		);
	}
	public function resetValue(){parent::resetValue();}
	public function getIdentified(){ return $this->getData('identified'); }
	public function getListToDo(){ return $this->getData('listtodo'); }
	public function getPekerja(){ return $this->getData('pekerja'); }
	public function getTime(){ return $this->getData('time'); }
	public function getContent(){ return $this->getData('content'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identified',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setListToDo($tempData,$tempAsWhere = false){
		return $this->setData('listtodo',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setPekerja($tempData,$tempAsWhere = false){
		return $this->setData('pekerja',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setTime($tempData,$tempAsWhere = false){
		return $this->setData('time',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setContent($tempData,$tempAsWhere = false){
		return $this->setData('content',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
}