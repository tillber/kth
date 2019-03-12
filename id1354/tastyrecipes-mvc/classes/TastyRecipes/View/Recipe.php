<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Controller\Controller;

class Recipe extends AbstractRequestHandler{
	private $recipe;
	
	public function setRecipe($recipe){
		$this->recipe = $recipe;
	}
	
	protected function doExecute(){		
		$controller = new Controller();
		
		$recipe = $controller->getRecipe($this->recipe);
		$this->addVariable('recipe', $recipe);
		
		$comments = $controller->getComments($this->recipe);
		$this->addVariable('comments', $comments);
		
		return 'recipe';
	}
}
?>