<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;

/**
* Shows the index page of the application.
*/
class Logout extends AbstractRequestHandler{
	protected function doExecute(){
		$this->session->invalidate();
		$this->session->restart();
		
		$referrer = basename($_SERVER['HTTP_REFERER'],".php");	
		header("Location: " . $referrer);
	}
}
?>