<?php

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

include("include/header.php");

// just submitted a new tip comment
if (isset($_SESSION['tipcomsuccess'])) {
    if ($_SESSION['tipcomsuccess']) {
        // comment was successful
        $session->displayDialog("Submission Successful",
    		"Thank you for your comments, they will be reviewed before being added to the site.",
            SITE_BASEDIR . "/tips.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
        	"We're sorry, but an error has occurred and your submission has failed. "
            . "Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['tipcomsuccess']);
} else {
    // just displaying a tip
    if (!isset($_GET['id'])) {
	    $session->displayDialog("No Tip",
	    	"No tip has been specified, please select a tip on the "
	        . "<a href='tips.php'>tips</a> page to see its content.",
	        $session->referrer);
    } else {
        // retrieve the id of the tip to display
	    $currentid = $_GET['id'];

	    // update view count
	    //$database->updateTipViews($currentid);

        # fetch tip
	    $sql = "SELECT * from " . TBL_TIPS . " where id = '". $currentid . "';";
	    $result = mysql_query($sql);
	    $numrows = mysql_num_rows($result);

	    if ($numrows != 0) {
	        while ($row = mysql_fetch_assoc($result)) {
	            echo "<div id='boxedtitle'>" . $row['title'] . "</div><br/>"
	                . "<i>Posted by <b>" . $row['posted_by'] . "</b> on " . $row['date_posted'] . "</i><br/><br/>"
	  		        . "<p>" . stripslashes($row['content']) . "</p>\n";
	        }
	    echo "</tr></table>\n";
	    echo "</div>\n";
    }

        # rate article

        # comment on article

        echo "<div id='dashed-spacer'>&nbsp;</div>\n";
        echo "<h3>Comments</h3>\n";

        # fetch glossary item
        $sql = "SELECT * from " . TBL_TIPCOM . " where active = 1 AND tip_id = ". $currentid . ";";
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
<form name='artcomsubmit' id='tipcomsubmit' action='include/process.php' method='post'>
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
			<input type="hidden" name="subtipcom" value="1">
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
