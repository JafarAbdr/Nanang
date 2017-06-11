<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ObjectDBRModel extends CoreObject{
	//methode
	protected $tableName;
	protected $tableType;
	//function
	public function __construct(){
		$this->resetValue();
	}
	public function resetValue(){
		$this->tableName = null;
		$this->tableType = null;
	}
}