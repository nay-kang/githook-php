<?php
require_once 'GitHook.php';

//http://php.net/manual/en/function.getallheaders.php#84262
if (!function_exists('getallheaders'))
{
    function getallheaders()
    {
           $headers = '';
       foreach ($_SERVER as $name => $value)
       {
           if (substr($name, 0, 5) == 'HTTP_')
           {
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
           }
       }
       return $headers;
    }
}

abstract class GitRequest{

	/**
	 * rerturn repository 
	 */
	abstract public function getRepository();
	
	/**
	 * return which Branch trigger the event
	 */
	abstract public function getBranch();

	/**
	 * return the event,eg 'pull'
	 */
	abstract public function getEvent();
	
	/**
	 * $provider string 
	 */
	public static function createRequestFromGlobal($provider){
		$className = $provider.'Request';
		include $className.'.php';
		if(!class_exists($className)){
			throw new Exception('Class not found:'.$className);			
		}
		$object = new $className();
		if(!is_subclass_of($object,'GitRequest')){
			throw new Exception('Class is not child of GitRequest');
		}
		return $object;
	}

	protected $gitHandler;

	public function setHandler(GitHook $hook){
		$this->gitHandler = $hook;
	}

	public function handleRequest(){
		$event = $this->getEvent();
		$event = 'hook'.$event;
		$result = $this->gitHandler->$event($this->getRepository(),$this->getBranch());
		return $result;
	}
}
?>
