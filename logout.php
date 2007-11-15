<?php

session_start();

require("include/config.php");

session_unregister("SESS_USERNAME");
session_unregister("SESS_USERID");
session_unregister("SESS_USERLEVEL");

header("Location: " . $config_basedir);

?>
