<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("include/header.php");

if (!isset($_GET['catid'])) {
	$session->displayDialog("No Category",
		"No category has been specified, please select an article on the "
	    . "<a href='articles.php'>articles</a> page and click on its category.",
	        $session->referrer);
} else {
	// retrieve the id of the article to display
	$catid = clean_data($_GET['catid']);
	
	// get category name
	$cat_name_sql = "SELECT name from " . TBL_CATEGORIES . " where id = " . $catid;
	$cat_name = mysql_result(mysql_query($cat_name_sql), 0);
?>

<div id="article">

	<div id="toptitle">
		<h2>Articles in category: <u><?php echo $cat_name?></u></h2>
	</div>

	<div id="introductory">
		<p>This page lists all of the articles that are contained in the <u><?php echo $cat_name?></u>
		category. We are always	looking for new artilces, if you have an idea for an article on this
		topic or have written some content yourself that you would like to shared, then please 
		<a href="contact.php">contact us</a> for more information.</p>
	</div>

<?php
// fetch all articles in the category.
//$sql = "SELECT * from " . TBL_ARTICLES . " where active = 1 AND ORDER BY date_posted DESC;";
$sql = "SELECT a.id, DATE_FORMAT(a.date_posted, \"%M %D, %Y, %l:%i%p\") " .
		"as newdate , a.posted_by, a.title, a.summary FROM " .
		TBL_ARTICLES . " a, " . TBL_CATEGORIES . " c, " .
		TBL_ARTICLE_CATEGORIES . " ac WHERE ac.cat_id = " . $catid . 
		" AND c.id = ac.cat_id AND a.id = ac.article_id AND a.state = 1;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
 		    . $row['title'] . "</a></strong><br/>"
		    . $row['summary'] . "</div>";
    }
}

?>

	<div id="spacer">&nbsp;</div>

</div>

<?php
    }
    
include("include/footer.php");
?>
