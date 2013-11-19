<?php

include_once("common.inc");
include_once("database.php");
	
// get the page number to show
$page = isset($_GET['page']) ? $database->clean_data($_GET['page']) : 1;

// get the search string to filter users on
$searchstring = isset($_GET['searchstring']) ? $database->clean_data($_GET['searchstring']) : "";

// get the column to filter users on
$searchcolumn = isset($_GET['searchcolumn']) ? $database->clean_data($_GET['searchcolumn']) : "username";

// get the sort column
$sortcolumn = isset($_GET['sortcolumn']) ? $database->clean_data($_GET['sortcolumn']) : "username";
	
// get the sort direction
$sortdirection = isset($_GET['sortdirection']) ? $database->clean_data($_GET['sortdirection']) : "";
		
// get the number of rows to show
$rows_per_page = isset($_GET['rows']) ? $database->clean_data($_GET['rows']) : PAGE_LIMIT;


// array for JSON result
$json_result = array();
$json_result['code'] = 0; 		// assume failure

// calculate the number of users
$sql = "SELECT COUNT(*) FROM " . TBL_USERS;
if ($searchcolumn) {
	$sql .= " WHERE $searchcolumn LIKE '%$searchstring%'";
}
$result = mysqli_query($database->getConnection(), $sql);
if (!$result || (mysqli_num_rows($result) < 1)) {
	$num_users = 0;
	$num_pages = 0;
	$num_rows  = 0;
    $json_result['message'] = "<p class='error'>Error calculating number of users: $sql.</p>";
    exit(json_encode($json_result));
} else {
	$row = mysqli_fetch_row($result);
	$num_users = $row['0'];

	// calculate number of pages
	if (isset($_GET['rows']) && $rows_per_page == 0) {
		$num_pages = 1;
	} else {
		$num_pages = ceil($num_users / $rows_per_page);
	}
	
	// get the details of the users
	if (!$searchstring) {
		$sql = "SELECT * FROM " . TBL_USERS;
	   	 if ($sortcolumn) {
    		$sql .= " ORDER BY $sortcolumn $sortdirection";
		}
		if ($rows_per_page > 0) {
			$sql .= " LIMIT " . ($page-1) * $rows_per_page . ", $rows_per_page";
		}
	} else {
		// we have a search string, filter users
		$sql = "SELECT * FROM " . TBL_USERS
			. " WHERE $searchcolumn LIKE '%$searchstring%' ";
	    if ($sortcolumn) {
    		$sql .= " ORDER BY $sortcolumn $sortdirection";
		}
		if ($rows_per_page > 0) {
			$sql .= " LIMIT " . ($page-1) * $rows_per_page . ", $rows_per_page";
		}
	}
	$result = mysqli_query($database->getConnection(), $sql);
	$num_rows = mysqli_num_rows($result);
	if (!$result || ($num_rows < 0)) {
        $json_result['message'] = "<p class='error'>Error filtering users: $sql</p>";
        exit(json_encode($json_result));
	}
}

$json_result['page'] 	= $page;
$json_result['max']  	= $num_pages;
$json_result['entries'] = $num_comments;

if ($num_rows != 0) {
	for ($i = 0; $i < $num_rows; $i++) {
		$row = mysqli_fetch_assoc($result);
		$uname  = $row['username'];
		$ulevel = $database->getUserLevelName($row['userlevel']);
        $firstname  = $row['firstname'];
        $lastname  = $row['lastname'];
		$email  = $row['email'];
		$active = (($row['active'] == 1) ? "Yes" : "No");
        $row = array($uname, $ulevel, $firstname, $lastname, $email, $active);
        $data[] = $row;
    }

    $json_result['data'] = $data;

	mysqli_free_result($result);

}

$json_result['code'] = 1;
$json_result['message'] = "Success";
exit(json_encode($json_result));

?>

