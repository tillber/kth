<?php
  session_start();
  require_once 'Comment.php';

  if (isset($_GET['timestamp'])) {
    $filename = 'comments.txt';

    $comments = explode(";\n", file_get_contents($filename));
    for ($i = count($comments) - 1; $i >= 0; $i--) {
        $comment = unserialize($comments[$i]);
        if ($comment instanceof Comment and ($comment->getTimestamp() == $_GET['timestamp'])) {
          $comment->setDeleted(true);
          $comments[$i] = serialize($comment);
          break;
        }
    }
    file_put_contents($filename, implode(";\n", $comments));
  }

  $referer = $_SERVER['HTTP_REFERER'];
  header("Location: $referer#submitComment");
?>
