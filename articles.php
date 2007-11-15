<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

require("include/header.php");

# fetch build process articles
echo "<div id='article'>";
echo "<p id='summary'>Articles on the Build Process</p>";
$sql = "SELECT * from articles where cat_id = 1 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
    		. $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "<br/><br/>";
    }
}    

# fetch build tools articles
echo "<p id='summary'>Articles on Build Tools</p>";
$sql = "SELECT * from articles where cat_id = 2 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
    		. $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "<br/><br/>";
    }
}

# fetch miscellaneous articles
echo "<p id='summary'>Articles on Supporting Core Skills</p>";
$sql = "SELECT * from articles where cat_id = 3 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
    		. $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "<br/><br/>";
    }
}	    
echo "</div>";
require("include/footer.php");

?>
