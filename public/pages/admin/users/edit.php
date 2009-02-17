<?php

include_once("common.inc");
include_once("header.php");

if (!isset($_GET['username'])) {
	// do we have a username
	$session->displayDialog("No Username Specified",
	 	"No username has been specified, please select a user on the "
	 	. "<b>users</b> page.",
	 	SITE_BASEDIR . "/pages/admin/users/");
} else if (!$database->usernameTaken(clean_data($_GET['username']))) {
	// does the user exist?
	$session->displayDialog("Username Does Not Exist",
	   	"The specified username does not exist, please select a user on the "
	   	. "<b>users</b> page.",
	    SITE_BASEDIR . "/pages/admin/users/");
} else {
	// do we have permission to edit users?
	if (!$session->isAdmin()) {
		$session->displayDialog("Insufficient Permission",
    		"Sorry you do not have permission to edit users.",
		SITE_BASEDIR . "/index.php");
	} else {
		// have we just updated user
		if (isset($_SESSION['usereditsuccess'])) {
			if (!$_SESSION['useredirsuccess']) {
				// submission failed
				echo "<div align='center'><p>Sorry, there was an Error updating the user</p></div>";
			}
			unset($_SESSION['usereditsuccess']);
		}

		// retrieve the username of the user to display
		$username = clean_data($_GET['username']);
		$newusername = "";

		// fetch username data
		$sql = "SELECT * from " . TBL_USERS . " where username = '" . $username. "'";
		$result = mysql_query($sql);
		$numrows = mysql_num_rows($result);

		if ($numrows != 0) {
			while ($row = mysql_fetch_assoc($result)) {
				$firstname = $row['firstname'];
				$lastname  = $row['lastname'];
				$email     = $row['email'];
			}
		}

		?>

<form id="userEditForm" action="edit.submit.php" method="post">
	<p><b>Bold</b> fields are required. <u>U</u>nderlined letters are accesskeys.</p>
	<fieldset>
		<legend>Edit Account: <?php echo $username; ?></legend>
		
			<!-- response from update -->
			<div id="response"></div>
			<br>
		
			<!-- users current username (non-editable) -->
			<label for="username" accesskey="c">Current Username:</label>
			<input type="text" id="curusername"	name="curusername" disabled="disabled"
				value="<?php echo $username; ?>">
			<br>			
				
			<!-- users new username -->
			<label for="newusername" accesskey="n">New Username:</label>
			<input type="text" id="newusername"	name="newusername" value="<?php echo $newusername; ?>">
			<br>
				
			<!-- users first name -->
			<label for="curfirst" accesskey="f">Firstname:</label>
			<input type="text" id="curfirst" name="curfirst" value="<?php echo $firstname; ?>">
			<br>					
				
			<!-- users last name -->
			<label for="curlast" accesskey="l">Lastname:</label>
			<input type="text" id="curlast"	name="curlast" value="<?php echo $lastname; ?>">
			<br>		
			
			<!-- users email address -->
			<label for="email" accesskey="e">Email:</label>
			<input type="text" id="email" name="email" size="50" value="<?php echo $email; ?>">
			<br>							
	
			<!-- users new password -->
			<label for="newpass" accesskey="p">New Password:</label>
			<input type="password" id="newpass" name="newpass" value="">
			<br>
		
			<!-- users new password (confirmation) -->
			<label for="newpass2" accesskey="a">New Password (confirmation):</label>
			<input type="password" id="newpass2" name="newpass2" value="">
			<br>
			<small>Enter the same password for confirmation.</small>			
								
			<!-- buttons and ajax waiting -->	
			<label for="kludge"></label>			
			<input type="submit" value="Submit" id="submit"/>
			<span id="waiting" style="visibility: hidden">			
				<img src="<?php echo SITE_PREFIX; ?>/images/waiter.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
			<br>
			
	</fieldset>
</form>


<?php
	}
}
include_once("footer.php");
?>
