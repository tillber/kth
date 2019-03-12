<?php
namespace TastyRecipes\Model;

class Comment{
  var $author;
  var $date;
  var $content;
  var $recipe;
  var $id;
  
	function __construct($author, $content, $recipe, $date, $id) {
		$this->author = $author;
		$this->date = $date;
		$this->content = $content;
		$this->recipe = $recipe;
		$this->id = $id;
	}
  
	public function setAuthor($author){
		$this->author = $author;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getDate() {
		return $this->date;
	}

	public function getContent() {
		return $this->content;
	}

	public function getRecipe() {
		return $this->recipe;
	}
	
	public function getId(){
		return $this->id;
	}
}
?>
