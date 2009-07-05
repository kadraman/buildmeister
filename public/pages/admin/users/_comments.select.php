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
	//if (strcmp($searchcolumn, "state") == 0) {
	//	$searchstring = $database->getCommentStateId($searchstring);
	//}

	// get the sort column 
	$sortcolumn = isset($_GET['sortcolumn']) ? $database->clean_data($_GET['sortcolumn']) : "date_posted";	
	
	// get the sort direction 
	$sortdirection = isset($_GET['sortdirection']) ? $database->clean_data($_GET['sortdirection']) : "DESC";	
		
	// get the number of rows to show
	$rows_per_page = isset($_GET['rows']) ? $database->clean_data($_GET['rows']) : PAGE_LIMIT;			

	// calculate the number of comments	
	$sql = "SELECT COUNT(*) FROM " . TBL_ARTCOM;
	if ($searchcolumn) {
		$sql .= " WHERE $searchcolumn LIKE '%$searchstring%'";
	}
	$result = mysqli_query($database->getConnection(), $sql);
	if (!$result || (mysqli_num_rows($result) < 1)) {
		$num_articles = 0;
		$num_pages = 0;
		$num_rows  = 0;
		echo "<p class='error'>Error calculating number of comments: $sql.</p>";
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
			$sql = "SELECT id, art_id, comment, state, posted_by,"
		 		. " DATE_FORMAT(date_posted, \"%d-%b-%y\") as new_date_posted"
    			. " FROM " . TBL_ARTCOM; 
	   	 	if ($sortcolumn) {
    			$sql .= " ORDER BY $sortcolumn $sortdirection";
			}
			if ($rows_per_page > 0) {
				$sql .= " LIMIT " . ($page-1) * $rows_per_page . ", $rows_per_page";
			}
		} else {
			// we have a search string, filter articles
			$sql = "SELECT id, art_id, comment, state, posted_by,"
		 		. " DATE_FORMAT(date_posted, \"%d-%b-%y\") as new_date_posted"
		    	. " FROM " . TBL_ARTCOM
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
			echo "<p class='error'>Error filtering comments: $sql</p>";
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
		echo "<th><a class='sortable' id='art_id' href='' >Article Title</a></th>";
		echo "<th><a class='sortable' id='comment' href='' >Comment</a></th>";
		echo "<th><a class='sortable' id='posted_by' href=''>Posted By</a></th>";
		echo "<th><a class='sortable' id='state' href=''>Active</th></tr>\n";
		for ($i = 0; $i < $num_rows; $i++) {
			if (($i % 2) == 1)
				echo "<tr class='altrow'>\n";
			else
				echo "<tr>\n";
			$row = mysqli_fetch_assoc($result);	
			$posted   = $row['new_date_posted'];
			$author   = $row['posted_by'];
			$cid      = $row['id'];
			$aid      = $row['art_id'];
			$comment  = strip_tags($row['comment']);
			$active = (($row['state'] == 1) ? "Yes" : "No");
			$article  = $database->getArticleTitle($row['art_id']);
			echo "<td><a class='editComment' href='" . REWRITE_PREFIX . "/comments/edit/" . $cid
				. "'><img src='" . SITE_BASEDIR . "/images/icons-small/Comments-edit.png'></img></a>";
			echo "<td><a class='deleteComment' id='" . $cid 
				. "' href=''>"
				. "<img src='" . SITE_BASEDIR . "/images/icons-small/Comments-del.png'></img></a>";
			echo "<td align=\"center\">$posted</td>\n";
			echo "<td align='left'><a href='" . REWRITE_PREFIX . "/articles/" .
				$database->flattenArticleTitle($article) . "'>$article</a></td>\n";
			echo "<td>$comment</td>\n";
			echo "<td><a href='" . SITE_PREFIX . "/pages/users/view.php?user=" .
				$author . "'>$author</a></td>\n";
			echo "<td>$active</td>\n";
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
	$$('a.deleteComment').each(function(link) {
		link.addEvent('click', function(e) {
			e.preventDefault();			
			new StickyWinModal({
				content: StickyWin.ui('Delete Comment', 'Are you sure you want to delete this comment?', {
					width: '400px',
				    buttons: [
                    {
				        text: 'Yes', 
				        onClick: function() {
                    	
                    		// delete the article via ajax
                    		var req = new Request({
                    			method: 'post',
                    			url: CONFIG.site_prefix + 
                    				'/pages/admin/comments/_comment.delete.php',
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

