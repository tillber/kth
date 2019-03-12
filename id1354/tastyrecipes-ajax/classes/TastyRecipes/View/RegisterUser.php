<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Integration\userDAO;
use \TastyRecipes\Controller\Controller;

class RegisterUser extends AbstractRequestHandler{
	private $username;
	private $password;
	
	public function setUsername($username){
		$this->username = $username;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}
	
	public function setPassword2($password){
		$this->password = $password;
	}
	
	protected function doExecute(){		
		//$controller = $this->session->get('controller');
		if(isset($_POST['username']) and isset($_POST['password']) and isset($_POST['password2'])){
			if($_POST['password'] === $_POST['password2']){
				$controller = new Controller();
				$controller->registerUser($_POST['username'], $_POST['password']);
			}
		}
		
		header("Location: Index");
	}
}
?>