<?php
?><?php
namespace TastyRecipes\Integration;
include_once 'deny-all/DBAccess.php';
include __DIR__ . '/../Model/User.php';

use TastyRecipes\Model\User;

/**
 * Handles all SQL calls to the tasty recipes database.
 */
class UserDAO{
	
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
	
	public function retrieveUser($username){
		$sql = $this->connection->prepare("SELECT username, password FROM user WHERE username=?");
		$sql->bind_param("s", $username);
		$sql->execute();
		
		$result = $sql->get_result();
		if ($result->num_rows == 0){ // User doesn't exist
			return null;
		}else{
			$user = $result->fetch_assoc();
			$userObj = new User($user['username'], $user['password']);
			return $userObj;
		}
	}
	
	public function registerUser($username, $password){	
		$sql = $this->connection->prepare("INSERT INTO user (username, password) VALUES (?,?)");
		$sql->bind_param("ss", $username, password_hash($password, PASSWORD_DEFAULT));
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