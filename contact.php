<?php
require("include/header.php");

// account has been updated succesfully
if (isset($_SESSION['contacted'])) {
    unset($_SESSION['contacted']);
    $session->displayDialog("Message Sent",
       "Thank you for your message, we have succesfully recieved it and will respond shortly.",
    SITE_BASEDIR . "/contact.php");
} else {
    // if user is logged in
    if($session->logged_in) {
        ?>

<form action="include/process.php" method="post">
<fieldset style="width:600px"><legend>Contact Us</legend>
<table>
	<tr>
		<td><label class="formLabelText" for="curfirst">Firstname:</label></td>
		<td><input class="formInputText" type="text" id="curfirst"
			name="curfirst"
			value="
<?php
if($form->value("curfirst") == "") {
   echo $session->userinfo['firstname'];
}else{
   echo $form->value("firstname");
}
?>"></td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="curlast">Lastname:</label></td>
		<td><input class="formInputText" type="text" id="curlast"
			name="curlast"
			value="<?php
if($form->value("curlast") == "") {
   echo $session->userinfo['lastname'];
}else{
   echo $form->value("lastname");
}
?>"></td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="email">Email:</label></td>
		<td><input class="formInputText" type="text" id="email" name="email"
			value="
<?php
if($form->value("email") == ""){
   echo $session->userinfo['email'];
}else{
   echo $form->value("email");
}
?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="message">Message:</label></td>
		<td><textarea class="formTextArea" name='message' id='message'
			onfocus="this.value=''; this.onfocus=null;" rows='10' cols='70' />Enter your message here...
			</textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="hidden" name="subcontact"
			value="1"> <input type="submit" value="Submit"></td>
	</tr>
</table>
</fieldset>
</form>

<?php
}
}
require("include/footer.php");
?>
