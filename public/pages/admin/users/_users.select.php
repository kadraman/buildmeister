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
		echo "<p class='error'>Error calculating number of users: $sql.</p>";
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
			echo "<p class='error'>Error filtering users: $sql</p>";
		}
	}		

	// create hidden fields for navigation and sorting
	echo "<input type='hidden' id='curPage' value='" . $page . "'/>";
	echo "<input type='hidden' id='maxPage' value='" . $num_pages . "'/>";
	echo "<input type='hidden' id='numEntries' value='" . $num_users . "'/>";
	
	// create the table
	echo "<table class='admintable'>\n";
	if ($num_rows != 0) {
		// display table contents
		echo "<tr><th colspan='2'></th>";
		echo "<th><a class='sortable' id='username' href=''>Username</a></th>";
		echo "<th><a class='sortable' id='userlevel' href=''>Level</a></th>";
		echo "<th><a class='sortable' id='email' href=''>Email</a></th>";
		echo "<th><a class='sortable' id='active' href=''>Active</a></th>";
		echo "<th><a class='sortable' id='timestamp' href=''>Last Active</a></th></tr>\n";
		for ($i = 0; $i < $num_rows; $i++) {
			if (($i % 2) == 1)
				echo "<tr class='altrow'>\n";
			else
				echo "<tr>\n";
			$row = mysqli_fetch_assoc($result);	
			$uname  = $row['username'];
			$ulevel = $database->getUserLevelName($row['userlevel']);
			$email  = $row['email'];
			$time   = date("M d, Y", $row['timestamp']);
			$active = (($row['active'] == 1) ? "Yes" : "No");
			echo "<td><a class='editUser' href='" . SITE_PREFIX . "/pages/users/view.php?user=" . $uname
				. "'><img src='" . SITE_BASEDIR . "/images/icons-small/User-edit.png'></img></a>";
			echo "<td><a class='deleteUser' id='" . $uname 
				. "' href=''>"
				. "<img src='" . SITE_BASEDIR . "/images/icons-small/User-del.png'></img></a>";
			echo "<td><a href='" . SITE_PREFIX . "/pages/users/view.php?user=" .
				$uname . "'>$uname</a></td>\n";
			echo "<td class='centerAlign'>$ulevel</td>\n";
			echo "<td>$email</td>\n";
			echo "<td class='centerAlign'>$active</td>\n";
			echo "<td class='centerAlign'>$time</td>\n";
			echo "</tr>\n";			
		}
		
		mysqli_free_result($result);
		
	} else {
		// display empty table
		echo "<tr><td>No results found</td></tr>";
	}	
	
	echo "</table>\n";
	
// include table specific javascript
		
$js = <<<EOD
		
	<script type="text/javascript">
	
	// delete comments
	$$('a.deleteUser').each(function(link) {
		link.addEvent('click', function(e) {
			e.preventDefault();			
			new StickyWinModal({
				content: StickyWin.ui('Delete User', 'Are you sure you want to delete this user?', {
					width: '400px',
				    buttons: [
                    {
				        text: 'Yes', 
				        onClick: function() {
                    	
                    		// delete the comment via ajax
                    		var req = new Request({
                    			method: 'post',
                    			url: CONFIG.site_prefix + 
                    				'/pages/admin/users/_user.delete.php',
                    		    data: { 'user' : link.id },
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

