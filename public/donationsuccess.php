<?php

# home page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 0;

include ("include/header.php");
?>

<div id="introductory">
<table width="100%">
	<tbody>
		<tr>
			<td>
				<p>Thankyou for your donation, if you haven't done so already
			 	then please <a href="register.php">register</a> and contribute
			 	to this site.</p>
			</td>
		</tr>
</table>
</div>

<div id="dashed-spacer"></div>

<?php
include ("include/footer.php");
?>
