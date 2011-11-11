<?php

include_once("common.inc");
include_once("header.inc");

// do we have a category id?
if (!isset($_GET['name'])) {
	$session->displayDialog("No Category Specified",
		"No category has been specified, please select an article on the "
	    . "<b>articles</b> page and click on one of its related categories.",
	    SITE_BASEDIR . "/pages/articles/");
} else {
	// retrieve the name of the category to display
	$cat_name = $database->clean_data($_GET['name']);
	$cat_name = str_replace("_", " ", $cat_name);
	
	// get category id
	$cat_id_sql = "SELECT id from " . TBL_CATEGORIES . " where name = '$cat_name'";
	if ($result = mysqli_query($database->getConnection(), $cat_id_sql)) {
		$cat_row = mysqli_fetch_row($result);
		$cat_id = $cat_row[0];
	}
?>

<div id="article">

	<div id="toptitle">
		<h2>Articles in category: <u><?php echo $cat_name?></u></h2>
	</div>

	<div id="introductory">
		<p>This page lists all of the articles that are contained in the <u><?php echo $cat_name?></u>
		category. We are always	looking for new artilces, if you have an idea for an article on this
		topic or have written some content yourself that you would like to shared, then please 
		<a href="../contact/">contact us</a> for more information.</p>
	</div>

<?php
	// fetch all articles in the category.
	$cat_sql = "SELECT a.id, DATE_FORMAT(a.date_posted, \"%M %D, %Y\") " 
		. "as newdate , a.posted_by, a.title, a.summary FROM "
		. TBL_ARTICLES . " a, " . TBL_CATEGORIES . " c, " 
		. TBL_ARTICLE_CATEGORIES . " ac WHERE ac.cat_id = " . $cat_id 
		. " AND c.id = ac.cat_id AND a.id = ac.article_id AND a.state = " 
		. PUBLISHED_STATE . " ORDER BY a.date_posted DESC;";
		
	if ($result = mysqli_query($database->getConnection(), $cat_sql)) {
    	while ($row = mysqli_fetch_assoc($result)) {
    		$atitle = strtolower(str_replace(" ", "_", $row['title']));
 			echo "<div id='splitlist'><strong><a href='"
 				. "/articles/" . $atitle . "'>"
 		    	. $row['title'] . "</a></strong><br/>"
 		    	. "<small>Posted by <a href='"
 		    	. "/users/" . $row['posted_by'] 
 		    	. "'>" . $row['posted_by'] . "</a> on "
 		    	. $row['newdate'] . "</small><br/>"
		    	. $row['summary'] . "</div>";
    	}
    	
    	// free result set
    	mysqli_free_result($result);
	}	

?>

</div>

<?php
    }
    
include_once("footer.inc");
?>
