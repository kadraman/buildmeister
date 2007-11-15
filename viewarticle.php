<?php

#require("db.php");

# articles page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 1;

# retrieve the id of the article to display
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$currentid = $_GET['id'];
} else {
	$currentid = 0;
}

require("include/header.php");

# fetch article content
$placeholder = "%image_dir%";
$actual_dir  = "articles/" . str_pad($currentid, 4, "0", STR_PAD_LEFT) . "/images";
$actual_file = "articles/" . str_pad($currentid, 4, "0", STR_PAD_LEFT) . "/index.html";
$fh = fopen($actual_file, 'r') or die('Could not open the file!');
# replace images directory location
$text = fread($fh, filesize($actual_file)) or die('Could not read that file');
fclose($fh);
$text = str_replace($placeholder, $actual_dir , $text);
echo $text;

# rate article

# comment on article

require("include/footer.php");

?>
