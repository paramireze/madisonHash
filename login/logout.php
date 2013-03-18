<?php
	include '../includes/common.php';
	session_destroy();
	header('location: ' . WWW_ROOT . 'index.php')
	
?>