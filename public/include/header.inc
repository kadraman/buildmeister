<?php

include_once("session.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
<?php
// meta description
if (isset($html_head_description)) {
	echo "<meta name=\"description\" content=\"" . $html_head_description . "\"/>\n"; 
} 
// meta keywords
if (isset($html_head_keywords)) {
	echo "<meta name=\"keywords\" content=\"" . $html_head_keywords . "\">\n";
}
// page title
echo "<title>";
if (isset($html_head_title)) {
	echo SITE_NAME . ": " . $html_head_title; 
} else {
	echo SITE_NAME;
}
echo "</title>";
?>	
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/include/config.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/mootools-1.2.1-core.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/mootools-1.2-more.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/clientcide-1.2.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/global.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/FilterTable.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/FormValidator.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/LabelledInput.js"></script>
<script type="text/javascript" src="<?php echo SITE_PREFIX; ?>/javascript/LabelledInput.js"></script>
<?php
// include supporting javascript file for page (if present)
$jsfile = str_replace(".php", ".js", $_SERVER['PHP_SELF']);
//if (file_exists($jsfile)) {
	echo "<script type=\"text/javascript\" src=\"" . $jsfile . "\"></script>";
//}
?>	
<style type="text/css">
@import "<?php echo SITE_PREFIX; ?>/stylesheets/main.css";
@import "<?php echo SITE_PREFIX; ?>/stylesheets/admin.css";
@import "<?php echo SITE_PREFIX; ?>/stylesheets/article.css";
@import "<?php echo SITE_PREFIX; ?>/stylesheets/socializer.css";
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
<script type="text/javascript"><!--
google_ad_client = "pub-3805144493754901";
/* 468x60, created 04/07/09 */
google_ad_slot = "4032349692";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
        	</div>
	    	<!-- advert end -->	
		</div>
		<!-- header end --> 
	
		<!-- sidebar begin -->
		<div id="sidebar">
			<!-- navigation menu begin -->
			<div id="navigation">
				<ul id="links">
					<li class="menuTitle">Main Menu</li>
					<li><a href="<?php echo REWRITE_PREFIX; ?>/">Home</a></li>
					<li><a href="<?php echo REWRITE_PREFIX; ?>/articles/">Articles</a></li>
					<li><a href="<?php echo REWRITE_PREFIX; ?>/books/">Books</a></li>
					<li><a href="<?php echo REWRITE_PREFIX; ?>/glossary/">Glossary</a></li>
					<li><a href="<?php echo REWRITE_PREFIX; ?>/links/">Links</a></li>
				</ul>
			</div>		
		 		
			<!-- search begin -->
			<div id="searchBox" class="sideBox">
				<div class="sideBoxTitle">Search</div>				
					<div id="searchFields" class="sideBoxContent">
						<form id="searchForm" action="<?php echo SITE_PREFIX; ?>/pages/search.submit.php" method="post">
							<input id="keywords" class="labelled"
								type="text" maxlength="80" 
								name="keywords" value="keywords"/>
							<input type="submit" value="Search" id="searchSubmit"/>
							&nbsp;
							<!-- TODO: advanced search -->
							<!-- a id="advancedSearch" href="">Advanced</a-->
						</form>								
					</div>
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
						<li><a class="sideBoxLink" href="<?php echo REWRITE_PREFIX; ?>/users/<?php echo $session->username; ?>">My account</a></li>
						<li><a class="sideBoxLink" href="<?php echo REWRITE_PREFIX; ?>/users/logout.html">Logout</a></li>
					</ul>
<?php
				} else {
?>
					<ul class="sideBoxList">
						<li><a class="sideBoxLink" href="<?php echo REWRITE_PREFIX; ?>/users/login.html">Login</a></li>
						<li><a class="sideBoxLink" href="<?php echo REWRITE_PREFIX; ?>/users/forgotpass.html">Forgotten password?</a></li>
						<li><a class="sideBoxLink" href="<?php echo REWRITE_PREFIX; ?>/users/register.html">Register now?</a></li>
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
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/admin/articles/">Articles</a></li>
						<li><a class="sideBoxLink" href="<?php echo SITE_PREFIX; ?>/pages/admin/comments/">Comments</a></li>
					</ul>	
				</div>
			</div>				
			<!-- administration menu end -->		
<?php 
		}
?>

			<!-- related reading begin -->
			<div id="readingBox" class="sideBox">
				<div class="sideBoxTitle">Recommended Reading</div>
				<div id="advertFields" class="sideBoxContent">
					<div align="center">
<script type="text/javascript"><!--
amazon_ad_tag="thebuildmeist-20"; 
amazon_ad_width="120"; 
amazon_ad_height="600"; 
amazon_color_background="FFFFFF"; 
amazon_color_border="FFFFFF"; 
amazon_color_logo="412288"; 
amazon_color_link="2B5A6B"; //--></script>
<script type="text/javascript" src="http://www.assoc-amazon.com/s/asw.js"></script>						
					</div>
				</div>
			</div>
			<!-- related reading end -->
				
			<!-- logos begin -->
			<div align="center">			
				<!-- TODO: include logos -->
				<b>Best viewed on:</b><br/>
				<a href="http://www.mozilla.com/firefox?from=sfx&uid=256449&t=305"><img border="0" alt="Spreadfirefox Affiliate Button" src="http://sfx-images.mozilla.org/affiliates/Buttons/firefox3/110x32_best-yet.png" /></a>
				<br/><br/>
			</div>
			<!-- logos end -->
		
			<div id="spacer">&nbsp;</div>
			
		    <!-- jobs begin -->
		    <div align="center">
		    <script type="text/javascript">
<!-- 
var jobthread_widget_title = "Jobs";
var jobthread_widget_outer_style = "background-color:#dddddd;border:1px solid #999999;width:160px;";
var jobthread_widget_inner_style = "background-color:#ffffff;color:#666666;border:1px solid #999999;margin-left:10px;margin-right:10px;padding:10px 10px 2px 8px;font:11px Arial, Helvetica, Sans-serif;line-height:16px;";
var jobthread_widget_title_style = "color:#313131;font-weight:bold;";
var jobthread_widget_link_style = "color:#0464bb;font-size:11px;font-weight:normal;text-decoration:none;border:none;";
var jobthread_widget_top_style = "padding-top:8px;";
var jobthread_widget_bottom_style = "padding-bottom:4px;";
//-->
</script>
<script type="text/javascript" src="http://syndication.jobthread.com/widget/?id=3bac5b&num_jobs=5&keywords=<?php echo $html_head_keywords ?>"></script>		    
		    </div>
		    <!-- jobs end -->
		    
			<div id="spacer">&nbsp;</div>
		
		</div>
		<!-- sidebar end -->

		<!-- div id="sideseparator"></div-->
		
		<!-- content begin -->
		<div id="content">
