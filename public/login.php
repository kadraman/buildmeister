<?php
include("include/header.php");

// are you already logged in
if ($session->logged_in) { 
	$session->displayDialog("Login Successful",
        "The user <b>$session->username</b> is now successfully logged in.",
        SITE_BASEDIR . "/index.php");
} else {
?>
<div align="center">
<form method="post" action="include/process.php">
    <fieldset style="width: 250px">
        <legend>User Login</legend> 
        <table>
            <tr>
                <td><label class="formLabelText" for="user">Username:</label></td> 
        		<td>
        		    <input class="formInputText" type="text" name="user" maxlength="30"
					    value="<?php echo $form->value("user"); ?>" id="user" onfocus="clearField(this)">
				</td>
			</tr>
			<tr>
				<td><label class="formLabelText" for="pass">Password:</label></td>
				<td>
					<input class="formInputText" type="password" name="pass" maxlength="30"
						value="<?php echo $form->value("pass"); ?>" id="pass">
				</td>
			</tr>
			<tr>
				<td align="right"><input id="login-checkbox" type="checkbox" name="remember" 
					<?php if ($form->value("remember") != ""){ echo "checked"; } ?> >
				<td>Remember me</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<?php echo $form->allErrors(); ?>
				</td>
			<tr>
				<td colspan="2" align="right">
					<input type="hidden" name="sublogin" value="1"></input> 
					<input id="login-button" type="submit" name="userlogin" value="Login" id="input.login"></input>
				</td>
			</tr>
		</table>
	</fieldset>
</form>
</div>

<?php
}
include("include/footer.php");
?>