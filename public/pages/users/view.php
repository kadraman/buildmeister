<?php

include_once("common.inc");
include_once("header.inc");

$username = isset($_GET['username']) ? $database->clean_data($_GET['username']) : '';

// if no user set, assume logged in user
if (!$username) {
   	$username = $session->username;
}

// does the user exist	   	        
if (!$database->usernameTaken($username)) {
	// does the user exist?
	$session->displayDialog("User Does Not Exist",
	   	"The specified user does not exist.", "/");
} else {	
	
    // display requested user information 
	$user_info = $database->getUserInfo($username);
    
	if ($session->username != $username) {
		echo "<h1>" . $username . "'s account</h1>";
	} else {
		echo "<h1>My account</h1>";
	}
?>

<form id="viewUserForm" action="<?php echo "/users/edit/" . $username; ?>" method="post">
	<fieldset style="width:400px; margin: 0px auto">

		<!-- user name -->		
    	<div>
        	<label for="user">Username:</label>
        	<input type="text" name="username" maxlength="50" id="username" class="disabled"
				disabled value="<?php echo $user_info['username']; ?>">
		</div>
		
		<!-- first name -->
		<div>
			<label for="firstname">First name:</label>
       		<input type="text" name="firstname" maxlength="50" id="firstname" class="disabled"
				disabled value="<?php echo $user_info['firstname']; ?>">
       	</div>

		<!-- last name -->
		<div>
        	<label for="lastname">Lastname:</label>
        	<input type="text" name="lastname" maxlength="50" id="lastname" class="disabled"
				disabled value="<?php echo $user_info['lastname']; ?>">
		</div>
				
<?php
    // if admin user or displaying own account show email
	if ($session->isAdmin() || (strcmp($session->username, $username) == 0)) {
?>		
		<!-- email -->
		<div>
			<label for="email">Email:</label>
			<input type="text" name="email" maxlength="100" id="email" class="disabled" 
				style="width:250px" disabled value="<?php echo $user_info['email']; ?>">
			<input type="hidden" name="user" value="<?php echo $user_info['username']; ?>">
		</div>
<?php
	}
?>

		<!-- website -->
		<div>
			<label for="email">Website:</label>
			<input type="text" name="website" maxlength="100" id="website" class="disabled" 
				style="width:250px" disabled value="<?php echo $user_info['website']; ?>">			
		</div>

<?php 	
	// if admin user or logged in and user viewing own account, give link to edit
	if ($session->isAdmin() || strcmp($session->username, $username) == 0) {
?>
		<!-- buttons -->
		<div>
			<label for="kludge"><!-- empty --></label>
   			<input type="submit" id="edit" value="Edit Account" class="btn"/>
   		</div>
   		
<?php 
	}
?>   		

	</fieldset>
</form>

<?php
	
		echo "<h2>Articles by this user</h2>";
		// fetch all published articles by this user
		$sql = "SELECT id, title, state, posted_by, DATE_FORMAT(date_posted, \"%M %D, %Y\")"
    		. " as newdate, summary from " . TBL_ARTICLES . " WHERE "
			. "posted_by = '$username' ORDER BY date_posted DESC;";
	
		if ($result = mysqli_query($database->getConnection(), $sql)) {		
			while ($row = mysqli_fetch_assoc($result)) {
				$atitle = strtolower(str_replace(" ", "_", $row['title']));
				echo "<div id='splitlist'><strong><a href='" 
					. "/articles/" . $atitle . "'>"
 			    	. $row['title'] . "</a></strong>"
 			    	. "&nbsp;[" . $database->getArticleStateName($row['state']) . "]<br/>"
 			    	. "Posted on " . $row['newdate'];			 
 			    echo "</small></div>";
    		}
    		// free result set
    		mysqli_free_result($result);
		}
	
		echo "<h2>Comments by this user</h2>";
		// fetch all comments by this user
   		$sql = "SELECT id, art_id, posted_by, comment, DATE_FORMAT(date_posted, \"%M %D, %Y\") " 
   			. "as newdate, art_id from " . TBL_ARTCOM . " where state = 1 AND posted_by = "
   			. "'$username' ORDER BY date_posted DESC;";
	
		if ($result = mysqli_query($database->getConnection(), $sql)) {		
			while ($row = mysqli_fetch_assoc($result)) {
				$atitle = $database->getArticleTitle($row['art_id']);
				$atitle_link = strtolower(str_replace(" ", "_", $atitle));
				echo "<div id='splitlist'><strong>Comment on article "
					. "<a href='/articles/" . $atitle_link . "'>"
 		    		. $atitle . "</a></strong><br/>"
 		    		. "Posted on " . $row['newdate'];			 
 		    	echo "</small></div>";
    		}
    		// free result set
    		mysqli_free_result($result);
		}
    }
    
include_once("footer.inc");
?>

