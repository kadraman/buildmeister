<?php
    session_start();

    require("config.php");

    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <title><?php echo $config_sitename; ?></title>
    <link type="text/css" title="www" rel="stylesheet" media="screen" href="stylesheets/main.css" />
    <link type="text/css" title="www" rel="stylesheet" media="screen" href="stylesheets/article.css" />
</head>

<body id="buildmeister">
<div id="container">

    <!-- header begin -->
    <div id="header">
        <div id="logo">
        <a href="http://www.buildmeister.com">
            <img src="images/logo.gif" alt="The Buildmeister"/>
            </a>
        </div>
    </div>
    <!-- header end -->

  <!-- sidebar begin -->
    <div id="sidebar">
        <!-- navigation menu begin -->
        <div id="navigation">
            <ul id="links">
                <?php
                    require("navigation.php");
                ?>
            </ul>
        </div>
        <!-- navigation bar end -->

    <!-- login begin -->
    <div id="login">
<?php
    if (isset ($_SESSION['SESS_USERNAME'])) {
        require("logout-form.php");
    } else {
        require("login-form.php");
    }        
?>            
        </div>
    <!-- login end -->

    <div id="spacer"></div>

    <!-- search begin -->
    <div id="search">
        <p>Search for:</p>
            <form id="search-form" method="get" action="http://www.buildmeister.com/search_results.php" target="_top">
                 <input type="text" name="q" maxlength="255" value="buildmeister" id="sbi"></input>
                 <input type="radio" name="sitesearch" checked id="ss0"></input>
                 <label for="ss0" title="Search the Web">The Web</label>
                 <input type="radio" name="sitesearch" checked value="www.buildmeister.com" id="ss1"></input>
                 <label for="ss1" title="Search www.buildmeister.com">This Site</label>
                 <label for="sbi" style="display: none">Enter your search terms</label>
                 <label for="sbb" style="display: none">Submit search form</label>
                 <input type="hidden" name="domains" value="www.buildmeister.com"></input>
                 <input type="submit" name="sa" value="Search" id="sa"></input>
                 <input type="hidden" name="client" value="pub-3805144493754901"></input>
                 <input type="hidden" name="forid" value="1"></input>
                 <input type="hidden" name="channel" value="1628619554"></input>
                 <input type="hidden" name="ie" value="ISO-8859-1"></input>
                 <input type="hidden" name="oe" value="ISO-8859-1"></input>
                 <input type="hidden" name="safe" value="active"></input>
                 <input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:F4F4F4;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:11"></input>
                 <input type="hidden" name="hl" value="en"></input>
     </form>
    </div>
    <!-- search end -->

    <div id="spacer"></div>

    </div>
    <!-- sidebar end -->

    <div id="content">

