<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include("include/header.php");

?>

<?php
// just submitted a new article
if (isset($_SESSION['articlesuccess'])) {
    if ($_SESSION['articlesuccess']) {
        // submission was sucessful
        $session->displayDialog("Submission Succesfull",
        	"Thank you for your submission, it will be reviewed before being added to the site.",
            SITE_BASEDIR . "/articles.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
            "We're sorry, but an error has occurred and your submission has failed. "
            ."Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['articlesuccess']);
} else {
?>

<div id="article">

<div id="toptitle"><h2>Articles</h2></div>

<div id="introductory">
<p>This page lists all of the categorized articles that are contained on this site. 
If you have an idea for an article or have written some content yourself, then please 
<a href="contact.php">contact us</a> for more information or <a href="#submit">submit</a> 
your content using the form at the bottom of this page.</p>
</div>

<div id="boxedtitle">Build Process</div>

<?php
// fetch build process articles
$sql = "SELECT * from " . TBL_ARTICLES . " where cat_id = 1 AND active = 1 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
    		. $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "</div>";
    }
}    
?>

<div id="spacer">&nbsp;</div>
<div id="boxedtitle">Build Tools</div>

<?php
// fetch build tools articles
$sql = "SELECT * from " . TBL_ARTICLES . " where cat_id = 2 AND active = 1 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
    		. $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "</div>";
    }
}

?>

<div id="spacer">&nbsp;</div>
<div id="boxedtitle">Supporting Core Skills</div>

<?php
// fetch miscellaneous articles
$sql = "SELECT * from " . TBL_ARTICLES . " where cat_id = 3 AND active = 1 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>"
    		. $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "</div>";
    }
}
?>

<a id="submit"></a>	    

<div id="dashed-spacer">&nbsp;</div>

<h3>Submit a new article</h3>
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
<form name='articlesubmit' id='articlesubmit' action='include/process.php' method='post'>
<fieldset style="text-align:left;width:600px"><legend>Submit Article</legend>
<table>
	<tr>
		<td>*<label class="formLabelText" for="articletitle">Title:</label></td>
		<td><input class="formInputText" type="text" name="articletitle" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("articletitle"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="articlesummary">Summary:</label></td>
		<td><input class="formInputText" type="text" name="articlesummary" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("articlesummary"); ?>"></td>
	</tr>

	<tr>
		<td>*<label class="formLabelText" for="articlecontent">Content:</label></td>
		<td>
			<textarea class="formTextArea" name='articlecontent' id='articlecontent' onfocus="this.value=''; this.onfocus=null;"
			<?php echo $disable_field; ?> rows='10' cols='70'/>Enter your content here...
			</textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>		
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="subarticle"	value="1"> 
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
include("include/footer.php");
?>
