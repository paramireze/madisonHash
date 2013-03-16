<?php
if(!isset($_SESSION)) {
	session_start();
}

date_default_timezone_set('America/Chicago');

	error_reporting(E_ALL);
	ini_set('display_errors','On');


// either redirect users back to their page or, if they didn't come from one, to home page
// this function is called if the user failed authorization
if (!function_exists('redirectUser')) {
	function redirectUser($errorMessage) {
		if (empty($_SERVER['HTTP_REFERER'])) {
			$_SESSION['pageError'] = $errorMessage;
			header('location: ' . WWW_ROOT . 'index.php');
			die();
		} else {
			$_SESSION['pageError'] = $errorMessage;
			$returnURL = $_SERVER['HTTP_REFERER'];
			header('location: ' . $returnURL);
			die();
			
		}
	}
}

if (!defined('curWebRoot')) {
	function curWebRoot() {
		$pageURL = 'http';
		if (isset( $_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
				$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"];
			}
		return $pageURL;
	}
}
if (!defined('curPageURL')) {
	function curPageURL() {
		$pageURL = 'http';
		if (isset( $_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
				$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
		return $pageURL;
	}
}

//check to see if a session is already started. If not, start session
// this allows me to use relative paths. 
if (!defined('DIR_ROOT')) {
	if (!empty($_SERVER['HTTP_HOST']) && strip_tags($_SERVER['HTTP_HOST']) == 'localhost:8080') {
		define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT'] . 'hash/');
	} else {
		define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
	}
}
// this allows me to use relative paths. 
if (!defined('WWW_ROOT')) {
	if (!empty($_SERVER['HTTP_HOST']) && strip_tags($_SERVER['HTTP_HOST']) == 'localhost:8080') {
		define('WWW_ROOT', curWebRoot() . '/hash/');
	}
	else {
		define('WWW_ROOT', curWebRoot() . '/');
	}
}

// get the current url by concatenating the server name and request URI
// returns the current url that the person is on
$listOfProtectedFiles['admin'][WWW_ROOT . 'example2.php'] = 'admin';
$listOfProtectedFiles['admin'][WWW_ROOT . 'example2.php'] = 'member';
$listOfProtectedFiles['admin'][WWW_ROOT . 'users.php'] = 'member';

// this block of code enforces authorization through roles. 
// if you want to change the permissions, switch out the values above, example, change admin to guest for that file

foreach ($listOfProtectedFiles['admin'] as $key => $value) {
	if (curPageURL() == $key) {
		if (!isset($_SESSION['user']['role'])) {
			$errorMessage = 'must be logged in to visit ' . curPageURL();
			redirectUser($errorMessage);
		}

		if ($_SESSION['user']['role'] != 'admin') {			
			if ($value != $_SESSION['user']['role']) {
				if (empty($_SERVER['HTTP_REFERER'])) {					
					$errorMessage = 'You are not authorized to visit ' . curPageURL(). '. email Webmaster@madisonh3.com to request access';					
					redirectUser($errorMessage);
				}
			}
		}
	}
}

// test
// shouold be called at every form
if (!function_exists('getToken')) {
	function getToken() {
		if(!isset($_SESSION['user_token'])) {
			$_SESSION['user_token'] = sha1(uniqid());
		}
	}
}
//put this into every page receiving the token
if (!function_exists('checkToken')) {
	function checkToken($token) {
		if($token != $_SESSION['user_token']) {
			return true;
		} else {
			return false;
		}
	}
	
}
//call this on every form
if (!function_exists('getTokenField')) {
	function getTokenField() {
		return '<input type="hidden" name="token" value="'. $_SESSION['user_token'].'" />';
		
	}
}

if (!function_exists('destroyToken')) {
	function destroyToken() {
		unset($_SESSION['user_token']);
	}
}
// =============================================================================
// Contents:
//   r_check_csrf_token()
//   r_set_session_csrf_token()
//
// =============================================================================


//
// r_check_csrf_token
//   verifies the session CSRF token against the one recieved in a POST request
// parameters[]
//   $post_csrf_token   string    hex-encoded token from $_POST['CSRFtoken']
// return
//   bool   TRUE if token matches session CSRF token, FALSE otherwise
// usage
//   if ( !isset($_POST['CSRFtoken])
//        || !r_check_csrf_token($_POST['CSRFtoken']) ) {
//     r_error('CSRF token mismatch');
//   } // else proceed as normal
//
/*
function r_check_csrf_token( $post_csrf_token ) {
  if ( !isset($_SESSION['CSRFtoken']) ) {
    r_set_session_csrf_token();
    return FALSE;
  }
  if ( isset($_SESSION['CSRFtoken'])
       && $_SESSION['CSRFtoken'] != $post_csrf_token ) {
        r_set_session_csrf_token();
       return FALSE;
  }
  return TRUE;
}


function r_set_session_csrf_token() {
  $sessionID = session_id();
  if ( empty($sessionID) ) {
    r_error('Could not create session CSRF token - no active session');
    return FALSE;
  } else {
    $_SESSION['CSRFtoken'] = hash('sha256',mt_rand());
  }
  return $_SESSION['CSRFtoken'];
}
*/
?>