<?php
    include_once("session.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<title><?php echo SITE_NAME; ?></title>
	<script type="text/javascript" src="javascript/datetimepicker.js"></script>	
	<style type="text/css">
		@import "stylesheets/main.css";
		@import "stylesheets/article.css";
	</style>
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
	        <script type="text/javascript"><!--
                google_ad_client = "pub-3805144493754901";
		        google_alternate_color = "F4F4F4";
		        google_ad_width = 468;
		        google_ad_height = 60;
		        google_ad_format = "468x60_as";
		        google_ad_type = "text_image";
         		//2007-07-19: buildmeister.com
		        google_ad_channel = "7986490318";
		        google_color_border = "F4F4F4";
		        google_color_bg = "F4F4F4";
		        google_color_link = "0000FF";
		        google_color_text = "000000";
		        google_color_url = "008000";
		        google_ui_features = "rc:6";
		        //-->
	        </script> 
	        <script type="text/javascript"	src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
        </div>
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
		 		
		<!-- search begin -->
		<div id="search">
			<p>Search</p>
			<form id="search-form" method="get" action="search.php">
				<input class="formInputText" style="width:150px" type="text" 
					name="searchKeywords" maxlength="80" value="Enter keyword(s)" 
					onfocus="clearField(this)"/>
				<input id="search-button" type="submit" value="Search"/>			
			</form>
			</form>
		</div>
		<!-- search end -->

		<div id="spacer">&nbsp;</div>
		
		<!-- user menu begin -->
		<div id="login">
			<p>User Menu</p>
			<form id="login-form">
<?php
if ($session->logged_in) {
?>
			<ul>
				<li><a href="userinfo.php?user=<?php echo $session->username; ?>">View My Account</a></li>
				<li><a href="useredit.php?user=<?php echo $session->username; ?>">Edit Account</a></li>
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
		<!-- user menu end -->

<?php 
if ($session->isAdmin()) {
?>
		<div id="spacer">&nbsp;</div>
		<!-- administration menu begin -->
		<div id="menu">
			<p>Administration Menu</p>
			<form id="menu-form">
			<ul>
				<li><a href="pages/admin/users.php">Users</a></li>
			</ul>
			</form>
		</div>				
		<!-- administration menu end -->		
<?php 
}
?>

		<div id="spacer">&nbsp;</div>

		<!-- related reading begin -->
		<div id="reading">
			<p>Related Reading</p>
			<form id="reading-form">
			<div align="center">
				<iframe src="http://rcm.amazon.com/e/cm?t=thebuildmeist-20&o=1&p=8&l=st1&mode=books&search=software%20build%20development%20agile&nou=1&fc1=000000&lt1=_blank&lc1=3366FF&bg1=FFFFFF&f=ifr" marginwidth="0" marginheight="0" width="120" height="240" border="0" frameborder="0" style="border:none;" scrolling="no"></iframe>
			</div>
			</form>
		</div>
		<!-- related reading end -->
		
		<div id="spacer">&nbsp;</div>
		
		<!-- logos begin -->
		<div align="center">			
			
		</div>
		<!-- logos end -->
		
		<div id="spacer">&nbsp;</div>
		
	</div>
	<!-- sidebar end -->

<div id="sideseparator"></div>
<div id="content">
