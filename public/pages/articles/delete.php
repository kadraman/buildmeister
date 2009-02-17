<?php

// setup include path
if (!defined("PATH_SEPARATOR")) {
	if (strpos($_ENV["OS"], "Win") !== false)
		define("PATH_SEPARATOR", ";");
	else define("PATH_SEPARATOR", ":");
} 
ini_set("include_path", "." . PATH_SEPARATOR . "../" . PATH_SEPARATOR
. "./include" . PATH_SEPARATOR . "../../include");
	
// articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("header.php");

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
	        . "<b>articles</b> page to see its content.",
	        SITE_BASEDIR . "/pages/articles/");       
	} else if (!$database->articleExists($_GET['id'])) {
		// invalid article specified
		$session->displayDialog("Article Does Not Exist",
	    	"The specified article does not exist, please select an article on the "
	    	. "<b>articles</b> page to see its content.",
	        SITE_BASEDIR . "/pages/articles/");		        
    } else {
        // delete the article
	    if ($database->deleteArticle(clean_data($_GET['id']))) {
	    	// delete succeeded
	    	$session->displayDialog("Article Deleted",
	    	"The specified article has been succesfully deleted.",
	        SITE_BASEDIR . "/pages/articles/"); 
	    } else {
	    	// delete failed
	    	$session->displayDialog("Error Deleting Article",
	    	"There was an error deleting the article.",
	        SITE_BASEDIR . "/pages/articles/"); 
	    }
    }    
}
    
include_once("footer.php");

?>
