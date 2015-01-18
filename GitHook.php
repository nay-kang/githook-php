<?php
require 'vendor/autoload.php';

class GitHook{

	private $logger;
	protected $commandPath = 'command/';

	public function __construct(){
		$this->logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
	}	
	
	public function __call($name,array $arguments){

		if(strpos($name,'hook')===0){
			$method_name = str_replace('hook','',$name);
			$method_name = '_'.strtolower($method_name);
			return call_user_func_array(array($this,$method_name),$arguments);
		}

		if(method_exists($this,$name)){
			return call_user_func_array(array($this,$name),$arguments);
		}
		
	}

	private function _push($request){
		$commands = file($this->commandPath.'push.sh');	
		foreach($commands as $cmd){
			exec($cmd,$output,$status);
			$this->logger->info($cmd);
			$this->logger->info($status);
			$output = join("\n",$output);
			$this->logger->info($output);
		}
	}	
}

?>
