<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SekolahObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'sekolah';
		$this->tempDataArrayIndexPrimary = array(
			'identified'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identified%>='<|identified|>'",
			"<%identified%>='<|identified|>' AND <%status%>='<|status|>'",
			"<%nama%>='<|nama|>'",
			"<%status%>='<|status|>'",
			"<%identified%><>'<|identified|>' AND <%nama%>='<|nama|>'"
		);
		$this->tempCodeOfWhere = array(
			"identified" => array(
				'kode' => "<%identified%>",
				'value' => "<|identified|>"
			),
			"kode" => array(
				'kode' => "<%kode%>",
				'value' => "<|kode|>"
			),
			"nama" => array(
				'kode' => "<%nama%>",
				'value' => "<|nama|>"
			),
			"alamat" => array(
				'kode' => "<%alamat%>",
				'value' => "<|alamat|>"
			),
			"email" => array(
				'kode' => "<%email%>",
				'value' => "<|email|>"
			),
			"nohp" => array(
				'kode' => "<%nohp%>",
				'value' => "<|nohp|>"
			),
			"kepsek" => array(
				'kode' => "<%kepsek%>",
				'value' => "<|kepsek|>"
			),
			"status" => array(
				'kode' => "<%status%>",
				'value' => "<|status|>"
			)
		);
	}
	public function resetValue(){parent::resetValue();}
	public function getIdentified(){ return $this->getData('identified'); }
	public function getKode(){ return $this->getData('kode'); }
	public function getNama(){ return $this->getData('nama'); }
	public function getAlamat(){ return $this->getData('alamat'); }
	public function getEmail(){ return $this->getData('email'); }
	public function getNoHp(){ return $this->getData('nohp'); }
	public function getKepSek(){ return $this->getData('kepsek'); }
	public function getStatus(){ return $this->getData('status'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identified',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setKode($tempData,$tempAsWhere = false){
		return $this->setData('kode',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setNama($tempData,$tempAsWhere = false){
		return $this->setData('nama',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setAlamat($tempData,$tempAsWhere = false){
		return $this->setData('alamat',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setEmail($tempData,$tempAsWhere = false){
		return $this->setData('email',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setNoHp($tempData,$tempAsWhere = false){
		return $this->setData('nohp',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setKepSek($tempData,$tempAsWhere = false){
		return $this->setData('kepsek',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('status',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
}