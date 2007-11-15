<?php
session_start();
if (isset ($_SESSION['loggedin']) && isset ($_SESSION['time']))
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Login script - by iQuest Studios</title>
<style>
a 
{ 
	color:#0000FF; 
	font-family: verdana; 
	font-size: 11px; 
	text-decoration: none;
}

a:link 
{ 
	color:#0000FF; 
	font-family: verdana; 
	font-size: 11px; 
	text-decoration: none; 
}

a:visited 
{ 
	color:#666666; 
	font-family: verdana; 
	font-size: 11px; 
	text-decoration: none; 
}

a:active 
{ 
	color:#FF0000; 
	font-family: verdana; 
	font-size: 11px; 
	text-decoration: none; 
}

a:hover { 
	color: #0000FF; 
	font-family: verdana; 
	font-size: 12px; 
	text-decoration: none; 
}
body 
{
	background-color:#FFFFFF;
	font-family:verdana;
	font-size:12px;
	color:#000000;
}
.heading
{
	font-family:Trebuchet MS;
	color:#000000;
	font-size:20px;
	text-align:center;
	background-color:#CCCCCC;
	width:800px;
	text-transform:uppercase;
}
.content
{
	width:800px;
	text-align:left;
}
</style>
</head>

<body>
<center><img src="logo.jpg" align="middle" alt="Login System" /></center>
<center><div class="heading">Welcome</div></center>
<div>&nbsp;</div>
<center><div class="content">Welcome to the home page of iQuest Studios Advanced Login System. 
It is basically an open-source login script which you can integrate into your current website easily. 
It is also flexible with many configuration settings which you can tweak and adjust to your site's needs.
You can view a demo <a href="login.php">here</a>.
<div class="content">You logged in at <? $time = getdate($_SESSION['time']); print $time['year']." ".$time['month']." ".$tine['mday']." ".$time['hours']."h".$time['minutes']."m".$time['seconds']."s";?>. <a href="login.php">Logout</a></div><br /><br />
<font color="#FF0000">The script is still under contruction. Current Version: 0.02b</font></div></center>
<p>&nbsp;</p>
<hr width="800px" align="center" />
<center>&copy; iQuest Studios</center>
</body>
</html>
<?php
}
else
{
require ("login.php");
}
?>
