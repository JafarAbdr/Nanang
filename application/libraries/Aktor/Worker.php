<?php
if(!defined('BASEURL_WE_NA'))
	define('BASEURL_WE_NA',"http://localhost/");
if(!defined('BASEPATH')) header("location:".BASEURL_WE_NA);
if(!defined('BASEPATH')) header("location:".BASEURL_WE_NA);
if(!defined('APPPATH')) header("location:".BASEURL_WE_NA);
require_once APPPATH."libraries/Aktor/Client.php";
class Worker extends Client{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->levelCode = 'W';
	}
	//public function 
}