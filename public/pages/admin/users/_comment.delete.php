<?php

include_once("common.inc");
include_once("session.php");

	$id = isset($_POST['id']) ? $database->clean_data($_POST['id']) : '';
	
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	if (!$session->isAdmin()) {
		$json_result['message'] = "Only Administrators are allowed to delete comments.";
		exit(json_encode($json_result));
	}

	// do we have an id
	if (!$id) {
		$json_result['message'] = "A comment id is required.";
		exit(json_encode($json_result));
	}
   
	// does the article exist
	if (!$database->articleCommentExists($id)) {
		$json_result['message'] = "The comment does not exist.";
		exit(json_encode($json_result));	        
    } 
    
    // delete the article
	if ($database->deleteArticleComment($id)) {
	 	$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
	   	$json_result['message'] = "Error deleting article comment from the database."; 
		exit(json_encode($json_result));
    }    

?>
