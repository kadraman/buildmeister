<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include("include/header.php");

?>

<div id="article">

<div id="toptitle"><h2>Articles</h2></div>

<div id="introductory">
<p>This page lists all of the categorized articles that are contained on this site. 
If you have an idea for an article or have written some content yourself, then please 
<a href="contact.php">contact us</a> for more information or <a href="#submit">submit</a> 
your content using the form at the bottom of this page.</p>
</div>

<div id="boxedtitle">Build Process</div>

<?php
// fetch build process articles
$sql = "SELECT * from " . TBL_ARTICLES . " where cat_id = 1 ORDER BY date_posted DESC;";
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
<div id="boxedtitle">Build Tools</div>

<?php
// fetch build tools articles
$sql = "SELECT * from " . TBL_ARTICLES . " where cat_id = 2 ORDER BY date_posted DESC;";
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
<div id="boxedtitle">Supporting Core Skills</div>

<?php
// fetch miscellaneous articles
$sql = "SELECT * from " . TBL_ARTICLES . " where cat_id = 3 ORDER BY date_posted DESC;";
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

<a id="submit"></a>	    
</div>

<?php
include("include/footer.php");
?>
