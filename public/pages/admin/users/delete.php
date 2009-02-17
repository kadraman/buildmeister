<?php

include_once("common.inc");
include_once("header.php");

if (!$session->isAdmin()) {
	// insufficient permission to delete user
    $session->displayDialog("Insufficient Permission",
      	"Only administrators are allowed to delete users.",
        $session->referrer);
} else {
	if (!isset($_GET['username'])) {
		// no username specified
	    $session->displayDialog("No Username Specified",
	    	"No username has been specified, please select a user on the "
	        . "<b>users</b> page.",
	        SITE_BASEDIR . "/pages/admin/users/");       
	} else if (!$database->userExists($_GET['username'])) {
		// invalid username specified
		$session->displayDialog("Username Does Not Exist",
	    	"The specified username does not exist, please select a user on the "
	    	. "<b>users</b> page.",
	        SITE_BASEDIR . "/pages/admin/users/");		        
    } else {
        // delete the user
	    if ($database->deleteUser(clean_data($_GET['username']))) {
	    	// delete succeeded
	    	$session->displayDialog("User Deleted",
	    	"The specified user has been succesfully deleted.",
	        SITE_BASEDIR . "/pages/admin/users"); 
	    } else {
	    	// delete failed
	    	$session->displayDialog("Error Deleting User",
	    	"There was an error deleting the user.",
	        SITE_BASEDIR . "/pages/admin/users/"); 
	    }
    }    
}
    
include_once("footer.php");

?>
