<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class NotifikasiObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'notifikasi';
		$this->tempDataArrayIndexPrimary = array(
			'identified'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identified%>='<|identified|>'"
		);
		$this->tempCodeOfWhere = array(
			"identified" => array(
				'kode' => "<%identified%>",
				'value' => "<|identified|>"
			),
			"pengguna" => array(
				'kode' => "<%pengguna%>",
				'value' => "<|pengguna|>"
			),
			"date" => array(
				'kode' => "<%date%>",
				'value' => "<|date|>"
			),
			"title" => array(
				'kode' => "<%title%>",
				'value' => "<|title|>"
			),
			"deskripsi" => array(
				'kode' => "<%deskripsi%>",
				'value' => "<|deskripsi|>"
			),
			"status" => array(
				'kode' => "<%status%>",
				'value' => "<|status|>"
			),
			"type" => array(
				'kode' => "<%type%>",
				'value' => "<|type|>"
			)
		);
	}
	public function resetValue(){parent::resetValue();}
	public function getIdentified(){ return $this->getData('identified'); }
	public function getPengguna(){ return $this->getData('pengguna'); }
	public function getDate(){ return $this->getData('date'); }
	public function getTitle(){ return $this->getData('title'); }
	public function getDeskripsi(){ return $this->getData('deskripsi'); }
	public function getStatus(){ return $this->getData('status'); }
	public function getType(){ return $this->getData('type'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identified',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setPengguna($tempData,$tempAsWhere = false){
		return $this->setData('pengguna',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setDate($tempData,$tempAsWhere = false){
		return $this->setData('date',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setTitle($tempData,$tempAsWhere = false){
		return $this->setData('title',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setDeskripsi($tempData,$tempAsWhere = false){
		return $this->setData('deskripsi',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('status',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setType($tempData,$tempAsWhere = false){
		return $this->setData('type',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
}