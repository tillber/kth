<?php
namespace TastyRecipes\Model;

class User{
  var $username;
  var $password;
  
	function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
  
	public function setUsername($username){
		$this->username = $username;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}
	
	//Compares this user with parametres username and password.
	public function equals($username, $password){
		if($this->getUsername() === $username and password_verify($password, $this->getPassword())) {
			return true;
		}
		return false;
	}
}
?>
