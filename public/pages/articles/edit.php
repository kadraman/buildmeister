<?php

include_once("common.inc");
include_once("header.inc");
include_once("fckeditor/fckeditor.php") ;

if (!isset($_GET['id'])) {
	// do we have an article id?
	$session->displayDialog("No Article Specified",
	 	"No article has been specified, please select an article on the "
	   	. "<b>articles</b> page to edit its content.",
	   	SITE_BASEDIR . "/pages/articles");        
} else if (!$database->articleExists($database->clean_data($_GET['id']))) {
	// does the article exist?
	$session->displayDialog("Article Does Not Exist",
	   	"The specified article does not exist, please select an article on the "
	   	. "<b>articles</b> page to see its content.",
	    SITE_BASEDIR . "/pages/articles");		   	
} else {
	// do we have permission to edit articles?	   	
	if (!$session->isAdmin()) {
		$session->displayDialog("Insufficient Permission",
    		"Sorry you do not have permission to edit articles.",
    		SITE_BASEDIR . "/pages/articles");
	} else {
				
		// retrieve the id of the article to display
		$currentid = $database->clean_data($_GET['id']);
	
		// fetch article data
		$sql = "SELECT id, title, summary, state, DATE_FORMAT(date_posted, \"%d-%m-%Y\")"
    		. " as newdate, posted_by, content from " . TBL_ARTICLES 
    		. " where id = " . $currentid;
    	
    	if ($result = mysqli_query($database->getConnection(), $sql)) {
			$row = mysqli_fetch_assoc($result);
       		$article_title = $row['title'];
       		$atitle = str_replace(" ", "_", $article_title);
       		$article_summary = $row['summary'];
       		$article_date  = $row['newdate'];
       		$article_state  = $row['state'];
       		$article_author = $row['posted_by'];
       		$article_text  = htmlspecialchars_decode($row['content']);
        
			// get the current categories for the entry
			$cat_sql = "select a.cat_id, c.name from " . TBL_ARTICLE_CATEGORIES . " a, "
				. TBL_CATEGORIES . " c where a.article_id = " . $row['id'] 
				. " AND a.cat_id = c.id;";	
			if ($cat_result = mysqli_query($database->getConnection(), $cat_sql)) {
				if (mysqli_num_rows($cat_result) == 0) {
					// empty array
					$selected[] = "";
				} else {
					while ($cat_row = mysqli_fetch_assoc($cat_result)) {
    					// add name to selected array
						$selected[] = $cat_row['name'];
					}
				} 
			}
			// free result set
    		mysqli_free_result($cat_result);
    		
			// get all the categories and select the appropriate ones
			$cat_all_sql = "SELECT * from " . TBL_CATEGORIES . ";";
			if ($cat_all_result = mysqli_query($database->getConnection(), $cat_all_sql)) {
				$article_categories_html = "";				
				while ($cat_all_row = mysqli_fetch_assoc($cat_all_result)) {
			       	if (in_array($cat_all_row['name'], $selected)) {
            	        $article_categories_html = $article_categories_html 
		        	        . "<option value='" . $cat_all_row['id'] . "' selected>"
		            	    . $cat_all_row['name'] . "</option> ";
                	} else {
		            	$article_categories_html = $article_categories_html
		               		. "<option value='" . $cat_all_row['id'] . "'>" 
		         	       	. $cat_all_row['name'] . "</option> ";
		        	}
		    	}
        	} 
        	// free result set
    		mysqli_free_result($cat_all_result);
    			
    		// get all the states and select the appropriate one
			$states_all_sql = "SELECT * from " . TBL_STATES . ";";
			if ($states_all_result = mysqli_query($database->getConnection(), $states_all_sql)) {
        		$article_states_html = "";
        		while ($states_all_row = mysqli_fetch_assoc($states_all_result)) {
       	        	if ($states_all_row['id'] == $article_state) {
           	        	$article_states_html = $article_states_html 
	        	        	. "<option value='" . $states_all_row['id'] . "' selected>" 
	            	    	. $states_all_row['name'] . "</option> ";
               		} else {
	            		$article_states_html = $article_states_html 
	                		. "<option value='" . $states_all_row['id'] . "'>"
	         	       		. $states_all_row['name'] . "</option> ";
	        		}
	    		}
			}
			// free result set
    		mysqli_free_result($states_all_result);
    		        		
    		// get all the users with admin permission and select the appropriate one
			$users_authors_sql = "SELECT username, userlevel from " . TBL_USERS 
				. " WHERE userlevel >= " . EDITOR_LEVEL . ";";
			if ($users_authors_result = mysqli_query($database->getConnection(), $users_authors_sql)) {
        		$article_authors_html = "";
        		while ($users_authors_row = mysqli_fetch_assoc($users_authors_result)) {
    	           	if ($users_authors_row['username'] == $article_author) {
            	       	$article_authors_html = $article_authors_html  
		                	. "<option value='" . $users_authors_row['username'] . "' selected>" 
		           	    	. $users_authors_row['username'] . "</option> ";
                	} else {
		           		$article_authors_html = $article_authors_html  
		               		. "<option value='" . $users_authors_row['username'] . "'>"
		               		. $users_authors_row['username'] . "</option> ";
		        	}
		    	}        		
			}
			// free result set
    		mysqli_free_result($users_authors_result);
		}
		
		// free result set
    	mysqli_free_result($result);
?>

<div class="article">

<a id="top" name="top"></a>
<a href="#bottom">Go to bottom</a>
<br/><br/>

<form id="editForm" action="<?php echo SITE_BASEDIR . "/pages/articles/edit.submit.php" ?>" method="post">
	<fieldset style="width:700px; margin: 0px auto">
	
		<!-- ajax submit response -->
		<div id="response">
			<p>All fields in <b>bold</b> fields are required.</p>
		</div>
		
		<!-- article title -->
		<div>
			<label class="required" for="title">Title:</label>
			<input type="text" name="title" id="title" class="txt"
				style="width:400px" size="40"
				maxlength="80" value="<?php echo $article_title?>">
		</div>
		
		<!-- article summary -->
		<div>
			<label class="required" for="summary">Summary:</label>
			<textarea type="text" name="summary" id="summary" class="txt"
				style="width:400px" size="40"
				rows="5" cols="80"><?php echo $article_summary?></textarea>
		</div>
	
		<!-- article category -->
		<div>
			<label for="category">Category:</label>	
			<select multiple name="category[]" id="category" size="6" class="txt">
				<?php echo $article_categories_html?>
			</select>
		</div>
	
		<!-- date posted -->
		<div>
			<label class="required" for="dateposted">Date Posted:</label>			
			<input type="text" id="dateposted" name="dateposted" class="txt"
				value="<?php echo $article_date?>">
			<a href="javascript:NewCal('dateposted','ddmmyyyy')">
				<img src="<?php echo SITE_PREFIX; ?>/images/cal.gif" width="16" 
					height="16" border="0"	alt="Pick a date">
			</a>	
		</div>
		
		<!-- article state -->
		<div>
			<label class="required" for="state">State:</label>
			<select name="state" id="state" class="txt">
				<?php echo $article_states_html?>
			</select>
		</div>
		
		<div>
			<label class="required" for="author">Author:</label>	
			<select name="author" id="author" class="txt">
				<?php echo $article_authors_html?>
			</select>
		</div>
	
		<!-- article content -->
		<div>
<?php

$oFCKeditor = new FCKeditor('contentText') ;
$oFCKeditor->BasePath = SITE_BASEDIR . '/include/fckeditor/' ;
$oFCKeditor->Height = '800';
$oFCKeditor->Width = '700';
$oFCKeditor->EditorAreaCSS = SITE_BASEDIR . '/stylesheets/article.css' ;
$oFCKeditor->ToolbarComboPreviewCSS = SITE_BASEDIR . '/stylesheets/article.css' ;
//$oFCKeditor->Config['SkinPath'] = SITE_BASEDIR . '/include/fckeditor/skins/silver/';
$oFCKeditor->Value = $article_text;
$oFCKeditor->Create() ;

?>	
		</div>
			
		<!-- buttons and ajax processing -->
		<div>		
			<input type="submit" value="Save" id="submit" class="btn"/>
			&nbsp;
			<span id="waiting" style="visibility:hidden">			
				<img align="absmiddle" src="<?php echo SITE_PREFIX; ?>/images/spinner.gif"/>
				&nbsp;<strong>Processing...<strong>
			</span>	
			<input type="submit" value="Cancel" id="cancel" onclick="history.back()" 
				class="btn"/>
		</div>
		
		<div>
			<!-- id of the article -->
			<input type="hidden" name="article_id" id="articleId" 
				value="<?php echo $currentid; ?>"/>
			<!-- title of the article -->
			<input type="hidden" name="article_title" id="articleTitle" 
				value="<?php echo $atitle; ?>"/>			
		</div>
	
	</fieldset>	
</form>

<br/>
<a href="#top">Back to top</a>
<a id="bottom" name="bottom"></a>

</div>

<?php
    	}
	}

	include_once("footer.inc");
?>
