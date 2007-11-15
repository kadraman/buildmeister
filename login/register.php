<?php
session_start();
/*
register.php
(C) Wu Xiao Tian
THIS SOFTWARE IS RELEASED 'AS IS' WITH NO WARRANTY PROVIDED
ANY PART OF THIS SOFTWARE, OR SCRIPT CANNOT BE DISRIBUTED COMMERICALLY UNLESS WITH PERMISSION FROM AUTHOR
REMVOAL OF COPYRIGHT IS NOT ALLOWED. IF YOU WISH TO REMOVE IT, PLEASE CONTACT ME AT y04chs067@gmail.com WITH EMAIL ENTITLED 'ALS COPYRIGHT REMOVAL'
REMOVAL OF COPYRIGHT COSTS A 1 TIME FEE OF $10 AND YOU WILL BE FREE TO DISTRIBUTE PARTS OF THE ENTIRE SOFTWARE, OR SCRIPT, AS YOU WISH.
*/
require ("config.php");
//checking of install file
if (file_exists ("install.php")) die ("<font color=\"red\">FATAL ERROR. INSTALL.PHP EXISTS! POSSIBLE SECURITY RISK! TERMINATING PROGRAM</font>");
if (isset ($_SESSION['loggedin']) && isset ($_SESSION['time']))
{
	header ('Location: ./');
}
else if ($allow_guest_to_register == TRUE || isset ($_SESSION['alsadmin']))
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Register</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body onLoad="setFocus()">
<?php
if ( isset ($_POST['submit']) )
{
	$error = false;
	$username = $_POST['username'];
	$pass1 = $_POST['password1'];
	$pass2 = $_POST['password2'];
	$email = $_POST['email'];
	//the validation no. user typed
	$imgno = md5 ($_POST['imgno']);
	//the real validation number
	//$realno = $_POST['realno'];
	//$realno = md5 ($_SESSION['imgcode']);
	$realno = rawurldecode (base64_decode ($_SESSION['imgcode'])); 
	$realno = md5 (str_replace (' ' , '' ,$realno)); 

	//search if the username exist
	$search1 = "SELECT * from ".$mysql_pretext."_users where username='$username'";
	$search2 = mysql_query ($search1) or die (mysql_error());
	$search3 = mysql_fetch_array ($search2);
	
	$search_email = "SELECT * from ".$mysql_pretext."_users where email='$email'";
   	$search_email2 = mysql_query( $search_email ) or die(mysql_error());
    $search_email3 = mysql_fetch_array( $search_email2 );
	
	if ( $pass1 == $pass2 )
	{
		if ( empty ($pass1) || empty ($pass2) )
		{
			print '<p align="center">You need to fill up the password and confirm password fields.</p>';
			$error = true;
		} 
		elseif ( $search3 )
		{
			print '<p align="center">Sorry,but that username is already taken.</p>';
			$error = true;
		}
		
		elseif ( empty ($username) )
		{
			print '<p align="center">You need to fill up the username field.</p>';
			$error = true;
		}
		
		elseif ( empty ($email) )
		{
			print '<p align="center">You need to fill in your email address.</p>';
			$error = true;
		}
		
		elseif ( $search_email3 )
		{
			print '<p align="center">Your email address already exists on the database!If you have forgotten your password,you can reset it by clicking <a href="reset.php">here</a>.</p>';
			$error = true;
		}
		
		 //if the user typed a validation number of less than 4 chars
		else if (strlen ($imgno) < 4 && $display_bot_image)
		{
			print '<p align="center">You did not enter a valid validation number.</p>';
			$error = true;
		}
	
		//if validation number is wrong
		else if ($imgno != $realno && $display_bot_image)
		{
			print '<p align="center">You did not enter a valid validation number</p>';
			$error = true;
		}
  	
		//if the email address is not valid.need at least 5 chars because the shortest valid email address will be something like a@b.cc and check that the @ sign is there
		else if (strlen ($email) < 5 || !eregi (".@", $email))
		{
			print '<p align="center">You did not enter a valid email</p>';
			$error = true;
		}
		
	}
	
	else
	{
		print '<p align="center">Your passwords doesn\'t match.</p>';
		$error = true;
	}
	
	if ( $error )
	{
		print '<p align="center"><a href="'.$_SERVER['PHP_SELF'].'?username='.$username.'&email='.$email.'&password='.$pass1.'">Retry?</a></p>';
	}
	
	else
	{
		$password = md5 ($pass1);
		$date = round (date("U")/1000);
      	srand ($date);
      	$validkey = rand (1,100000000);
      	$validkey = md5 ($validkey);
      	$SQL = "INSERT into ".$mysql_pretext."_users (username, password, email, validated, validkey, lastip) VALUES ('$username','$password', '$email','0', '$validkey','$_SERVER[REMOTE_ADDR]')"; 
      	mysql_query ($SQL) or die(mysql_error());
		if ($need_to_validate_acct == TRUE)
		{
			if (mail ("$email","Your Activation key","Thank you for registering at Advanced Login System.\n\nPaste the URL below to activate your account at Advanced Login System. \n $path/activate.php?email=$email&password=$password&key=$validkey\n\nYou can download a copy of this script at www.iqueststudios.com","From: ".$admin_email.""))
			{
				print'<p>You are registered!An email has been sent to your email address.You need to activate your account before you can login.</p><p align="center"><a href="javascript:window.close();">Close Window</a></p>';
			}
			else 
			{
				print '<p align="center">There is a problem with the mail server. Click on the link below to activate your account.</p><p align="center"><a href="activate.php?email='.$email.'&password='.$password.'&key='.$validkey.'">Activate</a></p>';
			}	
		}
		else
		{
			print'<p>You are registered!You can login now.</p><p align="center"><a href="javascript:window.close();">Close Window</a></p>';
		}
	}
}
else
{
$imgtxt = rand(1000,9999);
?>
<table width="350" cellpadding="5px" align="center" border="1" style="border-style:dashed; border-width:thin; border-collapse:collapse;" cellspacing="0px">
<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" name="register">
<input type="hidden" name="realno" value="<?php print md5 ($imgtxt); ?>" />
<tr>
  <td width="100">Username:</td><td><input type="text" name="username" size="20" value="<?php print $_GET['username']; ?>" /><br /></td>
</tr>
<tr>
  <td width="100">Password:</td><td> <input type="password" name="password1" size="20" value="<?php print $_GET['password']; ?>" /><br /></td>
</tr>
<tr>
  <td width="100">Confirm Password:</td><td> <input type="password" name="password2" size="20" value="<?php print $_GET['password']; ?>" /><br /></td>
</tr>
<tr>
  <td width="100">Email:</td><td> <input type="text" name="email" size="20" value="<?php print $_GET['email']; ?>" /><br /></td>
</tr>
<?php 
if ($display_bot_image)
{
		$img1 = rand (1,9);
		$img2 = rand (1,9);
		$img3 = rand (1,9);
		$img4 = rand (1,9);
		$imgtxt = $img1.'%20'.$img2.'%20'.$img3.'%20'.$img4;
		$_SESSION ['imgcode'] = base64_encode ($imgtxt);
?>
<tr>
  <td width="100">Validation:</td><td>Enter text shown in the image below:<br /><br /><img src="makeimg.php?imgtxt=<?php print base64_encode ($imgtxt); ?>" /><br /><br /><input type="text" name="imgno" size="20" maxlength="4"></td>
</tr>
<?php } ?>
<tr>
<td><input type="submit" name="submit" value="Register" /></td>

</tr></form>
</table>
</body>
</html>
<?php
}
}
//if not allowed for guests to register
else
{
	print '<link rel="stylesheet" type="text/css" href="style.css" />';
	if (isset ($_POST['login']))
	{
		//define variables incase server doesn't support global variables
		$username = $_POST['username'];
		$pass1 = md5 ($_POST['pass']);
		$password = md5 ($mysql_password);
		//check form details against database details. if correct,
		if ($username == $mysql_username && $password == $pass1)
		{
			//name the session the username,only encoded
			$_SESSION['alsadmin'] = base64_encode ($username);
			//redirect to the page again.
			print "<meta http-equiv=\"refresh\" content=\"2; url=".$_SERVER['PHP_SELF']."\" />";
			print "<center><a href=\"".$_SERVER['PHP_SELF']."\">Continue to if browser doesn't redirect you in 3 seconds</a></center>";
		}
		//if details doesn't match
		else
		{
			print "<center><font face=\"verdana\" color=\"red\" size=\"2\"><b>Error!</b></font></center><p align=\"center\">Incorrect Login</p>";
			print "<p align=\"center\"><a href=\"".$_SERVER['PHP_SELF']."?act=view\">Back</a></p>";
			die();
		}
	}
	else
	{
		print "<font color=\"red\"><center>The admin has disabled user registration. If you are the admin,you can login below to create a new user by entering your MySQL database username and MySQl database password</center></font>";
		print "<table width=\"300\" cellpadding=\"5px\" align=\"center\" border=\"1\" style=\"border-style:dashed; border-width:thin; border-collapse:collapse;\" cellspacing=\"0px\">";
		print "<caption style=\"font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px\">Login</caption>";
		print "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" />";
    	print "<tr><td width=\"45%\" style=\"font-size:11\">MySQL username</td><td><input type=\"text\" name=\"username\" size=\"30\" /></td></tr>";
		print "<tr><td width=\"45%\"style=\"font-size:11\">MySQL Password</td><td><input type=\"password\" name=\"pass\" size=\"30\" /></td></tr>";
		print "<tr><td width=\"45%\"></td><td><input type=\"submit\" name=\"login\" value=\"Login\" /></td></tr>";
		print "</form>";
		print "</table>";
		print "<hr width=\"300\" />";
		print "<div class=\"copyright\" align=\"center\">&copy; iQuest Studios</div>";
	}
}
?>

