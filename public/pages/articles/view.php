<?php

include_once("common.inc");
include_once("session.php");

// get details of article and add to HTML header
if (isset($_GET['id'])) {
	$aid = $database->clean_data($_GET['id']);
	$html_head_title = $database->getArticleTitle($aid);
	$html_head_description = str_replace("\n", "", trim($database->getArticleSummary($aid)));
	$html_head_keywords = trim($database->getArticleCategories($aid));
} else if (isset($_GET['title'])) {
	$atitle_unformatted = $database->clean_data($_GET['title']);
	$atitle = str_replace("_", " ", $atitle_unformatted);
	$aid = $database->getArticleIdByTitle($atitle);
	$html_head_title = $database->getArticleTitle($aid);
	$html_head_description = str_replace("\n", "", trim($database->getArticleSummary($aid)));
	$html_head_keywords = trim($database->getArticleCategories($aid));
}

include_once("fckeditor/fckeditor.php");
include_once("header.inc");

// do we have an article id?
if (!isset($_GET['id']) && !isset($_GET['title'])) {
    $session->displayDialog("No Article Specified",
    	"No article has been specified, please select an article on the "
        . "<b>articles</b> page to see its content.",
        SITE_BASEDIR . "/pages/articles/");
// does the article exist?	        
} else if (!$database->articleExists($aid)) {
	$session->displayDialog("Article Does Not Exist",
    	"The specified article does not exist, please select an article on the "
    	. "<b>articles</b> page to see its content.",
        SITE_BASEDIR . "/pages/articles/");		        	        
} else {
    $currentid = $aid;
	    
    // update view count
    if (!$session->isAdmin()) {
    	$database->updateArticleViews($currentid);
    }
    
    // should we show comments and comment form
    $show_comments = true;
	    
    // fetch article content
    echo "<div id='article'>\n";    
        
    $article_sql = "SELECT id, title, posted_by, DATE_FORMAT(date_posted, \"%M %D, %Y\")"
   		. " as newdate, DATE_FORMAT(date_updated, \"%M %D, %Y\") as updated, "
    	. "content, state from " . TBL_ARTICLES . " where id = " . $currentid;
        
    if ($result = mysqli_query($database->getConnection(), $article_sql)) {
		$row = mysqli_fetch_assoc($result);

		$realTitle = $row['title'];
		echo "<a id='top' name='top' title='top'></a>";
		echo "<h1 id='title'>" . $realTitle . "</h1>\n";
		
		// summary
		echo "<div id='articleSummary'>\n";
		
		// dzone
		echo "<div id='dZoneBox'>\n";
		echo "<script type='text/javascript'>";
		echo "var dzone_url = '" . SITE_BASEDIR . "/articles/" . $atitle_unformatted . "';\n";
		echo "var dzone_title = '" . $realTitle . "';\n";
		echo "var dzone_blurb = '" . $html_head_description . "';\n";
		echo "var dzone_style = '1';\n";
		echo "</script>";
		echo "<script language='javascript' src='http://widgets.dzone.com/widgets/zoneit.js'></script>\n";
		echo "</div>";
				
		echo "<div id='articleMeta'>\n";
		
   		// has the article been published?
    	if ($row['state'] != PUBLISHED_STATE) {
    		// NO, just display message 
    		echo "<p style='align:center' class='error'>This article has not yet been published.</p>";
    		$show_comments = false;
    	}

    	// show the article if unpublished and admin
    	if ($row['state'] == PUBLISHED_STATE || $session->isAdmin()) {
   			// display article
   			echo "<span class='header'>Posted by <a href='"
   				. REWRITE_PREFIX . "/users/" . $row['posted_by'] 
    			. "'>" . $row['posted_by'] . "</a> on " . $row['newdate'];
    		if (strcmp($row['updated'], "") != 0) {
    			echo ", last updated on " . $row['updated'];
    		}

    		// display edit and delete links
   			if ($session->isAdmin()) {
   				echo "&nbsp;|&nbsp;<a href='" . REWRITE_PREFIX .
   					"/articles/edit/" . $row['id'] . "'>Edit</a>";
				echo " | <a id='articleDelete' href='' >Delete</a>";
       		}

       		echo "</span>\n";
	       	echo "<br/>";
			echo "Filed under:&nbsp;\n";
  					
			// get categories for entry
			$cat_sql = "select a.cat_id, c.name from " . TBL_ARTICLE_CATEGORIES . " a, " 
				. TBL_CATEGORIES . " c where a.article_id = " . $row['id'] . " AND a.cat_id = c.id;";
			if ($cat_result = mysqli_query($database->getConnection(), $cat_sql)) {
				if (mysqli_num_rows($cat_result) == 0) {
   					echo "Uncategorized"; 
   				} else {
					while ($cat_row = mysqli_fetch_assoc($cat_result)) {
						$cname = strtolower(str_replace(" ", "_", $cat_row['name']));
	    				echo "<a class=\"labels\" href=\"" . REWRITE_PREFIX
	    					. "/categories/" . $cname . "\">" 
	    					. $cat_row['name'] . "</a>&nbsp;\n";
					}
   				}
				// free result set
    			mysqli_free_result($cat_result);
			} 
			echo "<br/>";
								
    		// fetch number of comments
   			$comment_sql = "SELECT COUNT(id) from " . TBL_ARTCOM . " where state = 1 AND art_id = ". $currentid;
   			if ($comment_result = mysqli_query($database->getConnection(), $comment_sql)) {
   				if (mysqli_num_rows($comment_result) == 0) {
   					echo "There are <a href='#comments'>no comments</a> on this article."; 
   				} else {
   					$comment_row = mysqli_fetch_row($comment_result);
   					echo "There are <a href='#comments'>" 
   						. $comment_row[0] . " comments</a> on this article.";
   				}
   			}
   			// free result set
    		mysqli_free_result($comment_result);

    		echo "</div></div>\n";
    		   		
?>

<!-- social networking/bookmarking -->
<div id="addThis">

<!-- AddThis Button BEGIN -->
<script type="text/javascript">
	var addthis_pub = "kevinlee";
	var addthis_brand = 'The Buildmeister';
	var addthis_header_color = "#412288";
	var addthis_header_background = "#BECEDC";		
</script>
<a href="http://www.addthis.com/bookmark.php?v=20" 
	onmouseover="return addthis_open(this, '', 
		'<?php echo SITE_BASEDIR . "/articles/" . $atitle_unformatted ?>', 
		'<?php echo $realTitle ?>')" 
	onmouseout="addthis_close()" onclick="return addthis_sendto()">
	<img src="http://s7.addthis.com/static/btn/lg-bookmark-en.gif" 
	width="125" height="16" alt="Bookmark and Share" style="border:0"/>
</a>
<script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
<!-- AddThis Button END -->

</div>

<?php 				
			echo htmlspecialchars_decode($row['content']);  															
    	}
    	
    	// free result set
    	mysqli_free_result($result);
	}
