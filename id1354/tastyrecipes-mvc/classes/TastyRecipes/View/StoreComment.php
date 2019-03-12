<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Integration\CommentDAO;
use \TastyRecipes\Controller\Controller;

class StoreComment extends AbstractRequestHandler{
	private $content;
	
	public function setContent($content){
		$this->content = $content;
	}
	
	protected function doExecute(){		
		$controller = new Controller();
		$controller->storeComment($this->session->get('username'), $this->content, $this->session->get('recipe'));
		
		$referrer = basename($_SERVER['HTTP_REFERER'],".php");		
		header("Location: " . $referrer . "#comment-form");
	}
}
?>