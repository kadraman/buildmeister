<?php

# links page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 4;

include("include/header.php");
?>

<div id="article">

<?php
// just submitted a new link
if (isset($_SESSION['linksuccess'])) {
    if ($_SESSION['linksuccess']) {
        // submissions was sucessful
        $session->displayDialog("Submission Succesfull",
        	"Thank you for your submission, it will be reviewed before being added to the site.",
            SITE_BASEDIR . "/links.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
            "We're sorry, but an error has occurred and your submission has failed. "
            ."Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['linksuccess']);
} else {
?>

<div id="toptitle"><h2>Recommended Links</h2></div>

<div id="introductory">
<p>This page contains a list of recommended links that discuss the build
process and the tools that can be used to implement it. Please note, that 
this is simply a collection of sites that members of this web site have 
recommended, together with some personal comments about them. </p>
<p>If you believe that there is a link that has been missed and should
 be included then please <a href="#submit">submit</a> it for inclusion using
 the form at the end of this page.</p>
</div>

<?php
# fetch build process books
$sql = "SELECT * from " . TBL_LINKS . " where active = 1 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitsection'><strong><a href='" . $row['url'] . "'>" . $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "</div>";
    }
}   
?>

<a id="submit"></a>

<h3>Submit a new link</h3>
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
<form name='linksubmit' id='linksubmit' action='include/process.php' method='post'>
<fieldset style="text-align:left;width:480px"><legend>Submit Link</legend>
<table>
	<tr>
		<td>*<label class="formLabelText" for="linktitle">Title:</label></td>
		<td><input class="formInputText" type="text" name="linktitle" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("linktitle"); ?>"></td>
	</tr>	
	<tr>
		<td>*<label class="formLabelText" for="linkurl">URL:</label></td>
		<td><input class="formInputText" type='text' name='linkurl' <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("linkurl"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="linksummary">Summary of link:</label></td>
		<td>
			<textarea class="formTextArea" name='linksummary' id='linksummary' onfocus="this.value=''; this.onfocus=null;"
			<?php echo $disable_field; ?> rows='6' cols='50'/>Enter your summary here...
			</textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>		
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="sublink" value="1"> 
			<input type="submit" value="Submit" <?php echo $disable_field; ?>>
		</td>
	</tr>
</table>
</fieldset>
</form>
</div>

<?php
    }
?>

</div>


<?php
include("include/footer.php");
?>
