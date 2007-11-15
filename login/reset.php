<?php
require ("config.php");
print '<link rel="stylesheet" type="text/css" href="style.css" />';
//process the information
if (isset ($_POST['submit']))
{
	$username = $_POST['username'];
	//remove all html tags
	$username = strip_tags ($username);
	$email = $_POST['email'];
	//remove all html tags
	$email = strip_tags ($email);  
 	//check if username exist in database
	$query = "SELECT * FROM ".$mysql_pretext."_users where username='$username' AND email='$email'";
  	$command = mysql_query ($query) 
  		or die($db_error);
  	$result = mysql_fetch_array ($command);
   	if(!$result || empty ($username) || empty ($email))
   	{
		print '<p align="center">Invalid email and username combination.</p><p align="center"><a href="'.$_SERVER['HTTP_REFERER'].'">Retry?</a></p>';
		die();
   	}
   	else 
   	{
        $email = $result['email'];
        $day = date("U");
        srand ($day);
        $pin = rand(1000000,2000000);
        $query = "UPDATE ".$mysql_pretext."_users set pin='$pin' where ID='$result[ID]'";
        mysql_query($query)
			or die(mysql_error());
        if (mail($email, "Generated PIN", "Your PIN is ".$pin.".\nEnter this PIN to reset your password", "From: ".$admin_email))
		{
      		print '<p align="center">You have been sent your PIN. Enter your PIN below to confirm your reset action.</p>';
		}
		//if there is a problem with the SMTP port,then,you must display the password
		else
		{
			print '<p align="center">There is a problem with the mail server.</p><p align="center">For security reason, your PIN will not be revealed here. Please contact '.$admin_email.' for your PIN.</p>';
		}
		if (isset ($pin))
		{
			print '<form method="post" action="'.$_SERVER['PHP_SELF'].'" name="pin">';
			print 'PIN:<input type="text" name="pin" size="20" maxlength="15">';
      		print '<input type="submit" value="Submit" name="pinsubmit" />';
		}
    }
}
else if (isset ($_POST['pinsubmit']))
{
	//remove all html tags
	$pin = strip_tags ($_POST['pin']);
 	//check if username exist in database
	$query = "SELECT * FROM ".$mysql_pretext."_users where pin='$pin'";
  	$command = mysql_query ($query) 
  		or die(mysql_error());
  	$result = mysql_fetch_array ($command);
   	if(!$result || empty ($pin))
   	{
		print '<p align="center">Invalid PIN</p><p align="center"><a href="'.$_SERVER['HTTP_REFERER'].'">Retry?</a></p>';
		die();
   	}
	else
	{
	?>
	<center>Enter your new password below</center>
	<form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>" name="newpass">
	<table width="350" cellpadding="5px" align="center" border="1" style="border-style:dashed; border-width:thin; border-collapse:collapse;" cellspacing="0px">
	<tr>
  	<td width="100" style="font-size:11">Password:</td><td> <input type="password" name="password1" size="20" /><br /></td>
	</tr>
	<tr>
	<td width="100" style="font-size:11">Confirm Password:</td><td> <input type="password" name="password2" size="20" /><br /></td></tr>
	<input type="hidden" name="username" value="<?php print $result['username']; ?>" />
	<tr><td width="100"></td><td><input type="submit" value="Reset Password" name="newpass" /></td></tr>
	
<?
	}
}
else if (isset ($_POST['newpass']))
{
	$pass1 = strip_tags ($_POST['password1']);
	$pass2 = strip_tags ($_POST['password2']);
	$username = strip_tags ($_POST['username']);
	$password = md5 ($pass2);
	if ($pass1 == $pass2)
	{
	    $query = "UPDATE ".$mysql_pretext."_users set password='$password',pin='0' where username='$username'";
        mysql_query($query)
			or die(mysql_error());
		print '<p align="center">Password Updated</p>';
		print '<p align="center"><a href="javascript:window.close();">Close Window</a></p>';
	}
	else
	{
		print '<p align="center">Your passwords doesn\'t match.</p>';
		print '<p align="center"><a href="'.$_SERVER['PHP_SELF'].'?username='.$username.'&email='.$email.'&password='.$pass1.'">Retry?</a></p>';
	}
}
else
{
	?>
	<center>Enter your username and email below to reset your password</center>
	<table width="250" cellpadding="5px" align="center" border="1" style="border-style:dashed; border-width:thin; border-collapse:collapse;" cellspacing="0px">
	<form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>" name="reset">
	<tr><td width="100" style="font-size:11">Username:</td><td><input type="text" name="username" size="20" maxlength="15" value="<?php print $_GET['username']; ?>"></tr></tr>
	<tr><td width="100" style="font-size:11">Email:</td><td><input type="text" name="email" size="20" value="<?php print $_GET['email']; ?>"></td></tr>
	<tr><td width="100"></td><td><input type="submit" value="Reset Password" name="submit" /></td></tr>
	</form>
	</table>
	<br /><br />
	<?
}
?>