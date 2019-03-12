<?php
class Comment{
  var $author;
  var $date;
  var $content;
  var $recipe;
  var $country;
  var $timestamp;
  var $deleted;

  function __construct($author, $date, $content, $recipe, $country, $timestamp) {
    $this->author = $author;
    $this->date = $date;
    $this->content = $content;
    $this->recipe = $recipe;
    $this->country = $country;
    $this->timestamp = $timestamp;
    $this->deleted = false;
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

  public function getCountry() {
      return $this->country;
  }

  public function getTimestamp() {
      return $this->timestamp;
  }

  public function isDeleted() {
      return $this->deleted;
  }
  
  public function setDeleted($deleted) {
      $this->deleted = $deleted;
  }
}
?>
