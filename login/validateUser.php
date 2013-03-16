<?php
/*
created by: nummy 2/22/2013
description: 
	this page will validate someone's log in credentials and, if they match a record in the database, the program will log them in
	
process
	program will check the following 
		make sure they are not hackers by checking referer
		if they did not enter a password or log in name, kick them back
		if the log in name does not match a log in name in the database, kick them back
		if the log in name matches but the password doesn't match the pw in database, kick them back
	if valid password and log in name
		assign session variables with user information
		send back to page they logged in from

*/
include '../includes/common.php';
	/*
		@TODO:  
				finished authenticating user
					write code to concatenate hash and password
					then write check 
				finish writing function getHasher
				
				
	*/
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

// make sure that the hasher entered a log in name and password
if (empty($_POST['loginName']) || empty($_POST['password'])) {
	$_SESSION['loginError'] = TRUE;
	header('location: '. $returnURL);
	die();
} 


include  DIR_ROOT . 'includes/functions/database_connection.php';
include  DIR_ROOT . 'includes/functions/do_pdo_query.php';
include  DIR_ROOT . 'methods/user_methods.php';
$hash = pdo_connect_hash();

// make sure the hasher entered a name and password
$loginName = $_POST['loginName'];
$password = $_POST['password'];
$nameMatched = checkLoginName($hash, $loginName);
// IF NOT name matched, then throw login error and send them packing
if (!$nameMatched) {
	$_SESSION['pageError'] = 'Either log in name and/or password was incorrect.';
	header('location: '. $returnURL);
	die();

}

// make the computer wait 2 seconds before checking database. 
// This will seriously slow down scripts written by hackers from cracking user accounts the brute force method or rainbow tables;
sleep(2);

// get hasher by name
$hasher_info_stmt = getHasherByName($hash, $loginName);

// if more than 1 hasher was returned, then throw error
if ($hasher_info_stmt->rowCount() != 1) {
	$_SESSION['bug'] = 'Currently experiencing a log in error :(';
	header('location: ' . WWW_ROOT  . 'error.php ');
	die();
}
$hasher_info_row = $hasher_info_stmt->fetch();
$id = $hasher_info_row['user_id'];
$storedPassword = $hasher_info_row['password'];
$salt = $hasher_info_row['salt'];
$role = $hasher_info_row['role'];

// concatenate salt and password, then hash them to create hashed password. 
// if user used the correct password, then it will match the one in the database.
// this method is called salting a password which means you add random values to someone's password, making it harder to hack.
$password =  sha1($salt .  $password);
if ($password != $storedPassword) {
	$_SESSION['pageError'] = 'Either log in name and/or password was incorrect.';
	header('location: '. $returnURL);
	die();
}

session_regenerate_id(true); 

$_SESSION['user']['id'] = $id;
$_SESSION['user']['name'] = $loginName;
$_SESSION['bug'] = NULL;
$_SESSION['user']['loggedIn'] = true;
$_SESSION['user']['role'] = $role;

/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
die();
*/

header('location: ' . $returnURL);

?>
