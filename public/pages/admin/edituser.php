<?php

# setup include path
if (!defined("PATH_SEPARATOR")) {
	if (strpos($_ENV["OS"], "Win") !== false)
	define("PATH_SEPARATOR", ";");
	else define("PATH_SEPARATOR", ":");
}
ini_set("include_path", "." . PATH_SEPARATOR . "../" . PATH_SEPARATOR
. "./include" . PATH_SEPARATOR . "../../include");

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("header.php");

if (!isset($_GET['username'])) {
	// do we have a username
	$session->displayDialog("No Username Specified",
	 	"No username has been specified, please select a user on the "
	   	. "<a href='users.php'>users</a> page.",
	   	SITE_BASEDIR . "/pages/admin/users.php");  
} else if (!$database->usernameTaken(clean_data($_GET['username']))) {
	// does the user exist?
	$session->displayDialog("User Does Not Exist",
	   	"The specified user does not exist, please select a user on the "
	   	. "<a href='users.php'>users</a> page.",
	    SITE_BASEDIR . "/pages/admin/users.php");		   	
} else {
	// do we have permission to edit users?	   	
	if (!$session->isAdmin()) {
		$session->displayDialog("Insufficient Permission",
    		"Sorry you do not have permission to edit users.",
    		SITE_BASEDIR . "/home.php");
	} else {
		// have we just updated user
		if (isset($_SESSION['usereditsuccess'])) {
    		if (!$_SESSION['useredirsuccess']) {
	       	    // submission failed
        		echo "<div align='center'><p>Error updating user</p></div>";
    		}
    	   	unset($_SESSION['usereditsuccess']);
		}
				
		// retrieve the username of the user to display
		$currentuser = clean_data($_GET['username']);
	
		// fetch article data
		$sql = "SELECT * from " . TBL_USERS . " where username = '" . $currentuser. "'";
		$result = mysql_query($sql);
		$numrows = mysql_num_rows($result);

		if ($numrows != 0) {
    		while ($row = mysql_fetch_assoc($result)) {

        		$user_name = $row['username'];
        		$user_first = $row['firstname'];
        		$user_last  = $row['lastname'];
        		$user_email  = $row['email'];
    		}
		}
?>

<div align="center">
<form name="articleupdate" id="articleupdate" action="include/process.php" method="post">
<fieldset style="text-align:left;width:700px">
<legend>Update User</legend>
<table>
	<tr>
		<td align="center" colspan="2">
			<p><?php echo $form->allErrors(); ?></p>
		</td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="articletitle">Username:</label></td>
		<td><input class="formInputText" style="width:200px"  type="text" name="username"
			maxlength="80" value="<?php echo $user_name?>"></td>
   	</tr>
	<tr>
		<td><label class="formLabelText" for="articletitle">First name:</label></td>
		<td><input class="formInputText" style="width:200px"  type="text" name="username"
			maxlength="80" value="<?php echo $user_first?>"></td>
   	</tr> 
	<tr>
		<td><label class="formLabelText" for="articletitle">Last name:</label></td>
		<td><input class="formInputText" style="width:200px"  type="text" name="username"
			maxlength="80" value="<?php echo $user_last?>"></td>
   	</tr> 
	<tr>
		<td><label class="formLabelText" for="articletitle">Email:</label></td>
		<td><input class="formInputText" style="width:200px"  type="text" name="username"
			maxlength="80" value="<?php echo $user_email?>"></td>
   	</tr>     	   	  	
	<tr>
		<td>
			<input name="username"	value="<?php echo $currentuser?>" type="hidden" />
			<input type="hidden" name="updateuser" value="1">
		</td>		
	</tr>
	<tr>
		<td align="left">
			<input type="submit" value="Submit"/>
		</td>
		<td align="right">
			<input type="button" value="Cancel" onclick="history.back()">
		</td>
	</tr>
</table>	
</form>
</div>

<?php
    	}
	}
include("footer.php");
?>
