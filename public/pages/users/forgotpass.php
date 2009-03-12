<?php

include_once("common.inc");
include_once("header.inc");

?>
<div id="toptitle">
	<h2>Forgotten password</h2>
</div>

<form id="forgotPassForm" action="forgotpass.submit.php" method="post">
	<fieldset style="width:400px; margin: 0px auto">

		<!-- ajax login response -->
		<div id="response">
			To retrieve your password enter your username below.
		</div>
	
		<!-- username -->
		<div>
			<label for="user" class="required" accesskey="U">Username:</label>
    		<input type="text" name="user" maxlength="30" id="user" class="txt">
    	</div>
    
    	<!-- buttons and ajax processing -->
		<div>		
			<label for="kludge"><!-- empty --></label>
			<input type="submit" value="Submit" id="submit" class="btn"/>
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
