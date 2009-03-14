<?php

include_once("common.inc");
include_once("header.inc");

?>

<div id="article">

	<div id="toptitle">
		<h2>Glossary</h2>
	</div>

	<div id="introductory">
		<p>This page is intended to define a number of terms that are used in
		or related to the build process. If you believe that a definition is
		missing and should be included then please <a href="../contact/">contact us</a>.</p>
	</div>

	<div id="alphabet">
<?php
for ($i = 65; $i <= 90; $i++) {
    echo "<a href='#" . chr($i) . "'>"
        . chr($i) . "</a>&nbsp;";
}        
?>
	</div>
        
<?php
// iterate over all the letters of the alphabet, fetching glossary terms
for ($i = 65; $i <= 90; $i++) {
    echo "<h2><a id='" . chr($i) . "'></a>"
        . chr($i) . "</h2>";
 
    // fetch glossary for letter
    $sql = "SELECT * from " . TBL_GLOSSARY 
        . " where active = 1 AND title REGEXP '^"
        . chr($i) . "' ORDER BY title;";
    if ($result = mysqli_query($database->getConnection(), $sql)) {	
    	$numrows = mysqli_num_rows($result);

    	// used to work out when to start/end table row
   	 	$count = 1;
    	if ($numrows != 0) {   
        	echo "<table width='95%'>";    
        	while ($row = mysqli_fetch_assoc($result)) {
            	// if first/odd item start new row
           		if (($count % 2) == 1) {
                	echo "<tr>\n";
            	}
            	// replace spaces for href navigation 
            	$title = $row['title'];
            	$href = str_replace(' ', '_', $title);
            	echo "<td class='glossitem' valign='top'><strong><a id='#" . $href . "'></a>"
        	    	. "<a href='" . REWRITE_PREFIX . "/categories/" 
        	    	. $href . "'>" 
                	. $row['title'] . "</a></strong><br/>"
		        	. stripslashes($row['summary']) . "</td>\n";
            	// do we have just a single row?
            	if ($numrows ==1) {
                	// yes add another column
                	echo "<td></td>\n";
            	}
            	// if last/even item end row		    
		    	if (($count++ % 2) == 0) {
                	echo "</tr>\n";
            	} 	
        	}
        	// do we have an odd number of entries?
        	if (($numrows % 2) == 1) {
            	// yes close down row
            	echo "</tr>";
        	}            
        	echo "</table>\n";
    	}    
    }   
}
?>

</div>

<?php
include_once("footer.inc");
?>
