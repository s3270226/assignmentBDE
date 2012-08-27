<?php
	session_start();
	$_SESSION['inSession']=true;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>