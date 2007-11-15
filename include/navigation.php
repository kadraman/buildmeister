<?php

session_start();

require("db.php");

for ($i = 0; $i < sizeof($navmenu_main); $i++) {
    # is the item currently active?
    if ($i == $_SESSION['SESS_NAVITEM']) {
        $class = "is-active";	    
    } else {
        $class = "";
    }	    

    # display menu items
    echo "<li><a href='" . $navmenu_main[$i]["Link"] . "' class='" . $class . "'>" . $navmenu_main[$i]["Title"] . "</a></li>";
}

?>		
