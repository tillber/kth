<?php
class User{
  var $username;
  var $password;

  function __construct($username, $password) {
    $this->username = $username;
    $this->password = $password;
  }

  public function getUsername() {
      return $this->username;
  }

  public function getPassword() {
      return $this->password;
  }
}
?>
