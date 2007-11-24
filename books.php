<?php

# books page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 2;

include("include/header.php");

?>

<?php
//<script type="text/javascript" src="http://www.assoc-amazon.com/s/link-enhancer?tag=thebuildmeist-20&o=1">
//</script>
//<noscript>
    //<img src="http://www.assoc-amazon.com/s/noscript?tag=thebuildmeist-20" alt="" />
//</noscript>
?>

<div id="article">

<?php
// just submitted a new book
if (isset($_SESSION['booksuccess'])) {
    if ($_SESSION['booksuccess']) {
        // submissions was successful
        $session->displayDialog("Submission Succesfull",
        	"Thank you for your submission, it will be reviewed before being added to the site.",
            SITE_BASEDIR . "/books.php");
    } else {
        // submission failed
        $session->displayDialog("Submission Failed",
            "We're sorry, but an error has occurred and your submission has failed. "
            ."Please try again at a later time.",
            $session->referrer);
    }
    unset($_SESSION['booksuccess']);
} else {
?>

<div id="toptitle"><h2>Recommended Books</h2></div>

<div id="introductory">
<p>This page contains a list of recommended books that discuss the build
process and the tools that can be used to implement it. Please note, that 
this is simply a list of books that members of this web site have 
read and enjoyed, together with some personal comments about them. </p>
<p>If you believe that there is a book that has been missed and should
 be included then please <a href="#submit">submit</a> it for inclusion using
 the form at the end of this page.</p>
</div>

<?php
# fetch build process books
$sql = "SELECT * from " . TBL_BOOKS . " where active = 1 ORDER BY date_published DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitsection'>\n";
        echo "<table width='100%' border=0'><tr>\n";
        echo "<td align='center' width='150px'><img src='"
        . $row['image_url'] . "' alt='[book image]'></td>\n";
        echo "<td><strong><a href='" . $row['url'] . "'>" . $row['title'] . "</a></strong><br/>by <i>"
        . $row['author'] . "</i><br/><br/>"
		. $row['summary'] . "</td>\n";
		echo "</tr></table>"; 
		echo "</div>";
    }
}   
?>

<a id="submit"></a>

<h3>Submit a new book</h3>
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
<form name='booksubmit' id='booksubmit' action='include/process.php' method='post'>
<fieldset style="text-align:left;width:500px">
<legend>Submit Book</legend>
<table>
	<tr>
		<td>*<label class="formLabelText" for="booktitle">Book Title:</label></td>
		<td><input class="formInputText" type="text" name="booktitle" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("booktitle"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="bookauthor">Book Author:</label></td>
		<td><input class="formInputText" type="text" name="bookauthor" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("bookauthor"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="bookurl">Amazon URL:</label></td>
		<td><input class="formInputText" type='text' name='bookurl' <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("bookurl"); ?>"></td>
	</tr>
	<tr>
		<td>*<label class="formLabelText" for="booksummary">Summary of book:</label></td>
		<td>
			<textarea class="formTextArea" name='booksummary' id='booksummary' onfocus="this.value=''; this.onfocus=null;"
			<?php echo $disable_field; ?> rows='6' cols='50'/>Enter your summary here
			</textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>		
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="subbook" value="1"> 
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