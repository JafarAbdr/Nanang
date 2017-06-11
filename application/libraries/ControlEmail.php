<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',base_url());
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/ControlCIInstance.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class ControlEmail extends ControlCIInstance { 
	protected $config;
	protected $target;
	protected $subject;
	protected $emailCI;
	protected $message;
	public function __CONSTRUCT($config=null){
		parent::__CONSTRUCT();
		if(!is_null($config)){
			if(!$this->initialConfig($config)) 
				$this->loadDefaultConfig();
		}else{
			$this->loadDefaultConfig();
		}
		$this->loadHel('email');
		$this->emailCI = $this->loadLib('email', true, $this->config);
		$this->subject = "";
		$this->message = "";
	}
	public function resetTarget(){
		$this->target = array();
	}
	public function pushTarget($target){
		if(!valid_email($target)) return false;
		$num = count($this->target);
		$this->target[$num]=$target;
		return true;
	}
	
	public function initialConfig($config){
		if(!is_array($config)) return false;
		$this->config = $config;
		return true;
	}
	public function addSubject($subject){
		if(!is_string($subject)) return false;
		$this->subject = $subject;
		return false;
	}
	public function addMessage($message){
		if(!is_string($message)) return false;
		$this->message = $message;
		return false;
	}
	public function getMessage(){return $this->message;}
	public function addMessageByView($path,$content){
		if(!file_exists(APPPATH."views/".$path)) return false;
		if(!is_array($content)) return false;
		$tempHtml = file_get_contents(APPPATH."views/".$path);
        foreach($content as $key => $value){
            $tempHtml = str_ireplace("@".$key.";",$value,$tempHtml);
        }
		//exit($tempHtml);
		$this->message = $tempHtml;
	}
	public function configChange($index, $value){
		if(!array_key_exists($index,$this->config)) return false;
		$this->config[$index] = $value;
	}
	public function loadDefaultConfig(){
		$this->config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => "siataifundip.core@gmail.com",
			'smtp_pass' => "greatHONORtoSIATA",
			'mailtype'  => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);
	}
	public function send(){
		$this->emailCI->initialize($this->config);
		$dataMessage=null;
		if(count($this->target) >= 1){
			foreach($this->target as $value){
				$this->emailCI->from($this->config['smtp_user'], 'Developer Web');
				$this->emailCI->to($value);
				$this->emailCI->reply_to($this->config['smtp_user']);
				$this->emailCI->subject($this->subject);
				$this->emailCI->message($this->message);
				try{
					if(!$this->emailCI->send()) $dataMessage[$value]=false;
					else $dataMessage[$value]=true;
				}catch(Exception $exception){
					
				}
			}
		}
		return $dataMessage;
	}
}