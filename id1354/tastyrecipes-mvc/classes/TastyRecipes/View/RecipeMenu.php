<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Controller\Controller;

class RecipeMenu extends AbstractRequestHandler{
	private $country;
	
	public function setCountry($country){
		$this->country = $country;
	}
	
	protected function doExecute(){
		$controller = new Controller();
		$this->addVariable('country', $controller->getCountry($this->country));
		
		return 'recipe-menu';
	}
}
?>