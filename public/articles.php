<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include("include/header.php");

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
    	" as newdate, summary from " . TBL_ARTICLES . " where state = 1 ORDER BY date_posted DESC;";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	if ($numrows != 0) {
    	while ($row = mysql_fetch_assoc($result)) {
			echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
 		    	. $row['title'] . "</a></strong><br/>"
 		    	. "<small>Posted by <a href='userinfo.php?user=" . $row['posted_by'] 
 		    	. "'>" . $row['posted_by'] . "</a> on "
 		    	. $row['newdate'] . "</small><br/>"
		    	. $row['summary'] . "</div>";
    	}
	}

?>

	<div id="spacer">&nbsp;</div>

</div>

<?php
include("include/footer.php");
?>
