<?php

include_once("common.inc");
include_once("session.php");

echo "<div id='article'>\n";
echo "<div id='toptitle'>\n";

if (!isset($_POST['keywords']) || ($_POST['keywords'] == "")
	|| ($_POST['keywords'] == "keywords")) {
	// no keywords have been specified
	echo "<h2>No keywords have been specified...</h2>\n";
	echo "</div>\n"; 
} else {
	// retrieve the keywords
	$keywordArray = explode(" ", $database->clean_data($_POST['keywords']));

	// search for the entries
	$search_sql = "SELECT id, DATE_FORMAT(date_posted, \"%M %D, %Y\") " .
		" as newdate, posted_by, title, summary FROM " . TBL_ARTICLES . 
		" WHERE content LIKE '%" . $keywordArray[0] . "%'";
	for ($i = 1; $i < count($keywordArray); $i++ ) {
		$search_sql = $search_sql . " AND content LIKE '%" . $keywordArray[$i] . "%'";
	}
	$search_sql = $search_sql . " AND state = " . PUBLISHED_STATE . " ORDER BY date_posted DESC;";

	$result = mysqli_query($database->getConnection(), $search_sql);

	if (!$result || (mysqli_num_rows($result) < 1)) {
		echo "<h2>No matching article(s) with keyword(s): " . 
		"<u>" . $_POST['keywords'] . "</u></h2>\n";
		echo "</div>\n";
	} else {
		echo "<h2>Found " . mysqli_num_rows($result) 
			. " matching article(s) with keyword(s): " 
			. "<u>" . $_POST['keywords'] . "</u></h2>\n";
		echo "</div>\n";

    	while ($row = mysqli_fetch_assoc($result)) {
        	echo "<div id='splitlist'><strong><a href='"
        		. SITE_PREFIX . "/pages/articles/view.php?id=" . $row['id'] . "'>"
 		    	. $row['title'] . "</a></strong><br/>"
 		    	. "<small>Posted by <a href='" . SITE_PREFIX 
 		    	. "/pages/users/view.php?user=" . $row['posted_by'] 
 		    	. "'>" . $row['posted_by'] . "</a> on "
 		    	. $row['newdate'] . "</small><br/>"
		    	. $row['summary'] . "</div>";
    	}
    	
    	mysqli_free_result($result);
	}
}

echo "</div>\n";

?>
