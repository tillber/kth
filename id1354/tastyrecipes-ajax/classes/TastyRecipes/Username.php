<?php
namespace TastyRecipes;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Controller\Controller;

class Username extends AbstractRequestHandler {

    protected function doExecute() {
        if($this->session->get('username') != null){
			$username = $this->session->get('username');
			echo json_encode($username);
		}
	}
}
?>