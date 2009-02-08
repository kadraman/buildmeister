<?php
include("include/header.php");

if (!isset($_GET['user'])) {
	// do we have a user
	$session->displayDialog("No User Specified",
	 	"No user has been specified.",
	   	SITE_BASEDIR . "/index.php");        
} else if (!$database->usernameTaken(clean_data($_GET['user']))) {
	// does the user exist?
	$session->displayDialog("User Does Not Exist",
	   	"The specified user does not exist.",
	    SITE_BASEDIR . "/index.php");		   	
} else {
	$req_user = trim($_GET['user']);
?>

<div align="center">
<form>
	<fieldset style="width:250px">

<?php    
// logged in user viewing own account
if (strcmp($session->username,$req_user) == 0){
   echo "<legend>My Account</legend>";
}
// visitor not viewing own account
else {
   echo "<legend>User Account</legend>";
}

// display requested user information 
$req_user_info = $database->getUserInfo($req_user);

?>
	<table>
	 	<tr>
        	<td><label class="formLabelText" for="firstname">Firstname:</label></td> 
        	<td>
        		<input class="formInputText" type="text" id="firstname"
					value="<?php echo $req_user_info['firstname']; ?>" readonly>
			</td>
		</tr>
	 	<tr>
        	<td><label class="formLabelText" for="lastname">Lastname:</label></td> 
        	<td>
        		<input class="formInputText" type="text" id="lastname"
					value="<?php echo $req_user_info['lastname']; ?>" readonly>
			</td>
		</tr>		
    	<tr>
        	<td><label class="formLabelText" for="user">Username:</label></td> 
        	<td>
        		<input class="formInputText" type="text" id="user"
					value="<?php echo $req_user_info['username']; ?>" readonly>
			</td>
		</tr>
<?php
    # if admin user or displaying own account show email
	if ($session->isAdmin() || (strcmp($session->username,$req_user) == 0)) {
?>		
		<tr>
			<td><label class="formLabelText" for="email">Email:</label></td>
			<td>
				<input class="formInputText" type="text" id="email" 
					value="<?php echo $req_user_info['email']; ?>" readonly>
			</td>
		</tr>
<?php
	}
	# if admin user or logged in and user viewing own account, give link to edit
	if ($session->isAdmin() || strcmp($session->username,$req_user) == 0) {
?>
		<tr>
			<td>&nbsp;</td>
   			<td><a href="useredit.php?user=<?php echo $req_user; ?>">Edit Account Information</a></td>
   		</tr>
<?php 
	}
?>   		

	</table>
	</fieldset>
</form>
</div>

<?php
	// TODO: display articles and/or comments by this user
    }
require("include/footer.php");
?>

