<?php
namespace TastyRecipes\Model;

class RecipeMenu {
    private $name;
    private $images;
    private $description;
	private $quote;
	private $chef;
	private $recipes;

    public function __construct($name, $description) {
        $this->name = $name;
        $this->description = $description;
    }

    public function getName() {
        return $this->name;
    }
	
    public function getImages() {
        return $this->images;
    }

    public function getDescription() {
        return $this->description;
    }
	
    public function getQuote() {
        return $this->quote;
    }
	
	public function getChef(){
		return $this->chef;
	}
	
	public function getRecipes(){
		return $this->recipes;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function setImages($images){
		$this->images = $images;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function setQuote($quote){
		$this->quote = $quote;
	}
	
	public function setChef($chef){
		$this->chef = $chef;
	}
	
	public function setRecipes($recipes){
		$this->recipes = $recipes;
	}
}
?>