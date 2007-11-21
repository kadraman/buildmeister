<?php

# retrieve the id of the article to display
if (isset($_GET['email']) && isset($_GET['verify'])) {
	$regemail     = urldecode($_GET['email']);
	$verifystring = urldecode($_GET['verify']); 
} else {
	  // verification failed
      echo "<p>We're sorry, but an error has occurred and your verification could not be completed."
      . "<br>Please try again at a later time.</p>";
}

include("include/header.php");

// check if user has already been activated
if ($database->confirmUserInactive($email) == 0) {
      echo "<p>We're sorry, but the user for email " . $email . " has already been activated.";
} else {
    # make user active
    $database->activateUser($email);
    echo "<p>The user for email " . $email . " has been activated."
    . "\n\nYou may now <a href=\"login.php\">login</a> to the site.";
}    

include("include/footer.php");

?>
