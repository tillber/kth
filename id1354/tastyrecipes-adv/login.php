<?php
session_start();
$filename = 'users.txt';
require_once 'User.php';

if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
  $users = explode("\n", file_get_contents($filename));
  if(count($users) > 1){
    for($i = 0; $i < count($users); $i++){
      $user = unserialize($users[$i]);
      if($user instanceof User and $user->getUsername() == $_POST['username'] and $user->getPassword() == $_POST['password']){
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $_POST['username'];

        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        exit;
      }else if($user instanceof User and $_POST['username'] == $user->getUsername()){
        $_SESSION['wrongPassword'] = true;
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        exit;
      }
    }
  }
  $_SESSION['userDoesntExist'] = true;
  $referer = $_SERVER['HTTP_REFERER'];
  header("Location: $referer");
  exit;
} else{
  echo 'Error occurred!';
}
?>
