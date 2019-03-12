<?php
namespace TastyRecipes\Integration;
include_once 'deny-all/DBAccess.php';
include __DIR__ . '/../Model/RecipeMenu.php';
include_once __DIR__ . '/../Model/Recipe.php';

use TastyRecipes\Model\RecipeMenu;
use TastyRecipes\Model\Recipe;

/**
 * Handles all SQL calls to the tasty recipes database concerning recipes.
 */
class RecipeMenuDAO{
	
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
	
	public function getCountry($countryName){
		//Retrieve country information
		$sql = $this->connection->prepare("SELECT name, description, firstimage, secondimage, thirdimage, quote, chef FROM country WHERE name=?");
		$sql->bind_param("s", $countryName);
		$sql->execute();
		
		$result = $sql->get_result();
		if ($result->num_rows == 0 ){ // Country doesn't exist
			header('Location: PageNotFound');
		}
		else { // Country exists
			$row = $result->fetch_assoc();
			$images = array($row['firstimage'], $row['secondimage'], $row['thirdimage']);
			$country = new RecipeMenu($row['name'], $row['description']);
			$country->setImages($images);
			$country->setQuote($row['quote']);
			$country->setChef($row['chef']);
		}
		
		//Retrieve recipes belonging to country
		$sql = $this->connection->prepare("SELECT name, image, description, time FROM recipe WHERE
		country IN (SELECT id from country WHERE name=?)");
		$sql->bind_param("s", $countryName);
		$sql->execute();
		
		$result = $sql->get_result();
		$recipes = array();
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$recipes[] = new Recipe($row['name'], $row['image'], $row['description'], $row['time']);
			}
			$country->setRecipes($recipes);
		} 
		
		return $country;
	}
	
	public function getCountries(){
		//Retrieve all countries and their descriptions.
		$result = $this->connection->query("SELECT name, description FROM country");
		
		if ($result->num_rows > 0) {
			$countries = array();
			while($row = $result->fetch_assoc()) {
				$countries[] = new RecipeMenu($row['name'], $row['description']);
			}
		} 
		
		return $countries;
	}
	
	/**
     * Closes the connection to the <code>persons</code> database.
     */
    public function __destruct() {
        $this->connection->close();
    }
}
?>