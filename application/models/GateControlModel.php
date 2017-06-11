<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."models/CoreObject.php";
require_once APPPATH."models/ObjectRedis.php";
require_once APPPATH."models/ObjectDB/ObjectDBModel/ObjectDBModel.php";
require_once APPPATH."models/ObjectDBR/ObjectDBRModel/ObjectDBRModel.php";
require_once APPPATH."models/ControlModel/ControlModel.php";
class GateControlModel extends CI_Model{
	protected $tempDB;
	protected $tempObjectRedis;
	public function __construct($db = null,$loadDBDefault = true){
		parent::__construct();
		if(is_null($db)){
			if($loadDBDefault){			
				$this->load->database();	
				$this->tempDB = $this->db;
				$this->db = null;	
			}
		}
		else{
			$db = 'mysqli://root:@localhost/'.$db;
			$this->tempDB = $this->load->database($db);
		}
		$this->tempObjectRedis = null;
	}
	public function loadObjectDB($tempData = null){
		if(is_null($tempData)) return null;
		if(!is_string($tempData)) return null;
		if(!file_exists(APPPATH."models/ObjectDB/".$tempData."ObjectDBModel.php")) return null;
		require_once APPPATH."models/ObjectDB/".$tempData."ObjectDBModel.php";
		$tempData = $tempData."ObjectDBModel";
		return new $tempData();
	}
	public function loadObjectDBR($tempData = null){
		if(is_null($tempData)) return null;
		if(!is_string($tempData)) return null;
		if(!file_exists(APPPATH."models/ObjectDBR/".$tempData."ObjectDBRModel.php")) return null;
		require_once APPPATH."models/ObjectDBR/".$tempData."ObjectDBRModel.php";
		$tempData = $tempData."ObjectDBRModel";
		return new $tempData();
	}
	public function executeObjectDB(ObjectDBModel $tempObjectDBModel){
		return new ControlModel($this->tempDB, $tempObjectDBModel);
	}
	public function executeObjectDBR(ObjectDBRModel $tempObjectDBRModel, $functionName = "default", $array = null){
		if(!method_exists($tempObjectDBRModel,$functionName)){
			return false;
		}
		if(is_array($array))
			return $tempObjectDBModel->$functionName($this->tempObjectRedis,$array);
		else
			return $tempObjectDBModel->$functionName($this->tempObjectRedis);
	}
	protected function initializeRedisObject(){
		if(is_null($this->tempObjectRedis)){
			$this->tempObjectRedis = new ObjectRedis();
			$this->tempObjectRedis->connect('127.0.0.1', 6379);
			$this->tempObjectRedis->auth("jaservtech");
		}
	}
}