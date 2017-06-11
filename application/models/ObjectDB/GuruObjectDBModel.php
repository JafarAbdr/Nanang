<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GuruObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'guru';
		$this->tempDataArrayIndexPrimary = array(
			'sekolah',"pekerja"
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%sekolah%>='<|sekolah|>'",
			"<%pekerja%>='<|pekerja|>'",
			"<%sekolah%>='<|sekolah|>' AND <%pekerja%>='<|pekerja|>'",
			"<%status%>='<|status|>'",
			"<%sekolah%>='<|sekolah|>' AND <%pekerja%>='<|pekerja|>' AND <%status%>='<|status|>'",
			"<%sekolah%>='<|sekolah|>' AND <%status%>='<|status|>'",
			"<%pekerja%>='<|pekerja|>' AND <%status%>='<|status|>'"
		);
		$this->tempCodeOfWhere = array(
			"sekolah" => array(
				'kode' => "<%sekolah%>",
				'value' => "<|sekolah|>"
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
	public function getSekolah(){ return $this->getData('sekolah'); }
	public function getPekerja(){ return $this->getData('pekerja'); }
	public function getStatus(){ return $this->getData('status'); }
	
	public function setSekolah($tempData,$tempAsWhere = false){
		return $this->setData('sekolah',$tempData,$tempAsWhere,function($x,$tempResult){
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