<?php
namespace TastyRecipes\View;
use TastyRecipes\Controller\Controller;
use Id1354fw\View\AbstractRequestHandler;

/**
* All requests without a url matching an existing request handler will be redirected 
* to the application's index page.
*/
class DefaultRequestHandler extends AbstractRequestHandler {

    protected function doExecute() {
        $this->session->restart();
        $this->session->set('controller', new Controller());
        \header('Location: /tastyrecipes/TastyRecipes/View/Index');
    }
}
?>