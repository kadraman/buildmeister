<?php

include_once("common.inc");
include_once("database.php");
	
	// get the page number to show
	if (!isset($_GET['page']))
		$page = 1;
	else  
		$page = $database->clean_data($_GET["page"]);

	// get the search string to filter users on
	if (!isset($_GET['searchstring']))
		$searchstring = "";
	else
		$searchstring = $database->clean_data($_GET["searchstring"]);

	// get the column to filter users on
	if (!isset($_GET['searchcolumn']))
		$searchcolumn = "username";
	else
		$searchcolumn = $database->clean_data($_GET["searchcolumn"]);
		
	// get the number of rows to show
	if (!isset($_GET['rows']))
		$rows_per_page = PAGE_LIMIT;
	else
		$rows_per_page = $database->clean_data($_GET["rows"]);	
	// TODO: check rows_per_page is a number;	
	
	// find the number of users
	$sql = "SELECT COUNT(*) FROM " . TBL_USERS . " WHERE " . $searchcolumn . 
		" LIKE '%" . $searchstring . "%'";
	$result = mysqli_query($database->getConnection(), $sql);
	if (!$result || (mysqli_num_rows($result) < 1)) {
		$num_users = 0;
		$num_pages = 0;
	} else {	
		$row = mysqli_fetch_row($result);
		$num_users = $row['0'];
		if (isset($_GET['rows']) && $rows_per_page == 0) {
			$num_pages = 1;		
		} else {
			$num_pages = ceil($num_users / $rows_per_page);
		}
	}
			
	// get the details of the users
	if (!$searchstring) {
		$sql = "SELECT * FROM " . TBL_USERS . " ORDER BY userlevel DESC,username";
		if ($rows_per_page > 0) {
			$sql .= " LIMIT " . ($page-1) * $rows_per_page . "," . $rows_per_page;
		}
	} else {
		$sql = "SELECT * FROM " . TBL_USERS
			. " WHERE " . $searchcolumn . " LIKE '%" . $searchstring . "%' " 
	    	. " ORDER BY userlevel DESC,username";
		if ($rows_per_page > 0) {
			$sql .= " LIMIT " . ($page-1) * $rows_per_page . "," . $rows_per_page;
		}
	}
	$result = mysqli_query($database->getConnection(), $sql);
	$num_rows = mysqli_num_rows($result);
	
	if (!$result || ($num_rows < 0)) {
		echo "<div align='center'><p class='error'>Error Searching for Users.</p></div>";
	}		

	// create hidden fields for navigation
	echo "<input type='hidden' id='curPage'  value='" . $page . "'/>";
	echo "<input type='hidden' id='maxPage'  value='" . $num_pages . "'/>";
	echo "<input type='hidden' id='numEntries' value='" . $num_users . "'/>";
	echo "<table class='admintable'>\n";
	if ($num_rows != 0) {
		// display table contents
		echo "<tr><th colspan='2'></th><th>Username</th><th>Level</th><th>Email</th><th>Active</th><th>Last Active</th></tr>\n";
		for ($i = 0; $i < $num_rows; $i++) {
			if (($i % 2) == 1)
				echo "<tr class='altrow'>\n";
			else
				echo "<tr>\n";
			$row = mysqli_fetch_assoc($result);	
			$uname  = $row['username'];
			$ulevel = $row['userlevel'];
			$email  = $row['email'];
			$time   = date("M d, Y", $row['timestamp']);
			$active = (($row['active'] == 1) ? "Yes" : "No");
			echo "<td><a class='editUser' href='" . SITE_PREFIX . "/pages/users/view.php?user=" . $uname
				. "'><img src='" . SITE_BASEDIR . "/images/icons/16x16/edit.png'></img></a>";
			echo "<td><a class='deleteUser' id='" . $uname 
				. "' href=''>"
				. "<img src='" . SITE_BASEDIR . "/images/icons/16x16/delete.png'></img></a>";
			echo "<td><a href='" . SITE_PREFIX . "/pages/users/view.php?user=" .
				$uname . "'>$uname</a></td>\n";
			echo "<td class='centerAlign'>$ulevel</td>\n";
			echo "<td>$email</td>\n";
			echo "<td class='centerAlign'>$active</td>\n";
			echo "<td class='centerAlign'>$time</td>\n";
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

