<?php
namespace TastyRecipes;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Controller\Controller;

class GetCommentsRecipe extends AbstractRequestHandler {
	
	public function setRecipe($recipe){
		$this->recipe = $recipe;
	}

    protected function doExecute() {
        $controller = new Controller();
		$comments = $controller->getComments($this->recipe);
		echo json_encode($comments);
	}
}
?>

