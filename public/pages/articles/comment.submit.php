<?php

include_once("common.inc");
include_once("session.php");

	$name = isset($_POST['name']) ? clean_data($_POST['name']) : '';
	$email = isset($_POST['email']) ? clean_data($_POST['email']) : '';
	$comment = isset($_POST['commentText']) ? clean_data($_POST['commentText']) : '';
	$article_id	= isset($_POST['article_id']) ? clean_data($_POST['article_id']) : '';
	$catchpa_text = isset($_POST['catchpa_text']) ? clean_data($_POST['catchpa_text']) : '';
		
	// check if we have enough parameters
	if ($name == "" || $email == "" || $comment == "" || $article_id == "" || $catchpa_text == "") {
		exit("INVALID_ARGS");
	}
	
	// validate email
	$email_regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
		."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
		."\.([a-z]{2,}){1}$";
	if (!eregi($email_regex, $email)) {
		exit("INVALID_EMAIL");
	}
		
	// validate catchpa	
	if ($session->securimage->check($catchpa_text) == false) {
		exit("INVALID_CATCHPA");
	}
	
	// convert html entities
	$comment = nl2br(htmlentities($comment));

	// try to submit comment
	// TODO: persist email
	if ($database->addNewArticleComment($name, $article_id, $comment)) {
		// TODO: only send email if not on localhost
		//$mailer->sendNotification("New article comment added by " . $name . ":\n\n" . $comment);
		exit("OK");
	} else {
		exit("DB_ERROR");
	}
	
?>

