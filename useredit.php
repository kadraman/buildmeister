<?php
require("include/header.php");

// account has been updated succesfully
if (isset($_SESSION['useredit'])) {
   unset($_SESSION['useredit']);
   $session->displayDialog("Account Updated", 
       "The account " . $session->username . " has been succesfully updated.",
       SITE_BASEDIR . "/index.php");    
} else {
    // if user is logged in
    if($session->logged_in) {
?>

<form action="process.php" method="post">
	<fieldset class="useredit-form">
	<legend>Edit Account: <?php echo $session->username; ?></legend>
	<table>
    	<tr>
        	<td><label class="formLabelText" for="curpass">Current Password:</label></td> 
        	<td>
        		<input class="formInputText" type="password" id="curpass"
					value="<?php echo $form->value("curpass"); ?>" name="curpass">
			</td>
		</tr>
    	<tr>
        	<td><label class="formLabelText" for="newpass">New Password:</label></td> 
        	<td>
        		<input class="formInputText" type="password" id="newpass"
					value="<?php echo $form->value("newpass"); ?>" name="newpass">
			</td>
		</tr>
		<tr>
        	<td><label class="formLabelText" for="email">Email:</label></td> 
        	<td>
        		<input class="formInputText" type="text" id="email"
					name="email" value="
<?php
if($form->value("email") == ""){
   echo $session->userinfo['email'];
}else{
   echo $form->value("email");
}
?>">					
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<?php echo $form->error("curpass"); ?>
				<?php echo $form->error("newpass"); ?>
				<?php echo $form->error("email"); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="subedit" value="1">
				<input type="submit" value="Edit Account">
			</td>
		</tr>
	</table>
</fieldset>
</form>

<?php
	}
}
require("include/footer.php");
?>
