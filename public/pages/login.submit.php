<?php

include_once("common.inc");
include_once("session.php");

	// check and clean form fields
	$user = isset($_POST['user']) ? clean_data($_POST['user']) : '';
	$pass = isset($_POST['pass']) ? clean_data($_POST['pass']) : '';
	$remember = isset($_POST['remember']);
	
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	// do we have the username
	if (!$user) {  
		$json_result['message'] = "A <b>username</b> is required.";
		$json_result['field'] = "user";
		exit(json_encode($json_result));
	}
	
	// do we have the password
	if (!$pass) {  
		$json_result['message'] = "A <b>password</b> is required.";
		$json_result['field'] = "pass";
		exit(json_encode($json_result));
	}
	
	// attempt login and act on results
	$login_status =  $session->login($user, $pass, $remember);
	switch ($login_status) {
		case "OK":
			$json_result['code'] = 1;
			$json_result['message'] = "Success"; 
			exit(json_encode($json_result));
			break;
		case "INVALID_USER":
			$json_result['message'] = "The <b>username</b> is not recognized."; 
			$json_result['field'] = "user";
			exit(json_encode($json_result));
			break;
		case "INVALID_PASSWORD":
			$json_result['message'] = "The <b>password</b> is incorrect for the specified user."; 
			$json_result['field'] = "pass";
			exit(json_encode($json_result));
			break;
		case "INACTIVE_USER";
			$json_result['message'] = "The specified user has not been activated."; 
			$json_result['field'] = "user";
			exit(json_encode($json_result));
			break; 
		default:
			$json_result['message'] = "Internal error validating user login.";
			exit(json_encode($json_result)); 
	}
?>

