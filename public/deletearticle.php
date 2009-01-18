<?php

// articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("include/header.php");

if (!$session->isAdmin()) {
	// insufficient permission to delete article
    $session->displayDialog("Insufficient Permission",
      	"Only administrators are allowed to delete articles.",
        $session->referrer);
} else {
	if (!isset($_GET['id'])) {
		// no article specified
	    $session->displayDialog("No Article Specified",
	    	"No article has been specified, please select an article on the "
	        . "<a href='articles.php'>articles</a> page to see its content.",
	        SITE_BASEDIR . "/articles.php");       
	} else if (!$database->articleExists($_GET['id'])) {
		// invalid article specified
		$session->displayDialog("Article Does Not Exist",
	    	"The specified article does not exist, please select an article on the "
	    	. "<a href='articles.php'>articles</a> page to see its content.",
	        SITE_BASEDIR . "/articles.php");		        
    } else {
        // delete the article
	    if ($database->deleteArticle(clean_data($_GET['id']))) {
	    	// delete succeeded
	    	$session->displayDialog("Article Deleted",
	    	"The specified article has been succesfully deleted.",
	        SITE_BASEDIR . "/articles.php"); 
	    } else {
	    	// delete failed
	    	$session->displayDialog("Error Deleting Article",
	    	"There was an error deleting the article.",
	        SITE_BASEDIR . "/articles.php"); 
	    }
    }    
}
    
include_once("include/footer.php");

?>
