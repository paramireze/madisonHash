<?php
	include '../includes/common.php';
	session_start();
	session_destroy();
	header('location: ' . WWW_ROOT . 'index.php');
	
?>