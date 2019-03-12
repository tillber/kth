<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use \TastyRecipes\Controller\Controller;

/**
* Shows the index page of the application.
*/
class Login extends AbstractRequestHandler{
	private $username;
	private $password;
	
	public function setReferrer($referrer){
		$this->referrer = $referrer;
	}
	
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
		
		$referrer = basename($_SERVER['HTTP_REFERER'],".php");		
		header("Location: " . $referrer);
	}
}
?>