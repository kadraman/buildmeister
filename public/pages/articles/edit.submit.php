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
		
	// check if we have enough parameters
	if ($title == "" || $summary == "" || $content == "" || $date == "" 
		|| $state == "" || $author == "" || $article_id == "") {
		exit("INVALID_ARGS");
	}
	
	// convert html entities
	$content = nl2br(htmlentities($content));

	// try to save article
	if ($database->updateArticle($article_id, $title, $summary, 
		$category, $date, $state, $author, $content)) {
		exit("OK");
	} else {
		exit("DB_ERROR");
	}
	
?>

