<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("include/header.php");

// just submitted a new article comment
if (isset($_SESSION['comment_failure'])) {
    if ($_SESSION['comment_failure']) {
        // submission failed
        $session->displayDialog("Submission Failed",
        	"We're sorry, but an error has occurred and your submission has failed. "
            . "Please try again at a later time.",
            $session->referrer);
    }
   	unset($_SESSION['comment_failure']);
} else {
    // just displaying an article
    if (!isset($_GET['id'])) {
	    $session->displayDialog("No Article",
	    	"No article has been specified, please select an article on the "
	        . "<a href='articles.php'>articles</a> page to see its content.",
	        $session->referrer);
    } else {
        // retrieve the id of the article to display
	    $currentid = clean_data($_GET['id']);
	    
	    // update view count
	    $database->updateArticleViews($currentid);
    
        # fetch article content
        echo "<div id='article'>\n";       
        
    	$sql = "SELECT id, title, posted_by, DATE_FORMAT(date_posted, \"%M %D, %Y\")" .
    		" as newdate, content from " . TBL_ARTICLES . " where id = " . $currentid;
		$result = mysql_query($sql);
		$numrows = mysql_num_rows($result);

		if ($numrows != 0){
    		while ($row = mysql_fetch_assoc($result)) {
    			# display article
        		echo "<h1>" . $row['title'] . "</h1>\n";
        		echo "<p><small>Posted on " . $row['newdate'];
        		
        		/*
        		// get user who created/edited the post
        		$user_sql = "select id, username from " . TBL_USERS . " where id = " 
        			. $row['posted_by'];
        		$user_result = mysql_query($user_sql);
        		if (!$user_result) {
    				echo " by unknown";
        		} else {
					$user_row = mysql_fetch_row($user_result); 	
        			echo " by <a href='#'>" . $user_row['username'] . "</a>";
        		}
        		*/
        		
        		if ($session->isAdmin()) {
        			echo "| <a href='editarticle.php?id=" . $row['id'] . "'>Edit</a>";
					echo "| <a href=\"\" onclick=\"javascript:deletePost(" . $row['id'] . ");return false;\">Delete</a>";
        		}

        		echo "</small></p>\n";
        		echo "<p>";
				echo "Filed under:&nbsp;\n";

				// TODO: get number of comments
				
				# get categories for entry
				$cat_sql = "select a.cat_id, c.name from " . TBL_ARTICLE_CATEGORIES . " a, " .
					TBL_CATEGORIES . " c where a.article_id = " . $row['id'] . " AND a.cat_id = c.id;";
				$cat_result = mysql_query($cat_sql);
				$cat_numrows = mysql_num_rows($cat_result);
				if ($cat_numrows != 0) {
    				while ($cat_row = mysql_fetch_assoc($cat_result)) {
						echo "<a class=\"labels\" href=\"viewcategory.php?catid=" . $cat_row['cat_id'] . "\">" . 
						$cat_row['name'] . "</a>&nbsp;\n";
					}
				} else {
					echo "Uncategorized\n";
				}
				
				echo "</p>";
        	      
				echo htmlspecialchars_decode($row['content']);  									
				
			}
		}
	    
        # TODO: rate article

        # comment on article

        echo "<div id='dashed-spacer'>&nbsp;</div>\n";
        echo "<h3>Comments</h3>\n";

        # fetch comments
        $sql = "SELECT id, posted_by, comment, DATE_FORMAT(date_posted, \"%M %D, %Y\") " .
        	"as newdate from " . TBL_ARTCOM . " where state = 1 AND art_id = ". $currentid . ";";
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
                echo "<p><small>Posted by <b>" . $row['posted_by'] . "</b> on " .
                	$row['newdate'];
            	if ($session->isAdmin()) {
        			echo "| <a href='editcomment.php?id=" . $row['id'] . "'>Edit</a>";
					echo "| <a href=\"\" onclick=\"javascript:deleteComment(" . $row['id'] . ");return false;\">Delete</a>";
        		}	
                echo "</small></p>";
                echo "<p>" . htmlspecialchars_decode($row['comment']) . "</p>";
                echo "</div>";
            }
        }        
?>

<a id="submit"></a>

<div id="dashed-spacer">&nbsp;</div>
<a id='submitcomment' href=''></a>

<h3>Submit a new comment</h3>
<?php
    // has the user logged in
    if (!$session->logged_in) {
        echo "<tr>";
        echo "<td colspan=\"2\"><p>Please note that submissions can only be made by registered users. "
        . "Please <a href='register.php'>register</a> and/or <a href='login.php'>login</a> first.</p></td></tr>";        
        $disable_field = "disabled";
    } else {
        $disable_field = "";
    }
?>    

<div align="center">
<form name='artcomsubmit' id='artcomsubmit' action='include/process.php' method='post'>
<fieldset style="text-align:left;width:600px"><legend>Submit Comment</legend>
<table>
	<tr>	
		<td>
			<textarea class="formTextArea" name='comment' onfocus="this.value=''; this.onfocus=null;"
			<?php echo $disable_field; ?> rows='6' cols='80'/>Enter your comment here...
			</textarea>
		</td>
	</tr>
	<tr>
		<td>
			To prevent spamming please enter the combination of letters and/or numbers
			that are contained in the following image:
		</td>
	</tr>
	<tr>  
		<td>
		    <table>
		    	<tr>
		    		<td>
						<img id="captcha" src="include/securimage/securimage_show.php" alt="CAPTCHA Image" />
					</td>			
					<td style="padding-left: 5px; padding-right: 5px">
						<input class="formTextArea" type="text" name="captcha_code" 
						onfocus="this.value=''; this.onfocus=null;"
						<?php echo $disable_field; ?> size="10" maxlength="6" />
					</td>
					<td style="padding-left: 5px">
						<a href="#" onclick="document.getElementById('captcha').src = 'include/securimage/securimage_show.php?' + Math.random(); return false">Reload Image</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>		
	<tr>
		<td align="right">
			<input type="hidden" name="articleid" value="<?php echo $currentid; ?>"/>
			<input type="hidden" name="subartcom" value="1"> 
			<input type="submit" value="Submit" <?php echo $disable_field; ?>>
		</td>
	</tr>
</table>
</fieldset>
</form>
</div>

</div>

<?php     
    }
}
    
include("include/footer.php");

?>
