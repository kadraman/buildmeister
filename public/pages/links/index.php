<?php

include_once("common.inc");
include_once("header.inc");

?>

<div id="article">

	<div id="toptitle">
		<h2>Recommended Links</h2>
	</div>

	<div id="introductory">
		<p>This page contains a list of recommended links that discuss the build
		process and the tools that can be used to implement it. Please note, that 
		this is simply a collection of sites that members of this web site have 
		recommended, together with some personal comments about them. </p>
		<p>If you believe that there is a link that has been missed and should
 		be included then please <a href="../contact.php">contact us</a>.</p>
	</div>

<?php
	// fetch category and display it
	function displayCategory($title, $cat_id) {
    	global $database;
    	
    	echo "<div id='boxedtitle'>$title</div>\n";
    	$sql = "SELECT * from " . TBL_LINKS . " where cat_id = "
    		. $cat_id . " AND active = 1 ORDER BY date_posted DESC;";
    		
    	if ($result = mysqli_query($database->getConnection(), $sql)) {
    		while ($row = mysqli_fetch_assoc($result)) {
	            echo "<div id='splitsection'>\n";
    	        echo "<table width='100%' border=0'><tr>\n";        
                echo "<td width='100%' align='left' valign='top'>\n";
                echo "<strong><a href='" . $row['url'] . "'>" . $row['title'] 
                    . "</a></strong><br/>" . $row['summary'] . "</td>\n";
            	echo "</tr></table>"; 
		    	echo "</div>";
        	}
    	}
	       	
	} // displayCategory

	displayCategory("Portals", 0);
	displayCategory("Process", 1);
	displayCategory("Tools", 2);
	displayCategory("Miscellaneous", 3);

?>

</div>


<?php
include_once("footer.inc");
?>
