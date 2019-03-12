<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;

/**
* Shows the index page of the application.
*/
class RegisterPage extends AbstractRequestHandler{
	protected function doExecute(){
		return 'register-page';
	}
}
?>