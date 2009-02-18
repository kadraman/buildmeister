<?php
// setup include path
if (!defined("PATH_SEPARATOR")) {
	if (strpos($_ENV["OS"], "Win") !== false)
	define("PATH_SEPARATOR", ";");
	else define("PATH_SEPARATOR", ":");
}
ini_set("include_path", "." . PATH_SEPARATOR . "../../../include");
?>