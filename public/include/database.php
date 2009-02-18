<?php
/**
 * @package Database
 *
 * The Database class is meant to simplify the task of accessing
 * information from the website's database.
 *
 * @author Kevin A. Lee <kevin.lee@buildmeister.com>
 * Based on code originally written by: Jpmaster77.
 */
include_once("constants.php");

class MySQLDB {
   var $connection;         // the MySQL database connection
   var $conn;				// the MySQL database connection
   var $num_active_users;   // number of active users viewing site
   var $num_active_guests;  // number of active guests viewing site
   var $num_members;        // number of signed-up users

   /**
	* Class constructor
	*/
   function __construct() {
      // connect to database
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
      
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
   		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
		}

      // only query database to find out number of members
      // when getNumMembers() is called for the first time,
      // until then, default value set.
      $this->num_members = -1;

      if (TRACK_VISITORS){
         // calculate number of users at site
         $this->calcNumActiveUsers();
         // calculate number of guests at site */
         $this->calcNumActiveGuests();
      }
   } // __construct
   
   /**
    * Class destructor
    */
   function __destruct() {
       $this->conn->close();
   } // __destruct
   
   function getConnection() {
   		return $this->conn;
   }

   /**
    * Checks whether or not the given username is in the database,
    * if so it checks if the given password is the same password
    * in the database for that user.
    *
    * @param string $username
    * @param string $password
    * @return If the user doesn't exist or if the passwords don't match up,
    * it returns an error code (1 or 2). On success it returns 0.
    */
   function confirmUserPass($username, $password) {
      // add slashes if necessary (for query)
      if (!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      // verify that user is in database
      $q = "SELECT password FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if( !$result || (mysql_numrows($result) < 1)){
         return 1; // indicates username failure
      }

      // retrieve password from result, strip slashes
      $dbarray = mysql_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

      // validate that password is correct
      if ($password == $dbarray['password']) {
         return 0; // success! Username and password confirmed
      } else {
         return 2; // indicates password failure
      }
   } // confirmUserPass

   /**
    * Checks whether or not the given username is in
    * the database, if so it checks if the given userid
    * is the same userid in the database for that user.
    *
    * @param string $username
    * @param string $userid
    * @return If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      // Add slashes if necessary (for query)
      if (!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      // verify that user is in database
      $q = "SELECT userid FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if (!$result || (mysql_numrows($result) < 1)) {
         return 1; // indicates username failure
      }

      // retrieve userid from result, strip slashes
      $dbarray = mysql_fetch_array($result);
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      // validate that userid is correct
      if ($userid == $dbarray['userid']) {
         return 0; // success! username and userid confirmed
      } else {
         return 2; // indicates userid invalid
      }
   } // confirmUserID

   /**
    * Checks whether the given user has been activated.
    *
    * @param string $username
    * @return If the user doesn't exist or is inactive
    * returns 1 otherwise returns 0.
    */
   function confirmUserActive($username){
      // add slashes if necessary (for query)
      if (!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      // verify that user is in database
      $q = "SELECT active FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if (!$result || (mysql_numrows($result) < 1)) {
         return 1; // indicates username failure
      }

      // retrieve active status from result, strip slashes
      $dbarray = mysql_fetch_array($result);
      $dbarray['active'] = stripslashes($dbarray['active']);

      // validate that user is active
      if ($dbarray['active'] == '0') {
         return 0; // success user is active
      } else {
         return 1; // user is inactive
      }
   } // confirmUserActive

   /**
    * Checks whether the given user is inactive.
    *
    * @param string $email
    * @return If the user is active returns 1 otherwise
    * returns 0.
    */
   function confirmUserInactive($email) {
      // add slashes if necessary (for query)
      if (!get_magic_quotes_gpc()) {
	      $email = addslashes($email);
      }

      // verify that user is in database
      $q = "SELECT active FROM ".TBL_USERS." WHERE email = '$email'";
      $result = mysql_query($q, $this->connection);
      if (!$result || (mysql_numrows($result) < 1)) {
         return 1; // indicates email failure
      }

      // retrieve active status from result, strip slashes
      $dbarray = mysql_fetch_array($result);
      $dbarray['active'] = stripslashes($dbarray['active']);

      // validate that user is active
      if ($dbarray['active'] == '1'){
         return 0; // success user is inactive
      } else {
         return 1; // user is already active
      }
   } // confirmUserInActive

   /**
    * Checks whether the specified username is already taken.
    *
    * @param string $username
    * @return true if the username has been taken, otherwise
    * false.
    */
   function usernameTaken($username){
      if (!get_magic_quotes_gpc()) {
         $username = addslashes($username);
      }
      $q = "SELECT username FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   } // usernameTaken

   /**
    * Checks whether the specified username has been
    * banned by the administrator.
    *
    * @param string $username
    * @return true if the username has been banned,
    * otherwise false.
    */
   function usernameBanned($username) {
      if (!get_magic_quotes_gpc()) {
         $username = addslashes($username);
      }
      $q = "SELECT username FROM " . TBL_BANNED_USERS . " WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   } // usernameBanned
   
   /**
    * Checks whether a user exists
    *
    * @param string $username
    * @return true on success, false otherwise.
    */
    function userExists($username) {
   		$retval = true;
      	# select user
      	$q = "SELECT active FROM " . TBL_USERS . " WHERE username = '$username'";
     	$result = mysql_query($q, $this->connection);
      	# error occurred, user does not exist
      	if (!$result || (mysql_numrows($result) < 1)) {
        	$retval = false;
      	}      	
      	return $retval;
    } // userExists   

   /**
    * Inserts the given user into the database.
    * By default the user is inactive.
    *
    * @param string $username
    * @param string $password
    * @param string $email
    * @param string $verifystring
    * @param int $mailok
    * @return true on success, false otherwise.
    */
   function addNewUser($username, $password, $firstname, $lastname, $email, $verifystring, $mailok) {
      $time = time();
      /* If admin sign up, give admin user level */
      if(strcasecmp($username, ADMIN_NAME) == 0){
         $ulevel = ADMIN_LEVEL;
      }else{
         $ulevel = USER_LEVEL;
      }
      $q = "INSERT INTO " . TBL_USERS
      . " VALUES ('$username', '$password', '$firstname', '$lastname',
      '0', $ulevel, '$email', $time, $mailok, '$verifystring', 0)";
      return mysql_query($q, $this->connection);
   } // addNewUser

   /**
    * Delete a user from the database.
    *
    * @param integer $username
    * @return true on success, false otherwise.
    */
    function deleteUser($username) {
      $retval = true;
      # delete user
      $q = "DELETE FROM " . TBL_USERS . " WHERE username = '$username'";
      if (!mysql_query($q, $this->connection)) {
          $retval = false;
      }
      return $retval;
    } // deleteUser
     
   /**
    * Adds a new article into the database.
    * By default the article is inactive.
    *
    * @param unknown_type $title
    * @param unknown_type $summary
    * @param unknown_type $category
    * @param unknown_type $date
    * @param unknown_type $text
    * @return true on success, false otherwise.
    */
    function addNewArticle($title, $summary, $category, $date, $text) {
      $retval = true;
      # add article into database
      $q = "INSERT INTO " . TBL_ARTICLES . " (date_posted, summary, title, content, state)"
      . " VALUES ('$date', '$summary', '$title', '$text', '0')";
      if (!mysql_query($q, $this->connection)) {
          $retval = false;
      } else {
          $artid = mysql_insert_id();
          # add categories
          $categories = explode(",", $category);
          foreach ($categories as $catid) {
              $q = "INSERT INTO " . TBL_ARTICLE_CATEGORIES . " (article_id, cat_id)"
                  . " VALUES ('$artid', '$catid')";
              if (!mysql_query($q, $this->connection)) { 
                  $retval = false; 
                  break;
              }
          }
      }
      return $retval;
    } // addNewArticle

   /**
    * Checks whether an article exists
    *
    * @param integer $artid
    * @return true on success, false otherwise.
    */
    function articleExists($artid) {
   		$retval = true;
      	# select article
      	$q = "SELECT id FROM " . TBL_ARTICLES . " WHERE id = '$artid'";
     	$result = mysql_query($q, $this->connection);
      	# error occurred, article does not exist
      	if (!$result || (mysql_numrows($result) < 1)) {
        	$retval = false;
      	}      	
      	return $retval;
    } // articleExists
    
   /**
    * Checks whether an article has been published
    *
    * @param integer $artid
    * @return true on success, false otherwise.
    */
    function articlePublished($artid) {
   		$retval = true;
      	# select article
      	$q = "SELECT id FROM " . TBL_ARTICLES . " WHERE id = '$artid' AND state = "
      		. PUBLISHED_STATE;
     	$result = mysql_query($q, $this->connection);
      	# error occurred, article does not exist
      	if (!$result || (mysql_numrows($result) < 1)) {
        	$retval = false;
      	}      	
      	return $retval;
    } // articlePublished  
    
   /**
    * Get the title of an article
    *
    * @param integer $artid
    * @return article title else NULL
    */
    function getArticleTitle($artid) {
    	$retval = NULL;
      	// select article
      	$sql = "SELECT title FROM " . TBL_ARTICLES . " WHERE id = '$artid'";
      	if ($result = mysqli_query($this->conn, $sql)) {
      		$row = mysqli_fetch_row($result);
      		$retval = $row['0'];
      		mysqli_free_result($result);
      	}
     	return $retval;
    } // getArticleTitle      

    
    /**
    * Updates an article in the database.
    * By default the article remains active.
    *
    * @param unknown_type $id
    * @param unknown_type $title
    * @param unknown_type $summary
    * @param unknown_type $category
    * @param unknown_type $date
    * @param unknown_type $state
    * @param unknown_type $author
    * @param unknown_type $text
    * @return true on success, false otherwise.
    */
    function updateArticle($artid, $title, $summary, $category, $date, 
    	$state, $author, $text) {
      $retval = true;
      # update article in database
      //$mysqldate = date( 'Y-m-d H:i:s', strtotime($date));     
      // TODO: turn state into number 
      $q = "UPDATE " . TBL_ARTICLES . " SET date_posted = STR_TO_DATE('$date','%d-%m-%Y'), " .
		"title = '$title', summary = '$summary', content = '$text', state = '$state', " .
        "posted_by = '$author' WHERE id = '$artid'";
      if (!mysql_query($q, $this->connection)) {
          $retval = false;
      } else {
         	# update categories
          	# delete existing refernces to category
          	$q = "DELETE FROM " . TBL_ARTICLE_CATEGORIES . " WHERE article_id = '$artid'";
          	if (!mysql_query($q, $this->connection)) {
            	  $retval = false;
              	break;
          	} else {
            	  # add again
          		if ($category) {
	              	foreach ($category as $catid) {
    	            	$q = "INSERT INTO " . TBL_ARTICLE_CATEGORIES . " (article_id, cat_id)"
        	              . " VALUES ('$artid', '$catid')";
            	      	if (!mysql_query($q, $this->connection)) { 
                	    	  $retval = false; 
                    	  	break;
                  		}
              		}
          		}
          	}
      	
      }
      return $retval;
    } // updateArticle

    /**
    * Delete an article from the database.
    *
    * @param integer $postid
    * @return true on success, false otherwise.
    */
    function deleteArticle($artid) {
      $retval = true;
      # delete article
      $q = "DELETE FROM " . TBL_ARTICLES . " WHERE id = '$artid'";
      if (!mysql_query($q, $this->connection)) {
          $retval = false;
      }
      return $retval;
    } // deleteArticle  
   
   /**
    * Adds a new book into the database.
    * By default the book is inactive.
    *
    * @param unknown_type $username
    * @param unknown_type $booktitle
    * @param unknown_type $bookauthor
    * @param unknown_type $bookurl
    * @param unknown_type $booksummary
    * @return true on success, false otherwise.
    */
   function addNewBook($username, $booktitle, $bookauthor, $bookurl, $booksummary) {
      $q = "INSERT INTO " . TBL_BOOKS . " (date_posted, posted_by, title, author, summary, url)"
      . " VALUES (now(), '$username', '$booktitle', '$bookauthor', '$booksummary', '$bookurl')";
      return mysql_query($q, $this->connection);
   } // addNewBook

   /**
    * Adds a new glossary item into the database.
    * By default the item is inactive.
    *
    * @param string $username
    * @param string $glosstitle
    * @param string $glosssummary
    * @return true on success, false otherwise.
    */
   function addNewGlossItem($username, $glosstitle, $glosssummary) {
      $q = "INSERT INTO " . TBL_GLOSSARY . " (posted_by, title, summary)"
      . " VALUES ('$username', '$glosstitle', '$glosssummary')";
      return mysql_query($q, $this->connection);
   } // addNewGlossItem

   /**
    * Adds a new link item to the database.
    * By default the item is inactive.
    *
    * @param string $username
    * @param string $linktitle
    * @param string $linkurl
    * @param string $linksummary
    * @return true on success, false otherwise.
    */
   function addNewLinkItem($username, $linktitle, $linkurl, $linksummary) {
      $q = "INSERT INTO " . TBL_LINKS . " (date_posted, posted_by, title, summary, url)"
      . " VALUES (now(), '$username', '$linktitle', '$linksummary', '$linkurl')";
      return mysql_query($q, $this->connection);
   } // addNewLinkItem

   /**
    * Adds a new article into the database.
    * By default the article is inactive.
    *
    * @param string $username
    * @param string $articletitle
    * @param string $articlesummary
    * @return true on success, false otherwise.
    */
   /*function addNewArticle($username, $articletitle, $articlesummary, $articlecontent) {
      $q = "INSERT INTO " . TBL_ARTICLES . " (date_posted, posted_by, title, summary, content)"
      . " VALUES (now(), '$username', '$articletitle', '$articlesummary', '$articlecontent')";
      return mysql_query($q, $this->connection);
   } // addNewArticle
*/
   /**
    * Adds a new tip into the database.
    * By default the tip is inactive.
    *
    * @param string $username
    * @param string $tiptitle
    * @param string $tipsummary
    * @param string $tipcontent
    * @return true on success, false otherwise.
    */
   function addNewTip($username, $tiptitle, $tipsummary, $tipcontent) {
      $q = "INSERT INTO " . TBL_TIPS . " (date_posted, posted_by, title, summary, content)"
      . " VALUES (now(), '$username', '$tiptitle', '$tipsummary', '$tipcontent')";
      return mysql_query($q, $this->connection);
   } // addNewTip

   /**
    * Adds a new glossary item comment into the database.
    * By default the comment is inactive.
    *
    * @param string $username
    * @param string $glossid
    * @param string $comment
    * @return true on success, false otherwise.
    */
   function addNewGlossaryComment($username, $glossid, $comment) {
      $q = "INSERT INTO " . TBL_GLOSSCOM . " (date_posted, posted_by, gloss_id, comment)"
      . " VALUES (now(), '$username', '$glossid', '$comment')";
      return mysql_query($q, $this->connection);
   } // addNewGlossaryComment

   /**
    * Adds a new tip item comment into the database.
    * By default the comment is inactive.
    *
    * @param string $username
    * @param string $tipid
    * @param string $comment
    * @return true on success, false otherwise.
    */
   function addNewTipComment($username, $tipid, $comment) {
      $q = "INSERT INTO " . TBL_TIPCOM . " (date_posted, posted_by, tip_id, comment)"
      . " VALUES (now(), '$username', '$tipid', '$comment')";
      return mysql_query($q, $this->connection);
   } // addNewTipComment

   /**
    * Adds a new article comment into the database.
    * By default the comment is inactive.
    *
    * @param string $username
    * @param string $artid
    * @param string $comment
    * @return true on success, false otherwise.
    */
   function addNewArticleComment($username, $artid, $comment) {
      $q = "INSERT INTO " . TBL_ARTCOM . " (date_posted, posted_by, art_id, comment, state)"
      . " VALUES (now(), '$username', '$artid', '$comment', 1)";
      return mysql_query($q, $this->connection);
   } // addNewArticleComment

   /**
    * Checks whether an article comment exists
    *
    * @param integer $comid
    * @return true on success, false otherwise.
    */
    function articleCommentExists($comid) {
   		$retval = true;
      	# select comment
      	$q = "SELECT id FROM " . TBL_ARTCOM . " WHERE id = '$comid'";
     	$result = mysql_query($q, $this->connection);
      	# error occurred, comment does not exist
      	if (!$result || (mysql_numrows($result) < 1)) {
        	$retval = false;
      	}      	
      	return $retval;
    } // articleCommentExists
    
   /**
    * Delete an article comment from the database.
    *
    * @param integer $comid
    * @return true on success, false otherwise.
    */
    function deleteArticleComment($comid) {
      $retval = true;
      # delete comment
      $q = "DELETE FROM " . TBL_ARTCOM . " WHERE id = '$comid'";
      if (!mysql_query($q, $this->connection)) {
          $retval = false;
      }
      return $retval;
    } // deleteArticleComment  
    
   /**
    * Updates a field in the user's row.
    *
    * @param string $username
    * @param string $field
    * @param string $value
    * @return true on success, false otherwise.
    */
   function updateUserField($username, $field, $value) {
      $q = "UPDATE " . TBL_USERS . " SET " . $field
      . " = '$value' WHERE username = '$username'";
      return mysql_query($q, $this->connection);
   } // updateUserField

   /**
    * Gets all the information for a specific user.
    *
    * @param string $username
    * @return the result array with all information stored
    * regarding the given username. If query fails, NULL
    * is returned.
    */
   function getUserInfo($username) {
      $q = "SELECT * FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      // error occurred, return given name by default
      if (!$result || (mysql_numrows($result) < 1)) {
         return NULL;
      }
      // return result array
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
   } // getUserInfo

   /**
    * Gets the number of signed-up users (excluding banned
    * members). The first time the function is called on
    * page load, the database is queried, on subsequent calls,
    * the stored result is returned. This is to improve
    * efficiency, effectively not querying the database when
    * no call is made.
    *
    * @return number of users
    */
   function getNumMembers(){
      if ($this->num_members < 0) {
         $q = "SELECT * FROM " . TBL_USERS;
         $result = mysql_query($q, $this->connection);
         $this->num_members = mysql_numrows($result);
      }
      return $this->num_members;
   } // getNumMembers

   /**
    * Finds out how many active users are viewing site and
    * sets class variable accordingly.
    */
   function calcNumActiveUsers(){
      $q = "SELECT * FROM " . TBL_ACTIVE_USERS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_users = mysql_numrows($result);
   } // calcNumActiveUsers

   /**
    * Finds out how many active guests are viewing site
    * and sets class variable accordingly.
    */
   function calcNumActiveGuests() {
      $q = "SELECT * FROM " . TBL_ACTIVE_GUESTS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_guests = mysql_numrows($result);
   } // calcNumActiveGuests

   /**
    * Updates username's last active timestamp in the
    * database, and also adds him to the table of
    * active users, or updates timestamp if already there.
    *
    * @param string $username
    * @param datetime $time
    */
   function addActiveUser($username, $time) {
      $q = "UPDATE " . TBL_USERS . " SET timestamp = '$time' WHERE username = '$username'";
      mysql_query($q, $this->connection);

      if (!TRACK_VISITORS) return;
      $q = "REPLACE INTO " . TBL_ACTIVE_USERS . " VALUES ('$username', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   } // addActiveUser

   /**
    * Activate a previously created user.
    *
    * @param string $email
    */
   function activateUser($email) {
      $q = "UPDATE " . TBL_USERS . " SET active = '1' WHERE email = '$email'";
      mysql_query($q, $this->connection);
   } // activateUser

   /**
	* Adds guest to active guests table
	*
	* @param string ip
	* @param datetime time
	*/
   function addActiveGuest($ip, $time) {
      if (!TRACK_VISITORS) return;
      $q = "REPLACE INTO " . TBL_ACTIVE_GUESTS . " VALUES ('$ip', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   } // addActiveGuest

   /**
    * Updates the views field for an article
    *
    * @param string $artid
    * @return unknown
    */
   function updateArticleViews($artid) {
       $q = "SELECT views FROM " . TBL_ARTICLES . " where id = " . $artid;
       $result = mysql_query($q, $this->connection);
       $row = mysql_fetch_row($result);
       $num_views = $row[0];
       $num_views++;
       $q = "UPDATE " . TBL_ARTICLES . " SET views =  " . $num_views
           . " where id = " . $artid;
       return mysql_query($q, $this->connection);
   } // updateArticleViews

   /**
    * Removes an active user.
    *
    * @param string $username
    */
   function removeActiveUser($username) {
      if (!TRACK_VISITORS) return;
      $q = "DELETE FROM " . TBL_ACTIVE_USERS . " WHERE username = '$username'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   } // removeActiveUser

   /**
    * Removes an active guest.
    *
    * @param string $ip
    */
   function removeActiveGuest($ip) {
      if (!TRACK_VISITORS) return;
      $q = "DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE ip = '$ip'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   } // removeActiveGuest

   /**
    * Removes all inactive users.
    */
   function removeInactiveUsers() {
      if (!TRACK_VISITORS) return;
      $timeout = time() - USER_TIMEOUT*60;
      $q = "DELETE FROM " . TBL_ACTIVE_USERS . " WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   } // removeInactiveUsers

   /**
    * Removes all inactive guests.
    *
    */
   function removeInactiveGuests() {
      if (!TRACK_VISITORS) return;
      $timeout = time() - GUEST_TIMEOUT*60;
      $q = "DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   } // removeInactiveGuests

   /**
    * Performs the given query on the database and
    * returns the result.
    *
    * @param string $query
    * @return false, true or a resource identifier.
    */
   function query($query){
      return mysql_query($query, $this->connection);
   }
      
   function getArticles($state) {
   		$sql = "SELECT id, title, posted_by, DATE_FORMAT(date_posted, \"%M %D, %Y\")" .
    		" as newdate, summary from " . TBL_ARTICLES . " where state = "
			. $state . " ORDER BY date_posted DESC;";
		return $con->query($sql);		
   }
   
};

// create database connection
$database = new MySQLDB;

?>
