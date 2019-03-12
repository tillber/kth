<?php
namespace TastyRecipes\Integration;
include_once 'deny-all/DBAccess.php';
include __DIR__ . '/../Model/Comment.php';

use TastyRecipes\Model\Comment;

/**
 * Handles all SQL calls to the tasty recipes database.
 */
class CommentDAO{
	
	private $connection;
	
	/**
     * Connects to the database and empties it.
     * 
     * @throws \mysqli_sql_exception If unable to connect to the database or to empty it. 
     */
    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$this->connection = new \mysqli(DBAccess::HOST, DBAccess::USER, DBAccess::PASS, DBAccess::NAME);
		$this->connection->set_charset("utf8");
    }
	
	public function getComments($recipeName){
		$sql = $this->connection->prepare("SELECT id, author, content, recipe, date FROM comment WHERE recipe = ? ORDER BY id DESC");
		$sql->bind_param("s", $recipeName);
		$sql->execute();
		
		$result = $sql->get_result();
		$comments = array();
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$comments[] = new Comment($row['author'], $row['content'], $row['recipe'], $row['date'], $row['id']);
			}
		}
		
		return $comments;
	}
	
	//Since methods overriding aren't supported in PHP, I solve it by creating and using another method.
	public function getCommentsNoRecipe(){
		$result = $this->connection->query("SELECT id, author, content, recipe, date FROM comment ORDER BY id DESC");
		$comments = array();
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$comments[] = new Comment($row['author'], $row['content'], $row['recipe'], $row['date'], $row['id']);
			}
		}
		
		return $comments;
	}
	
	public function storeComment($user, $content, $recipe){
		$sql = $this->connection->prepare("INSERT INTO comment (author, content, recipe) VALUES (?, ?, ?)");
		$sql->bind_param("sss", $user, $content, $recipe);
		$sql->execute();
	}
	
	public function deleteComment($id){
		$sql = $this->connection->prepare("DELETE FROM Comment WHERE id=?");
		$sql->bind_param("i", $id);
		$sql->execute();
	}
	
	/**
     * Closes the connection to the <code>persons</code> database.
     */
    public function __destruct() {
        $this->connection->close();
    }
}
?>