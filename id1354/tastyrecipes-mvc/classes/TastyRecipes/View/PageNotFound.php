<?php
namespace TastyRecipes\View;
use Id1354fw\View\AbstractRequestHandler;

/**
* Shows the 404 error page.
*/
class PageNotFound extends AbstractRequestHandler{
	
	protected function doExecute(){
		return '404';
	}
}
?>