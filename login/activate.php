<?php
require ("config.php");
//check if there is a need to validate the account in the 1st place
if ($need_to_validate_acct)
{
	print '<link rel="stylesheet" type="text/css" href="style.css" />';
	//define these vars incase server doesn't support global vars
	$email = $_GET['email'];
	$password = $_GET['password'];
	$key = $_GET['key'];
	//execute the query to check for the correct row in the db and update it
	$activate1 = "SELECT * from ".$mysql_pretext."_users where email='$email' and password='$password' and validkey='$key'";
	$activate2 = mysql_query($activate1) or die(mysql_error());
	$activate3 = mysql_fetch_array ($activate2);
	if (!$activate3)
	{
	 	//failure
	 	print '<p align="center">Unable to activate your account.Plese check you entered a valid URL.</p>';
	  	print '<p align="center"><a href="javascript:window.close();">Close Window</a></p>';
	}
	else
	{
		//success
		$update = "Update ".$mysql_pretext."_users set validated='1' where email='$email'";
		mysql_query($update) or die("Could not activate");
  		print '<p align="center">Account activated</p>';
		print '<p align="center"><a href="javascript:window.close();">Close Window</a></p>';
	}
}
//someone trying to act funny,so we act funny with him
else
{
	die("<font color=\"red\">FATAL ERROR. TERMINATING PROGRAM</font>");
}
?>


  