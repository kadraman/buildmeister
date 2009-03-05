<?php

include_once("common.inc");
include_once("session.php");

	$name = isset($_POST['name']) ? clean_data($_POST['name']) : '';
	$website = isset($_POST['website']) ? clean_data($_POST['website']) : '';
	$comment = isset($_POST['commentText']) ? clean_data($_POST['commentText']) : '';
	$article_id	= isset($_POST['article_id']) ? clean_data($_POST['article_id']) : '';
	$catchpa_text = isset($_POST['catchpa_text']) ? clean_data($_POST['catchpa_text']) : '';

	// array for JSON result
	$json_result = array();
	$json_result['code'] = 0; 		// assume failure
	
	// do we have the article id
	if (!$article_id) {  
		$json_result['message'] = "Internal error: unknown article.";
		exit(json_encode($json_result));
	}
	
	// do we have a name
	if (!$name) {
		$json_result['message'] = "Your <b>name</b> is required.";
		$json_result['field'] = "name";
		exit(json_encode($json_result));
	}

	// do we have a website
	if ($website) {
		$regexp = "/\b(?:(?:https?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		if (!preg_match($regexp, $website)) {
			$json_result['message'] = "The <b>website</b> address is invalid.";
			$json_result['field'] = "website";
			exit(json_encode($json_result));;
		} else {
			// strip http etc
			$website = preg_replace("/^https?:\/\/(.+)$/i","\\1", $website);
		}
	}
	
	// do we have a comment
	if ((strcmp($comment,"Enter your comment here...") == 0) || (strcmp($comment,"") == 0)) {
		$json_result['message'] = "A <b>comment</b> is required.";
		exit(json_encode($json_result));
	}
	
	// do we have a catchpa
	if (!$catchpa_text) {
		$json_result['message'] = "You are required to enter the text as shown in the <b>catchpa</b> image.";
		$json_result['field'] = "catchpa_text";
		exit(json_encode($json_result));
	}
		
	// validate catchpa	
	if ($session->securimage->check($catchpa_text) == false) {
		$json_result['message'] = "The <b>catchpa</b> you entered is invalid, please try again.";
		$json_result['field'] = "catchpa_text";
		exit(json_encode($json_result));
	}
	
	// convert html entities
	$comment = nl2br(htmlentities($comment));

	// try to submit comment
	if ($database->addNewArticleComment($name, $website, $article_id, $comment)) {
		$mailer->sendNotification("New article comment added by " . $name . ":\n\n" 
			. html_entity_decode($comment));
		$json_result['code'] = 1;
		$json_result['message'] = "Success"; 
		exit(json_encode($json_result));
	} else {
		$json_result['message'] = "Error submitting comment to the database."; 
		exit(json_encode($json_result));
	}
	
?>

