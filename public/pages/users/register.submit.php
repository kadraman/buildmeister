<?php

include_once("common.inc");
include_once("session.php");

	// check and clean form fields
	$firstname = isset($_POST['firstname']) ? $database->clean_data($_POST['firstname']) : '';
	$lastname = isset($_POST['lastname']) ? $database->clean_data($_POST['lastname']) : '';
	$username = isset($_POST['username']) ? $database->clean_data($_POST['username']) : '';
	$password = isset($_POST['password']) ? $database->clean_data($_POST['password']) : '';
	$verify = isset($_POST['verify']) ? $database->clean_data($_POST['verify']) : '';		
	$email = isset($_POST['email']) ? $database->clean_data($_POST['email']) : '';
	$website = isset($_POST['website']) ? $database->clean_data($_POST['website']) : '';
	$catchpa_text = isset($_POST['catchpa_text']) ? $database->clean_data($_POST['catchpa_text']) : '';
	$mailok = isset($_POST['mailok']) ? $database->clean_data($_POST['mailok']) : '';
	$agreedisc = isset($_POST['agreedisc']) ? $database->clean_data($_POST['agreedisc']) : '';
	
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
		
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
	
	// do we have the username
	if (!$username) {  
		$json_result['message'] = "A <b>username</b> is required.";
		$json_result['field'] = "username";
		exit(json_encode($json_result));
	} else {
		$json_result['field'] = "username";			
		if (strlen($username) < 5) {
			$json_result['message'] = "The <b>username</b> is required to be 5 or more characters.";
			exit(json_encode($json_result));
		} else if (strlen($username) > 30) {
			$json_result['message'] = "The <b>username</b> is required to be 30 characters or less.";
			exit(json_encode($json_result));
		} else if (!preg_match("/^([0-9a-z])+$/", $username)) {
			$json_result['message'] = "The <b>username</b> should contain alpha numeric characters only.";
			exit(json_encode($json_result));
		} else if (strcasecmp($username, GUEST_NAME) == 0) {
			$json_result['message'] = "The <b>username</b> is reserved.";
			exit(json_encode($json_result));			
		} else if ($database->usernameTaken($username)) {
			$json_result['message'] = "The <b>username</b> is already in use.";
			exit(json_encode($json_result));
		} else if ($database->usernameBanned($username)) {
			$json_result['message'] = "The <b>username</b> contains a banned word.";
			exit(json_encode($json_result));
		}
	}
	
	// do we have a password
	if (!$password) {
		$json_result['message'] = "A <b>password</b> is required.";
		$json_result['field'] = "password";
		exit(json_encode($json_result));
	} else {
		$json_result['field'] = "password";
		// the password is too short or not alphanumeric
		if (strlen($password) < 8) {
			$json_result['message'] = "The <b>password</b> is required to be 8 or more characters.";
			exit(json_encode($json_result));		
		} else if (!preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) {
			$json_result['message'] = "The <b>password</b> must contain at least one lower case letter, one upper case letter and one digit.";
			exit(json_encode($json_result));
		}
	}
	
	// do we have a password verification
	if (!$verify) {
		$json_result['message'] = "A <b>password verification</b> is required.";
		$json_result['field'] = "verify";
		exit(json_encode($json_result));
	}
	
	// do the passwords match
	if (strcmp($password, $verify) != 0) {		
		$json_result['field'] = "password";
		$json_result['message'] = "The <b>password</b> and <b>password verification</b> do not match.";
		exit(json_encode($json_result));
	}
	
	// do we have an email
	if (!$email) {
		$json_result['message'] = "An <b>email</b> is required.";
		$json_result['field'] = "email";
		exit(json_encode($json_result));
	} else {
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

	// do we have a catchpa
	if (!$catchpa_text) {
		$json_result['message'] = "You are required to enter the text as shown in the <b>catchpa</b> image.";
		$json_result['field'] = "catchpa_text";
		exit(json_encode($json_result));
	}
		
	// validate catchpa	
	if ($session->securimage->check($catchpa_text) == false) {
		$json_result['message'] = "The <b>catchpa</b> you entered is invalid, please try again.";
		$json_result['field'] = "catchpa_text";
		exit(json_encode($json_result));
	}
	
	// have we agreed to the disclosure
	if  (strcmp($agreedisc, "on") != 0) {
		$json_result['message'] = "You need to agree to the <b>disclosure</b> to register.";
		$json_result['field'] = "agreedisc";
		exit(json_encode($json_result));
	}

	// calculate verifystring
	$randomstring = "";
	for ($i = 0; $i < 16; $i++) {
		$randomstring .= chr(mt_rand(32, 126));
	}
	$verifystring = urlencode($randomstring);
	$verifyemail  = urlencode($email);
	
	// register the user
	if ($database->addNewUser($username, md5($password), $firstname, $lastname, 
		$email, $website, $randomstring, $mailok)) {
		$mailer->sendVerification($username, $email, $verifyemail, $verifystring);
		$mailer->sendNotification("A new user has registered: " . $firstname
			. " " . $lastname . " - " . $email);
		$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
		$json_result['message'] = "Error registering user."; 
		exit(json_encode($json_result));
	}
	
?>

