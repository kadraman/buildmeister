<?php

# glossary page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 3;

include("include/header.php");
?> 

<div id="toptitle"><h2>Glossary</h2></div>

<?php
include("include/footer.php");

?>
