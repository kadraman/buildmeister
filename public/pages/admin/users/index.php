<?php

include_once("common.inc");
include_once("header.inc");

?>

<div id="toptitle">
	<h2>User Administration</h2>
</div>

<?php

// check if user is an administrator
if (!$session->isAdmin()){
	echo "<p>Sorry, this page is only available for use by administrators.</p>";
} else {

?>

<div id="filterTable"></div>
		
<?php 
}

include_once("footer.inc");

?>

