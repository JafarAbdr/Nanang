<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RoomObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'room';
		$this->tempDataArrayIndexPrimary = array(
			'guru',"pekerja"
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%guru%>='<|guru|>'",
			"<%pekerja%>='<|pekerja|>'",
			"<%guru%>='<|guru|>' AND <%pekerja%>='<|pekerja|>'",
			"<%status%>='<|status|>'",
			"<%guru%>='<|guru|>' AND <%pekerja%>='<|pekerja|>' AND <%status%>='<|status|>'",
			"<%guru%>='<|guru|>' AND <%status%>='<|status|>'",
			"<%pekerja%>='<|pekerja|>' AND <%status%>='<|status|>'"
		);
		$this->tempCodeOfWhere = array(
			"guru" => array(
				'kode' => "<%guru%>",
				'value' => "<|guru|>"
			),
			"pekerja" => array(
				'kode' => "<%pekerja%>",
				'value' => "<|pekerja|>"
			),
			"status" => array(
				'kode' => "<%status%>",
				'value' => "<|status|>"
			)
		);
	}
	public function resetValue(){parent::resetValue();}
	public function getGuru(){ return $this->getData('guru'); }
	public function getPekerja(){ return $this->getData('pekerja'); }
	public function getStatus(){ return $this->getData('status'); }
	
	public function setGuru($tempData,$tempAsWhere = false){
		return $this->setData('guru',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setPekerja($tempData,$tempAsWhere = false){
		return $this->setData('pekerja',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('status',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
}