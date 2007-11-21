<?php

# links page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 4;

include("include/header.php");
?>

<div id="toptitle"><h2>Recommended Links</h2></div>


<?php
include("include/footer.php");
?>
