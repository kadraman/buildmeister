<?php

function pf_fix_slashes($string) {
	if (get_magic_Quotes_gpc() == 1) {
		return ($string);
	} else {
		return (addslashes($string));
	}
}

function pf_check_number($value) {
	if (isset($value) == FALSE) {
		$error = 1;
	}
	if (is_numeric($value) == FALSE) {
		$error = 1;
	}

	if ($error == 1) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function short_date($date) {
	return "(" . date("m-d", strtotime($date)) . ")";
}

function clean_data($string) {
	if (get_magic_quotes_gpc()) {
		$string = stripslashes($string);
	}
	return mysql_real_escape_string($string);
}

function clean_html_data($string) {
	if (get_magic_quotes_gpc()) {
		$string = htmlspecialchars(stripslashes($string));
	} else {
		$string = htmlspecialchars($string);
	}
	return mysql_real_escape_string($string);
}

?>
