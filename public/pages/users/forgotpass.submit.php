<?php

include_once("common.inc");
include_once("session.php");

	// check and clean form fields
	$email = isset($_POST['email']) ? $database->clean_data($_POST['email']) : '';
		
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure		
			
	// do we have the username
	if (!$email) {  
		$json_result['message'] = "Your <b>email</b> is required.";	
		$json_result['field'] = "email";	
		exit(json_encode($json_result));
	}
	
	// check email
	if ($email) {
		if (!$database->emailTaken($email)) {
			$json_result['message'] = "The <b>email</b> address does not exist.";
			$json_result['field'] = "email";
			exit(json_encode($json_result));
		} 
	}
	
	// generate new password
    $newpass = $session->generateRandStr(8);

    // Get email of user */
    $user_info = $database->getUserInfoByEmail($email);
    $user  = $user_info['username'];

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

