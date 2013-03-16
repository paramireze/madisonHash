<?php
if (!function_exists('insertUser')) {
	function insertUser($conn, $name, $password, $email, $salt, $hashName) {
		$insert_user['query'] = "INSERT INTO users (name, password, role, email, salt, hashName) 
						VALUES (:name, :password, 'guest', :email, :salt, :hashName)";
		$insert_user['params'] = array();
		$insert_user['params'][':name'] = $name;
		$insert_user['params'][':password'] = $password;
		$insert_user['params'][':email'] = $email;
		$insert_user['params'][':salt'] = $salt;
		$insert_user['params'][':hashName'] = $hashName;
		
		return do_pdo_query($conn, $insert_user['query'], $insert_user['params']);		
	}
}

if (!function_exists('updatePassword')) {
	function updatePassword($conn, $id, $password) {
		$update_password['query'] = "UPDATE users 
						SET (password = :password)
						WHERE id = :id";
		$update_password['params'] = array();
		$update_password['params'][':password'] = $password;
		$update_password['params'][':id'] = $id;
		
		return do_pdo_query($conn, $update_password['query'], $update_password['params']);
	}
}

if (!function_exists('updateUser')) {
	function updateUser($conn, $id, $name, $role, $hashName) {
		$update_user['query'] = "UPDATE users 
						SET (name = :name, hashName = :hashName, password = :password, role = :role)
						WHERE id = :id";
		$update_user['params'] = array();
		$update_user['params'][':name'] = $name;
		$update_user['params'][':hashName'] = $hashName;
		$update_user['params'][':role'] = $role;
		$update_user['params'][':id'] = $id;
		
		return do_pdo_query($conn, $update_user['query'], $update_user['params']);
	}
}

if (!function_exists('deleteUser')) {
	function deleteUser($conn, $id) {
		$delete_user['query'] = "DELETE FROM users 
							WHERE id = :id";
		$delete_user['params'] = array();
		$delete_user['params'][':id'] = $id;
		
		return  do_pdo_query($conn, $delete_user['query'], $delete_user['params']);
	}
}
	
if (!function_exists('getHasherByName')) {
	function getHasherByName($conn, $name) {
		$get_single_user['query'] = "SELECT user_id, name, role, salt, password
								FROM users 
								WHERE name = :name";
								
		$get_single_user['params'] = array();
		$get_single_user['params'][':name'] = $name;
		
		$get_single_user_stmt = do_pdo_query($conn, $get_single_user['query'], $get_single_user['params']);
		if ($get_single_user_stmt->rowCount() != 1) {
			$_SESSION['bug'] = 'Currently experiencing an log in error :(';
			header('location: ' . WWW_ROOT  . 'error.php ');
			die();
		}
		return $get_single_user_stmt;
		
	}
}

if (!function_exists('checkLoginName')) {
	function checkLoginName($conn, $name) {
		$get_single_user['query'] = "SELECT COUNT(*) as matches
								FROM users 
								WHERE name = :name";
								
		$get_single_user['params'] = array();
		$get_single_user['params'][':name'] = $name;
		
		$get_single_user_stmt = do_pdo_query($conn, $get_single_user['query'], $get_single_user['params']);
		
		$get_single_user_row = $get_single_user_stmt->fetch();
		if ($get_single_user_row['matches'] > 1) {
			$_SESSION['bug'] = 'Unexpected results from the database';
			header('location: ' . WWW_ROOT  . 'error.php ');
			die();
		}
		return $get_single_user_row['matches'];
		
		
	}
}


if (!function_exists('logHasherIn')) {
	function logHasherIn($conn, $id) {
		$log_in_hasher['query'] = "SELECT user_id, name, hashName, email, role
								FROM users 
								WHERE user_id = :id";
								
		$log_in_hasher['params'] = array();
		$log_in_hasher['params'][':id'] = $id;
		
		$log_in_hasher_stmt = do_pdo_query($conn, $log_in_hasher['query'], $log_in_hasher['params']);
		if ($log_in_hasher_stmt->rowCount() != 1) {
			$_SESSION['bug'] = 'failed to log you in :(';
			header('location: ' . WWW_ROOT  . 'error.php ');
			die();
		}	
		$log_in_hasher_row = $log_in_hasher_stmt->fetch();
		$id = $log_in_hasher_row['user_id'];
		$name = $log_in_hasher_row['name'];
		$email = $log_in_hasher_row['email'];
		$role = $log_in_hasher_row['role'];
		$hashName = $log_in_hasher_row['hashName'];
		
		// this person is now logged in
		$_SESSION['user']['id'] = $id;
		$_SESSION['user']['name'] = $name;
		$_SESSION['user']['hashName'] = $hashName;
		$_SESSION['bug'] = NULL;
		$_SESSION['user']['loggedIn'] = true;
		$_SESSION['user']['role'] = $role;
		
		return true;
	}
}

if (!function_exists('selectAllAdmin')) {
	function selectAllAdmin($conn) {
		$select_all_admins['query'] = "SELECT user_id, hashName, name, role, email
								FROM users
								WHERE role = 'admin'";
								
		$select_all_admins['params'] = NULL;		
		return do_pdo_query($conn, $select_all_admins['query'], $select_all_admins['params']);
	}
}	
if (!function_exists('selectAllMembers')) {
	function selectAllMembers($conn) {
		$select_all_members['query'] = "SELECT user_id, hashName, name, role, email
								FROM users
								WHERE role = 'member'";
								
		$select_all_members['params'] = NULL;		
		return do_pdo_query($conn, $select_all_members['query'], $select_all_members['params']);
	}
}	
if (!function_exists('selectAllGuests')) {
	function selectAllGuests($conn) {
		$select_all_users['query'] = "SELECT user_id, hashName, name, role, email
								FROM users
								WHERE role = 'guest'";
								
		$select_all_users['params'] = NULL;		
		return do_pdo_query($conn, $select_all_users['query'], $select_all_users['params']);
	}
}	

if (!function_exists('selectAllUsers')) {
	function selectAllUsers($conn) {
		$select_all_users['query'] = "SELECT user_id, hashName, name, role, email
								FROM users";
								
		$select_all_users['params'] = NULL;		
		return do_pdo_query($conn, $select_all_users['query'], $select_all_users['params']);
	}
}	
if (!function_exists('checkUniqueUserName')) {
	function checkUniqueUserName($conn, $name) {
		$select_all_users['query'] = "SELECT COUNT(*) as duplicateCount
								FROM users
								WHERE name = :name
								";
								
		$select_all_users['params'] = array();		
		$select_all_users['params'][':name'] = $name;		
		$select_all_users_stmt =  do_pdo_query($conn, $select_all_users['query'], $select_all_users['params']);
		$select_all_users_row = $select_all_users_stmt->fetch();
		return $select_all_users_row['duplicateCount'];
		
		
	}
}	

if (!function_exists('checkIfPasswordAndUserNameMatches')) {
	function checkIfPasswordAndUserNameMatches($conn, $loginName, $password) {
		$check_login_info['query'] = "SELECT COUNT(*) as isLoggedIn
								FROM users
								WHERE name = :loginName
									AND password = :password";
								
		$check_login_info['params'] = array();
		$check_login_info['params'][':loginName'] = $loginName;
		$check_login_info['params'][':password'] = $password;

		$check_login_info_stmt = do_pdo_query($conn, $check_login_info['query'], $check_login_info['params']);
		if ($check_login_info_stmt->rowCount() == 1) {
			return false;
		} else {
			return true;
		}
	}
}	
	
?>