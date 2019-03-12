<?php
namespace TastyRecipes\Integration;
include_once 'deny-all/DBAccess.php';
include_once __DIR__ . '/../Model/Recipe.php';

use TastyRecipes\Model\Recipe;

/**
 * Handles all SQL calls to the tasty recipes database concerning recipes.
 */
class RecipeDAO{
	
	private $connection;
	
	/**
     * Connects to the database and sets the correct charset.
     * 
     * @throws \mysqli_sql_exception If unable to connect to the database or to empty it. 
     */
    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$this->connection = new \mysqli(DBAccess::HOST, DBAccess::USER, DBAccess::PASS, DBAccess::NAME);
		$this->connection->set_charset("utf8");
    }
	
	public function getRecipe($recipeName){
		$sql = $this->connection->prepare("SELECT name, image, description, time FROM recipe WHERE name = ?");
		$sql->bind_param("s", $recipeName);
		$sql->execute();
		
		$result = $sql->get_result();
		if ($result->num_rows == 0){ // Recipe doesn't exist
			header('Location: PageNotFound');
		}
		else { // Recipe exists
			$recipe = $result->fetch_assoc();
			$recipeObj = new Recipe($recipeName, $recipe['image'], $recipe['description'], $recipe['time']);
		}
		
		//Retrieve country
		$sql = $this->connection->prepare("SELECT name from country where id IN (SELECT country from recipe WHERE name = ?)");
		$sql->bind_param("s", $recipeName);
		$sql->execute();
		
		$result = $sql->get_result();
		if ($result->num_rows == 0){ // Recipe doesn't exist
			header('Location: PageNotFound');
		}
		else { // Recipe exists
			$result = $result->fetch_assoc();
			$country = $result['name'];
			$recipeObj->setCountry($country);
		}
		
		//Retrieve other recipes
		$sql = $this->connection->prepare("SELECT name FROM recipe WHERE country IN (SELECT country from recipe WHERE name = ?) AND name != ?");
		$sql->bind_param("ss", $recipeName, $recipeName);
		$sql->execute();
		
		$result = $sql->get_result();
		if ($result->num_rows > 0) {
			$otherRecipes = array();
			while($row = $result->fetch_assoc()) {
				$otherRecipes[] = $row['name'];
			}
			$recipeObj->setOtherRecipes($otherRecipes);
		} 
		
		//Retrieve tasks
		$sql = $this->connection->prepare("SELECT task FROM task WHERE id IN (SELECT task FROM recipe_task WHERE recipe 
		IN (SELECT id from recipe WHERE name=?))");
		$sql->bind_param("s", $recipeName);
		$sql->execute();
		
		$result = $sql->get_result();
		if ($result->num_rows > 0) {
			$tasks = array();
			while($row = $result->fetch_assoc()) {
				$tasks[] = $row["task"];
			}
			$recipeObj->setTasks($tasks);
		}
		
		//Retrieve ingredients
		$sql = $this->connection->prepare("SELECT ingredient FROM ingredient WHERE id IN (SELECT ingredient FROM recipe_ingredient WHERE recipe 
		IN (SELECT id from recipe WHERE name='" . $recipeName . "'))");
		$sql->bind_param("s", $recipeName);
		$sql->execute();
		
		$result = $sql->get_result();
		if ($result->num_rows > 0) {
			$ingredients = array();
			while($row = $result->fetch_assoc()) {
				$ingredients[] = $row['ingredient'];
			}
			$recipeObj->setIngredients($ingredients);
		}
		
		return $recipeObj;
	}
	
	/**
     * Closes the connection to the <code>persons</code> database.
     */
    public function __destruct() {
        $this->connection->close();
    }
}
?>