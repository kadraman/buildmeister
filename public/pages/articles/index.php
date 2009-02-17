<?php

// setup include path
if (!defined("PATH_SEPARATOR")) {
	if (strpos($_ENV["OS"], "Win") !== false)
		define("PATH_SEPARATOR", ";");
	else define("PATH_SEPARATOR", ":");
} 
ini_set("include_path", "." . PATH_SEPARATOR . "../" . PATH_SEPARATOR
. "./include" . PATH_SEPARATOR . "../../include");
	
// articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("header.php");

?>

<div id="article">

	<div id="toptitle">
		<h2>Articles</h2>
	</div>

	<div id="introductory">
		<p>This page lists all of the articles that are contained on this site. We are always
		looking for new artilces, if you have an idea for an article or have written some content 
		yourself that you would like to shared, then please <a href="contact.php">contact us</a> 
		for more information.</p>
	</div>

<?php
	# fetch all published articles
	$sql = "SELECT id, title, posted_by, DATE_FORMAT(date_posted, \"%M %D, %Y\")" .
    	" as newdate, summary from " . TBL_ARTICLES . " where state = "
		. PUBLISHED_STATE . " ORDER BY date_posted DESC;";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	if ($numrows != 0) {
    	while ($row = mysql_fetch_assoc($result)) {
			echo "<div id='splitlist'><strong><a href='view.php?id=" . $row['id'] . "'>"
 		    	. $row['title'] . "</a></strong><br/>"
 		    	. "<small>Posted by <a href='../../userinfo.php?user=" . $row['posted_by'] 
 		    	. "'>" . $row['posted_by'] . "</a> on "
 		    	. $row['newdate'] . "</small><br/>"
		    	. $row['summary'] . "</div>";
    	}
	}

?>

	<div id="spacer">&nbsp;</div>

</div>

<?php
include_once("footer.php");
?>
