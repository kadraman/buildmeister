<?php

# glossary page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 3;

include("include/header.php");
?> 

<div id="article">

<?php
// just submitted a new glossary item
if (isset($_SESSION['glosssuccess'])) {
    if ($_SESSION['glosssuccess']) {
        // submissions was successful
        $session->displayDialog("Submission Succesfull",
        	"Thank you for your submission, it will be reviewed before being added to the site.",
            SITE_NAME . "/glossary.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
            "We're sorry, but an error has occurred and your submission has failed. "
            ."Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['glosssuccess']);
} else {
?>

<div id="toptitle"><h2>Glossary</h2></div>

<div id="introductory">
<p>This page is intended to define a number of terms that are used in
or related to the build process. If you believe that a definition is
missing and should be included then please <a href="#submit">submit</a> 
it for inclusion using the form at the end of this page.</p>
</div>

<?php
# fetch glossary
$sql = "SELECT * from " . TBL_GLOSSARY . " where active = 1 ORDER BY title;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

$count = 0;
if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        if (($count++ % 2) == 0) {
            $usediv = "glossitem-even";
        } else {
            $usediv = "glossitem-odd";          
        }
        echo "<div id='" . $usediv . "'><strong><a id='#" . $row['title'] . "'>" 
        . $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "</div>";
    }
}   
?>

<a id="submit"></a>

<div id="dashed-spacer">&nbsp;</div>

<h3>Submit a new glossary item</h3>
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
<form name='glosssubmit' id='glosssubmit' action='process.php' method='post'>
<fieldset style="text-align:left;width:460px"><legend>Submit Glossary Item</legend>
<table>
	<tr>
		<td><label class="formLabelText" for="glossoktitle">Term:</label></td>
		<td><input class="formInputText" type="text" name="glosstitle" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("glosstitle"); ?>">*</td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="glosssummary">Definition:</label></td>
		<td>
			<textarea class="formTextArea" name='glosssummary' id='glosssummary' 
			<?php echo $disable_field; ?> rows='6' cols='50'/>
			</textarea>*
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>		
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="subgloss"	value="1"> 
			<input type="submit" value="Submit">
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
