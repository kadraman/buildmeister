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

include_once("database.php");
include_once("mailer.php");
include_once("securimage/securimage.php");

/**
 * Class to simplify keeping track of users and tasks.
 *
 * @author Kevin A. Lee
 * @email kevin.lee@buildmeister.com
 */
class Session
{
	var $username;     //Username given on sign-up
	var $userid;       //Random value generated on current login
	var $userlevel;    //The level to which the user pertains
	var $time;         //Time user was last active (page loaded)
	var $logged_in;    //True if user is logged in, false otherwise
	var $userinfo = array();  //The array holding all user info
	var $url;          //The page url current being viewed
	var $referrer;     //Last recorded site page viewed
	var $result_str;   // results string to be displayed.
	var $securimage;   // class for checking catchpas

	/**
	 * Note: referrer should really only be considered the actual
	 * page referrer in process.php, any other time it may be
	 * inaccurate.
	 */

	/* Class constructor */
	function Session(){
		$this->time = time();
		$this->startSession();
	}

	/**
	 * startSession - Performs all the actions necessary to
	 * initialize this session object. Tries to determine if the
	 * the user has logged in already, and sets the variables
	 * accordingly. Also takes advantage of this page load to
	 * update the active visitors tables.
	 */
	function startSession(){
		global $database;	// the database connection

		// is session already started?
		if(!isset($_SESSION)) {
			// start the session
			session_start();
		}

		// determine if user is logged in
		$this->logged_in = $this->checkLogin();

		// update users last active timestamp
		if ($this->logged_in){
			$database->addActiveUser($this->username, $this->time);
		}

		// remove inactive visitors from database
		$database->removeInactiveUsers();
		#$database->removeInactiveGuests();

		// set referrer page
		if(isset($_SESSION['url'])){
			$this->referrer = $_SESSION['url'];
		} else {
			$this->referrer = "/";
		}

		// set current url
		$this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
		
		// create securimage catchpa class
		$this->securimage = new Securimage();
	} // startSession

	/**
	 * checkLogin - Checks if the user has already previously
	 * logged in, and a session with the user has already been
	 * established. Also checks to see if user has been remembered.
	 * If so, the database is queried to make sure of the user's
	 * authenticity. Returns true if the user has logged in.
	 */
	function checkLogin(){
		global $database;  //The database connection
		/* Check if user has been remembered */
		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
			$this->username = $_SESSION['username'] = $_COOKIE['cookname'];
			$this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];
		}

		/* Username and userid have been set and not guest */
		if (isset($_SESSION['username']) && isset($_SESSION['userid'])) {
			/* Confirm that username and userid are valid */
			if ($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0) {
				/* Variables are incorrect, user not logged in */
				unset($_SESSION['username']);
				unset($_SESSION['userid']);
				return false;
			}

			/* User is logged in, set class variables */
			$this->userinfo  = $database->getUserInfo($_SESSION['username']);
			$this->username  = $this->userinfo['username'];
			$this->userid    = $this->userinfo['userid'];
			$this->userlevel = $this->userinfo['userlevel'];
			return true;
		}
		/* User not logged in */
		else{
			return false;
		}
	}

	/**
	 * login - The user has submitted his username and password
	 * through the login form, this function checks the authenticity
	 * of that information in the database and creates the session.
	 * Effectively logging in the user if all goes well.
	 */
	function login($subuser, $subpass, $subremember) {
		global $database;

		// checks that username is in database and password is correct */
		$subuser = stripslashes($subuser);
		$subpass = stripslashes($subpass);
		$result = $database->confirmUserPass($subuser, md5($subpass));

		// check error codes
		if ($result == 1) {
			return "INVALID_USER";
		} else if ($result == 2){
			return "INVALID_PASSWORD";
		}

		// check if user has been activated
		if ($database->confirmUserActive($subuser) == 0) {
			return "INACTIVE_USER";
		}		

		// username and password correct, register session variables 
		$this->userinfo  = $database->getUserInfo($subuser);
		$this->username  = $_SESSION['username'] = $this->userinfo['username'];
		$this->userid    = $_SESSION['userid']   = $this->generateRandID();
		$this->userlevel = $this->userinfo['userlevel'];

		// insert userid into database and update active users table
		$database->updateUserField($this->username, "userid", $this->userid);
		$database->addActiveUser($this->username, $this->time);
		#$database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

		// reflect fact that user has logged in
		$this->logged_in = true;

		// setup cookies to remember login
		if ($subremember) {
			setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
			setcookie("cookid",   $this->userid,   time()+COOKIE_EXPIRE, COOKIE_PATH);
		}
	
		// login completed sucessfuly
		return "OK";
	}

	/**
	 * logout - Gets called when the user wants to be logged out of the
	 * website. It deletes any cookies that were stored on the users
	 * computer as a result of him wanting to be remembered, and also
	 * unsets session variables and demotes his user level to guest.
	 */
	function logout(){
		global $database;  //The database connection
		/**
		 * Delete cookies - the time must be in the past,
		 * so just negate what you added when creating the
		 * cookie.
		 */
		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
			setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
			setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
		}

		/* Unset PHP session variables */
		unset($_SESSION['username']);
		unset($_SESSION['userid']);

		/* Reflect fact that user has logged out */
		$this->logged_in = false;

		/**
		 * Remove from active users table and add to
		 * active guests tables.
		 */
		$database->removeActiveUser($this->username);
		#$database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);

		/* Set user level to guest */
		#$this->username  = GUEST_NAME;
		#$this->userlevel = GUEST_LEVEL;
	}
	
	/**
	 * isAdmin - Returns true if currently logged in user is
	 * an administrator, false otherwise.
	 */
	function isAdmin(){
		return ($this->userlevel == ADMIN_LEVEL ||
		$this->username  == ADMIN_NAME);
	}

	/**
	 * generateRandID - Generates a string made up of randomized
	 * letters (lower and upper case) and digits and returns
	 * the md5 hash of it to be used as a userid.
	 */
	function generateRandID(){
		return md5($this->generateRandStr(16));
	}

	/**
	 * generateRandStr - Generates a string made up of randomized
	 * letters (lower and upper case) and digits, the length
	 * is a specified parameter.
	 */
	function generateRandStr($length){
		$randstr = "";
		for($i=0; $i<$length; $i++){
			$randnum = mt_rand(0,61);
			if($randnum < 10){
				$randstr .= chr($randnum+48);
			}else if($randnum < 36){
				$randstr .= chr($randnum+55);
			}else{
				$randstr .= chr($randnum+61);
			}
		}
		return $randstr;
	}

	/**
	 * Display a dialog box for results
	 *
	 * @param string $title
	 * @param string $text
	 * @param string $referrer
	 */
	function displayDialog($title, $text, $referrer) {
$dialog =<<<EOD
<form id="dialogForm" action="$referrer" method="post">
    <fieldset style="width:350px; margin: 0px auto">   	

		<h2>$title</h2>
		
		<p>$text</p>
 									
		<!-- buttons and ajax processing -->
		<div>					
			<input type="submit" value="OK" id="submit"/>
		</div>
		
	</fieldset>
</form>		
EOD;
		echo $dialog;
	}
};


/**
 * Initialize session object
 */
$session = new Session;

?>
