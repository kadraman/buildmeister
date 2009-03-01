<?php

include_once("common.inc");
include_once("session.php");

	// check and clean form fields
	$user = isset($_POST['user']) ? clean_data($_POST['user']) : '';
		
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure		
			
	// do we have the username
	if (!$user) {  
		$json_result['message'] = "Your <b>username</b> is required.";	
		$json_result['field'] = "user";	
		exit(json_encode($json_result));
	}
	
	// check username
	if ($user) {
		if (!$database->usernameTaken($user)) {
			$json_result['message'] = "The <b>username</b> does not exist.";
			$json_result['field'] = "user";
			exit(json_encode($json_result));
		} 
	}
	
	// generate new password
    $newpass = $session->generateRandStr(8);

    // Get email of user */
    $user_info = $database->getUserInfo($user);
    $email  = $user_info['email'];

    // attempt to send the email with new password
    if ($mailer->sendNewPass($user, $email, $newpass)) {
    	// email sent, update database
        $database->updateUserField($user, "password", md5($newpass));
        $json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
    } else {
    	// failed to send email, do not update database
    	$json_result['message'] = "Failed to send email: " .
    		print_r($mailer->error_message, true);     	
		exit(json_encode($json_result));
    }
		
?>

