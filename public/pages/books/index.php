<?php

include_once("common.inc");
include_once("header.php");

?>

<div id="article">

	<div id="toptitle">
		<h2>Recommended Books</h2>
	</div>

	<div id="introductory">
		<p>This page contains a list of recommended books that discuss the build
		process and the tools that can be used to implement it. Please note, that 
		this is simply a list of books that members of this web site have 
		read and enjoyed, together with some personal comments about them. </p>
		<p>If you believe that there is a book that has been missed and should
 		be included then please <a href="../../contact.php">contact us</a>.</p>
	</div>

<?php
	// fetch all active books
	$sql = "SELECT * from " . TBL_BOOKS 
		. " where active = 1 ORDER BY date_published DESC;";
	
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
        	echo "<div id='splitsection'>\n";
       		echo "<table width='100%' border=0'><tr>\n";
        	echo "<td align='center' width='150px'><img src='"
        		. $row['image_url'] . "' alt='[book image]'></td>\n";
        	echo "<td><strong><a href='" . $row['url'] . "'>" . $row['title'] . "</a></strong><br/>by <i>"
        		. $row['author'] . "</i><br/><br/>"
				. $row['summary'] . "</td>\n";
			echo "</tr></table>"; 
			echo "</div>";
    	}
	}
  
?>

</div>

<?php
include_once("footer.php");
?>