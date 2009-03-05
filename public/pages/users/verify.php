<?php

include_once("common.inc");
include_once("header.php");

// do we have the right parameters
if (isset($_GET['email']) && isset($_GET['verify'])) {
	$email  = urldecode(clean_data($_GET['email']));
	$verify = urldecode(clean_data($_GET['verify']));
	// YES, check if they are valid
	if (!$database->confirmVerifyString($email, $verify)) {
		// verification failed
		$session->displayDialog("Verification Failed",
        	"We're sorry, but an error has occurred and your verification could not be completed. "
        	. "Please try again at a later time.",
        	SITE_BASEDIR . "/index.php");
	} else {
		// check if user has already been activated
		if ($database->confirmUserInactive($email) == 0) {
			// NO, display mes
			$session->displayDialog("Already Activated",
    			"The user for email " . $email . " has already been activated.",
				SITE_BASEDIR . "/pages/users/login.php");
		} else {
			// YES, make user active
			$database->activateUser($email);
			$session->displayDialog("User Activated",
    		"The user for email " . $email . " has been activated. "
    			. "You may now login to the site.",
    			SITE_BASEDIR . "/pages/users/login.php");
		}
	}
} else {
	// verification failed
	$session->displayDialog("Invalid Verification Attributes",
        "No or insufficient verification attributes have been supplied.",
		SITE_BASEDIR . "/index.php");
}


include_once("footer.php");

?>
