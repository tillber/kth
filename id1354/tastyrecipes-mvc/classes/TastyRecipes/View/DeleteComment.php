<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Integration\CommentDAO;
use \TastyRecipes\Controller\Controller;

class DeleteComment extends AbstractRequestHandler{
	private $id;
	
	public function setId($id){
		$this->id = $id;
	}
	
	protected function doExecute(){		
		//$controller = $this->session->get('controller');
		$controller = new Controller();
		$controller->deleteComment($this->id);
		
		$referrer = basename($_SERVER['HTTP_REFERER'],".php");		
		header("Location: " . $referrer . "#comment-form");
	}
}
?>