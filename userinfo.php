<?php
include("include/header.php");

// requested Username error checking
$req_user = trim($_GET['user']);
if(!$req_user || strlen($req_user) == 0 ||
   !eregi("^([0-9a-z])+$", $req_user) ||
   !$database->usernameTaken($req_user)){
   die("Username not registered");
}
?>

<form>
	<fieldset class="userinfo-form">

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
        	<td><label class="formLabelText" for="user">Username:</label></td> 
        	<td>
        		<input class="formInputText" type="text" id="user"
					value="<?php echo $req_user_info['username']; ?>" readonly>
			</td>
		</tr>
		<tr>
			<td><label class="formLabelText" for="pass">Password:</label></td>
			<td>
				<input class="formInputText" type="text" id="pass" 
					value="<?php echo $req_user_info['email']; ?>" readonly>
			</td>
		</tr>
<?php
// if logged in user viewing own account, give link to edit
if (strcmp($session->username,$req_user) == 0){
   echo "<tr><td>&nbsp;</td>";
   echo "<td><a href=\"useredit.php\">Edit Account Information</a></td></tr>";
}
?>

	</table>
	</fieldset>
</form>

<?php	
require("include/footer.php");
?>

