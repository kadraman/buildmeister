<div id="block">
	<div id='boxedtitle'>Latest Articles</div>
<?php
	// fetch latest articles
	$sql = "SELECT * from " . TBL_ARTICLES .
    	" where state = " . PUBLISHED_STATE . 
    	" ORDER BY date_posted DESC LIMIT 5;";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		if (mysqli_num_rows($result) != 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] .
            		"'>" . $row['title'] . "</a></strong><br/>" . $row['summary'] . "</div>\n";
			}
		}
	}

?>
	<div id='dashed-spacer'></div>
</div>