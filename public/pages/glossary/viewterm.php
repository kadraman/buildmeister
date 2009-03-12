<?php

include_once("common.inc");
include_once("header.inc");

?>

<div id="article">

<?php
if (!isset($_GET['term'])) {
    $session->displayDialog("No Glossary Item",
    	"No glossary item has been specified, please select a term on the "
        . "<b>glossary</b> page to see its definition.",
	    SITE_BASEDIR . "/pages/public/glossary/");
} else {
    // retrieve the id of the article to display
	$gitem = $database->clean_data($_GET['term']);
    
?>

	<div id="toptitle">
		<h2>Glossary</h2>
	</div>

	<div id="introductory">
		<p>This page defines an individual term that is used in
		or related to the build process. If you believe that the definition is
		incorrect or would like to comment then please 
		<a href="../contact.php">contact us</a>.
</div>

<h3>Definition</h3>

<?php
	// replace underlines for href navigation 
	$term = str_replace('_', ' ', $gitem);
	// fetch glossary item
	$sql = "SELECT * from " . TBL_GLOSSARY . " where title = '". $term . "';";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		$glossid = 0;
		echo "<div align='center'>\n";
    	echo "<table width='95%'><tr>";    
    	while ($row = mysqli_fetch_assoc($result)) {
	        // replace href to point to glossary page
    	    $summary = str_replace("href=\"#", "href=\"index.php#", $row['summary']);
        	echo "<td align='left'><strong><a id='#" . $row['title'] . "'>" 
            	. $row['title'] . "</a></strong><br/>"
		    	. stripslashes($summary) . "</td>\n";
			$glossid = $row['id'];
    	}
    	echo "</tr></table>\n";
    	echo "</div>\n";
	}   

/*	
	// comment on glossary item
	echo "<h3>Comments</h3>";

	// fetch glossary item
	$sql = "SELECT * from " . TBL_GLOSSCOM . " where state = 1 AND gloss_id = ". $glossid . ";";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
        	echo "<div id='comment'>Posted by <b>" . $row['posted_by']
            . "</b><br/>" . $row['comment'] . "</div>";
    	}
	}
*/
}        

?>

</div>

<?php

include_once("footer.inc");

?>
