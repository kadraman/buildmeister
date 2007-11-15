<?php

session_start();

require("include/config.php");

    if ($_POST['userlogin']) {
        # check username and password
        $_SESSION['SESS_USERNAME']  = "admin";
        $_SESSION['SESS_USERID']    = 1;
        $_SESSION['SESS_USERLEVEL'] = 1;
        header("Location: " . $config_basedir);
    }       

?>
