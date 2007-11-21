<?php

# books page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 2;

include("include/header.php");

?>

<div id="article">

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
$sql = "SELECT * from books where active = 1 ORDER BY date_published DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitsection'><strong><a href='" . $row['url'] . "'>" . $row['title'] . "</a></strong><br/>by <i>"
        . $row['author'] . "</i><br/><br/>"
		. $row['summary'] . "</div>";
    }
}   
?>

<a id="submit"></a>

<?php
// just submitted a new book
if (isset($_SESSION['booksuccess'])) {
    if ($_SESSION['booksuccess']) {
        // registration was successful
        echo "<p>Thank you for your submission, it will be reviewed before being added to the site.</p>";
    } else {
        // Registration failed
        echo "<p>We're sorry, but an error has occurred and your submission has failed.<br>Please try again at a later time.</p>";
    }
    unset($_SESSION['booksuccess']);
} else {
?>

<div align="center">
<form name='booksubmit' id='booksubmit' action='process.php' method='post'>
<fieldset style="text-align:left;width:450px"><legend>Submit Book</legend>
<table>

<?php
    // has the user logged in
    if (!$session->logged_in) {
        echo "<tr><td>&nbsp;</td>";
        echo "<td><p>Note: new submissions can only be made by registered users. "
        . "Please <a href='login.php'>login</a> first.</p></td></tr>";
        $disable_field = "disabled";
    } else {
        $disable_field = "";
    }
?>    
	<tr>
		<td><label class="formLabelText" for="booktitle">Title:</label></td>
		<td><input class="formInputText" type="text" name="booktitle" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("booktitle"); ?>"></td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="bookauthor">Author:</label></td>
		<td><input class="formInputText" type="text" name="bookauthor" <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("bookauthor"); ?>"></td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="bookurl">URL:</label></td>
		<td><input class="formInputText" type='text' name='bookurl' <?php echo $disable_field; ?>
			maxlength="80" value="<?php echo $form->value("bookurl"); ?>"></td>
	</tr>
	<tr>
		<td><label class="formLabelText" for="disclaimer">Summary:</label></td>
		<td>
			<textarea class="formTextArea" name='booksummary' id='booksummary' 
			<?php echo $disable_field; ?> rows='4' cols='50'/>
			</textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $form->allErrors(); ?></td>
	</tr>		
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="subbook"	value="1"> 
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

<script type="text/javascript" src="http://www.assoc-amazon.com/s/link-enhancer?tag=thebuildmeist-20&o=1">
</script>
<noscript>
    <img src="http://www.assoc-amazon.com/s/noscript?tag=thebuildmeist-20" alt="" />
</noscript>


<?php
include("include/footer.php");
?>