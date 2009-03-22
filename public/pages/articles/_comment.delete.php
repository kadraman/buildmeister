<?php

include_once("common.inc");
include_once("session.php");

	$cid = isset($_POST['cid']) ? $database->clean_data($_POST['cid']) : '';
	
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	if (!$session->isAdmin()) {
		$json_result['message'] = "Only Administrators are allowed to delete comments.";
		exit(json_encode($json_result));
	}

	// do we have a comment
	if (!$cid) {
		$json_result['message'] = "A comment id is required.";
		exit(json_encode($json_result));
	}
   
	// does the comment exist
	if (!$database->articleCommentExists($cid)) {
		$json_result['message'] = "The comment does not exist.";
		exit(json_encode($json_result));	        
    } 
    
    // delete the comment
	if ($database->deleteArticleComment($cid)) {
	 	$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
	   	$json_result['message'] = "Error deleting comment from the database."; 
		exit(json_encode($json_result));
    }    

?>
