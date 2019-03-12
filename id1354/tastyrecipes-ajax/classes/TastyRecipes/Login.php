<?php
namespace TastyRecipes;
use Id1354fw\View\AbstractRequestHandler;
use \TastyRecipes\Controller\Controller;


class Login extends AbstractRequestHandler{
	private $username;
	private $password;
	
	public function setUsername($username){
		$this->username = $username;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}
	
	protected function doExecute(){		
		$controller = new Controller();
		
		if($controller->verifyLogin($this->username, $this->password)){
			$this->session->set('username', $this->username);
		}
	}
}
?>