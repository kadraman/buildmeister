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

require("XPertMailer/MAIL.php");
include_once("constants.php");

error_reporting(E_ALL); // report all errors

/**
 * Support class for sendind formatted emails .
 *
 * @author Kevin A. Lee
 * @email kevin.lee@buildmeister.com
 */
class Mailer {
	
	var $error_message;		// a description of the error for any failures
		
   /**
    * Sends a welcome message to a newly registered user, 
    * supplying the username and password.
    * 
    * @param string $user - the user's username
    * @param string $email - the user's email
    * @param string $pass - the user's password
    * @param string $verifystring - a verification string to be used
    * @return true if email sent successfully, else false (the class variable 
    * $error_message will be set with the error code and text)
    *  
    */
   function sendVerification($user, $email, $pass, $verifystring) {
      $from = "From: ". EMAIL_FROM_NAME . " <" . EMAIL_FROM_ADDR . ">";
      $subject = "\"" . SITE_NAME . "\" Registration";
      $body = "Hello " . $user . ",\n\n"
             . "Please click on the following link to verify your new account:\n\n"
             . SITE_BASEDIR . "/pages/users/verify.php" . "?email=" . $email . "&verify=" . $verifystring
             . "\n\nThe Buildmeister\n";
             
      return mail($email, $subject, $body, $from);
   } // sendVerification
   
   /**
    * Send a notification message to all interested users.
    *
    * @param string $message - message to be setn
    * @return true if email sent successfully, else false (the class variable 
    * $error_message will be set with the error code and text)
    */
   function sendNotification($message) {
   		// TODO: get users who wish to be notified            
      	$email = "kevin.lee@buildmeister.com";
      	$user  = "kevin";
      	
        global $_RESULT;
   	   		
		$m = new MAIL;

		// try and connect to mail server
		if (!($c = $m->Connect(SMTP_SERVER, 25, SMTP_USERNAME, SMTP_PASSWORD))) {
			$this->error_message = $_RESULT;
			return false;
		} else {
			// format the message
			$f = $m->From(EMAIL_FROM_ADDR, EMAIL_FROM_NAME);
			$t = $m->AddTo($email, $user);
			$s = $m->Subject('[' . SITE_NAME . '] notification');
			$m->Html($message);
						
			// send mail
			if (!$m->Send($c)) {
				$this->error_message = $_RESULT;
				return false;
			}
			return true;
		}    	
   } // sendNotification
   
   /**
    * Sends the newly generated password to the user's email address 
    * that was specified at registration.
    * 
    * @param string $user - the user's username
    * @param string $email - the user's email
    * @param string $pass - the user's new password
    * @return true if email sent successfully, else false (the class variable 
    * $error_message will be set with the error code and text)   
    * 
    */
   function sendNewPass($user, $email, $pass) {
   		global $_RESULT;
   	   		
		$m = new MAIL;

		// try and connect to mail server
		if (!($c = $m->Connect(SMTP_SERVER, 25, SMTP_USERNAME, SMTP_PASSWORD))) {
			$this->error_message = $_RESULT;
			return false;
		} else {
			// format the message
			$f = $m->From(EMAIL_FROM_ADDR, EMAIL_FROM_NAME);
			$t = $m->AddTo($email, $user);
			$s = $m->Subject("[" . SITE_NAME . "] your new password");
			// TODO: HTML message support
			$m->Text($user . ",\n\n"
				. "At your request, we've generated a new password for you."
             	. "You can now use the following username and password "
             	. "to log in to " . SITE_NAME . ":\n\n"
             	. "\tUsername: " . $user . "\n"
             	. "\tPassword: " . $pass . "\n\n"
             	. "It is recommended that you change your password "
             	. "to something easier to remember. You can "
             	. "do this from your account page immediately after "
             	. "logging in.\n\n"
			);
						
			// send mail
			if (!$m->Send($c)) {
				$this->error_message = $_RESULT;
				return false;
			}
			return true;
		}    	   	
   } // sendNewPass
   
};

// initialize mailer object
$mailer = new Mailer;
 
?>
