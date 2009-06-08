<?php

include_once("common.inc");
include_once("session.php");

	$user = isset($_POST['user']) ? $database->clean_data($_POST['user']) : '';
	
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	if (!$session->isAdmin()) {
		$json_result['message'] = "Only Administrators are allowed to delete users.";
		exit(json_encode($json_result));
	}

	// do we have a user
	if (!$user) {
		$json_result['message'] = "A username is required.";
		exit(json_encode($json_result));
	}
   
	// does the user exist
	if (!$database->userExists($user)) {
		$json_result['message'] = "The user does not exist.";
		exit(json_encode($json_result));	        
    } 
    
    // delete the user
	if ($database->deleteUser($user)) {
	 	$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
	   	$json_result['message'] = "Error deleting user from the database."; 
		exit(json_encode($json_result));
    }    

?>
