<?php
include("include/session.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<title><?php echo SITE_NAME; ?></title>
	<link type="text/css" title="www" rel="stylesheet" media="screen"
		href="stylesheets/main.css" />
	<link type="text/css" title="www" rel="stylesheet" media="screen"
		href="stylesheets/article.css" />
<script language="javascript" type="text/javascript">
function clearField(obj) {
	if (obj.defaultValue==obj.value) obj.value = '';
}
</script>
</head>

<body id="buildmeister">
	<div id="container">
	
	<!-- header begin -->
	<div id="header">
	<div id="logo">
		<a href="http://www.buildmeister.com"> 
			<img src="images/logo.gif" alt="The Buildmeister" /> 
		</a>
	</div>
	<!-- advert begin -->
	<div id="advert">
	    <a href="http://sourceforge.net"><img src="http://sflogo.sourceforge.net/sflogo.php?group_id=207249&amp;type=7" width="210" height="62" border="0" alt="SourceForge.net Logo" /></a>    </div>
	<!-- advert end -->
	</div>
	<!-- header end --> 
	
	<!-- sidebar begin -->
	<div id="sidebar">
		<!-- navigation menu begin -->
		<div id="navigation">
		<ul id="links">
<?php
include("navigation.php");
?>
		</ul>
		</div>
		<!-- navigation bar end --> 
		<!-- user menu begin -->
		<div id="login">
			<p>User Menu</p>
			<form id="login-form">
<?php
if ($session->logged_in) {
    ?>
			<ul>
				<li><a href="userinfo.php?user=<?php echo $session->username; ?>">View
					My Account</a></li>
				<li><a href="useredit.php?user=<?php echo $session->username; ?>">Edit
					Account</a></li>
<?php
	if ($session->isAdmin()) {
	    echo "<li><a href=\"admin\admin.php\">Admin Center</a></li>";
	}
?>
				<li><a href="include/process.php">Logout</a></li>
			</ul>
	<?php
} else {
    ?>
			<ul>
				<li><a href="login.php">Login</a></li>
				<li><a href="forgotpass.php">Forgotten password?</a></li>
				<li><a href="register.php">Register now?</a></li>
			</ul>
    <?php
}
?>
			</form>
		</div>
		<!-- login end -->

		<div id="spacer">&nbsp;</div>

		<!-- search begin -->
		<div id="search">
			<p>Search</p>
			<form id="search-form" method="get" action="search.php">
			<input class="formInputText" type="text" name="q" maxlength="255"
				value="" id="sbi">
			<br />
			<input type="radio" name="sitesearch" checked id="ss0"></input>
			<label for="ss0" title="Search the Web">The Web</label>
			<input type="radio" name="sitesearch" checked
				value="www.buildmeister.com" id="ss1"></input>
			<label for="ss1" title="Search www.buildmeister.com">This Site</label>
			<label for="sbi" style="display: none">Enter your search terms</label>
			<label for="sbb" style="display: none">Submit search form</label>
			<input type="hidden" name="domains" value="www.buildmeister.com"></input>
			<div align=left><input type="submit" name="sa" value="Search" id="sa"></input></div>
			<input type="hidden" name="client" value="pub-3805144493754901"></input>
			<input type="hidden" name="forid" value="1"></input>
			<input type="hidden" name="channel" value="1628619554"></input>
			<input type="hidden" name="ie" value="ISO-8859-1"></input>
			<input type="hidden" name="oe" value="ISO-8859-1"></input>
			<input type="hidden" name="safe" value="active"></input>
			<input type="hidden" name="cof"
				value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:11"></input>
			<input type="hidden" name="hl" value="en"></input>
			</form>
		</div>
		<!-- search end -->

		<div id="spacer">&nbsp;</div>

		<!-- related reading begin -->
		<div align="center">		
    		<a href="http://sourceforge.net/donate/index.php?group_id=207249"><img src="http://images.sourceforge.net/images/project-support.jpg" width="88" height="32" border="0" alt="Support This Project" /> </a>
        </div>		
		<!-- related reading end -->

		<div id="spacer">&nbsp;</div>
		
	</div>
	<!-- sidebar end -->

<div id="sideseparator"></div>
<div id="content">