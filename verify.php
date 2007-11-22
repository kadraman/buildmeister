<?php

# retrieve the id of the article to display
if (isset($_GET['email']) && isset($_GET['verify'])) {
	$regemail     = urldecode($_GET['email']);
	$verifystring = urldecode($_GET['verify']); 
} else {
	  // verification failed
	  $session->displayDialog("Verification Failed",
          "We're sorry, but an error has occurred and your verification could not be completed. "
          . "Please try again at a later time.",
          SITE_BASEDIR . "/index.php");
}

include("include/header.php");

// check if user has already been activated
if ($database->confirmUserInactive($email) == 0) {
    $session->displayDialog("Already Activated",
    	"We're sorry, but the user for email " . $email . " has already been activated.",
        SITE_BASEDIR . "/index.php");
} else {
    # make user active
    $database->activateUser($email);
    $session->displayDialog("User Activated",
    	"The user for email " . $email . " has been activated. "
        . "You may now <a href=\"login.php\">login</a> to the site.",
        SITE_BASEDIR . "/login.php");
}    

include("include/footer.php");

?>
