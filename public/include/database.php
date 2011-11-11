<?php

/*
 * Copyright 2007-2009 Kevin A. Lee
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

include_once("constants.inc");

/**
 * Class for simplifying database access.
 *
 * @author Kevin A. Lee
 * @email kevin.lee@buildmeister.com
 */
class MySQLDB {
	var $connection;		// the MySQL database connection
	var $num_active_users;  // number of active users viewing site
	var $num_active_guests; // number of active guests viewing site
	var $num_members;       // number of signed-up users

	/**
	 * Class constructor.
	 */
	function __construct() {
		// connect to database
		$this->connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);		
		if (mysqli_connect_errno()) {
			die("Database connect failed: " . mysqli_connect_error() . "\n");
		}

		// only query database to find out number of members
		// when getNumMembers() is called for the first time,
		// until then, default value set.
		$this->num_members = -1;

		if (TRACK_VISITORS) {
			// calculate number of users at site
			$this->calcNumActiveUsers();
			// calculate number of guests at site
			$this->calcNumActiveGuests();
		}
	} // __construct

	/**
	 * Class destructor.
	 */
	function __destruct() {
		$this->connection->close();
	} // __destruct

	/**
	 * Get the current database connection.
	 *
	 * @return database connection
	 */
	function getConnection() {
		return $this->connection;
	} // getConnection
	
	/**
	 * Cleans a string to ensure it is suitable for database queries.
	 *
	 * @param string $string
	 * @return unknown
	 */
	function clean_data($string) {
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		// encode the string
		return mysqli_real_escape_string($this->connection, $string);
	} // clean_data

	/**
	 * Cleans a html string to ensure it is suitable for database queries.
	 *
	 * @param string $string
	 * @return unknown
	 */
	function clean_html_data($string) {
		if (get_magic_quotes_gpc()) {
			$string = htmlspecialchars(stripslashes($string));
		} else {
			$string = htmlspecialchars($string);
		}
		// encode the string
		return mysqli_real_escape_string($this->connection, $string);
	} // clean_html_data

	/**
	 * Get information about the site
	 *
	 * @return the result array with all information. 
	 * If query fails, NULL is returned.
	 */
	function getSiteInfo() {
		$sql = "SELECT * FROM " . TBL_SITE;
		$result = mysqli_query($this->connection, $sql);
		// error occurred
		if (!$result || (mysqli_num_rows($result) < 1)) {
			return NULL;
		}
		// return result array
		$dbarray = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $dbarray;
	} // getSiteInfo
	
	/**
	 * Updates a field in the site table.
	 *
	 * @param string $field
	 * @param string $value
	 * @return true on success, false otherwise.
	 */
	function updateSiteField($field, $value) {
		$sql = "UPDATE " . TBL_SITE . " SET " . $field
			. " = '$value'";
		if (mysqli_query($this->connection, $sql)) {
			return true;
		} else {
			return false;
		}
	} // updateSiteField
	
	/**
	 * Checks whether or not the given username is in the database,
	 * and if so validates the supplied password.
	 *
	 * @param string $username
	 * @param string $password
	 * @return If the user doesn't exist or if the passwords don't match up,
	 * it returns an error code (1 or 2). On success it returns 0.
	 */
	function confirmUserPass($username, $password) {
		// verify that user is in database
		$sql = "SELECT password FROM " . TBL_USERS
		. " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return 1; // indicates username failure
		}

		// retrieve password from result, strip slashes
		$dbarray = mysqli_fetch_array($result);
		$dbarray['password'] = stripslashes($dbarray['password']);
		$password = stripslashes($password);

		// validate that password is correct
		if (strcmp($password,$dbarray['password']) == 0) {
			mysqli_free_result($result);
			return 0; // success! username and password confirmed
		} else {
			mysqli_free_result($result);
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
		// verify that user is in database
		$sql = "SELECT userid FROM " . TBL_USERS
		. " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return 1; // indicates username failure
		}

		// retrieve userid from result, strip slashes
		$dbarray = mysqli_fetch_array($result);
		$dbarray['userid'] = stripslashes($dbarray['userid']);
		$userid = stripslashes($userid);

		// validate that userid is correct
		if (strcmp($userid, $dbarray['userid']) == 0) {
			mysqli_free_result($result);
			return 0; // success! username and userid confirmed
		} else {
			mysqli_free_result($result);
			return 2; // indicates userid invalid
		}
	} // confirmUserID

	/**
	 * Checks whether the given user has been activated.
	 *
	 * @param string $username
	 * @return If the user doesn't exist or is inactive
	 * returns 0 otherwise returns 1.
	 */
	function confirmUserActive($username){
		// verify that user is in database
		$sql = "SELECT active FROM " . TBL_USERS
		. " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return 2; // indicates username failure
		}

		// retrieve active status from result, strip slashes
		$dbarray = mysqli_fetch_array($result);
		$dbarray['active'] = stripslashes($dbarray['active']);

		// validate that user is active
		if ($dbarray['active'] == '1') {
			mysqli_free_result($result);
			return 1; // success user is active
		} else {
			mysqli_free_result($result);
			return 0; // user is inactive
		}
	} // confirmUserActive

	/**
	 * Checks whether the given email is inactive.
	 *
	 * @param string $email
	 * @return If the email doesn't exist or is inactive
	 * returns 1 otherwise returns 0.
	 */
	function confirmUserInactive($email) {
		// verify that user is in database
		$sql = "SELECT active FROM " . TBL_USERS
		. " WHERE email = '$email'";
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return 2; // indicates email failure
		}

		// retrieve active status from result, strip slashes
		$dbarray = mysqli_fetch_array($result);
		$dbarray['active'] = stripslashes($dbarray['active']);

		// validate that user is inactive
		if ($dbarray['active'] == '0') {
			mysqli_free_result($result);
			return 1;
		} else {
			mysqli_free_result($result);
			return 0;
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
		$sql = "SELECT username FROM " . TBL_USERS
		. " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		if (mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		} else {
			mysqli_free_result($result);
			return false;
		}
	} // usernameTaken
	
	/**
	 * Checks whether the specified email is already taken.
	 *
	 * @param string $email
	 * @return true if the email has been taken, otherwise
	 * false.
	 */
	function emailTaken($email){
		$sql = "SELECT email FROM " . TBL_USERS
		. " WHERE email = '$email'";
		$result = mysqli_query($this->connection, $sql);
		if (mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		} else {
			mysqli_free_result($result);
			return false;
		}
	} // emailTaken

	/**
	 * Checks whether the specified username has been
	 * banned by the administrator.
	 *
	 * @param string $username
	 * @return true if the username has been banned,
	 * otherwise false.
	 */
	function usernameBanned($username) {
		$sql = "SELECT username FROM " . TBL_BANNED_USERS
		. " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		if (mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		} else {
			mysqli_free_result($result);
			return false;
		}
	} // usernameBanned

	/**
	 * Checks whether a user exists
	 *
	 * @param string $username
	 * @return true on success, false otherwise.
	 */
	function userExists($username) {
		$sql = "SELECT active FROM " . TBL_USERS
		. " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		if (mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		} else {
			mysqli_free_result($result);
			return false;
		}
	} // userExists

	/**
	 * Inserts the given user into the database.
	 * By default the user is inactive.
	 *
	 * @param string $username
	 * @param string $password
	 * @param string $email
	 * @param string $website
	 * @param string $verifystring
	 * @param int $mailok
	 * @return true on success, false otherwise.
	 */
	function addNewUser($username, $password, $firstname, $lastname, $email,
	$website, $verifystring, $mailok) {
		$time = time();			// current time
		$ulevel = USER_LEVEL;	// default user level

		$sql = "INSERT INTO " . TBL_USERS
		. " VALUES ('$username', '$password', '$firstname', '$lastname',
		'0', $ulevel, '$email', '$website', $time, $mailok, '$verifystring', 0)";
		$result = mysqli_query($this->connection, $sql);
		if ($result) {
			return true;
		} else {
			return false;
		}
	} // addNewUser

	/**
	 * Delete a user from the database.
	 *
	 * @param string $username
	 * @return true on success, false otherwise.
	 */
	function deleteUser($username) {
		$sql = "DELETE FROM " . TBL_USERS . " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		if (mysqli_query($this->connection, $sql)) {
			return true;
		} else {
			return false;
		}
	} // deleteUser

	/**
	 * Updates a field in the user's row.
	 *
	 * @param string $username
	 * @param string $field
	 * @param string $value
	 * @return true on success, false otherwise.
	 */
	function updateUserField($username, $field, $value) {
		$sql = "UPDATE " . TBL_USERS . " SET " . $field
		. " = '$value' WHERE username = '$username'";
		if (mysqli_query($this->connection, $sql)) {
			return true;
		} else {
			return false;
		}
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
		$sql = "SELECT * FROM " . TBL_USERS
		. " WHERE username = '$username'";
		$result = mysqli_query($this->connection, $sql);
		// error occurred, return given name by default
		if (!$result || (mysqli_num_rows($result) < 1)) {
			return NULL;
		}
		// return result array
		$dbarray = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $dbarray;
	} // getUserInfo
	
	/**
	 * Gets all the information for a specific email address.
	 *
	 * @param string $email
	 * @return the result array with all information stored
	 * regarding the given username. If query fails, NULL
	 * is returned.
	 */
	function getUserInfoByEmail($email) {
		$sql = "SELECT * FROM " . TBL_USERS
		. " WHERE email = '$email'";
		$result = mysqli_query($this->connection, $sql);
		// error occurred, return given name by default
		if (!$result || (mysqli_num_rows($result) < 1)) {
			return NULL;
		}
		// return result array
		$dbarray = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
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
			$sql = "SELECT * FROM " . TBL_USERS;
			$result = mysqli_query($this->connection, $sql);
			$this->num_members = mysqli_num_rows($result);
			mysqli_free_result($result);
		}
		return $this->num_members;
	} // getNumMembers

	/**
	 * Finds out how many active users are viewing site and
	 * sets class variable accordingly.
	 */
	function calcNumActiveUsers(){
		$sql = "SELECT * FROM " . TBL_ACTIVE_USERS;
		$result = mysqli_query($this->connection, $sql);
		$this->num_active_users = mysqli_num_rows($result);
		mysqli_free_result($result);
	} // calcNumActiveUsers

	/**
	 * Finds out how many active guests are viewing site
	 * and sets class variable accordingly.
	 */
	function calcNumActiveGuests() {
		$sql = "SELECT * FROM " . TBL_ACTIVE_GUESTS;
		$result = mysqli_query($this->connection, $sql);
		$this->num_active_guests = mysqli_num_rows($result);
		mysqli_free_result($result);
	} // calcNumActiveGuests

	/**
	 * Updates username's last active timestamp in the
	 * database, and also adds him/her to the table of
	 * active users, or updates timestamp if already there.
	 *
	 * @param string $username
	 * @param datetime $time
	 */
	function addActiveUser($username, $time) {
		$sql = "UPDATE " . TBL_USERS
		. " SET timestamp = '$time' WHERE username = '$username'";
		mysqli_query($this->connection, $sql);

		if (!TRACK_VISITORS) return;
		$sql = "REPLACE INTO " . TBL_ACTIVE_USERS
		. " VALUES ('$username', '$time')";
		mysqli_query($this->connection, $sql);
		$this->calcNumActiveUsers();
	} // addActiveUser

	/**
	 * Confirms that the user has supplied the correct verification string.
	 *
	 * @param string $email
	 * @return true on success, false otherwise.
	 */
	function confirmVerifyString($email, $verifystring) {
		$sql = "SELECT active FROM " . TBL_USERS
		. " WHERE email = '$email' AND verifystring = '$verifystring'";
		$result = mysqli_query($this->connection, $sql);
		if ($result) {
			mysqli_free_result($result);
			return true;
		} else {
			mysqli_free_result($result);
			return false;
		}
	} // confirmVerifyString

	/**
	 * Activate a previously created user.
	 *
	 * @param string $email
	 */
	function activateUser($email) {
		$sql = "UPDATE " . TBL_USERS
		. " SET active = '1' WHERE email = '$email'";
		mysqli_query($this->connection, $sql);
	} // activateUser

	/**
	 * Adds guest to active guests table
	 *
	 * @param string ip
	 * @param datetime time
	 */
	function addActiveGuest($ip, $time) {
		if (!TRACK_VISITORS) return;
		$sql = "REPLACE INTO " . TBL_ACTIVE_GUESTS
		. " VALUES ('$ip', '$time')";
		mysqli_query($this->connection, $sql);
		$this->calcNumActiveGuests();
	} // addActiveGuest

	/**
	 * Removes an active user.
	 *
	 * @param string $username
	 */
	function removeActiveUser($username) {
		if (!TRACK_VISITORS) return;
		$sql = "DELETE FROM " . TBL_ACTIVE_USERS
		. " WHERE username = '$username'";
		mysqli_query($this->connection, $sql);
		$this->calcNumActiveUsers();
	} // removeActiveUser

	/**
	 * Removes an active guest.
	 *
	 * @param string $ip
	 */
	function removeActiveGuest($ip) {
		if (!TRACK_VISITORS) return;
		$sql = "DELETE FROM " . TBL_ACTIVE_GUESTS
		. " WHERE ip = '$ip'";
		mysqli_query($this->connection, $sql);
		$this->calcNumActiveGuests();
	} // removeActiveGuest

	/**
	 * Removes all inactive users.
	 */
	function removeInactiveUsers() {
		if (!TRACK_VISITORS) return;
		$timeout = time() - USER_TIMEOUT * 60;
		$sql = "DELETE FROM " . TBL_ACTIVE_USERS
		. " WHERE timestamp < $timeout";
		mysqli_query($this->connection, $sql);
		$this->calcNumActiveUsers();
	} // removeInactiveUsers

	/**
	 * Removes all inactive guests.
	 */
	function removeInactiveGuests() {
		if (!TRACK_VISITORS) return;
		$timeout = time() - GUEST_TIMEOUT * 60;
		$sql = "DELETE FROM " . TBL_ACTIVE_GUESTS
		. " WHERE timestamp < $timeout";
		mysqli_query($this->connection, $sql);
		$this->calcNumActiveGuests();
	} // removeInactiveGuests
	
	/**
	 * Get the name of a user level
	 *
	 * @param integer $ulid
	 * @return level name else NULL
	 */
	function getUserLevelName($ulid) {
		$retval = NULL;
		// select state
		$sql = "SELECT name FROM " . TBL_LEVELS . " WHERE id = '$ulid'";
		if ($result = mysqli_query($this->connection, $sql)) {
			$row = mysqli_fetch_row($result);
			$retval = $row['0'];
			mysqli_free_result($result);
		}
		return $retval;
	} // getUserLevelName	

	/**
	 * Adds a new article into the database.
	 * By default the article is inactive.
	 *
	 * @param string $title
	 * @param string $summary
	 * @param string $category
	 * @param string $date
	 * @param string $author
	 * @param string $content
	 * @return true on success, false otherwise.
	 */
	function addNewArticle($title, $summary, $category, $author, $content) {
		$retval = true;
		// add article into database
		$sql = "INSERT INTO " . TBL_ARTICLES
		. " (date_posted, summary, title, content, posted_by, state)"
		. " VALUES (now(), '$summary', '$title', '$content', '$author', 1)";
		if (!mysqli_query($this->connection, $sql)) {
			$retval = false;
		} else {
			$artid = mysqli_insert_id($this->connection);
			if ($category) {
				foreach ($category as $catid) {
					$sql = "INSERT INTO " . TBL_ARTICLE_CATEGORIES . " (article_id, cat_id)"
					. " VALUES ('$artid', '$catid')";
					if (!mysqli_query($this->connection, $sql)) {
						$retval = false;
						break;
					}
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
		$sql = "SELECT id FROM " . TBL_ARTICLES
		. " WHERE id = '$artid'";
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return false;
		} else {
			mysqli_free_result($result);
			return true;
		}
	} // articleExists

	/**
	 * Checks whether an article has been published
	 *
	 * @param integer $artid
	 * @return true on success, false otherwise.
	 */
	function articlePublished($artid) {
		$sql = "SELECT id FROM " . TBL_ARTICLES
		. " WHERE id = '$artid' AND state = "
		. PUBLISHED_STATE;
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return false;
		} else {
			mysqli_free_result($result);
			return true;
		}
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
		if ($result = mysqli_query($this->connection, $sql)) {
			$row = mysqli_fetch_row($result);
			$retval = $row['0'];
			mysqli_free_result($result);
		}
		return $retval;
	} // getArticleTitle
	
	/**
	 * Get the id of an article by title
	 *
	 * @param string $atitle
	 * @return article title else NULL
	 */
	function getArticleIdByTitle($atitle) {
		$retval = NULL;
		// select id
		$sql = "SELECT id FROM " . TBL_ARTICLES . " WHERE title = '$atitle'";
		if ($result = mysqli_query($this->connection, $sql)) {
			$row = mysqli_fetch_row($result);
			$retval = $row['0'];
			mysqli_free_result($result);
		}
		return $retval;
	} // getArticleIdByTitle
	
	/**
	 * Get the summary of an article
	 *
	 * @param integer $artid
	 * @return article summary else NULL
	 */
	function getArticleSummary($artid) {
		$retval = NULL;
		// select article
		$sql = "SELECT summary FROM " . TBL_ARTICLES . " WHERE id = '$artid'";
		if ($result = mysqli_query($this->connection, $sql)) {
			$row = mysqli_fetch_row($result);
			$retval = $row['0'];
			mysqli_free_result($result);
		}
		return $retval;
	} // getArticleSummary
	
	/**
	 * Get the categories of an article
	 *
	 * @param integer $artid
	 * @return article categories else NULL
	 */
	function getArticleCategories($artid) {
		$retval = NULL;
		// get categories for article
		$sql = "SELECT a.cat_id, c.name FROM " . TBL_ARTICLE_CATEGORIES . " a, " 
			. TBL_CATEGORIES . " c WHERE a.article_id = " . $artid 
			. " AND a.cat_id = c.id;";
		if ($result = mysqli_query($this->connection, $sql)) {
			while ($row = mysqli_fetch_assoc($result)) {
	    		$retval = $retval . $row['name'] . " ";
			}
   			// free result set
    		mysqli_free_result($result);
		}
		return $retval;
	} 
	
	/**
	 * Get the name of an article state
	 *
	 * @param integer $sid
	 * @return state name else NULL
	 */
	function getArticleStateName($sid) {
		$retval = NULL;
		// select state
		$sql = "SELECT name FROM " . TBL_STATES . " WHERE id = '$sid'";
		if ($result = mysqli_query($this->connection, $sql)) {
			$row = mysqli_fetch_row($result);
			$retval = $row['0'];
			mysqli_free_result($result);
		}
		return $retval;
	} // getArticleStateName
	
	/**
	 * Get the id of an article state
	 *
	 * @param string $state
	 * @return state id else NULL
	 */
	function getArticleStateId($state) {
		$retval = NULL;
		// select state
		$sql = "SELECT id FROM " . TBL_STATES . " WHERE name = '$state'";
		if ($result = mysqli_query($this->connection, $sql)) {
			$row = mysqli_fetch_row($result);
			$retval = $row['0'];
			mysqli_free_result($result);
		}
		return $retval;
	} // getArticleStateId

	/**
	 * Flatten the title of the article
	 *
	 * @param string $title
	 * @return flattened title else NULL
	 */
	function flattenArticleTitle($title) {
		$retval = NULL;
		$retval = strtolower(str_replace(" ", "_", $title));
		return $retval;
	} // getArticleStateId
		
	/**
	 * Updates an article in the database.
	 * By default the article remains active.
	 *
	 * @param string $id
	 * @param string $title
	 * @param string $summary
	 * @param string $category
	 * @param string $date
	 * @param integer $state
	 * @param string $author
	 * @param string $text
	 * @return true on success, false otherwise.
	 */
	function updateArticle($artid, $title, $summary, $category, $date,
	$state, $author, $text) {		
		$retval = true;

		// TODO: turn state into number
		// update article
		$sql = "UPDATE " . TBL_ARTICLES . " SET date_posted = STR_TO_DATE('$date','%d-%m-%Y'), "
		. "date_updated = now(), "
		. "title = '$title', summary = '$summary', content = '$text', state = '$state', "
		. "posted_by = '$author' WHERE id = '$artid'";
		if (!mysqli_query($this->connection, $sql)) {
			$retval = false;
		} else {
			// update categories
			// delete existing references to category
			$sql = "DELETE FROM " . TBL_ARTICLE_CATEGORIES
			. " WHERE article_id = '$artid'";
			if (!mysqli_query($this->connection, $sql)) {
				$retval = false;
				break;
			} else {
				// add again
				if ($category) {
					foreach ($category as $catid) {
						$sql = "INSERT INTO " . TBL_ARTICLE_CATEGORIES . " (article_id, cat_id)"
						. " VALUES ('$artid', '$catid')";
						if (!mysqli_query($this->connection, $sql)) {
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
		$sql = "DELETE FROM " . TBL_ARTICLES . " WHERE id = '$artid'";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // deleteArticle

	/**
	 * Updates the views field for an article
	 *
	 * @param string $artid
	 * @return true on success, false otherwise.
	 */
	function updateArticleViews($artid) {
		$sql = "SELECT views FROM " . TBL_ARTICLES . " where id = " . $artid;
		if ($result = mysqli_query($this->connection, $sql)) {
			$row = mysqli_fetch_row($result);
			$num_views = $row[0];
			$num_views++;
			mysqli_free_result($result);
			$sql = "UPDATE " . TBL_ARTICLES . " SET views =  " . $num_views
			. " where id = " . $artid;
			if (!mysqli_query($this->connection, $sql)) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	} // updateArticleViews

	/**
	 * Adds a new article comment into the database.
	 * By default the comment is inactive.
	 *
	 * @param string $username
	 * @param string $artid
	 * @param string $comment
	 * @return true on success, false otherwise.
	 */
	function addNewArticleComment($username, $website, $artid, $comment) {
		$sql = "INSERT INTO " . TBL_ARTCOM
		. " (date_posted, posted_by, website, art_id, comment, state)"
		. " VALUES (now(), '$username', '$website', '$artid', '$comment', 1)";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // addNewArticleComment

	/**
	 * Checks whether an article comment exists
	 *
	 * @param integer $comid
	 * @return true on success, false otherwise.
	 */
	function articleCommentExists($comid) {
		$sql = "SELECT id FROM " . TBL_ARTCOM . " WHERE id = '$comid'";
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return false;
		} else {
			mysqli_free_result($result);
			return true;
		}
	} // articleCommentExists
	
	/**
	 * Updates an article comment in the database.
	 *
	 * @param string $id
	 * @param string $comment
	 * @param string $state
	 * @return true on success, false otherwise.
	 */
	function updateArticleComment($id, $comment, $state) {		
		$sql = "UPDATE " . TBL_ARTCOM . " SET comment = '$comment', "
			. "state = '$state' WHERE id = '$id'";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // updateArticleComment
	
	/**
	 * Delete an article comment from the database.
	 *
	 * @param integer $comid
	 * @return true on success, false otherwise.
	 */
	function deleteArticleComment($comid) {
		$sql = "DELETE FROM " . TBL_ARTCOM . " WHERE id = '$comid'";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // deleteArticleComment
	
	/**
	 * Adds a new article category into the database.
	 *
	 * @param string $name
	 * @return true on success, false otherwise.
	 */
	function addNewArticleCategory($name) {
		$sql = "INSERT INTO " . TBL_CATEGORIES . " (name) VALUES ('$name')";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // addNewArticleCategory
	
	/**
	 * Checks whether an article category exists
	 *
	 * @param integer $id
	 * @return true on success, false otherwise.
	 */
	function articleCategoryExists($id) {
		$sql = "SELECT id FROM " . TBL_CATEGORIES . " WHERE id = '$id'";
		$result = mysqli_query($this->connection, $sql);
		if (!$result || (mysqli_num_rows($result) < 1)) {
			mysqli_free_result($result);
			return false;
		} else {
			mysqli_free_result($result);
			return true;
		}
	} // articleCategoryExists
	
	/**
	 * Updates an article category in the database.
	 *
	 * @param string $id
	 * @param string $name
	 * @return true on success, false otherwise.
	 */
	function updateArticleCategory($id, $name) {		
		$sql = "UPDATE " . TBL_CATEGORIES . " SET name = '$name' "
			. "WHERE id = '$id'";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // updateArticleCategory
	
	/**
	 * Delete an article category from the database.
	 *
	 * @param integer $id
	 * @return true on success, false otherwise.
	 */
	function deleteArticleCategory($id) {
		$sql = "DELETE FROM " . TBL_CATEGORIES . " WHERE id = '$id'";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			$sql = "DELETE FROM " . TBL_ARTICLE_CATEGORIES . " WHERE cat_id = '$id'";
			if (!mysqli_query($this->connection, $sql)) {
				return false;
			} else {
				return true;
			}
		}
	} // deleteArticleCategory

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
		$sql = "INSERT INTO " . TBL_GLOSSARY
		. " (posted_by, title, summary)"
		. " VALUES ('$username', '$glosstitle', '$glosssummary')";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
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
		$sql = "INSERT INTO " . TBL_LINKS
		. " (date_posted, posted_by, title, summary, url)"
		. " VALUES (now(), '$username', '$linktitle', '$linksummary', '$linkurl')";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // addNewLinkItem

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
		$sql = "INSERT INTO " . TBL_GLOSSCOM
		. " (date_posted, posted_by, gloss_id, comment)"
		. " VALUES (now(), '$username', '$glossid', '$comment')";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
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
		$sql = "INSERT INTO "
		. TBL_TIPCOM . " (date_posted, posted_by, tip_id, comment)"
		. " VALUES (now(), '$username', '$tipid', '$comment')";
		if (!mysqli_query($this->connection, $sql)) {
			return false;
		} else {
			return true;
		}
	} // addNewTipComment

	/**
	 * Performs the given query on the database and
	 * returns the result.
	 *
	 * @param string $query
	 * @return false, true or a resource identifier.
	 */
	function query($query){
		return mysqli_query($this->connection, $query);
	}

};

// create database connection
$database = new MySQLDB;

?>
