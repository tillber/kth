<?php
session_start();

  require_once 'Comment.php';

  $d = getdate()['mday'];
  $m = getdate()['mon'];
  $y = getdate()['year'];
  $date = $d . "/" . $m . "/" . $y;

  $filename = 'comments.txt';
  if(!empty($_GET["content"])){
    $comment = new Comment($_SESSION["username"], $date, preg_replace('/[\r\n]+/',' ', $_GET["content"]), $_SESSION["recipe"], $_SESSION["country"], time());
    file_put_contents($filename, serialize($comment) . ";\n", FILE_APPEND);

    $_SESSION['commented'] = 1;
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer#submitComment");
  }else{
    $_SESSION['commented'] = -1;
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer#submitComment");
  }

 ?>
