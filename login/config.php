<?php
if (eregi ("config.php",$_SERVER['PHP_SELF'])) die ("<font color=\"red\">FATAL ERROR. TERMINATING PROGRAM</font>");
/*
ADVANCED LOGIN SYSTEM
v0.03 BETA
ORIGINAL CODE BY
-Wu Xiao Tian
DEVELOPED BY iQuest Studios
FOR SUPPORT/BUG REPORTING,PLEASE VISIT
www.iqueststudios.com/forum
Please read the readme file
Files: config.php,login.php,activate.php,index.php,install.php,readme.txt,makeimg.php,register.php,style.css,logo.jpeg
*/
////////////////////////////////////////////////////////////////////////SETTINGS////////////////////////////////////////////////////////////////////////

// START MySQL Details //
$mysql_username = "root"; // your database username
$mysql_password = ""; // your database password
$mysql_dbname = "buildmeister"; // name of your database
$mysql_host = "localhost"; // your host, default is localhost
$mysql_pretext = ""; // the pretext you wish to have before the table
// END MySQL DETAILS //

// START CONFIGURATION SETTINGS //
$allow_guest_to_register = TRUE; //do you want to allow guests to register?
$need_to_validate_acct = TRUE; //do you need the users to validate their account through email?
$display_bot_image = FALSE; //do you want to display the validation image during registration/change password to prevent bots from registering? 
$display_bot_image_login = FALSE; //do you want to display the validation image during login to prevent brute forcing?
$admin_email = "admin@buildmeister.com"; //your email
$path = "http://localhost/buildmeister.com/login/"; //the path you installed the login system (eg. http://www.example.com/example/) Please remember to include the http://
$development = TRUE; //SET IT TO FALSE UNLESS YOUR DATA IS PROTECTED PROPERLY. ONLY FOR DEVELOPMENTAL USE,MAY CAUSE SECRUITY BREECH
// END CONFIGUATION SETTINGS //
//////////////////////////////////////////////////////////////////////END SETTINGS//////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////DO NOT EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING/////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

parse_str("$QUERY_STRING");
$db = mysql_connect($mysql_host, $mysql_username, $mysql_password) 
	or die("<font color=\"red\">ERROR:" . mysql_error() ." CODE = 1</font>");
if(!$db) 
	die("<font color=\"red\">ERROR:" . mysql_error() ." CODE = 2</font>");
if(!mysql_select_db($mysql_dbname,$db))
 	die("<font color=\"red\">ERROR:" . mysql_error() ." CODE = 3</font>"); 
	
//update checking. You are strongly advised not to remove this,as it may cause your script to be outdated and hence a security threat
//however,if you find it really a bother,then you can remove it
$update = "http://www.iqueststudios.com/updates/als/update2.txt";
$fp = @fopen ($update, "r");
if ($fp)
{
	die ("<center><font face=\"verdana\" color=\"green\" size=\"2\"><b>UPDATE!</b></font></center><p align=\"center\">There is an update ready. If you are the site admin, please upgrade your version of this script.Site disabled to prevent exploiting of discovered/fixed features. View updates at ".$update."</p>");
}
?>
