<?php
/*

name: do_pdo_query()
description:
	run the specified query, binding query parameters if provided
parameters:
	$db 					- pdo object
	$query        - static sql query string || query 		string with named parameter markers(e.g. ":variable")
	$query_params - [optional] required if $query contains any parameter markers. Associative array with keys that match the parameter markers in $query (of the form [':variable'])
return:
	PDOStatement containing the executed query, die() and log error on failure
*/
if (!function_exists('do_pdo_query')) {
	function do_pdo_query($db, $query, $query_params = NULL) {
		// no query parameters
		if (empty($query_params)) {
		  $stmt = $db->query($query);
			if (!$stmt) {				
				$log_msg = 'problem executing query "' . $query . '".';
				error_log($log_msg);
			}
		}
		// parameterized query
		else {
			try {
			  $stmt = $db->prepare($query);
        if ($stmt == NULL) {
          error_log('couldn\'t prepare query: ' . $query);
        }
        foreach ($query_params as $key => $value) {
          $stmt->bindValue($key, $value);
        }
        
				$result = $stmt->execute();
			}
			catch (Exception $e) {
			  $log_msg = 'problem executing query "' . $query . '": ' . $e->getMessage();
				error_log($log_msg);
			}
			if (!$result) {
			  $log_msg = 'problem executing query "' . $query . '" with paramater set: ' . print_r($query_params, TRUE);
				error_log($log_msg);
			}
		}

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
	return $stmt;
	}
}
?>