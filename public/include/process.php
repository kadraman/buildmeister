<?php
/**
 * Process.php
 *
 * The Process class is meant to simplify the task of processing
 * user submitted forms, redirecting the user to the correct
 * pages if errors are found, or if form is successful, either
 * way. Also handles the logout procedure.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
include("session.php");

class Process
{
   /* Class constructor */
   function Process(){
      global $session;
      /* User submitted login form */
      if(isset($_POST['sublogin']) && !isset($_POST['ignorelogin'])) {
         $this->procLogin();
      }
      /* User submitted registration form */
      else if(isset($_POST['subjoin'])){
         $this->procRegister();
      }
      /* User submitted forgot password form */
      else if(isset($_POST['subforgot'])){
         $this->procForgotPass();
      }
      /* User submitted edit account form */
      else if(isset($_POST['subedit'])){
         $this->procEditAccount();
      }
      // user submitting new book
      else if(isset($_POST['subbook'])) {
          $this->procSubmitBook();
      }
      // user submitting new glossary item
      else if(isset($_POST['subgloss'])) {
          $this->procSubmitGloss();
      }
      // user submitting new link item
      else if(isset($_POST['sublink'])) {
          $this->procSubmitLink();
      }
      // user submitting new article
      else if(isset($_POST['subarticle'])) {
          $this->procSubmitArticle();
      }
      // user submitting new tip
	  else if(isset($_POST['subtip'])) {
	      $this->procSubmitTip();
      }
      else if (isset($_POST['subartcom'])) {
          $this->procSubmitArticleComment();
      }
      // user submitting a comment on a glossary item
      else if (isset($_POST['subgcom'])) {
          $this->procSubmitGlossaryComment();
      }
      // user submitting a comment on a tip
	  else if (isset($_POST['subtipcom'])) {
	            $this->procSubmitTipComment();
      }
      // administrator updating an article
	  else if (isset($_POST['updateart'])) {
	            $this->procUpdateArticle();
      }
      // user sent us a message
      else if (isset($_POST['subcontact'])) {
          $this->procContactUs();
      }
      /**
       * The only other reason user should be directed here
       * is if he wants to logout, which means user is
       * logged in currently.
       */
      else if($session->logged_in){
         $this->procLogout();
      }
      /**
       * Should not get here, which means user is viewing this page
       * by mistake and therefore is redirected.
       */
       else{
          header("Location: " . SITE_BASEDIR . "/index.php");
       }
   }

   /**
    * procLogin - Processes the user submitted login form, if errors
    * are found, the user is redirected to correct the information,
    * if not, the user is effectively logged in to the system.
    */
   function procLogin(){
      global $session, $form;
      /* Login attempt */
      $retval = $session->login($_POST['user'], $_POST['pass'], isset($_POST['remember']));

      /* Login successful */
      if($retval){
         header("Location: ". $session->referrer);
      }
      /* Login failed */
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: " . $session->referrer);
      }
   }

   /**
    * procLogout - Simply attempts to log the user out of the system
    * given that there is no logout form to process.
    */
   function procLogout(){
      global $session;
      $retval = $session->logout();
      header("Location: " . SITE_BASEDIR . "/index.php");
   }

   /**
    * Processes the user submitted registration form,
    * if errors are found, the user is redirected to correct the
    * information, if not, the user is effectively registered with
    * the system and an email is (optionally) sent to the newly
    * created user.
    *
    */
   function procRegister() {
      global $session, $form;
      // convert username to all lowercase (by option)
      if (ALL_LOWERCASE){
         $_POST['reguser'] = strtolower($_POST['reguser']);
      }

      // attempt registration
      $retval = $session->register($_POST['reguser'], $_POST['regpass'],
          $_POST['regfirst'], $_POST['reglast'], $_POST['regemail'],
          $_POST['regmailok']);

      // succesful
      if ($retval == 0) {
         $_SESSION['reguname'] = $_POST['reguser'];
         $_SESSION['regsuccess'] = true;
         header("Location: ".$session->referrer);
      }
      // error with form
      else if ($retval == 1) {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      } // failed
      else if ($retval == 2) {
         $_SESSION['reguname'] = $_POST['reguser'];
         $_SESSION['regsuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procRegister

   /**
    * Submit a new book into the database.
    */
   function procSubmitBook() {
      global $session, $form;

      // submission attemp
      $retval = $session->submitBook($_POST['booktitle'], $_POST['bookauthor'], $_POST['bookurl'], $_POST['booksummary']);

      // successful
      if ($retval == 0){
         $_SESSION['booksuccess'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['booksuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procSubmitBook

   /**
    * Submit a new glossary item into the database.
    */
   function procSubmitGloss() {
      global $session, $form;

      // submission attemp
      $retval = $session->submitGlossItem($_POST['glosstitle'], $_POST['glosssummary']);

      // successful
      if ($retval == 0){
         $_SESSION['glosssuccess'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['glosssuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procSubmitGlossItem

   /**
    * Submit a new link into the database.
    */
   function procSubmitLink() {
      global $session, $form;

      // submission attemp
      $retval = $session->submitLink($_POST['linktitle'], $_POST['linkurl'], $_POST['linksummary']);

      // successful
      if ($retval == 0){
         $_SESSION['linksuccess'] = true;
         header("Location: " . SITE_BASEDIR . "/links.php");
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['linksuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procSubmitLink

   /**
    * Submit a new article into the database.
    */
   function procSubmitArticle() {
      global $session, $form;

      // submission attemp
      $retval = $session->submitArticle($_POST['articletitle'], $_POST['articlesummary'], $_POST['articlecontent']);

      // successful
      if ($retval == 0){
         $_SESSION['articlesuccess'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['articlesuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procSubmitArticle

   /**
    * Submit a new tip into the database.
    */
   function procSubmitTip() {
      global $session, $form;

      // submission attemp
      $retval = $session->submitTip($_POST['tiptitle'], $_POST['tipsummary'], $_POST['tipcontent']);

      // successful
      if ($retval == 0){
         $_SESSION['tipsuccess'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['tipsuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procSubmitTip

   /**
    * Submit a comment on an article into the database.
    */
   function procSubmitArticleComment() {
      global $session, $form;

      // submission attempt
      $retval = $session->submitArticleComment($_POST['articleid'], $_POST['comment'], 
      	$_POST['captcha_code']);

      // successful
      if ($retval == 0){
         //$_SESSION['artcomsuccess'] = true;
         $_SESSION['value_array'] = $_POST;
         header("Location: " . SITE_BASEDIR . "/viewarticle.php?id=" . $_POST['articleid']
         	. "#submitcomment");
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: " . SITE_BASEDIR . "/viewarticle.php?id=" . $_POST['articleid']
         	. "#submitcomment");
      }
      // failed
      else if ($retval == 2){
         $_SESSION['comment_failure'] = true;
         header("Location: " . SITE_BASEDIR . "/viewarticle.php?id=" . $_POST['articleid']);
      }
   } // procSubmitArticleComment

   /**
    * Submit a comment on a glossary item into the database.
    */
   function procSubmitGlossaryComment() {
      global $session, $form;

      // submission attempt
      $retval = $session->submitGlossaryComment($_POST['glossid'], $_POST['comment']);

      // successful
      if ($retval == 0){
         $_SESSION['gcomsuccess'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['gcomsuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procSubmitGlossaryComment

   /**
    * Submit a comment on a tip into the database.
    */
   function procSubmitTipComment() {
      global $session, $form;

      // submission attempt
      $retval = $session->submitTipComment($_POST['tipid'], $_POST['comment']);

      // successful
      if ($retval == 0){
         $_SESSION['tipcomsuccess'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['tipcomsuccess'] = false;
         header("Location: ".$session->referrer);
      }
   } // procSubmitTipComment

   /**
    * Update an existing article in the database.
    */
   function procUpdateArticle() {
      global $session, $form;

      // submission attempt
      $retval = $session->updateArticle(clean_data($_POST['articleid']), 
      	clean_data($_POST['articletitle']), clean_data($_POST['articlesummary']), 
      	$_POST['articlecategory'], clean_data($_POST['articledate']), 
      	clean_data($_POST['articlestate']), clean_data($_POST['articleauthor']),
      	clean_html_data($_POST['articlecontent']));

      // successful
      if ($retval == 0){
         $_SESSION['articlesuccess'] = true;
         header("Location: " . SITE_BASEDIR . "/viewarticle.php?id=" . $_POST['articleid']);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: " . SITE_BASEDIR . "/editarticle.php?id=" . $_POST['articleid']);
      }
      // failed
      else if ($retval == 2){
         $_SESSION['articlesuccess'] = false;
         header("Location: " . SITE_BASEDIR . "/editarticle.php?id=" . $_POST['articleid']);
      }
   } // procUpdateArticle
   
   /**
    * Send a contact email
    */
   function procContactUs() {
      global $session, $form;

      // mail attempt
      $retval = $session->contactUs($_POST['curfirst'], $_POST['curlast'], $_POST['email'], $_POST['message']);

      // successful
      if ($retval == 0) {
         $_SESSION['contacted'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else if ($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      // failed
      else if($retval == 2){
         $_SESSION['contacted'] = false;
         header("Location: ".$session->referrer);
      }
   } // procContactUs

   /**
    * procForgotPass - Validates the given username then if
    * everything is fine, a new password is generated and
    * emailed to the address the user gave on sign up.
    */
   function procForgotPass(){
      global $database, $session, $mailer, $form;
      /* Username error checking */
      $subuser = $_POST['user'];
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "* Username not entered<br>");
      }
      else{
         /* Make sure username is in database */
         $subuser = stripslashes($subuser);
         if(strlen($subuser) < 5 || strlen($subuser) > 30 ||
            !eregi("^([0-9a-z])+$", $subuser) ||
            (!$database->usernameTaken($subuser))){
            $form->setError($field, "* Username does not exist<br>");
         }
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
      }
      /* Generate new password and email it to user */
      else{
         /* Generate new password */
         $newpass = $session->generateRandStr(8);

         /* Get email of user */
         $usrinf = $database->getUserInfo($subuser);
         $email  = $usrinf['email'];

         /* Attempt to send the email with new password */
         if($mailer->sendNewPass($subuser,$email,$newpass)){
            /* Email sent, update database */
            $database->updateUserField($subuser, "password", md5($newpass));
            $_SESSION['forgotpass'] = true;
         }
         /* Email failure, do not change password */
         else{
            $_SESSION['forgotpass'] = false;
         }
      }

      header("Location: ".$session->referrer);
   }

   /**
    * Attempts to edit the user's account
    * information, including the password, which must be verified
    * before a change is made.
    *
    */
   function procEditAccount() {
      global $session, $form;
      // account edit attempt
      $retval = $session->editAccount($_POST['curpass'], $_POST['newpass'],
          $_POST['curfirst'], $_POST['curlast'], $_POST['email']);

      // account edit successful
      if ($retval) {
         $_SESSION['useredit'] = true;
         header("Location: ".$session->referrer);
      }
      // error found with form
      else {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
   } // procEditAccount
};

/* Initialize process */
$process = new Process;

?>
