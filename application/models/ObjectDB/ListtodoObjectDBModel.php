<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ListtodoObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'listtodo';
		$this->tempDataArrayIndexPrimary = array(
			'identified'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identified%>='<|identified|>'",
			"<%guru%>='<|guru|>' ORDER BY lastedit ASC",
			"<%guru%>='<|guru|>' AND <%status%>=<|status|> ORDER BY lastedit ASC"
		);
		$this->tempCodeOfWhere = array(
			"identified" => array(
				'kode' => "<%identified%>",
				'value' => "<|identified|>"
			),
			"guru" => array(
				'kode' => "<%guru%>",
				'value' => "<|guru|>"
			),
			"lastedit" => array(
				'kode' => "<%lastedit%>",
				'value' => "<|lastedit|>"
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
			"uptime" => array(
				'kode' => "<%uptime%>",
				'value' => "<|uptime|>"
			),
			"kodeadd" => array(
				'kode' => "<%kodeadd%>",
				'value' => "<|kodeadd|>"
			)
		);
	}
	public function resetValue(){parent::resetValue();}
	public function getIdentified(){ return $this->getData('identified'); }
	public function getGuru(){ return $this->getData('guru'); }
	public function getLastEdit(){ return $this->getData('lastedit'); }
	public function getTitle(){ return $this->getData('title'); }
	public function getDeskripsi(){ return $this->getData('deskripsi'); }
	public function getStatus(){ return $this->getData('status'); }
	public function getUpTime(){ return $this->getData('uptime'); }
	public function getKodeAdd(){ return $this->getData('kodeadd'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identified',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setKodeAdd($tempData,$tempAsWhere = false){
		return $this->setData('kodeadd',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setGuru($tempData,$tempAsWhere = false){
		return $this->setData('guru',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
	public function setLastEdit($tempData,$tempAsWhere = false){
		return $this->setData('lastedit',$tempData,$tempAsWhere,function($x,$tempResult){
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
	public function setUpTime($tempData,$tempAsWhere = false){
		return $this->setData('uptime',$tempData,$tempAsWhere,function($x,$tempResult){
			return $tempResult;
		});
	}
}