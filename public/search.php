<?php

sleep(5);

include_once("include/database.php");
include_once("include/functions.php");

echo "<div id='article'>\n";
echo "<div id='toptitle'>\n";

if (!isset($_GET['searchKeywords']) || ($_GET['searchKeywords'] == "")
	|| ($_GET['searchKeywords'] == "Enter keyword(s)")) {
	// no keywords have been specified
	echo "<h2>No keywords have been specified...</h2>\n";
	echo "</div>\n"; 
} else {
	# retrieve the keywords
	$keywordArray = explode(" ", clean_data($_GET['searchKeywords']));

	# search for the entries
	$search_sql = "SELECT id, DATE_FORMAT(date_posted, \"%M %D, %Y\") " .
		" as newdate, posted_by, title, summary FROM " . TBL_ARTICLES . 
		" WHERE content LIKE '%" . $keywordArray[0] . "%'";
	for ($i = 1; $i < count($keywordArray); $i++ ) {
		$search_sql = $search_sql . " AND content LIKE '%" . $keywordArray[$i] . "%'";
	}
	$search_sql = $search_sql . " AND state = 1 ORDER BY date_posted DESC;";

	$result = mysql_query($search_sql);
	$numrows = mysql_num_rows($result);
	
	echo "<h2>Found " . $numrows . " matching article(s) with keyword(s): " . 
		"<u>" . $_GET['searchKeywords'] . "</u></h2>\n";
	echo "</div>\n";
	
	if ($numrows > 0) {
    	while ($row = mysql_fetch_assoc($result)) {
        	echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
 		    	. $row['title'] . "</a></strong><br/>"
 		    	. "<small>Posted by <a href='userinfo.php?user=" . $row['posted_by'] 
 		    	. "'>" . $row['posted_by'] . "</a> on "
 		    	. $row['newdate'] . "</small><br/>"
		    	. $row['summary'] . "</div>";
    	}
	}
}

echo "</div>\n";

?>
