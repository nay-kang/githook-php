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
			$result = call_user_func_array(array($this,'before'.ucfirst($name)),$arguments);
			if(!$result) return $result;

			$result = call_user_func_array(array($this,$name),$arguments);
			if(!$result) return $result;

			$result = call_user_func_array(array($this,'after'.ucfirst($name)),$arguments);
			if(!$result) return $result;
		}

		if(method_exists($this,$name)){
			return call_user_func_array(array($this,$name),$arguments);
		}
		
	}

	protected function getCommands($event,$repo,$branch){
		$commands = file($this->commandPath.$event.'.sh');		
		return $commands;
	}

	protected function hookPush($repo,$branch){
		$commands = $this->getCommands('push',$repo,$branch);	
		foreach($commands as $cmd){
			exec($cmd,$output,$status);
			$this->logger->info($cmd);
			$this->logger->info($status);
			$output = join("\n",$output);
			$this->logger->info($output);
		}
	}	

	protected function beforeHookPush(){
		return true;
	}

	protected function afterHookPush(){
		return true;
	}
}

?>
