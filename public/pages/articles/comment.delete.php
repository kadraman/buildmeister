<?php

include_once("common.inc");
include_once("header.inc");

if (!$session->isAdmin()) {
	// insufficient permission to delete comments
    $session->displayDialog("Insufficient Permission",
      	"Only administrators are allowed to delete comments.",
        $session->referrer);
} else {
	if (!isset($_GET['cid'])) {
		// no comment specified
	    $session->displayDialog("No Comment Specified",
	    	"No comment has been specified, please select a comment to be deleted.",
	        $session->referrer);       
	} else if (!$database->articleCommentExists($_GET['cid'])) {
		// invalid comment specified
		$session->displayDialog("Comment Does Not Exist",
	    	"The specified comment does not exist, please select a comment to be deleted.",
	        $session->referrer);		        
    } else {
    	$artid = $database->clean_data($_GET['aid']);
    	$atitle = $database->getArticleTitle($aid);
    	$atitle = str_replace(" ", "_", $atitle);
    	
        // delete the article comment
        // TODO: cater for other types of comments
	    if ($database->deleteArticleComment($database->clean_data($_GET['cid']))) {
	    	// delete succeeded
	    	$session->displayDialog("Comment Deleted",
	    	"The specified comment has been succesfully deleted.",
	        REWRITE_PREFIX . "/articles/$atitle"); 
	    } else {
	    	// delete failed
	    	$session->displayDialog("Error Deleting Comment",
	    	"There was an error deleting the comment.",
	        REWRITE_PREFIX . "/articles/$atitle"); 
	    }
    }    
}
    
include_once("footer.inc");

?>
