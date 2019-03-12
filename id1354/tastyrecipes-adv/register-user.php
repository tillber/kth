<?php
session_start();
require_once 'User.php';

$filename = 'users.txt';

if (isset($_POST['register']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])) {

  $users = explode("\n", file_get_contents($filename));
  for($i = 0; $i < count($users); $i++){
    $user = unserialize($users[$i]);
    if($user instanceof User and $user->getUsername() == $_POST['username']){
      //User already exists
      $_SESSION['userExists'] = true;
      $referer = $_SERVER['HTTP_REFERER'];
      header("Location: $referer");
      exit;
    }
  }

  if($_POST['password'] != $_POST['password2']){
    //Passwords doesn't match
    $_SESSION['passNoMatch'] = true;
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
    exit;
  }

  //User doesn't exist, create user
  $user = new User($_POST['username'], $_POST['password']);
  file_put_contents($filename, serialize($user) . ";\n", FILE_APPEND);
  $referer = $_SERVER['HTTP_REFERER'];
  header("Location: $referer");
  exit;

}else{
  //Error
  echo("Error");
}
?>
