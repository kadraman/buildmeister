<?php

include_once("common.inc");
include_once("session.php");

	$title = isset($_POST['title']) ? $database->clean_data($_POST['title']) : '';
	$summary = isset($_POST['summary']) ? $database->clean_data($_POST['summary']) : '';
	$content = isset($_POST['contentText']) ? $database->clean_data($_POST['contentText']) : '';
	$date = isset($_POST['dateposted']) ? $database->clean_data($_POST['dateposted']) : '';
	$state = isset($_POST['state']) ? $database->clean_data($_POST['state']) : '';
	$author = isset($_POST['author']) ? $database->clean_data($_POST['author']) : '';
	$article_id	= isset($_POST['article_id']) ? $database->clean_data($_POST['article_id']) : '';
	$category	= isset($_POST['category']) ? $_POST['category'] : '';
		
	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	// do we have a title
	if (!$title) {
		$json_result['message'] = "A <b>title</b> is required.";
		$json_result['field'] = "title";
		exit(json_encode($json_result));
	}
	
	// do we have a summary
	if (!$title) {
		$json_result['message'] = "A <b>summary</b> is required.";
		$json_result['field'] = "summary";
		exit(json_encode($json_result));
	}
	
	// do we have a date
	if (!$title) {
		$json_result['message'] = "A <b>date</b> is required.";
		$json_result['field'] = "date";
		exit(json_encode($json_result));
	}
	
	// do we have some content
	if (!$title) {
		$json_result['message'] = "Some <b>content</b> is required.";
		$json_result['field'] = "contentText";
		exit(json_encode($json_result));
	}
	
	// convert html entities
	$content = nl2br(htmlentities($content));

	// try to save article
	if ($database->updateArticle($article_id, $title, $summary, 
		$category, $date, $state, $author, $content)) {
		$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
		$json_result['code'] = 1;
		$json_result['message'] = "Error submitting article to the database."; 
		exit(json_encode($json_result));
	}
	
?>

