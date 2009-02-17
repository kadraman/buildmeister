<?php

// TODO: get title of article and add to HTML header

include_once("common.inc");
include_once("fckeditor/fckeditor.php");
include_once("header.php");

// do we have an article id?
if (!isset($_GET['id'])) {
    $session->displayDialog("No Article Specified",
    	"No article has been specified, please select an article on the "
        . "<b>articles</b> page to see its content.",
        SITE_BASEDIR . "/pages/articles/");
// does the article exist?	        
} else if (!$database->articleExists($_GET['id'])) {
	$session->displayDialog("Article Does Not Exist",
    	"The specified article does not exist, please select an article on the "
    	. "<b>articles</b> page to see its content.",
        SITE_BASEDIR . "/pages/articles/");		        	        
} else {
    // retrieve the id of the article to display
    $currentid = clean_data($_GET['id']);
	    
    // update view count
    if (!$session->isAdmin()) {
    	$database->updateArticleViews($currentid);
    }
	    
    // fetch article content
    echo "<div id='article'>\n";       
        
    $sql = "SELECT id, title, posted_by, DATE_FORMAT(date_posted, \"%M %D, %Y\")" .
   		" as newdate, content, state from " . TBL_ARTICLES . " where id = " . $currentid;
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	if ($numrows != 0){
    	while ($row = mysql_fetch_assoc($result)) {
    		// has the article been published?
    		if ($row['state'] != PUBLISHED_STATE && !$session->isAdmin()) {
    			echo "<h1 id='title'>" . $row['title'] . "</h1>\n";
    			echo "<p>This article has not yet been published.</p>";
    			// TODO: shouldn't allow users to comment on it yet? redirect
    		} else {
    			// TODO: display the fact that the article is unpublished.
	   			// display article
        		echo "<h1 id='title'>" . $row['title'] . "</h1>\n";
       			echo "<p><small>Posted by <a href='../../userinfo.php?user=" . $row['posted_by'] 
 	    			. "'>" . $row['posted_by'] . "</a> on " . $row['newdate'];
       		
       			if ($session->isAdmin()) {
       				echo " | <a href='edit.php?id=" . $row['id'] . "'>Edit</a>";
					echo " | <a href='delete.php?id=" . $row['id'] . "'"
						. "onclick=\"return confirm('Are you sure you want to delete this article?')\""
						. ">Delete</a>";
       			}

       			echo "</small></p>\n";
	       		echo "<p>";
				echo "Filed under:&nbsp;\n";

				// TODO: display number of comments and link to them
					
				// get categories for entry
				$cat_sql = "select a.cat_id, c.name from " . TBL_ARTICLE_CATEGORIES . " a, " .
					TBL_CATEGORIES . " c where a.article_id = " . $row['id'] . " AND a.cat_id = c.id;";
				$cat_result = mysql_query($cat_sql);
				$cat_numrows = mysql_num_rows($cat_result);
				if ($cat_numrows != 0) {
	    			while ($cat_row = mysql_fetch_assoc($cat_result)) {
						echo "<a class=\"labels\" href=\"../../viewcategory.php?catid=" . $cat_row['cat_id'] . "\">" . 
							$cat_row['name'] . "</a>&nbsp;\n";
					}
				} else {
					echo "Uncategorized\n";
				}
				
				echo "</p>";
        	      
				echo htmlspecialchars_decode($row['content']);  									
				
			}
    	}
	}
	    
    // TODO: rate article

    // comments
   	echo "<h3 class='sub'>Comments</h3>\n";

   	// fetch comments
   	$sql = "SELECT id, posted_by, comment, DATE_FORMAT(date_posted, \"%M %D, %Y\") " .
       	"as newdate from " . TBL_ARTCOM . " where state = 1 AND art_id = ". $currentid . 
       	" ORDER BY date_posted DESC;";
   	$result = mysql_query($sql);
   	$numrows = mysql_num_rows($result);

	if ($numrows != 0) {
       	$current_row = 0;
        while ($row = mysql_fetch_assoc($result)) {
           	if (($current_row++ % 2) == 0) {
           		echo "<div style='background-color:#EFEFDD;padding:5px;margin:10px'>";
           	} else {
           		echo "<div style='background-color:#CDCDBB;padding:5px;margin:10px'>";
           	}
            echo "<p><small>Posted by <b>" . $row['posted_by'] . "</b>"
 		    		. " on " . $row['newdate'];
            if ($session->isAdmin()) {
        		echo " | <a href='../../editcomment.php?aid=$currentid&cid=" . $row['id'] . "'>Edit</a>";
        		echo " | <a href='../../deletecomment.php?aid=$currentid&cid=" . $row['id'] . "'"
					. "onclick=\"return confirm('Are you sure you want to delete this comment?')\""
					. ">Delete</a>";					
        	}	
            echo "</small></p>";
            echo "<p>" . htmlspecialchars_decode($row['comment']) . "</p>";
            echo "</div>";
        }
    } else {
    	 echo "<p>There are no comments on this article.</p>";    
    }
?>

<a id="submitcomment" href=""></a>

<h3 class="sub">Submit a new comment</h3>  

<form id="commentForm" action="comment.submit.php" method="post">
	<fieldset style="width:650px; margin: 0px auto">
		<!-- TODO: auto fill if logged in -->
		
		<!-- ajax login response -->
		<div id="response">
			<p>All fields in <b>bold</b> fields are required.</p>
		</div>
		
		<!-- name -->
		<div>
			<label for="name" class="required" accesskey="N" for="name">Name:</label>
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
			<label class="required" accesskey="E" for="email">Email:</label>
			<input type="text" name="email" maxlength="50" id="email" class="txt"
<?php
	if ($session->logged_in) {
		echo "value='" . $session->userinfo['email'] . "'";
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
			<!-- textarea name="comment" id=commentText rows="6" style="width:500px"
				class="txt"/>Enter your comment here...</textarea-->
		</div>
			
		<!-- catchpa -->
		<div>
			<label for="kludge"><!-- empty --></label>
			<img class="txt" id="catchpa" 
				src="../../include/securimage/securimage_show.php" alt="CAPTCHA Image" />				
		</div>
		<div>
			<label class="required" accesskey="p" for="captchpaText">Catchpa:</label>					    
			<input class="txt" type="text" maxlength="4" name="catchpa_text" 
				id="catchpaText" style="width:50px">
		</div>
					
		<!-- ajax login response -->
		<div id="response">
			<!-- spanner -->
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
		</div>

	</fieldset>
</form>

</div>

<?php     
    }
    
include_once("footer.php");

?>
