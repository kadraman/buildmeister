<?php

include_once("common.inc");
include_once("database.php");
	
// get the page number to show
$page = isset($_GET['page']) ? $database->clean_data($_GET['page']) : 1;

// get the search string to filter users on
$searchstring = isset($_GET['searchstring']) ? $database->clean_data($_GET['searchstring']) : "";

// get the column to filter users on
$searchcolumn = isset($_GET['searchcolumn']) ? $database->clean_data($_GET['searchcolumn']) : "state";
// if its a state name we need to get the id
if (strcmp($searchcolumn, "state") == 0) {
	$searchstring = $database->getArticleStateId($searchstring);
}

// get the sort column 
$sortcolumn = isset($_GET['sortcolumn']) ? $database->clean_data($_GET['sortcolumn']) : "state";	
	
// get the sort direction 
$sortdirection = isset($_GET['sortdirection']) ? $database->clean_data($_GET['sortdirection']) : "";	
		
// get the number of rows to show
$rows_per_page = isset($_GET['rows']) ? $database->clean_data($_GET['rows']) : PAGE_LIMIT;			

// array for JSON result
$json_result = array();
$json_result['code'] = 0; 		// assume failure

// calculate the number of articles	
$sql = "SELECT COUNT(*) FROM " . TBL_ARTICLES;
if ($searchcolumn) {
	$sql .= " WHERE $searchcolumn LIKE '%$searchstring%'";
}
$result = mysqli_query($database->getConnection(), $sql);
if (!$result || (mysqli_num_rows($result) < 1)) {
	$num_articles = 0;
	$num_pages = 0;
	$num_rows  = 0;
	$json_result['message'] = "<p class='error'>Error calculating number of articles: $sql.</p>";
	exit(json_encode($json_result));
} else {	
	$row = mysqli_fetch_row($result);
	$num_articles = $row['0'];
	
	// calculate number of pages
	if (isset($_GET['rows']) && $rows_per_page == 0) {
		$num_pages = 1;		
	} else {
		$num_pages = ceil($num_articles / $rows_per_page);
	}
	
	// get the details of the articles
	if (!$searchstring) {
		$sql = "SELECT id, title, state, posted_by,"
		 	. " DATE_FORMAT(date_posted, \"%d-%b-%y\") as new_date_posted,"
		 	. " DATE_FORMAT(date_updated, \"%d-%b-%y\") as new_date_updated"
    		. " FROM " . TBL_ARTICLES; 
	   	if ($sortcolumn) {
    		$sql .= " ORDER BY $sortcolumn $sortdirection";
		}
		if ($rows_per_page > 0) {
			$sql .= " LIMIT " . ($page-1) * $rows_per_page . ", $rows_per_page";
		}
	} else {
		// we have a search string, filter articles
		$sql = "SELECT id, title, state, posted_by,"
		 	. " DATE_FORMAT(date_posted, \"%d-%b-%y\") as new_date_posted,"
		 	. " DATE_FORMAT(date_updated, \"%d-%b-%y\") as new_date_updated"
		    . " FROM " . TBL_ARTICLES
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
		$json_result['message'] = "<p class='error'>Error filtering articles: $sql</p>";
		exit(json_encode($json_result));
	}
}		
	
$json_result['page'] 	= $page;
$json_result['max']  	= $num_pages;
$json_result['entries'] = $num_articles;

if ($num_rows != 0) {
	$data = array();
	for ($i = 0; $i < $num_rows; $i++) {
		$row = mysqli_fetch_assoc($result);	
		$posted   = $row['new_date_posted'];
		$updated  = $row['new_date_updated'];
		$author   = $row['posted_by'];
		$aid      = $row['id'];
		$title    = $row['title'];
		$state    = $database->getArticleStateName($row['state']);
		$row = array($aid, $title, $posted, $updated, $author, $state);
		$data[] = $row;	
	}
	
	$json_result['data'] = $data;
	
	mysqli_free_result($result);
	
}
	
$json_result['code'] = 1;
$json_result['message'] = "Success"; 
exit(json_encode($json_result));
	
?>

