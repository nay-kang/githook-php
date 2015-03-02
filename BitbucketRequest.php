<?php

require 'vendor/autoload.php';

class BitbucketRequest extends GitRequest{
	
	private $data;

	public function __construct(){
		$this->logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
		$input = json_decode($_POST['payload'],true);
		$this->logger->info('bitbucket input',$input);
		$this->data = array(
			'repository'	=> $input['repository']['name'],
			'event'			=> 'push'
		);
		foreach($input['commits'] as $commit){
			if($commit['branch']){
				$this->data['branch'] = $commit['branch'];
				break;
			}	
		}
		$this->logger->info('bitbucket data',$this->data);
	}

	public function getRepository(){
		return $this->data['repository'];
	}

	public function getBranch(){
		return $this->data['branch'];
	}

	public function getEvent(){
		return $this->data['event'];
	}
}
?>
