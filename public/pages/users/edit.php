<?php

include_once("common.inc");
include_once("header.php");

// do we have a user?
if (!isset($_POST['user'])) {
	$session->displayDialog("No Username Specified",
	 	"No username has been specified, please select a user on the "
	 	. "<b>users</b> page.",
	 	SITE_BASEDIR . "/pages/admin/users/");
// does the user exist	 	
} else if (!$database->usernameTaken(clean_data($_POST['user']))) {
	$session->displayDialog("Username Does Not Exist",
	   	"The specified username does not exist, please select a user on the "
	   	. "<b>users</b> page.",
	    SITE_BASEDIR . "/pages/admin/users/");
// do we have permission to edit this user?	    
} else if (!$session->isAdmin() && (strcmp($session->username, clean_data($_POST['user']) != 0))) {
	$session->displayDialog("Insufficient Permission",
   		"Sorry you do not have permission to edit this user.",
	SITE_BASEDIR . "/index.php");
} else {
		

	// retrieve the username of the user to display
	$username = clean_data($_POST['user']);
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
	<fieldset style="width:500px; margin: 0px auto">
		
		<!-- ajax login response -->
		<div id="response">
			<p>All fields in <b>bold</b> are required.</p>
		</div>
		
		<!-- users current username (non-editable) -->
		<div>
			<label for="username" accesskey="c">Username:</label>
			<input type="text" id="username" name="username" class="txt" disabled
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
				<img src="<?php echo SITE_PREFIX; ?>/images/spinner.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
			<input type="hidden" name="user" id="user" value="<?php echo $username; ?>">
		</div>
			
	</fieldset>
</form>


<?php
	}

include_once("footer.php");
?>
