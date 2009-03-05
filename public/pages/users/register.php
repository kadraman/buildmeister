<?php

include_once("common.inc");
include_once("header.php");

// the user is already logged in
if ($session->logged_in) {
    $session->displayDialog("Already Registered",
        "The user <b>$session->username</b>, is already registered and logged in.",
        SITE_BASEDIR . "/index.php");
} else {
    // fill out the registration form
?>

<h1>Register</h1>

<form id="registrationForm" action="register.submit.php" method="post">
	<fieldset style="width:650px; margin: 0px auto">
	
		
		<!-- ajax submit response -->
		<div id="response">
			All fields in <b>bold</b> are required.
		</div>
	
		<fieldset>
		<!-- first name -->
		<div>
			<label class="required" for="firstname">First name:</label>
			<input type="text" name="firstname" maxlength="30" id="firstname" class="txt">
		</div>
	
		<!-- last name -->
		<div>
			<label class="required" for="lastname">Last name:</label>
			<input type="text" name="lastname"	maxlength="30" id="lastname" class="txt">
		</div>
	
		<!-- username -->
		<div>
			<label class="required" for="username">Username:</label>
			<input type="text" name="username" maxlength="30" id="username" class="txt">
		</div>
	
		<!-- password -->
		<div>
			<label class="required" for="password">Password:</label>
			<input type="password" name="password"	maxlength="30" id="password" class="txt">
		</div>
	
		<!-- verify password -->
		<div>
			<label class="required" for="verify">Verify Password:</label>
			<input type="password" name="verify" maxlength="30" id="verify" class="txt">
		</div>
	
		<!-- email -->
		<div>
			<label class="required" for="email">Email:</label>
			<input type="text" name="email" maxlength="100" id="email" 
				style="width:250px" class="txt">
		</div>
	
		<!-- website -->
		<div>
			<label for="website">Website:</label>
			<input type="text" name="website" maxlength="100" id="website" 
				style="width:250px" class="txt">
		</div>
		
		<!-- catchpa -->
		<div>
			<label for="kludge"><!-- empty --></label>
			<img class="txt" id="catchpa" 
				src="../../include/securimage/securimage_show.php" alt="CAPTCHA Image" />
			<a href="" id="reload" class="txt">Reload Image</a>				
		</div>
		<div>
			<label class="required" accesskey="p" for="captchpaText">Catchpa:</label>					    
			<input class="txt" type="text" maxlength="4" name="catchpa_text" 
				id="catchpaText" style="width:50px">			
		</div>
	
		<!-- receive notifications -->
		<div>
			<b>Receive occasional email notices
			from administrators and moderators</b>:
			<input type="radio" name="mailok" id="mailok" value="1" checked="checked"/>Yes
			<input type="radio" name="mailok" id="mailok" value="0"/>No			
		</div>
		</fieldset>
	
		<fieldset>
		<!-- disclaimer -->
		<textarea name="disclaimer" rows="8" cols="50" class="txt" 
				style="width:600px" readonly="readonly">
While the administrators and moderators of this site will attempt to remove or edit any generally objectionable material as quickly as possible, it is impossible to review every message. Therefore you acknowledge that all posts made to this site express the views and opinions of the author and not the administrators, moderators or webmaster (except for posts by these people) and hence will not be held liable. 

You agree not to post any abusive, obscene, vulgar, slanderous, hateful, threatening, sexually-orientated or any other material that may violate any applicable laws. Doing so may lead to you being immediately and permanently banned (and your service provider being informed). The IP address of all posts is recorded to aid in enforcing these conditions. Creating multiple accounts for a single user is not allowed. You agree that the webmaster, administrator and moderators of this site have the right to remove, edit, move or close any topic at any time should they see fit. As a user you agree to any information you have entered above being stored in a database. While this information will not be disclosed to any third party without your consent the webmaster, administrator and moderators cannot be held responsible for any hacking attempt that may lead to the data being compromised. 

This site system uses cookies to store information on your local computer. These cookies do not contain any of the information you have entered above, they serve only to improve your viewing pleasure. The email address is used only for confirming your registration details and password (and for sending new passwords should you forget your current one). By clicking Register below you agree to be bound by these conditions.
		</textarea>
		<br>
		<input type="checkbox" id="agreedisc" name="agreedisc" class="checkbox">I agree to the above
		</fieldset>	
		
		<!-- buttons and ajax processing -->
		<div>		
			<label for="kludge"><!-- empty --></label>
			<input type="submit" value="Register" id="submit" class="btn"/>
			&nbsp;
			<span id="waiting" style="visibility: hidden">			
				<img align="absmiddle" src="<?php echo SITE_PREFIX; ?>/images/spinner.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
		</div>

	</fieldset>
</form>

<?php
}

include_once("footer.php");

?>

