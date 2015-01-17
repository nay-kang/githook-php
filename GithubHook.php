<?php
require 'vendor/autoload.php';

class GithubHook{

	private $logger;

	public function __construct(){
		$this->logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
	}	
	
	public function __call($name,array $arguments){
		if(method_exists($this,$name)){
			return call_user_func_array(array($this,$name),$arguments);
		}
		if(strpos($name,'hook')===0){
			$method_name = str_replace('hook','',$name);
			$method_name = '_'.strtolower($method_name);
			return call_user_func_array(array($this,$method_name),$arguments);
		}
	}

	private function _pull($request){
		$this->logger->info($request);
	}	
}

?>
