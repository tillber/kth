<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Controller\Controller;

class Recipe extends AbstractRequestHandler{
	private $recipe;
	
	public function setRecipe($recipe){
		$this->recipe = $recipe;
	}
	
	public function setContent($content){
		$this->content = $content;
	}
	
	protected function doExecute(){		
		$controller = new Controller();
		
		$recipe = $controller->getRecipe($this->recipe);
		$this->addVariable('recipe', $recipe);
		
		return 'recipe';
	}
}
?>