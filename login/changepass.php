<?php
ob_start();
session_start();
require ("config.php");
if (file_exists ("install.php")) die ("<font color=\"red\">FATAL ERROR. INSTALL.PHP EXISTS! POSSIBLE SECURITY RISK! TERMINATING PROGRAM</font>");
if (isset ($_SESSION['loggedin']) && isset ($_SESSION['time']))
{
	print '<title>Change Password</title><link rel="stylesheet" type="text/css" href="style.css" />';
	//set the variable to be the user's username
	$username = $_SESSION['loggedin'];
	
	//check if the user has submitted the form
	if(isset ($_POST['submit']))
	{
    	//declare variables frm form
		$cpass = $_POST['cpass'];
		$md5cpass = md5 ($cpass);
		$npass1 = $_POST['npass1'];
		$npass2 = $_POST['npass2'];
		//the validation no. user typed
		$imgno = md5 ($_POST['imgno']);
		//the real validation number
		$realno = $_POST['realno'];
		//if user didn't type old password
    	if (strlen ($cpass) < 1)
    	{
      		print "<p align=\"center\">You need to enter your current Password</p>";
			print "<p align=\"center\"><a href=\"changepass.php\">Retry?</a></p>";
    	}
		//if user didn't type new password
		else if (strlen ($npass1) < 1)
		{
      		print "<p align=\"center\">You need to enter your new Password</p>";
			print "<p align=\"center\"><a href=\"changepass.php\">Retry?</a></p>";
    	}	
		//if user didn't confirm new password
		else if (strlen ($npass2) < 1)
		{
      		print "<p align=\"center\">You need to confirm your new Password</p>";
			print "<p align=\"center\"><a href=\"changepass.php\">Retry?</a></p>";
    	}		
		//if new pass and confirm pass doesn't match
		else if ($npass1 != $npass2)
		{
      		print "<p align=\"center\">Your new passwords don't match!</p>";
			print "<p align=\"center\"><a href=\"changepass.php\">Retry?</a></p>";
    	}	
		//if user entered a validation no. of less than 3 chars			
		else if (strlen ($imgno) < 4 && $display_bot_image == TRUE)
		{
			print "<p align=\"center\">You did not enter a validation number</p>";
			print "<p align=\"center\"><a href=\"changepass.php\">Retry?</a></p>";
		}
		//if validation number is wrong
		else if ($imgno != $realno && $display_bot_image == TRUE)
		{
			print "<p align=\"center\">You did not enter a valid validation number</p>";
			print "<p align=\"center\"><a href=\"changepass.php\">Retry?</a></p>";
		}
		//so far so good...
    	else
    	{     
      		//check the current password = password in db
			$query = "SELECT * FROM ".$mysql_pretext."_users where username='$username' AND password='$md5cpass'";
    		$command = mysql_query ($query) 
				or die(mysql_error());
    		$execute = mysql_fetch_array ($command);
			//everything's ok!
			if ($execute)
			{
				$password = md5 ($npass1);
      			$updatepass = "UPDATE ".$mysql_pretext."_users set password='$password' where username='$username'";
      			mysql_query ($updatepass) 
					or die(mysql_error());
				//log the player out
				session_destroy();
     			print "<p align=\"center\">Your password has been changed!Please <a href=\"index.php\">relogin!</a></p>";
			}
			else
			{
				print "<p align=\"center\">Your current password is wrong!</p>";
				print "<p align=\"center\"><a href=\"changepass.php\">Retry?</a></p>";
			}				
    	}
   
	}
  	else
  	{
	$imgtxt = rand(100,999);
  	?>
    <table width="250" cellpadding="5px" align="center" border="1" style="border-style:dashed; border-width:thin; border-collapse:collapse;" cellspacing="0px">
	<form method="post" action="changepass.php" name="changepass">
	<input type="hidden" name="realno" value="<?php print md5 ($imgtxt); ?>" />
	<tr><td width="100" style="font-size:11">Current Password:</td><td><input type="password" name="cpass" size="20"></tr></tr>
	<tr><td width="100" style="font-size:11">New Password:</td><td><input type="password" name="npass1" size="20"></td></tr>
	<tr><td width="100" style="font-size:11">Confirm New Password:</td><td><input type="password" name="npass2" size="20"></td></tr>
	<?php if ($display_bot_image == TRUE) { ?><tr><td width="100" style="font-size:11">Validation:</td><td>Enter text shown in the image below:<br /><br /><img src="makeimg.php?imgtxt=<?php print base64_encode ($imgtxt); ?>" /><br /><br /><input type="text" name="imgno" size="20" maxlength="3"></td></tr><? } ?>
	<tr><td width="100" style="font-size:11"></td><td><input type="submit" value="Continue" name="submit" /></td></tr>
	</form>
	</table>
	<br /><br />
	<?
  	}
}
//if user is not logged in
else
{
	require ("login.php");	
}
ob_end_flush();
?>
