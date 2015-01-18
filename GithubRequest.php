<?php
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
