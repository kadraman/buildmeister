<?php
/**
 * admin.php
 *
 * User administration console.
 *
 * @author Kevin A. Lee <kevin.lee@buildmeister.com>
 * Based on code originally written by: Jpmaster77. 
 */

include("include/header.php");
    
// Displays the banned users table as html
function displayBannedUsers(){
   global $database;
   $q = "SELECT username,timestamp "
       . "FROM " . TBL_BANNED_USERS . " ORDER BY username";
   $result = $database->query($q);
   // error occurred, return given name by default
   $num_rows = mysql_numrows($result);
   if (!$result || ($num_rows < 0)) {
      echo "<p>Error displaying info.</p>";
      return;
   }
   if ($num_rows == 0) {
      echo "<p>Database table empty.</p>";
      return;
   }
   
   // display table contents
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Time Banned</b></td></tr>\n";
   for ($i=0; $i<$num_rows; $i++) {
      $uname = mysql_result($result,$i,"username");
      $time  = mysql_result($result,$i,"timestamp");
      echo "<tr><td>$uname</td><td>$time</td></tr>\n";
   }
   echo "</table><br>\n";
}
   
// check if user is an administrator
if (!$session->isAdmin()){
    echo "<p>Sorry, this page is only available for use by administrators.</p>";
} else {
?>

<?php
if($form->num_errors > 0) {
   echo "<p id=\"error\">Error with request, please fix</p><br><br>";
}
?>

<h3>Users Table Contents:</h3>
<?php
   global $database;
   $q = "SELECT username,userlevel,email,timestamp "
       . "FROM " . TBL_USERS . " ORDER BY userlevel DESC username";
       echo "<p>$q</p>";
   $result = $database->query($q);
   // error occurred, return given name by default
   $num_rows = mysql_numrows($result);
   if (!$result || ($num_rows < 0)) {
      echo "<p>Error displaying info.</p>";
      return;
   }
   if ($num_rows == 0) {
      echo "<p>Database table empty.</p>";
      return;
   }
     
   // display table contents
   echo "users<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Level</b></td><td><b>Email</b></td><td><b>Last Active</b></td></tr>\n";
   for ($i=0; $i<$num_rows; $i++) {
      $uname  = mysql_result($result,$i,"username");
      $ulevel = mysql_result($result,$i,"userlevel");
      $email  = mysql_result($result,$i,"email");
      $time   = mysql_result($result,$i,"timestamp");
      echo "<tr><td>$uname</td><td>$ulevel</td><td>$email</td><td>$time</td></tr>\n";
   }
   echo "</table><br>\n";
}
?>

<h3>Update User Level</h3>
<?php echo $form->error("upduser"); ?>
<table>
<form action="include/adminprocess.php" method="POST">
<tr><td>
Username:<br>
<input type="text" name="upduser" maxlength="30" value="<?php echo $form->value("upduser"); ?>">
</td>
<td>
Level:<br>
<select name="updlevel">
<option value="1">1
<option value="9">9
</select>
</td>
<td>
<br>
<input type="hidden" name="subupdlevel" value="1">
<input type="submit" value="Update Level">
</td></tr>
</form>
</table>
</td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>

<h3>Delete User</h3>
<?php echo $form->error("deluser"); ?>
<form action="include/adminprocess.php" method="POST">
Username:<br>
<input type="text" name="deluser" maxlength="30" value="<?php echo $form->value("deluser"); ?>">
<input type="hidden" name="subdeluser" value="1">
<input type="submit" value="Delete User">
</form>
</td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>

<h3>Delete Inactive Users</h3>
This will delete all users (not administrators), who have not logged in to the site<br>
within a certain time period. You specify the days spent inactive.<br><br>
<table>
<form action="include/adminprocess.php" method="POST">
<tr><td>
Days:<br>
<select name="inactdays">
<option value="3">3
<option value="7">7
<option value="14">14
<option value="30">30
<option value="100">100
<option value="365">365
</select>
</td>
<td>
<br>
<input type="hidden" name="subdelinact" value="1">
<input type="submit" value="Delete All Inactive">
</td>
</form>
</table>
</td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>

<h3>Ban User</h3>
<?php echo $form->error("banuser"); ?>
<form action="include/adminprocess.php" method="POST">
Username:<br>
<input type="text" name="banuser" maxlength="30" value="<?php echo $form->value("banuser"); ?>">
<input type="hidden" name="subbanuser" value="1">
<input type="submit" value="Ban User">
</form>
</td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr><td>

<h3>Banned Users Table Contents:</h3>
<?php
displayBannedUsers();
?>
</td></tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>

<h3>Delete Banned User</h3>
<?php echo $form->error("delbanuser"); ?>
<form action="include/adminprocess.php" method="POST">
Username:<br>
<input type="text" name="delbanuser" maxlength="30" value="<?php echo $form->value("delbanuser"); ?>">
<input type="hidden" name="subdelbanned" value="1">
<input type="submit" value="Delete Banned User">
</form>
</td>
</tr>
</table>

<?php

include("include/footer.php"); 
?>

