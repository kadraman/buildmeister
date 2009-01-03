<?php

include("include/header.php");

// user is in database and new password has been generated
if (isset($_SESSION['forgotpass'])) {
    if($_SESSION['forgotpass']){
        $session->displayDialog("New Password Generated",
          "Your new password has been generated and sent to the email "
          . "address associated with your account.",
          SITE_BASEDIR . "/index.php");
    }
    // email could not be sent
    else {
        $session->displayDialog("New Password Failure",
        	"There was an error sending you the email with the new password, "    	
        	. "your password has therefore not been changed.",
        	SITE_BASEDIR . "/index.php");
    }
     
    unset($_SESSION['forgotpass']);
} else {
    // display form
    ?>

<div align="center">
<form action='include/process.php' method='post'>
<fieldset style="width:300px"><legend>Forgotten Password</legend>
<table>
	<tr>
		<td colspan="2">
		<p>A new password will be generated for you and sent to the email
		address associated with your account, all you have to do is enter your
		username in the field below.<br/></p>
		</td>
	</tr>
	<tr>
		<td><label class="formLabelText" for=user>Username:</label></td>
		<td><input class="formInputText" type="text" id="user" name="user"
			value="<?php echo $form->value("user"); ?>"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="hidden" name="subforgot"
			value="1"> <input type="submit" value="Generate Password"></td>
	</tr>
</table>
</fieldset>
</form>
</div>

<?php
}

require("include/footer.php");
?>


