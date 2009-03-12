<?php

include_once("common.inc");
include_once("session.php");
include_once("fckeditor/fckeditor.php");
include_once("header.inc");

?>

<div id="toptitle">
	<h2>Contact us</h2>
</div>

<form id="contactForm" action="contact.submit.php" method="post">
	<fieldset style="width:650px; margin: 0px auto">
		
		<!-- ajax submit response -->
		<div id="response">
			All fields in <b>bold</b> are required.
		</div>
		
		<!-- name -->
		<div>
			<label class="required" accesskey="N" for="name">Name:</label>
       		<input type="text" name="name" maxlength="50" id="name" class="txt"
<?php
		if ($session->logged_in) {
			echo "value='" . $session->userinfo['firstname'] . " "
				. $session->userinfo['lastname'] . "'";
		} 
?>       		
       		>
       	</div>
       	
       	<!-- email -->
		<div>
			<label class="required" accesskey="E" for="email">Email:</label>
			<input type="text" name="email" maxlength="50" id="email" 
				style="width:250px" class="txt"
<?php
		if ($session->logged_in) {
			echo "value='" . $session->userinfo['email'] . "'";
		} 
?> 			
			>
		</div>
		
		<!-- message -->
		<div>
			<label class="required" accesskey="M" for="message">Message:</label>
			<span id="fckeditor">
<?php

$oFCKeditor = new FCKeditor('messageText') ;
$oFCKeditor->BasePath = SITE_BASEDIR . '/include/fckeditor/' ;
$oFCKeditor->Height = '200';
$oFCKeditor->Width = '500';
$oFCKeditor->EditorAreaCSS = SITE_BASEDIR . '/stylesheets/article.css' ;
$oFCKeditor->ToolbarSet = 'Basic';
$oFCKeditor->Config['LinkBrowser'] = 'false';
$oFCKeditor->Config['LinkUpload'] = 'false';
$oFCKeditor->Value = 'Enter your message here...';
$oFCKeditor->Create();

?>			
			</span>	

		</div>
			
		<!-- catchpa -->
		<div>
			<label for="kludge"><!-- empty --></label>
			<img class="txt" id="catchpa" 
				src="../include/securimage/securimage_show.php" alt="CAPTCHA Image" />
			<a href="" id="reload" class="txt">Reload Image</a>				
		</div>
		<div>
			<label class="required" accesskey="p" for="captchpaText">Catchpa:</label>					    
			<input class="txt" type="text" maxlength="4" name="catchpa_text" 
				id="catchpaText" style="width:50px">			
		</div>
						
		<!-- buttons and ajax processing -->
		<div>		
			<label for="kludge"><!-- empty --></label>
			<input type="submit" value="Send Message" id="submit" class="btn"/>
			&nbsp;
			<span id="waiting" style="visibility: hidden">			
				<img align="absmiddle" src="<?php echo SITE_PREFIX; ?>/images/spinner.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
		</div>
		
	</fieldset>
</form>

<?php
				
include_once("footer.inc");

?>
