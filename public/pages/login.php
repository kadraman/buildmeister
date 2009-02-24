<?php

include_once("common.inc");
include_once("header.php");

// are you already logged in
if ($session->logged_in) { 
	$session->displayDialog("Already logged in",
        "The user <b>$session->username</b> is already logged in.",
        SITE_BASEDIR . "/userinfo.php");
} else {
?>

<h1>Log in</h1>

<!-- named div so content can be replaced on successfull login -->
<div id="status" style="width:350px; margin: 0px auto">

<form id="loginForm" action="login.submit.php" method="post">
    <fieldset>   	

		<!-- ajax login response -->
		<div id="response">
			<p>All fields in <b>bold</b> fields are required.</p>
		</div>
		
		<!-- username -->
		<div>
			<label for="user" class="required" accesskey="U">Username:</label>
       		<input type="text" name="user" maxlength="30" id="user" class="txt">
       	</div>
			
		<!-- password -->
		<div>
			<label class="required" accesskey="P" for="pass">Password:</label>
			<input type="password" name="pass" maxlength="30" id="pass" class="txt">
		</div>
			
		<!-- remember login -->
		<div>
			<label for="kludge"><!-- empty --></label>
			<input id="login-checkbox" type="checkbox" name="remember" class="btn">&nbsp;
			<span style="vertical-align:bottom">Remember me</span>
		</div>
				
 		<br>
 									
		<!-- buttons and ajax processing -->
		<div>		
			<label for="kludge"><!-- empty --></label>
			<input type="submit" value="Login" id="submit" class="btn"/>
			&nbsp;
			<span id="waiting" style="visibility: hidden">			
				<img align="absmiddle" src="<?php echo SITE_PREFIX; ?>/images/spinner.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
		</div>
		
	</fieldset>
</form>

</div>

<?php
}
include_once("footer.php");
?>