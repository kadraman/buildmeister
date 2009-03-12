<?php

include_once("common.inc");
include_once("session.php");

	$name = isset($_POST['name']) ? $database->clean_data($_POST['name']) : '';
	$email = isset($_POST['email']) ? $database->clean_data($_POST['email']) : '';
	$message = isset($_POST['messageText']) ? $database->clean_data($_POST['messageText']) : '';
	$catchpa_text = isset($_POST['catchpa_text']) ? $database->clean_data($_POST['catchpa_text']) : '';

	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	// do we have a name
	if (!$name) {
		$json_result['message'] = "Your <b>name</b> is required.";
		$json_result['field'] = "name";
		exit(json_encode($json_result));
	}

	// do we gave an email
	if (!$email) {
		$json_result['message'] = "Your <b>email</b> is required.";
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
	
	// do we have a message
	//if ((strcmp($message,"Enter your message here...") == 0) || (strcmp($message,"") == 0)) {
	//	$json_result['message'] = "A <b>message</b> is required.";
	//	exit(json_encode($json_result));
	//}
	
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
	
	// convert html entities
	$message = nl2br(htmlentities($message));

	// try to submit message
	if ($mailer->sendContact($name, $email, html_entity_decode($message))) {
		$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
		$json_result['message'] = "Error submitting contact message: "
			. print_r($mailer->error_message, true);; 
		exit(json_encode($json_result));
	}
	
?>

