<?php

include_once("session.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<title>
<?php
if (isset($html_head_title)) {
	echo SITE_NAME . ": " . $html_head_title; 
} else {
	echo SITE_NAME;
}
?>	
	</title>
	<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/include/config.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/mootools-1.2.1-core.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/mootools-1.2-more.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/clientcide-1.2.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/global.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/FilterTable.js"></script>
<?php
	// include supporting javascript file for page (if present)
    $jsfile = basename($_SERVER['PHP_SELF'], ".php") . ".js";
	if (file_exists($jsfile)) {
		echo "    <script type=\"text/javascript\" src=\"" . $jsfile . "\"></script>";
	}
?>	
	<style type="text/css">
		@import "<?php echo SITE_PREFIX; ?>/stylesheets/main.css";
		@import "<?php echo SITE_PREFIX; ?>/stylesheets/admin.css";
		@import "<?php echo SITE_PREFIX; ?>/stylesheets/article.css";
	</style>
</head>

<body id="buildmeister">
	<!-- container begin -->
	<div id="container">
	
	    <!-- header begin -->
	    <div id="header">
	        <div id="logo">
		        <img src="<?php echo SITE_PREFIX; ?>/images/logo.gif" alt="The Buildmeister" /> 
	        </div>
	    	<!-- advert begin -->
	    	<div id="advert">
	        	
        	</div>
	    	<!-- advert end -->	
		</div>
		<!-- header end --> 
	
		<!-- sidebar begin -->
		<div id="sidebar">
			<!-- navigation menu begin -->
			<div id="navigationBox" class="sideBox">
				<div class="sideBoxTitle">Navigation</div>
				<div id="navigationFields" class="sideBoxContent">
					<ul class="sideBoxList">
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/">Home</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/articles/">Articles</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/books/">Books</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/glossary/">Glossary</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/links/">Links</a></li>
					</ul>
				</div>
			</div>			
		 		
			<!-- search begin -->
			<div id="searchBox" class="sideBox">
				<div class="sideBoxTitle">Search</div>
				<form id="searchForm" action="<?php echo SITE_PREFIX; ?>/pages/search.submit.php" method="post">					
					<div id="searchFields" class="sideBoxContent">
						<input id="searchKeywords" class="txt" 
							style="width:125px" type="text" maxlength="80" 
							name="searchKeywords" value="Enter keyword(s)"/>
						<input type="submit" value="Search" id="submit" class="btn"/>
						&nbsp;
						<!-- TODO: advanced search -->
						<!-- a id="advancedSearch" href="">Advanced</a-->								
					</div>
				</form>
			</div>
			<!-- search end -->
		
			<!-- user menu begin -->
			<div id="userMenuBox" class="sideBox">
				<div class="sideBoxTitle">User Menu</div>
				<div id="userMenuFields" class="sideBoxContent">
<?php
				if ($session->logged_in) {
?>
					<ul class="sideBoxList">
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/users/view.php?user=<?php echo $session->username; ?>">My Account</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/include/process.php">Logout</a></li>
					</ul>
<?php
				} else {
?>
					<ul class="sideBoxList">
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/login.php">Login</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/forgotpass.php">Forgotten password?</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/register.php">Register now?</a></li>
					</ul>
<?php
				}
?>
				</div>
			</div>
			<!-- user menu end -->

<?php 
		if ($session->isAdmin()) {
?>
			<!-- administration menu begin -->
			<div id="adminMenuBox" class="sideBox">
				<div class="sideBoxTitle">Administration Menu</div>
				<div id="adminMenuFields" class="sideBoxContent">
					<ul class="sideBoxList">
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/admin/users/">Users</a></li>
					</ul>	
				</div>
			</div>				
			<!-- administration menu end -->		
<?php 
		}
?>

			<!-- related reading begin -->
			<div id="readingBox" class="sideBox">
				<div class="sideBoxTitle">Related Reading</div>
				<div id="advertFields" class="sideBoxContent">
					<div align="center">
						
					</div>
				</div>
			</div>
			<!-- related reading end -->
				
			<!-- logos begin -->
			<div align="center">			
				<!-- TODO: include logos -->
				<b>Icons by <a href="http://dryicons.com">DryIcons</a></b>
			</div>
			<!-- logos end -->
		
			<div id="spacer">&nbsp;</div>
		
		</div>
		<!-- sidebar end -->

		<!-- div id="sideseparator"></div-->
		
		<!-- content begin -->
		<div id="content">
