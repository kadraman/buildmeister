<?php

#require("db.php");

# home page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 2;

require("include/header.php");

require("include/footer.php");

?>
