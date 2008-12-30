<?php

# glossary page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 3;

include("include/header.php");

?>

<div id="article">

<?php
// just submitted a new glossary item
if (isset($_SESSION['gcomsuccess'])) {
    if ($_SESSION['gcomsuccess']) {
        // comment was successful
        $session->displayDialog("Submission Succesfull",
    		"Thank you for your comments, they will be reviewed before being added to the site.",
            SITE_NAME . "/glossary.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
        	"We're sorry, but an error has occurred and your submission has failed. "
            . "Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['gcomsuccess']);
} else {
    // just displaying a term
    if (!isset($_GET['term'])) {
	    $session->displayDialog("No Glossary Item",
	    	"No glossary item has been specified, please select a term on the "
	        . "<a href='glossary.php'>glossary</a> page to see its definition.",
	        $session->referrer);
    } else {
        // retrieve the id of the article to display
	    $gitem = $_GET['term'];
    
?>

<div id="toptitle"><h2>Glossary</h2></div>

<div id="introductory">
<p>This page defines an individual term that is used in
or related to the build process. If you believe that the definition is
incorrect or would like to <a href="#submit">comment</a> 
on it then please use the form at the end of this page.</p>
</div>

<h3>Definition</h3>

<?php
// replace underlines for href navigation 
$term = str_replace('_', ' ', $gitem);
# fetch glossary item
$sql = "SELECT * from " . TBL_GLOSSARY . " where title = '". $term . "';";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

$glossid = 0;

if ($numrows != 0) {
    echo "<div align='center'>\n";
    echo "<table width='95%'><tr>";    
    while ($row = mysql_fetch_assoc($result)) {
        // replace href to point to glossary page
        $summary = str_replace("href=\"#", "href=\"glossary.php#", $row['summary']);
        echo "<td align='left'><strong><a id='#" . $row['title'] . "'>" 
            . $row['title'] . "</a></strong><br/>"
		    . stripslashes($summary) . "</td>\n";
		$glossid = $row['id'];
    }
    echo "</tr></table>\n";
    echo "</div>\n";
}   

# comment on glossary item
echo "<h3>Comments</h3>";

# fetch glossary item
$sql = "SELECT * from " . TBL_GLOSSCOM . " where active = 1 AND gloss_id = ". $glossid . ";";
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
<form name='gcomsubmit' id='gcomsubmit' action='include/process.php' method='post'>
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
			<input type="hidden" name="glossid" value="<?php echo $glossid; ?>"/>
			<input type="hidden" name="subgcom" value="1"> 
			<input type="submit" value="Submit">
		</td>
	</tr>
</table>
</fieldset>
</form>
</div>

<?php
    }
}    
?>

</div>

<?php

include("include/footer.php");

?>
