<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CommentedListObjectDBRModel extends ObjectDBRModel {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->tableName = "CommentedListId";
		$this->tableType = "List";
	}
	public function getAllData(ObjectRedis $tempRedis,$array == null){
		if(is_null($array)){return $this->getFailedResult();}
		if(array_key_exists($array, 'All')){
			if($array['all']){return $tempRedis->lrange($this->tableName,0,-1);}
			else{return $this->getFailedResult();}
		}else{
			if(!array_key_exists($array, 'page')){return $this->getFailedResult();}
			if(!array_key_exists($array, 'interval')){return $this->getFailedResult();}
			$tempPage = intval($array['page']);
			$tempInterval = intval($array['interval']);
			$h = $tempPage*$tempInterval;
			$x = $h-$tempInterval;
			$y = $h-1;
			if($x < 0){$x = 0; $y = $tempInterval-1;}
			return $tempRedis->lrange($this->tableName,$x,$y);
		}
	}
}