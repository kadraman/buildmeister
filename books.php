<?php

# home page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 2;

include("include/header.php");

include("include/footer.php");

?>
