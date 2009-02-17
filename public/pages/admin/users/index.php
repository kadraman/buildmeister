<?php
/**
 * users.php
 */

include_once("common.inc");
include_once("header.php");

?>

<div id="toptitle">
	<h2>User Administration</h2>
</div>

<?php

// check if user is an administrator
if (!$session->isAdmin()){
	echo "<p>Sorry, this page is only available for use by administrators.</p>";
} else {

?>

<div class="tableNav">
	<input id="firstButton" type="button" value="&nbsp;&lt;&lt;&nbsp;"/>
	&nbsp;
	<input id="prevButton" type="button" value="&nbsp;&lt;&nbsp;"/>
	&nbsp;
	<input id="nextButton" type="button" value="&nbsp;&gt;&nbsp;"/>
	&nbsp;
	<input id="lastButton" type="button" value="&nbsp;&gt;&gt;&nbsp;"/>
	&nbsp;
	<label id="searchLabel" for="searchString" class="formInputLabel">Filter:</label>
	<select class="formInputText" id="searchColumn" class="formInputText">
		<option id="1">username</option>
		<option id="2">email</option>
	</select>
	&nbsp; 
	<input id="searchString" class="formInputText" style="width:100px" type="text" 
		name="searchstring" maxlength="40" value=""/>
	&nbsp;
	<input id="filterButton" type="button" value="Filter"/>
	&nbsp;
	<input id="resetButton" type="button" value="Reset"/>
	&nbsp;
	<span id="waiting" style="visibility: hidden">			
		<img align="top" src="<?php echo SITE_PREFIX; ?>/images/waiter.gif"/>
		&nbsp;<strong>Processing...<strong>
	</span>	
</div>
<div id="results">
	<input type="hidden" id="curPage" value="1"/>
	<input type="hidden" id="maxPage" value="1"/>
	<input type="hidden" id="items"   value="1"/>
	<table class="admintable">
		<tr><td>&nbsp;</td></tr>
	</table>
</div>
<div class="tableSummary">
	<label id="numEntriesLabel" class="formInputLabel"></label>
	&nbsp;|&nbsp;
	<label id="rowsLabel" for="rowsString" class="formInputLabel">Showing </label>
	<input id="rowsString" class="formInputText" style="width:20px" type="text" 
		name="rowsString" maxlength="4" value="<?php echo PAGE_LIMIT; ?>"/>
	<label id="rowsLabel2" class="formInputLabel">per page</label>
	&nbsp;|&nbsp;
	<a id="allRows" href="">Show all</a>	
</div>
		
<?php 
}

include_once("footer.php");

?>

