<?php
namespace TastyRecipes\Model;

class Recipe {
    private $name;
    private $image;
    private $description;
	private $cookingtime;
	private $country;
	private $otherRecipes;
	private $tasks;
	private $ingredients;

    
    public function __construct($name, $image, $description, $cookingtime) {
        $this->name = $name;
        $this->image = $image;
        $this->description = $description;
		$this->cookingtime = $cookingtime;
    }

    /**
     * @return string the recipe name.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string the recipe image.
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @return string the recipe description.
     */
    public function getDescription() {
        return $this->description;
    }
	
	/**
     * @return string the recipe cooking time.
     */
    public function getCookingTime() {
        return $this->cookingtime;
    }
	
	public function getCountry(){
		return $this->country;
	}
	
	public function getOtherRecipes(){
		return $this->otherRecipes;
	}
	
	public function getTasks(){
		return $this->tasks;
	}
	
	public function getIngredients(){
		return $this->ingredients;
	}
	
	public function setCountry($country){
		$this->country = $country;
	}
	
	public function setOtherRecipes($otherRecipes){
		$this->otherRecipes = $otherRecipes;
	}
	
	public function setTasks($tasks){
		$this->tasks = $tasks;
	}
	
	public function setIngredients($ingredients){
		$this->ingredients = $ingredients;
	}

}
?>