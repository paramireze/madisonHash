<?php

/*
written by: paul ramirez 2/17/2013
description: from registration page, the user will fill in their name and password. When they submit, they bounce off of this page, inserting a record if valid data

incoming variables: 
	name = string, required
	password = string, required
	
return:
	errors
		or
	a confirmation of success or failure
*/
include '../includes/common.php';

//reset errors 
$_SESSION['errors'] = NULL;
$_SESSION['errors'] = array();

/* -------------- SECURITY METHODS -------------- */
// check to see if user typed in the url, instead of submitting login form
if(!isset($_SERVER['HTTP_REFERER'])) {
	
	header('location: ' . WWW_ROOT . 'index.php');
	die();
}

$returnURL = $_SERVER['HTTP_REFERER'];

// This variable is assigned a value when submitting the login form
// if ont, send back to whatever page they were on
if (!isset($_POST['token'])) {
	header('location: '. $returnURL);
	die();
} 

// function returns either true (which is bad), or false( which means the tokens match)
$badFormSubmissoin = checkToken($_POST['token']);
if ($badFormSubmissoin) {
	header('location: '. $returnURL);
	die();
}
destroyToken();
/* -------------------------------------------------*/
// function: this will end the session being used to check against CSFR
include  DIR_ROOT . 'includes/functions/database_connection.php';
include  DIR_ROOT . 'includes/functions/do_pdo_query.php';
include  DIR_ROOT . 'methods/user_methods.php';
$hash = pdo_connect_hash();



// check to see if they entered anything
if (empty($_POST['name'])) {
	$_SESSION['errors']['nullname'] = 'user name is required';
} else {
	$name = $_POST['name'];
}

if (empty($_POST['hashName'])) {
	$_SESSION['errors']['nullhashName'] = 'hash name is required';
} else {
	$hashName = $_POST['hashName'];
}

// make sure user name is only letters and numbers
if (!ctype_alnum($name)) {
	$_SESSION['errors']['badname'] = 'user name can only contain letters and numbers';
} 


if (empty($_POST['email'])) {
	$_SESSION['errors']['nullemail'] = 'Email required. Don\'t worry, we only need it to reset your password.';
} else {
	$email = $_POST['email'];
}
if (empty($_POST['password'])) {
	$_SESSION['errors']['nullpassword'] = 'Password is required';
} else {
	$password = $_POST['password'];
}
// if errors, back to registration form
if (!empty($_SESSION['errors'])) {
	header('location: '. WWW_ROOT . 'login/register.php ');
	die();
}

// make sure this person isn't making a user name that someone else has choosen.
$nameIsNotUnique = checkUniqueUserName($hash, $name);
if ($nameIsNotUnique) {
	$_SESSION['errors']['duplicatename'] = 'Sorry, that name is already being used. Please choose another.';
}
// see if they typed something that resembles an email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$_SESSION['errors']['notvalidemail'] = 'Invalid email.';
}
// make sure their password is at least 6 characters long, don't feel like making a hackers job too easy
if (strlen($password) < 6) {
	$_SESSION['errors']['passwordtoshort'] = 'Password needs to be 6 characters or more';
}

// after further validation  - if errors, back to registration form
if (!empty($_SESSION['errors'])) {
	header('location:  '. WWW_ROOT . 'login/register.php ');
	die();
}

//hash password
$salt = sha1(uniqid());
$password = $_POST['password'];
$hashedAndSaltedPassword = sha1($salt . $password);
//insert into user
$insert_stmt = insertUser($hash, $name, $hashedAndSaltedPassword, $email, $salt, $hashName);
// check if insert failed
if ($insert_stmt->rowCount() != 1) {
	$_SESSION['bug'] = 'Was unable to insert your new registration into the database :(';
	header('location: ' . WWW_ROOT  . 'error.php ');
	die();
} else {
	$id = $hash->lastInsertId();
	// make sure an ID was returned. This is a little over kill but I like to make sure.
	if (empty($id)) {
		$_SESSION['bug'] = 'There was an error entering your information into the database! :(';
		header('location: ' . WWW_ROOT  . 'error.php ');
		die();
	}
	logHasherIn($hash, $id);
	header('location: ' . WWW_ROOT . 'index.php');
	die();
}



?>