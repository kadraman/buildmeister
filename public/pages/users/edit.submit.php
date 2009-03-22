<?php

include_once("common.inc");
include_once("session.php");

	// check and clean form fields
	$user = isset($_POST['user']) ? $database->clean_data($_POST['user']) : '';
	$newusername = isset($_POST['newusername']) ? $database->clean_data($_POST['newusername']) : '';
	$firstname = isset($_POST['firstname']) ? $database->clean_data($_POST['firstname']) : '';
	$lastname = isset($_POST['lastname']) ? $database->clean_data($_POST['lastname']) : '';
	$email = isset($_POST['email']) ? $database->clean_data($_POST['email']) : '';
	$website = isset($_POST['website']) ? $database->clean_data($_POST['website']) : '';
	$currentpass = isset($_POST['currentpass']) ? $database->clean_data($_POST['currentpass']) : '';
	$newpass = isset($_POST['newpass']) ? $database->clean_data($_POST['newpass']) : '';
	
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
			
	// do we have the username
	if (!$user) {  
		$json_result['message'] = "Internal error: unknown user.";
		exit(json_encode($json_result));
	}

	// do we have a firstname
	if (!$firstname) {  
		$json_result['message'] = "A <b>first name</b> is required.";
		$json_result['field'] = "firstname";
		exit(json_encode($json_result));
	}
	
	// do we have a lastname
	if (!$lastname) {
		$json_result['message'] = "A <b>last name</b> is required.";
		$json_result['field'] = "lastname";
		exit(json_encode($json_result));
	}
	
	// do we have an email
	if (!$email) {
		$json_result['message'] = "An <b>email</b> is required.";
		$json_result['field'] = "email";
		exit(json_encode($json_result));
	}	
		
	// new username entered by admin user
	if ($session->isAdmin()) {
		if ($newusername) {	
			$json_result['field'] = "newusername";			
			if (strlen($newusername) < 5) {
				$json_result['message'] = "The new <b>username</b> is required to be 5 or more characters.";
				exit(json_encode($json_result));
			} else if (strlen($newusername) > 30) {
				$json_result['message'] = "The new <b>username</b> is required to be 30 characters or less.";
				exit(json_encode($json_result));
			} else if (strcmp($newusername, $user) == 0) {
				$json_result['message'] = "The new <b>username</b> is the same as the current <b>username</b>.";
				exit(json_encode($json_result));
			} else if (!preg_match("/^([0-9a-z])+$/", $newusername)) {
				$json_result['message'] = "The new <b>username</b> should contain alpha numeric characters only.";
				exit(json_encode($json_result));
			} else if (strcasecmp($newusername, GUEST_NAME) == 0) {
				$json_result['message'] = "The new <b>username</b> is reserved.";
				exit(json_encode($json_result));			
			} else if ($database->usernameTaken($newusername)) {
				$json_result['message'] = "The new <b>username</b> is already in use.";
				exit(json_encode($json_result));
			} else if ($database->usernameBanned($newusername)) {
				$json_result['message'] = "The new <b>username</b> contains a banned word.";
				exit(json_encode($json_result));
			}
			$subusername = $newusername;
		} else {
			$subusername = $user;
		}
	} else {
		$subusername = $user; 	
	}
		
	// current password entered but no new password
	if ($currentpass && !$newpass) {		
		$json_result['field'] = "newpass";
		$json_result['message'] = "The <b>new password</b> needs to be supplied.";
		exit(json_encode($json_result));
	}
		
	// new password entered
	if ($newpass) {		
		$json_result['field'] = "currentpass";
		if (!$currentpass) {				
			$json_result['message'] = "The <b>current password</b> needs to be supplied.";
			exit(json_encode($json_result));
		} else if ($database->confirmUserPass($subusername, md5($currentpass)) != 0) {
			$json_result['message'] = "The <b>current password</b> is incorrect.";
			exit(json_encode($json_result));
		}

		$json_result['field'] = "newpass";
		// the new password is too short or not alphanumeric
		if (strlen($newpass) < 8) {
			$json_result['message'] = "The <b>new password</b> is required to be 8 or more characters.";
			exit(json_encode($json_result));
		} else if (strcmp($newpass, $currentpass) == 0) {
			$json_result['message'] = "The <b>new password</b> is the same as the old password.";
			exit(json_encode($json_result));
		} else if (!preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $newpass)) {
			$json_result['message'] = "The <b>new password</b> must contain at least one lower case letter, one upper case letter and one digit.";
			exit(json_encode($json_result));
		}
	}
		

	// email error checking
	if ($email) {
		// check if valid email address
		$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
		if (!preg_match($regexp, $email)) {
			$json_result['message'] = "The <b>email</b> address is invalid.";
			$json_result['field'] = "email";
			exit(json_encode($json_result));;
		}
	}
	
	// website error checking
	if ($website) {
		$regexp = "/\b(?:(?:https?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		if (!preg_match($regexp, $website)) {
			$json_result['message'] = "The <b>website</b> address is invalid.";
			$json_result['field'] = "website";
			exit(json_encode($json_result));;
		} else {
			// strip http etc
			$website = preg_replace("/^https?:\/\/(.+)$/i","\\1", $website);
		}
	}

	// update username		
	if ($session->isAdmin() && $newusername) {
		$database->updateUserField($user, "username", $newusername);
		// if changing own username, re-register session variables
		if (strcmp($session->username,$user) == 0) {
			 $session->username  = $_SESSION['username'] = $newusername;
		}
	}
	
		
	// update password 
	if ($currentpass && $newpass) {
		$database->updateUserField($subusername, "password", md5($newpass));
	}

	// update email
	if ($email) {
		$database->updateUserField($subusername, "email", $email);
	}
	
	// update website
	if ($website) {
		$database->updateUserField($subusername, "website", $website);
	}

	// update firstname
	if ($firstname) {
		$database->updateUserField($subusername, "firstname", $firstname);
	}

	// update lastname
	if ($lastname) {
		$database->updateUserField($subusername, "lastname", $lastname);
	}

	$json_result['code'] = 1;
	$json_result['message'] = "Success"; 
	exit(json_encode($json_result));
	
	
?>

