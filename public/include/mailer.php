<?php 

/*
 * Copyright 2007-2011 Kevin A. Lee
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
 * Support class for sending formatted emails.
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
	 * @param string $verifyemail - the user's encoded email to be sent
	 * @param string $verifystring - a verification string to be sent
	 * @return true if email sent successfully, else false
     *  
     */
	function sendVerification($user, $email, $verifyemail, $verifystring) {
		/*global $_RESULT;
   	   		
		$m = new MAIL;

		// try and connect to mail server
		if (!($c = $m->Connect(SMTP_SERVER, 25, SMTP_USERNAME, SMTP_PASSWORD))) {
			$this->error_message = $_RESULT;
			return false;
		} else {
			// format the message
			$f = $m->From(EMAIL_FROM_ADDR, EMAIL_FROM_NAME);
			$t = $m->AddTo($email, $user);
			$s = $m->Subject('[' . SITE_NAME . '] registration');
			$m->Html("Hello " . $user . ", <br><br>"
             . "Please click on the following link to verify your new account at ."
             . SITE_NAME . ": <br><br>"
             . SITE_BASEDIR . "/pages/users/verify.php" . "?email=" . $verifyemail 
             . "&verify=" . $verifystring);
						
			// send mail
			if (!$m->Send($c)) {
				$this->error_message = $_RESULT;
				return false;
			}
			return true;
		}*/
        $headers = 'From: ' . EMAIL_FROM_NAME . '<' . EMAIL_FROM_ADDR . '>' . "\r\n";
        $headers .= 'Return-Path: <' . EMAIL_FROM_ADDR . '>' . "\r\n";
        $headers .= 'MIME-Version 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = '[' . SITE_NAME . '] registration';
        $message = "Hello " . $user . ", <br><br>"
             . "Please click on the following link to verify your new account at ."
             . SITE_NAME . ": <br><br>"
             . SITE_BASEDIR . "/pages/users/verify.php" . "?email=" . $verifyemail
             . "&verify=" . $verifystring;

        if (mail($email, $subject, $message, $headers))
            return true;
        else
            return false;
        
   } // sendVerification
   
   /**
    * Send a notification message to all interested users.
    *
    * @param string $message - message to be setn
    * @return true if email sent successfully, else false (the class variable 
    * $error_message will be set with the error code and text)
    */
   function sendNotification($message) {
      	
        /*global $_RESULT;
   	   		
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
		} */

        $headers = 'From: ' . EMAIL_FROM_NAME . '<' . EMAIL_FROM_ADDR . '>' . "\r\n";
        $headers .= 'Return-Path: <' . EMAIL_FROM_ADDR . '>' . "\r\n";
        $headers .= 'MIME-Version 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = '[' . SITE_NAME . '] notification';

        if (mail(EMAIL_NOTIFY_ADDR, $subject, $message, $headers))
            return true;
        else
            return false;
   } // sendNotification
   
   /**
    * Send a contact message to the site owner.
    *
    * @param string $message - message to be setn
    * @return true if email sent successfully, else false (the class variable 
    * $error_message will be set with the error code and text)
    */
   function sendContact($name, $emailFrom, $message) {
      	
        /*global $_RESULT;
   	   		
		$m = new MAIL;

		// try and connect to mail server
		if (!($c = $m->Connect(SMTP_SERVER, 25, SMTP_USERNAME, SMTP_PASSWORD))) {
			$this->error_message = $_RESULT;
			return false;
		} else {
			// format the message
			$f = $m->From($emailFrom, $name);
			$t = $m->AddTo($emailTo, $user);
			$s = $m->Subject('[' . SITE_NAME . '] contact message');
			$m->Html("New contact message by " . $name 
				. " (" . $emailFrom . ")" . ":\n\n" . $message);
						
			// send mail
			if (!$m->Send($c)) {
				$this->error_message = $_RESULT;
				return false;
			}
			return true;
		} */

        $headers = 'From: ' . $name . '<' . $emailFrom . '>' . "\r\n";
        $headers .= 'Return-Path: <' . $emailFrom . '>' . "\r\n";
        $headers .= 'MIME-Version 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = '[' . SITE_NAME . '] contact message';

        if (mail(EMAIL_NOTIFY_ADDR, $subject, $message, $headers))
            return true;
        else
            return false;
   } // sendContact
   
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
   		/*global $_RESULT;
   	   		
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
		} */

        $headers = 'From: ' . EMAIL_FROM_NAME . '<' . EMAIL_FROM_ADDR . '>' . "\r\n";
        $headers .= 'Return-Path: <' . EMAIL_FROM_ADDR . '>' . "\r\n";
        $headers .= 'MIME-Version 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = '[' . SITE_NAME . '] your new password';
        $message = "Hello " . $user . ",<br/><br/>"
				. "At your request, we've generated a new password for you."
             	. "You can now use the following username and password "
             	. "to log in to " . SITE_NAME . ":<br/><br/>"
                . "<blockquote>"
             	. "Username: " . $user . "<br/>"
             	. "Password: " . $pass . "<br/><br/>"
                . "</blockquote>"
             	. "It is recommended that you change your password "
             	. "to something easier to remember. You can "
             	. "do this from your account page immediately after "
             	. "logging in.<br/><br/>";

        if (mail($email, $subject, $message, $headers))
            return true;
        else
            return false;
   } // sendNewPass
   
};

// initialize mailer object
$mailer = new Mailer;
 
?>
