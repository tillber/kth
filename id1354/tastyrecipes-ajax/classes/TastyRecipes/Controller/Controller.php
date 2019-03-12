<?php
namespace TastyRecipes\Controller;

use TastyRecipes\Integration\CommentDAO;
use TastyRecipes\Integration\UserDAO;
use TastyRecipes\Integration\RecipeDAO;
use TastyRecipes\Integration\RecipeMenuDAO;
use TastyRecipes\Model\Comment;
use TastyRecipes\Model\User;
use TastyRecipes\Model\Recipe;
use TastyRecipes\Model\RecipeMenu;

/**
 * The application's controller, all calls to the model pass through here.
 */
class Controller {
	
	private $commentDAO;
	private $userDAO;
	private $recipeDAO;
	private $recipeMenuDAO;

    public function __construct() {
        $this->commentDAO = new CommentDAO();
		$this->userDAO = new UserDAO();
		$this->recipeDAO = new RecipeDAO();
		$this->recipeMenuDAO = new RecipeMenuDAO();
    }

    public function storeComment($username, $content, $recipe) {
        $this->commentDAO->storeComment($username, $content, $recipe);
    }
	
	public function deleteComment($id){
		$this->commentDAO->deleteComment($id);
	}
	
	public function getComments($recipe){
		$comments = $this->commentDAO->getComments($recipe);
		return $comments;
	}
	
	public function getCommentsNoRecipe(){
		$comments = $this->commentDAO->getCommentsNoRecipe();
		return $comments;
	}
	
    public function verifyLogin($username, $password) {
        $user = $this->userDAO->retrieveUser($username);
		if($user != null){
			if($user->equals($username, $password)){
				return true;
			}
		}
		
		return false;
    }
	
	public function registerUser($username, $password){
		$user = $this->userDAO->retrieveUser($username);
		if($user == null){
			$this->userDAO->registerUser($username, $password);
		}
	}
	
	public function getRecipe($recipe){
		$recipe = $this->recipeDAO->getRecipe($recipe);
		return $recipe;
	}
	
	public function getCountry($country){
		$country = $this->recipeMenuDAO->getCountry($country);
		return $country;
	}
	
	public function getCountries(){
		$countries = $this->recipeMenuDAO->getCountries();
		return $countries;
	}
}
