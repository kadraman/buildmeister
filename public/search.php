<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("include/header.php");

if (!isset($_GET['searchKeywords']) || ($_GET['searchKeywords'] == "")
	|| ($_GET['searchKeywords'] == "Enter keyword(s)")) {
	// no keywords have been specified
	$session->displayDialog("No Keywords Specified",
		"No keywords have been specified, please enter at least one in the search field.",
	        $session->referrer);
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
	
?>

<div id="article">

	<div id="toptitle">
		<h2>Found <?php echo $numrows ?> matching article(s) with keyword(s): 
			<u><?php echo $_GET['searchKeywords']?></u></h2>
	</div>
	
<?php

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

?>

	<div id="spacer">&nbsp;</div>

</div>

<?php
    }
    
include("include/footer.php");
?>
