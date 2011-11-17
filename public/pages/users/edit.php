<?php

include_once("common.inc");
include_once("header.inc");

// do we have a user?
if (!isset($_POST['username'])) {
	$session->displayDialog("No Username Specified",
	 	"No username has been specified.",
	 	SITE_BASEDIR . "/index.php");
// does the user exist	 	
} else if (!$database->usernameTaken($database->clean_data($_POST['username']))) {
	$session->displayDialog("Username Does Not Exist",
	   	"The specified username does not exist.",
	    SITE_BASEDIR . "/index.php");
// do we have permission to edit this user as it is not us?	    
} else if ((strcmp($session->username, $database->clean_data($_POST['username'])) != 0)
	&& !$session->isAdmin()) {
	$session->displayDialog("Insufficient Permission",
   		"Sorry you do not have permission to edit this user.",
		"/index.php");
} else {	

	// retrieve the username of the user to display
	$username = $database->clean_data($_POST['username']);
	$newusername = "";
	
	echo "<div id='toptitle'>\n";
	if ($session->isAdmin()) {
		echo "<h2>" . $username . "'s account</h2>\n";
	} else {
		echo "<h2>My account</h2>\n";
	}
	echo "</div>\n";

	// fetch username data
	$sql = "SELECT * from " . TBL_USERS . " where username = '" . $username. "'";
	$result = mysqli_query($database->getConnection(), $sql);
	$numrows = mysqli_num_rows($result);

	if ($numrows != 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$firstname = $row['firstname'];
			$lastname  = $row['lastname'];
			$email     = $row['email'];
			$website   = $row['website'];
		}
	}
	
	mysqli_free_result($result);

?>

<form id="userEditForm" action="/pages/users/edit.submit.php" method="post">
	<fieldset style="width:500px; margin: 0px auto">
		
		<!-- ajax login response -->
		<div id="response">
			All fields in <b>bold</b> are required.
		</div>
		
		<!-- users current username (non-editable) -->
		<div>
			<label for="username" accesskey="u">Username:</label>
			<input type="text" id="username" name="username" class="disabled" disabled
				value="<?php echo $username; ?>">
		</div>			
				
<?php
	// allow admin user to change username 
	if ($session->isAdmin()) {
?>
		<!-- users new username -->
		<div>
			<label for="newusername" accesskey="n">New Username:</label>
			<input type="text" id="newusername"	name="newusername" class="txt">
		</div>
<?php
	} 
?>				
		<!-- users first name -->
		<div>
			<label for="firstname" class="required" accesskey="f">First name:</label>
			<input type="text" id="firstname" name="firstname" class="txt"
				value="<?php echo $firstname; ?>">
		</div>					
				
		<!-- users last name -->
		<div>
			<label for="lastname" class="required" accesskey="l">Last name:</label>
			<input type="text" id="lastname" name="lastname" class="txt"
				value="<?php echo $lastname; ?>">
		</div>		

		<!-- users website -->
		<div>
			<label for="website" accesskey="e">Website:</label>
			<input type="text" id="website" name="website" size="50" class="txt"
				style="width:250px" value="<?php echo $website; ?>">
		</div>	
					
		<!-- users email address -->
		<div>
			<label for="email" class="required" accesskey="e">Email:</label>
			<input type="text" id="email" name="email" size="50" class="txt"
				style="width:250px" value="<?php echo $email; ?>">
		</div>							
	
		<!-- users current password -->
		<div>
			<label for="currentpass" accesskey="p">Current Password:</label>
			<input type="password" id="currentpass" name="currentpass" class="txt">
		</div>
		
		<!-- users new password -->
		<div>
			<label for="newpass" accesskey="a">New Password:</label>
			<input type="password" id="newpass" name="newpass" class="txt">
		</div>
		
		<!-- TODO: new password confirmation -->
									
		<!-- buttons and ajax waiting -->
		<div>	
			<label for="kludge"></label>			
			<input type="submit" value="Submit" id="submit" class="btn"/>
			<span id="waiting" style="visibility: hidden">			
				<img src="/images/spinner.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
			<input type="hidden" name="user" id="user" value="<?php echo $username; ?>">
		</div>
			
	</fieldset>
</form>


<?php
	}

include_once("footer.inc");
?>
