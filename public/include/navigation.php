<?php

// TODO: get from database
for ($i = 0; $i < sizeof($navmenu_main); $i++) {
    // display menu items
    echo "<li><a href='" . $navmenu_main[$i]["Link"] . "' >" 
    	. $navmenu_main[$i]["Title"] . "</a></li>";
}

?>		
