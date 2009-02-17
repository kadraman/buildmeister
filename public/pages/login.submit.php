<?php

include_once("common.inc");
include_once("session.php");

	$user = isset($_POST['user']) ? clean_data($_POST['user']) : '';
	$pass = isset($_POST['pass']) ? clean_data($_POST['pass']) : '';
	$remember = isset($_POST['remember']);
	
	if ($user == "" || $pass == "") {
		exit("INVALID_ARGS");
	} else {
		$retval =  $session->login($user, $pass, $remember);
		exit($retval);
	}
?>

