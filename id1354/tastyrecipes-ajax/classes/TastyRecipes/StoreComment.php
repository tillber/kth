<?php
namespace TastyRecipes;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Integration\CommentDAO;
use \TastyRecipes\Controller\Controller;

class StoreComment extends AbstractRequestHandler{
	private $content;
	private $recipe;
	
	public function setContent($content){
		$this->content = $content;
	}
	
	public function setRecipe($recipe){
		$this->recipe = $recipe;
	}
	
	protected function doExecute(){		
		$controller = new Controller();
		$controller->storeComment($this->session->get('username'), $this->content, $this->recipe);
	}
}
?>