?>

<!-- social networking/bookmarking -->
<div id="addThis">

<!-- AddThis Button BEGIN -->
<script type="text/javascript">
	var addthis_pub = "kevinlee";
	var addthis_brand = 'The Buildmeister';
	var addthis_header_color = "#412288";
	var addthis_header_background = "#BECEDC";		
</script>
<a href="http://www.addthis.com/bookmark.php?v=20" 
	onmouseover="return addthis_open(this, '', 
		'<?php echo SITE_BASEDIR . "/articles/" . $atitle_unformatted ?>', 
		'<?php echo $realTitle ?>')" 
	onmouseout="addthis_close()" onclick="return addthis_sendto()">
	<img src="http://s7.addthis.com/static/btn/lg-bookmark-en.gif" 
	width="125" height="16" alt="Bookmark and Share" style="border:0"/>
</a>
<script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
<!-- AddThis Button END -->

</div>

<?php 		   
	// display comments and comment form
	if ($show_comments) {
		echo "<a id='comments' name='comments' title='comments'></a>";
		
		echo "<div id='comment'>\n";
	   	echo "<h3 class='sub'>Comments</h3>\n";

	   	// fetch comments
   		$comment_sql = "SELECT id, posted_by, comment, DATE_FORMAT(date_posted, \"%M %D, %Y\") " .
       		"as newdate, website from " . TBL_ARTCOM . " where state = 1 AND art_id = ". $currentid . 
       		" ORDER BY date_posted DESC;";
   		if ($result = mysqli_query($database->getConnection(), $comment_sql)) {
   			if (mysqli_num_rows($result) == 0) {
   				echo "There are no comments on this article.<br/>"; 
   			} else {
       			$current_row = 0;
       			while ($comment_row = mysqli_fetch_assoc($result)) {
           			if (($current_row++ % 2) == 0) {
	      	     		echo "<div class='even'>";
    	 	      	} else {
        		   		echo "<div class='odd'>";
          	 		}
          	 		if ($comment_row['website'] != "") {
          		  		echo "<span class='header'>Posted by <a href='http://" . $comment_row['website']
          		  			. "'>" . $comment_row['posted_by'] . "</a>";
          	 		} else {
          	 			echo "<span class='header'>Posted by <b>". $comment_row['posted_by'] . "</b>";
          	 		}
 		    		
					// display edit and delete links 		    		
            		if ($session->isAdmin()) {
        				echo "<small> | <a class='deleteComment' id='"
        					. $comment_row['id'] . "' href=''"
							. ">Delete</a></small>";					
        			}	
        		
         	   		echo "</span>";
            		echo "<p>" . htmlspecialchars_decode($comment_row['comment']) . "</p>";
            		echo "<span class='footer'>Posted on " . $comment_row['newdate']. "</span>";
            		echo "</div>";
        		}
   			}
        	
        	// free result set
    		mysqli_free_result($result);
    	}     	
?>

<br/>
<a href="#top">Back to Top</a>

<a id="submitcomment" name="submitcomment" title="submitcomment"></a>

<h3 class="sub">Submit a new comment</h3>  

<form id="commentForm" action="<?php echo SITE_BASEDIR . "/pages/articles/_comment.submit.php" ?>" method="post">
	<fieldset style="width:650px; margin: 0px auto">
		
		<!-- ajax submit response -->
		<div id="response">
			All fields in <b>bold</b> are required.
		</div>
		
		<!-- name -->
		<div>
			<label class="required" accesskey="N" for="name">Name:</label>
       		<input type="text" name="name" maxlength="50" id="name" class="txt"
<?php
		if ($session->logged_in) {
			echo "value='" . $session->userinfo['firstname'] . " "
				. $session->userinfo['lastname'] . "'";
		} 
?>       		
       		>
       	</div>
       	
       	<!-- email -->
		<div>
			<label accesskey="w" for="website">Website:</label>
			<input type="text" name="website" maxlength="50" id="website" 
			 style="width:250px" class="txt"
<?php
		if ($session->logged_in) {
			echo "value='" . $session->userinfo['website'] . "'";
		} 
?> 			
			>
		</div>
		
		<!-- comment -->
		<div>
			<label class="required" accesskey="C" for="comment">Comment:</label>
			<span id="fckeditor">
<?php

$oFCKeditor = new FCKeditor('commentText') ;
$oFCKeditor->BasePath = SITE_BASEDIR . '/include/fckeditor/' ;
$oFCKeditor->Height = '200';
$oFCKeditor->Width = '500';
$oFCKeditor->EditorAreaCSS = SITE_BASEDIR . '/stylesheets/article.css' ;
$oFCKeditor->ToolbarSet = 'Basic';
$oFCKeditor->Config['LinkBrowser'] = 'false';
$oFCKeditor->Config['LinkUpload'] = 'false';
$oFCKeditor->Create();

?>			
			</span>	

		</div>
			
		<!-- catchpa -->
		<div>
			<label for="kludge"><!-- empty --></label>
			<img class="txt" id="catchpa" 
				src="<?php echo SITE_PREFIX . "/include/securimage/securimage_show.php" ?>" alt="CAPTCHA Image" />
			<a href="" id="reload" class="txt">Reload Image</a>				
		</div>
		<div>
			<label class="required" accesskey="p" for="captchpaText">Catchpa:</label>					    
			<input class="txt" type="text" maxlength="4" name="catchpa_text" 
				id="catchpaText" style="width:50px">			
		</div>
						
		<!-- buttons and ajax processing -->
		<div>		
			<label for="kludge"><!-- empty --></label>
			<input type="submit" value="Submit Comment" id="submit" class="btn"/>
			&nbsp;
			<span id="waiting" style="visibility: hidden">			
				<img align="absmiddle" src="<?php echo SITE_PREFIX; ?>/images/spinner.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
		</div>
		
		<div>
			<!-- id of the article -->
			<input type="hidden" name="article_id" id="articleId" 
				value="<?php echo $currentid; ?>"/>
			<!-- title of the article -->
			<input type="hidden" name="article_title" id="articleTitle" 
				value="<?php echo $atitle_unformatted; ?>"/>				
		</div>

	</fieldset>
</form>

</div>

<?php
				
		}     
		
		echo "</div>\n";
    }
    
include_once("footer.inc");

?>
