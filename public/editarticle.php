<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include_once("include/header.php");
include_once("include/fckeditor/fckeditor.php") ;

// has an article been specified?
if (!isset($_GET['id'])) {
	// NO, return to articles page
	$session->displayDialog("No Article Specified",
	 	"No article has been specified, please select an article on the "
	   	. "<a href='articles.php'>articles</a> page to edit its content.",
	   	SITE_BASEDIR . "/articles.php");
} else {	   	
	// YES, do we have permission to edit articles?
	if (!$session->isAdmin()) {
		// NO
		$session->displayDialog("Insufficient Permission",
    		"Sorry you do not have permission to edit articles.",
    		SITE_BASEDIR . "/articles.php");
	} else {

		// have we just updated article
		if (isset($_SESSION['articlesuccess'])) {
    		if (!$_SESSION['articlesuccess']) {
	       	    // submission failed
        		echo "<div align='center'><p>Error updating article</p></div>";
    		}
    	   	unset($_SESSION['artcomsuccess']);
		}
				
		// retrieve the id of the article to display
		$currentid = clean_data($_GET['id']);
	
		// fetch article data
		$sql = "SELECT id, title, summary, state, DATE_FORMAT(date_posted, \"%d-%m-%Y\")" .
    		" as newdate, content from " . TBL_ARTICLES . " where id = " . $currentid;
		$result = mysql_query($sql);
		$numrows = mysql_num_rows($result);

		if ($numrows != 0) {
    		while ($row = mysql_fetch_assoc($result)) {

        		$article_title = $row['title'];
        		$article_summary = $row['summary'];
        		$article_date  = $row['newdate'];
        		$article_state  = $row['state'];
        		$article_text  = htmlspecialchars_decode($row['content']);
        
				# get categories for entry
				$cat_sql = "select a.cat_id, c.name from " . TBL_ARTICLE_CATEGORIES . " a, " .
					TBL_CATEGORIES . " c where a.article_id = " . $row['id'] . " AND a.cat_id = c.id;";	
				$cat_result = mysql_query($cat_sql);
				$cat_numrows = mysql_num_rows($cat_result);
				if ($cat_numrows != 0) {
    				while ($cat_row = mysql_fetch_assoc($cat_result)) {
						# add name to selected array
						$selected[] = $cat_row['name'];
					}
				} else {
					# empty array
					$selected[] = "";
				}
		
				# get all the categories and select the appropriate ones
				$cat_all_sql = "SELECT * from " . TBL_CATEGORIES . ";";
        		$result = mysql_query($cat_all_sql);
        		$numrows = mysql_num_rows($result);
        		$article_categories_html = "";
        
	        	if ($numrows != 0) {
    	        	while ($row = mysql_fetch_assoc($result)) {
        	        	if (in_array($row['name'], $selected)) {
            	        	$article_categories_html = $article_categories_html . 
		        	        	"<option value='" . $row['id'] . "' selected>" .
		            	    	$row['name'] . "</option> ";
                		} else {
		            		$article_categories_html = $article_categories_html . 
		                		"<option value='" . $row['id'] . "'>" .
		         	       		$row['name'] . "</option> ";
		        		}
		    		}
        		} else {
     	       		# no categories
        		}
        		
    			# get all the states and select the appropriate one
				$states_all_sql = "SELECT * from " . TBL_STATES . ";";
        		$result = mysql_query($states_all_sql);
        		$numrows = mysql_num_rows($result);
        		$article_states_html = "";
        
	        	if ($numrows != 0) {
    	        	while ($row = mysql_fetch_assoc($result)) {
        	        	if ($row['id'] == $article_state) {
            	        	$article_states_html = $article_states_html . 
		        	        	"<option value='" . $row['id'] . "' selected>" .
		            	    	$row['name'] . "</option> ";
                		} else {
		            		$article_states_html = $article_states_html . 
		                		"<option value='" . $row['id'] . "'>" .
		         	       		$row['name'] . "</option> ";
		        		}
		    		}
        		} else {
     	       		# no states
        		}
			}
		}
?>

<div align="center">
<form name="articleupdate" id="articleupdate" action="include/process.php" method="post">
<fieldset style="text-align:left;width:700px">
<legend>Update Article</legend>
<table>
	<tr>
		<td align="center" colspan="2">
			<p><?php echo $form->allErrors(); ?></p>
		</td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="articletitle">Title:</label></td>
		<td><input class="formInputText" style="width:400px"  type="text" name="articletitle"
			maxlength="80" value="<?php echo $article_title?>"></td>
   	</tr>
   	<tr>
		<td><label class="formLabelText" for="articlesummary">Summary:</label></td>
		<td>
			<textarea class="formTextArea" name="articlesummary" 
			rows="5" cols="80"><?php echo $article_summary?></textarea>
		</td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="articlecategory">Category:</label></td>	
		<td>
			<select class="formSelect" multiple name="articlecategory[]" size="6">
				<?php echo $article_categories_html?>
			</select>
		</td>
	</tr> 
	<tr>
		<td><label class="formLabelText" for="articledate">Date Posted:</label></td>
		<td>		
			<input class="formInputText" style="width:100px" id="articledate" name="articledate"
				type="text" value="<?php echo $article_date?>">
			<a href="javascript:NewCal('articledate','ddmmyyyy')">
				<img src="images/cal.gif" width="16" height="16" border="0" 
				alt="Pick a date">
			</a>	
		</td>
	</tr>
		<tr>
		<td><label class="formLabelText" for="articlestatus">State:</label></td>	
		<td>
			<select class="formSelect" style="width:100px" name="articlestatus">
				<?php echo $article_states_html?>
			</select>
		</td>
	</tr> 
	<tr>
		<td width="100%" colspan="2">
<?php

$oFCKeditor = new FCKeditor('articlecontent') ;
$oFCKeditor->BasePath = SITE_BASEDIR . '/include/fckeditor/' ;
$oFCKeditor->Height = '800';
$oFCKeditor->Width = '700';
$oFCKeditor->EditorAreaCSS = SITE_BASEDIR . '/stylesheets/article.css' ;
$oFCKeditor->ToolbarComboPreviewCSS = SITE_BASEDIR . '/stylesheets/article.css' ;
//$oFCKeditor->Config['SkinPath'] = SITE_BASEDIR . '/include/fckeditor/skins/silver/';
$oFCKeditor->Value = $article_text;
$oFCKeditor->Create() ;

?>	
		</td>
	</tr>
	<tr>
		<td>
			<input name="articleid"	value="<?php echo $currentid?>" type="hidden" />
			<input type="hidden" name="updateart" value="1">
		</td>		
	</tr>
	<tr>
		<td align="left">
			<input name="articleid"	value="<?php echo $currentid?>" type="hidden" />
			<input name="id"		value="<?php echo $currentid?>" type="hidden" />
			<input type="submit" value="Submit"/>
		</td>
		<td align="right">
			<input type="button" value="Cancel" onclick="history.back()">
		</td>
	</tr>
</table>	
</form>
</div>

<?php
    	}
	}
include("include/footer.php");
?>
