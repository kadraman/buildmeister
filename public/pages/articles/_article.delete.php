<?php

include_once("common.inc");
include_once("session.php");

	$aid = isset($_POST['id']) ? $database->clean_data($_POST['id']) : '';
	
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	if (!$session->isAdmin()) {
		$json_result['message'] = "Only Administrators are allowed to delete articles.";
		exit(json_encode($json_result));
	}
	
	// do we have an article
	if (!$aid) {
		$json_result['message'] = "An article id is required.";
		exit(json_encode($json_result));
	}
	
	// does the article exist
	if (!$database->articleExists($aid)) {
		$json_result['message'] = "The article does not exist.";
		exit(json_encode($json_result));	        
    } 
	
    // delete the article
	if ($database->deleteArticle($aid)) {
	 	$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
	   	$json_result['message'] = "Error deleting article from the database."; 
		exit(json_encode($json_result));
    }   
    
?>
