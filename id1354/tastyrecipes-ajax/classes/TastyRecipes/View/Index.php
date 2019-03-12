<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Controller\Controller;

/**
* Shows the index page of the application.
*/
class Index extends AbstractRequestHandler{
	protected function doExecute(){
		$controller = new Controller();
		
		$comments = $controller->getCommentsNoRecipe();
		$this->addVariable('comments', $comments);
		
		$countries = $controller->getCountries();
		$this->addVariable('countries', $countries);
		
		return 'index';
	}
}
?>