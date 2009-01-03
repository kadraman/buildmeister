<?php
include("include/header.php");

// the user is already logged in
if ($session->logged_in) {
    $session->displayDialog("Already Registered",
        "The user <b>$session->username</b>, is already registered and logged in.",
        SITE_BASEDIR . "/index.php");
} else if (isset($_SESSION['regsuccess'])) {
    if ($_SESSION['regsuccess']) {
        // registration was successful
        $session->displayDialog("Registration Successful",
            "Thank you <b>" . $_SESSION['reguname'] . "</b>, an email has been sent to your " .
		    "inbox, please click on the link it contains to enable your account.",
            SITE_BASEDIR . "/index.php");
    } else {
        // registration failed
        $session->displayDialog("Registration Failed",
            "Unfortunately an error has occurred and registration for the username <b>"
            . $_SESSION['reguname'] . "</b>, " . " could not be completed.v"
            . "Please try again at a later time.",
            SITE_BASEDIR . "/index.php");
    }
    unset($_SESSION['regsuccess']);
    unset($_SESSION['reguname']);
} else {
    // fill out the registration form
?>

<div align="center">
<form name='userinfo' id='userinfo' action='include/process.php' method='post' onsubmit='return validate_userinfo();'>
<fieldset style="width:580px"><legend>User Registration</legend>
<table>
<tr>
	<td><label class="formLabelText" for="regfirst">Firstname:</label></td>
		<td><input class="formInputText" type="text" name="regfirst"
			maxlength="30" value="<?php echo $form->value("regfirst"); ?>"></td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="reglast">Lastname:</label></td>
		<td><input class="formInputText" type="password" name="reglast"
			maxlength="30" value="<?php echo $form->value("reglast"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="reguser">Username:</label></td>
		<td><input class="formInputText" type="text" name="reguser"
			maxlength="30" value="<?php echo $form->value("reguser"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="regpass">Password:</label></td>
		<td><input class="formInputText" type="password" name="regpass"
			maxlength="30" value="<?php echo $form->value("regpass"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="regvpass">Verify Password:</label></td>
		<td><input class="formInputText" type='password' name='regvpass'
			maxlength="30" value="<?php echo $form->value("regvpass"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="regemail">Email:</label></td>
		<td><input class="formInputText" type="text" name="regemail"
			maxlength="50" value="<?php echo $form->value("regemail"); ?>"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="regmailok">Receive occasional
		email notices <br />
		from administrators and moderators?</label></td>
		<td><input type='radio' name='regmailok' value='1' checked='checked' />Yes
		<input type='radio' name='regmailok' value='0' />No</td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="disclaimer">Disclaimer:</label></td>
		<td>
			<textarea class="formTextArea" name='disclaimer' id='disclaimer' rows='8' cols='50' 
				readonly="readonly">While the administrators and moderators of this site will attempt to remove or edit any generally objectionable material as quickly as possible, it is impossible to review every message. Therefore you acknowledge that all posts made to this site express the views and opinions of the author and not the administrators, moderators or webmaster (except for posts by these people) and hence will not be held liable. 

You agree not to post any abusive, obscene, vulgar, slanderous, hateful, threatening, sexually-orientated or any other material that may violate any applicable laws. Doing so may lead to you being immediately and permanently banned (and your service provider being informed). The IP address of all posts is recorded to aid in enforcing these conditions. Creating multiple accounts for a single user is not allowed. You agree that the webmaster, administrator and moderators of this site have the right to remove, edit, move or close any topic at any time should they see fit. As a user you agree to any information you have entered above being stored in a database. While this information will not be disclosed to any third party without your consent the webmaster, administrator and moderators cannot be held responsible for any hacking attempt that may lead to the data being compromised. 

This site system uses cookies to store information on your local computer. These cookies do not contain any of the information you have entered above, they serve only to improve your viewing pleasure. The email address is used only for confirming your registration details and password (and for sending new passwords should you forget your current one). 

By clicking Register below you agree to be bound by these conditions.
		</textarea>
		<br />
		<input type='checkbox' id='agreedisc' name='agreedisc'/>&nbsp;I agree to the above</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="subjoin"	value="1"> 
			<input type="submit" value="Register">
		</td>
	</tr>
</table>
</fieldset>
</form>
</div>

<script type='text/javascript'>
<!--//
function validate_userinfo() {
	myform = window.document.userinfo;
    if (!myform.agreedisc.checked) { window.alert("You need to agree to the disclaimer to register."); return false; }	
	return true;
}
//--></script>

<?php
}
require("include/footer.php");
?>

