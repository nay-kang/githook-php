<?php

require 'vendor/autoload.php';

class BitbucketRequest extends GitRequest{
	
	private $data;

	public function __construct(){
		$input = json_decode($_POST['payload'],true);
		$this->data = array(
			'repository'	=> $input['repository']['name'],
			'branch'		=> $input['commits'][0]['branch'],
			'event'			=> 'push'
		);
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
