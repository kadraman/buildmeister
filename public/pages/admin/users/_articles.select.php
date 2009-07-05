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
		echo "<p class='error'>Error calculating number of articles: $sql.</p>";
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
			echo "<p class='error'>Error filtering articles: $sql</p>";
		}
	}		
	
	// create hidden fields for navigation
	echo "<input type='hidden' id='curPage' value='" . $page . "'/>";
	echo "<input type='hidden' id='maxPage' value='" . $num_pages . "'/>";
	echo "<input type='hidden' id='numEntries' value='" . $num_articles . "'/>";

	// create the table
	echo "<table class='admintable'>\n";
	if ($num_rows != 0) {
		// display table contents
		echo "<tr><th colspan='2'></th>";
		echo "<th><a class='sortable' id='date_posted' href=''>Date Posted</a></th>";
		echo "<th><a class='sortable' id='date_updated' href=''>Last Updated</a></th>";
		echo "<th><a class='sortable' id='title' href='' >Title</a></th>";
		echo "<th><a class='sortable' id='posted_by' href=''>Posted By</a></th>";
		echo "<th><a class='sortable' id='state' href=''>State</th></tr>\n";
		for ($i = 0; $i < $num_rows; $i++) {
			if (($i % 2) == 1)
				echo "<tr class='altrow'>\n";
			else
				echo "<tr>\n";
			$row = mysqli_fetch_assoc($result);	
			$posted   = $row['new_date_posted'];
			$updated  = $row['new_date_updated'];
			$author   = $row['posted_by'];
			$aid      = $row['id'];
			$title    = $row['title'];
			$state    = $database->getArticleStateName($row['state']);
			echo "<td><a class='editArticle' href='" . REWRITE_PREFIX . "/articles/edit/" . $aid
				. "'><img src='" . SITE_BASEDIR . "/images/icons-small/Doc-edit.png'></img></a>";
			echo "<td><a class='deleteArticle' id='" . $aid 
				. "' href=''>"
				. "<img src='" . SITE_BASEDIR . "/images/icons-small/Doc-del.png'></img></a>";
			echo "<td align=\"center\">$posted</td>\n";
			echo "<td align=\"center\">$updated</td>\n";
			echo "<td><a href='" . REWRITE_PREFIX . "/articles/" .
				$database->flattenArticleTitle($title) . "'>$title</a></td>\n";
			echo "<td><a href='" . SITE_PREFIX . "/pages/users/view.php?user=" .
				$author . "'>$author</a></td>\n";
			echo "<td>$state</td>\n";
			echo "</tr>\n";			
		}
	} else {
		// display empty table
		echo "<tr><td>No results found</td></tr>";
	}
	mysqli_free_result($result);
	
	echo "</table>\n";
	
// include javascript
		
$js = <<<EOD
		
	<script type="text/javascript">
	
	// delete comments
	$$('a.deleteArticle').each(function(link) {
		link.addEvent('click', function(e) {
			e.preventDefault();			
			new StickyWinModal({
				content: StickyWin.ui('Delete Article', 'Are you sure you want to delete this article?', {
					width: '400px',
				    buttons: [
                    {
				        text: 'Yes', 
				        onClick: function() {
                    	
                    		// delete the article via ajax
                    		var req = new Request({
                    			method: 'post',
                    			url: CONFIG.site_prefix + 
                    				'/pages/admin/articles/_article.delete.php',
                    		    data: { 'id' : link.id },
                    		    onComplete: function(response) { 
                    		    	// decode the JSON response
                					var status = JSON.decode(response);

                					// act on the response
                					if (status.code) {
                						// successful, reload the page
                						window.location = location.href;
                					} else {
                						alert("Error: " + status.message);
                					}
                    		    }	
                    		}).send();
                    	}
				    },
				    {
				        text: 'No', 
				        onClick: function(){ 
				    		// ignore 
				    	}
				    }
				    ]
				})
			});
		});
	});	
	
	</script>
EOD;
echo $js;
?>

