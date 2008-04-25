<?php

# links page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 4;

include("include/header.php");
?>

<?php
// just submitted a new tip
if (isset($_SESSION['tipsuccess'])) {
    if ($_SESSION['tipsuccess']) {
        // submissions was sucessful
        $session->displayDialog("Submission Successful",
        	"Thank you for your submission, it will be reviewed before being added to the site.",
            SITE_BASEDIR . "/tips.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
            "We're sorry, but an error has occurred and your submission has failed. "
            ."Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['tipsuccess']);
} else {
?>

<div id="article">

<div id="toptitle"><h2>Build Tool Tips</h2></div>

<div id="introductory">
<p>This page contains a list of tips for a variety of build tools. Please note, that
this is a collection of tips from members of this web site, we do not guarantee their
correctness or operation. </p>
<p>If you have your own tip then please <a href="#submit">submit</a> it for inclusion using
 the form at the end of this page.</p>
</div>

<?php
// fetch category and display it
function displayCategory($title, $cat_id) {

    echo "<div id='boxedtitle'>$title</div>\n";
    $sql = "SELECT * from " . TBL_TIPS . " where cat_id = "
        . $cat_id . " AND active = 1 ORDER BY date_posted DESC;";
    $result = mysql_query($sql);
    $numrows = mysql_num_rows($result);

    if ($numrows != 0) {
        while ($row = mysql_fetch_assoc($result)) {
            echo "<div id='splitlist'><strong><a href='viewtip.php?id=" . $row['id'] . "'>"
    		    . $row['title'] . "</a></strong><br/>"
		    . $row['summary'] . "</div>\n";
		    echo "<div id='spacer'>&nbsp;</div>\n";
        }
    } else {
        echo "<div id='splitlist'>There are currently no tips in this category.</div>\n";
        echo "<div id='spacer'>&nbsp;</div>\n";
    }
} // displayCategory

displayCategory("Apache Ant", 1);
displayCategory("Microsoft MSBuild", 2);
displayCategory("GNU Make", 3);
displayCategory("Miscellaneous", 9)
?>

<a id="submit"></a>
<div id="dashed-spacer">&nbsp;</div>

<h3>Submit a new tip</h3>
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
<form name='tipsubmit' id='tipsubmit' action='include/process.php' method='post'>
<fieldset style="text-align:left;width:600px"><legend>Submit Tip</legend>
<table>
	<tr>
		<td>*<label class="formLabelText" for="tiptitle">Title:</label></td>
		<td><input class="formInputText" type="text" name="tiptitle" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("tiptitle"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="tipsummary">Summary:</label></td>
		<td><input class="formInputText" type="text" name="tipsummary" <?php echo $disable_field; ?>
			maxlength="120" value="<?php echo $form->value("tipsummary"); ?>"></td>
	</tr>

	<tr>
		<td>*<label class="formLabelText" for="tipcontent">Content:</label></td>
		<td>
			<textarea class="formTextArea" name='tipcontent' id='tipcontent' onfocus="this.value=''; this.onfocus=null;"
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
			<input type="hidden" name="subtip"	value="1">
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
