<?php

include_once("common.inc");
include_once("header.php");

$current_user = isset($_GET['user']) ? clean_data($_GET['user']) : '';

// if no user set, assume logged in user
if (!$current_user) {
   	$current_user = $session->username;
}

// does the user exist	   	        
if (!$database->usernameTaken(clean_data($current_user))) {
	// does the user exist?
	$session->displayDialog("User Does Not Exist",
	   	"The specified user does not exist.",
	    SITE_BASEDIR . "/index.php");		   	
} else {	
	
    // display requested user information 
	$user_info = $database->getUserInfo($current_user);
    
	if ($session->isAdmin() || ($session->username != $current_user)) {
		echo "<h1>" . $current_user . "'s account</h1>";
	} else {
		echo "<h1>My account</h1>";
	}
?>

<form id="viewUserForm" action="edit.php" method="post">
	<fieldset style="width:400px; margin: 0px auto">

		<!-- user name -->		
    	<div>
        	<label for="user">Username:</label>
        	<input type="text" name="username" maxlength="50" id="username" class="disabled"
				disabled value="<?php echo $user_info['username']; ?>">
		</div>
		
		<!-- first name -->
		<div>
			<label for="firstname">First name:</label>
       		<input type="text" name="firstname" maxlength="50" id="firstname" class="disabled"
				disabled value="<?php echo $user_info['firstname']; ?>">
       	</div>

		<!-- last name -->
		<div>
        	<label for="lastname">Lastname:</label>
        	<input type="text" name="lastname" maxlength="50" id="lastname" class="disabled"
				disabled value="<?php echo $user_info['lastname']; ?>">
		</div>
				
<?php
    // if admin user or displaying own account show email
	if ($session->isAdmin() || (strcmp($session->username, $current_user) == 0)) {
?>		
		<!-- email -->
		<div>
			<label for="email">Email:</label>
			<input type="text" name="email" maxlength="100" id="email" class="disabled" 
				style="width:250px" disabled value="<?php echo $user_info['email']; ?>">
			<input type="hidden" name="user" value="<?php echo $user_info['username']; ?>">
		</div>
<?php
	}
?>

		<!-- website -->
		<div>
			<label for="email">Website:</label>
			<input type="text" name="website" maxlength="100" id="website" class="disabled" 
				style="width:250px" disabled value="<?php echo $user_info['website']; ?>">			
		</div>

<?php 	
	// if admin user or logged in and user viewing own account, give link to edit
	if ($session->isAdmin() || strcmp($session->username, $current_user) == 0) {
?>
		<!-- buttons -->
		<div>
			<label for="kludge"><!-- empty --></label>
   			<input type="submit" id="edit" value="Edit Account" class="btn"/>
   		</div>
   		
<?php 
	}
?>   		

	</fieldset>
</form>

<?php
	
	echo "<h2>Articles by this user</h2>";
	// TODO: display articles by this user
	
	echo "<h2>Comments by this user</h2>";
	// TODO: display comments by this user
	
    }
    
include_once("footer.php");
?>

