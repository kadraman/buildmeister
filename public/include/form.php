<?php 
/**
 * @package Form 
 *
 * The Form class is meant to simplify the task of keeping
 * track of errors in user submitted forms and the form
 * field values that were entered correctly.
 * 
 * @author Kevin A. Lee <kevin.lee@buildmeister.com>
 * Based on code originally written by: Jpmaster77. 
 */
class Form {
   var $values = array();  	// holds submitted form field values
   var $errors = array();  	// holds submitted form error messages
   var $num_errors;   		// the number of errors in submitted form

   /**
    * Class constructor - initialise session variables
    */
   function Form() {
       // get form value and error arrays, used when there
       // is an error with a user-submitted form.
      if (isset($_SESSION['value_array']) && isset($_SESSION['error_array'])) {
         $this->values = $_SESSION['value_array'];
         $this->errors = $_SESSION['error_array'];
         $this->num_errors = count($this->errors);

         unset($_SESSION['value_array']);
         unset($_SESSION['error_array']);
      } else {
         $this->num_errors = 0;
      }
   } // Form

   /**
    * Records the value typed into the given form field by the user.
    * @param string $field
    * @param string $value
    */
   function setValue($field, $value) {
      $this->values[$field] = $value;
   } // setValue

   /**
    * Records new form error given the form
    * field name and the error message attached to it.
    * @param string $field
    * @param string $errmsg
    */
   function setError($field, $errmsg) {
      $this->errors[$field] = $errmsg;
      $this->num_errors = count($this->errors);
   } // setError

   /**
    * Returns the value attached to the given
    * field, if none exists, the empty string is returned.
    * @param string $field
    * @return string
    */
   function value($field) {
      if (array_key_exists($field, $this->values)) {
         return htmlspecialchars(stripslashes($this->values[$field]));
      } else {
         return "";
      }
   } // value

   /**
    * Returns the error message attached to the
    * given field, if none exists, the empty string is returned.
    * @param string $field
    * @return string
    */
   function error($field) {
      if (array_key_exists($field,$this->errors)){
         return "<div id=\"error\">" . $this->errors[$field] . "</div>";
      } else {
         return "";
      }
   } // error

   /**
    * Returns the array of error message
    * @return array 
    */
   function getErrorArray() {
      return $this->errors;
   } // getErrorArray
   
   /**
    * Returns a string containing all the errors for the form
    * @return string
    */
   function allErrors() {
       $errMess = "<div id=\"error\">";
       foreach ($this->errors as $err) {
           $errMess = $errMess . $err . "<br/>";
       }
       $errMes = $errMess . "</div>";
       return $errMess;
   } // allErrors
   
};
 
?>
