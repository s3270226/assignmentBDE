<?php
session_start();
$_SESSION['inSession']=false;
unset($_SESSION['inSession']);
session_destroy();
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
