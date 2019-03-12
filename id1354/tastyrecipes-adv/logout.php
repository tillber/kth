<?php
session_start();
unset($_SESSION["valid"]);
unset($_SESSION["username"]);
session_destroy();
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
?>
