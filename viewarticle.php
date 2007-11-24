<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include("include/header.php");

// just submitted a new article comment
if (isset($_SESSION['artcomsuccess'])) {
    if ($_SESSION['artcomsuccess']) {
        // comment was successful
        $session->displayDialog("Submission Succesfull",
    		"Thank you for your comments, they will be reviewed before being added to the site.",
            SITE_BASEDIR . "/articles.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
        	"We're sorry, but an error has occurred and your submission has failed. "
            . "Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['artcomsuccess']);
} else {
    // just displaying an article
    if (!isset($_GET['id'])) {
	    $session->displayDialog("No Article",
	    	"No article has been specified, please select an article on the "
	        . "<a href='articles.php'>articles</a> page to see its content.",
	        $session->referrer);
    } else {
        // retrieve the id of the article to display
	    $currentid = $_GET['id'];
	    
	    // update view count
	    $database->updateArticleViews($currentid);
    
        # fetch article content
        $placeholder = "%image_dir%";
        $actual_dir  = "articles/" . str_pad($currentid, 4, "0", STR_PAD_LEFT) . "/images";
        $actual_file = "articles/" . str_pad($currentid, 4, "0", STR_PAD_LEFT) . "/index.html";
        $fh = fopen($actual_file, 'r') or die('Could not open the file!');
        # replace images directory location
        $text = fread($fh, filesize($actual_file)) or die('Could not read that file');
        fclose($fh);
        $text = str_replace($placeholder, $actual_dir , $text);
        echo $text;

        # rate article

        # comment on article

        echo "<div id='dashed-spacer'>&nbsp;</div>\n";
        echo "<h3>Comments</h3>\n";

        # fetch glossary item
        $sql = "SELECT * from " . TBL_ARTCOM . " where active = 1 AND art_id = ". $currentid . ";";
        $result = mysql_query($sql);
        $numrows = mysql_num_rows($result);

        if ($numrows != 0) {
            while ($row = mysql_fetch_assoc($result)) {
                echo "<div id='comment'>Posted by <b>" . $row['posted_by']
                    . "</b><br/>" . $row['comment'] . "</div>";
            }
        }        
?>

<a id="submit"></a>

<div id="dashed-spacer">&nbsp;</div>

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
<fieldset style="text-align:left;width:460px"><legend>Submit Comment</legend>
<table>
	<tr>
		<td>*<label class="formLabelText" for="comment">Comment:</label></td>
		<td>
			<textarea class="formTextArea" name='comment' onfocus="this.value=''; this.onfocus=null;"
			<?php echo $disable_field; ?> rows='6' cols='50'/>Enter your comment here...
			</textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>		
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="artid" value="<?php echo $currentid; ?>"/>
			<input type="hidden" name="subartcom" value="1"> 
			<input type="submit" value="Submit" <?php echo $disable_field; ?>>
		</td>
	</tr>
</table>
</fieldset>
</form>
</div>

<?php     
    }
}
    
include("include/footer.php");

?>
