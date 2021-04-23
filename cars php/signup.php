<?php
include_once 'Utilitties.php';
include_once 'includes/header.php';
// sign up

// initialize password
$_POST["Password"] = '';
$passw = $_POST["Password"];

// initialize the msg and error to nothing
$message = '';
$error = '';

// check if the sign up is set
if (isset($_POST["signup"])) {
  // hash the password
  $password_hash = password_hash($passw, PASSWORD_DEFAULT);




  //process the form 
  //Initialise the array to store messages from form
  $form_errors = array();

  //form validation
  $required_fields = array('Email', 'Fullname', 'password');

  //call the function to check empty field and merge the return data into array
  $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

  //Fields that require checking for min length
  $fields_to_check_length = array('Fullname' => 4, 'password' => 6);

  //Call the function to check min required length
  $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

  //Email validation 
  $form_errors = array_merge($form_errors, check_email($_POST));

  if (isset($form_errors)) {
    // check if the file existe or not
    if (file_exists('data.json')) {
      // get the json file content
      $datajson = file_get_contents('data.json');
      // decode
      $array_data = json_decode($datajson, true);
      // initialize an array
      $extra = array(
        'Fullname' => $_POST['Fullname'],
        'Driver_License' => $_POST["Driver_License"],
        'Email' => $_POST["Email"],
        'Password' => $password_hash
      );
      // add the extra to json file
      $array_data[] = $extra;
      // encode that data
      $final_data = json_encode($array_data);
      // display message
      if (file_put_contents('data.json', $final_data)) {
        $message = '<div class="alert alert-success">Account created</div>';
      }
    }
  } else {
    echo $form_errors;
  }
}
require_once "includes/htm.php";
