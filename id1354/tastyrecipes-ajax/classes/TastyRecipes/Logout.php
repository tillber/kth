<?php
namespace TastyRecipes;
use Id1354fw\View\AbstractRequestHandler;

class Logout extends AbstractRequestHandler{
	protected function doExecute(){
		session_start();
		session_unset();
		session_destroy();
	}
}
?>