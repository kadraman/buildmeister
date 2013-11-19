<?php

include_once("session.php");

?>

<!DOCTYPE html>
<html>
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="javascript/bootstrap.min.js"></script>

    <script type="text/javascript" src="/include/config.js"></script>
    <script type="text/javascript" src="/javascript/mootools-1.2.1-core.js"></script>
    <script type="text/javascript" src="/javascript/mootools-1.2-more.js"></script>
    <script type="text/javascript" src="/javascript/clientcide-1.2.js"></script>
    <script type="text/javascript" src="/javascript/datetimepicker.js"></script>
    <script type="text/javascript" src="/javascript/global.js"></script>
    <script type="text/javascript" src="/javascript/FilterTable.js"></script>
    <script type="text/javascript" src="/javascript/FormValidator.js"></script>
    <script type="text/javascript" src="/javascript/LabelledInput.js"></script>
    <script type="text/javascript" src="/javascript/LabelledInput.js"></script>
<?php
// include supporting javascript file for page (if present)
$jsfile = str_replace(".php", ".js", $_SERVER['PHP_SELF']);
//if (file_exists($jsfile)) {
	echo "<script type=\"text/javascript\" src=\"" . $jsfile . "\"></script>";
//}
?>

    <link href="stylesheets/bootstrap.min.css" rel="stylesheet">
<?php
/*
<style type="text/css">
@import "/stylesheets/main.css";
@import "/stylesheets/admin.css";
@import "/stylesheets/article.css";
@import "/stylesheets/socializer.css";
</style> */
?>
</head>

<body id="buildmeister">
	<!-- container begin -->
	<div id="container">
	
	    <!-- header begin -->
	    <div id="header">
	        <div id="logo">
		        <img src="/images/logo.gif" alt="The Buildmeister" />
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
					<li><a href="/">Home</a></li>
					<li><a href="/articles/">Articles</a></li>
					<li><a href="/books/">Books</a></li>
					<li><a href="/glossary/">Glossary</a></li>
					<li><a href="/links/">Links</a></li>
				</ul>
			</div>		
		 		
			<!-- search begin -->
			<div id="searchBox" class="sideBox">
				<div class="sideBoxTitle">Search</div>				
					<div id="searchFields" class="sideBoxContent">
						<form id="searchForm" action="/pages/search.submit.php" method="post">
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
						<li><a class="sideBoxLink" href="/users/<?php echo $session->username; ?>">My account</a></li>
						<li><a class="sideBoxLink" href="/users/logout.html">Logout</a></li>
					</ul>
<?php
				} else {
?>
					<ul class="sideBoxList">
						<li><a class="sideBoxLink" href="/users/login.html">Login</a></li>
						<li><a class="sideBoxLink" href="/users/forgotpass.html">Forgotten password?</a></li>
						<li><a class="sideBoxLink" href="/users/register.html">Register now?</a></li>
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
						<li><a class="sideBoxLink" href="/pages/admin/users/">Users</a></li>
						<li><a class="sideBoxLink" href="/pages/admin/articles/">Articles</a></li>
						<li><a class="sideBoxLink" href="/pages/admin/comments/">Comments</a></li>
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
			</div>
			<!-- logos end -->
		
			<div id="spacer">&nbsp;</div>
			
		    <!-- jobs begin --
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
//--
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
