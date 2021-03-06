<?php

class GithubRequest extends GitRequest{
	
	private $data;

	public function __construct(){
		$headers = getallheaders();
		$input = json_decode(file_get_contents("php://input"),true);
		$this->data = array(
			'repository'	=> $input['repository']['name'],
			'branch'		=> $input['repository']['default_branch'],
			'event'			=> $headers['X-Github-Event']
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
