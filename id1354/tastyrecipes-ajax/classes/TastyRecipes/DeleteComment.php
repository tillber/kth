<?php
namespace TastyRecipes;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Integration\CommentDAO;
use \TastyRecipes\Controller\Controller;

class DeleteComment extends AbstractRequestHandler{
	private $id;
	
	public function setId($id){
		$this->id = $id;
	}
	
	protected function doExecute(){		
		$controller = new Controller();
		$controller->deleteComment($this->id);
	}
}
?>