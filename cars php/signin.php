<?php
require_once "includes/header.php";
//  sign in 


// initialize password
$_POST["Password"] = '';
$passw = $_POST["Password"];

// login content
if (isset($_POST["login"])) {
    // if the user login in
    // get the data
    $MyData = file_get_contents('data.json');
    // decode the data
    $array_data = json_decode($MyData);
    // set the session login to false
    $_SESSION["LOGIN"] = false;
    // loop through the data that we get to check if the user is there
    foreach ($array_data as $key) {
        // check for the password hash and the username on json
        if ($key->Fullname === $_POST["Fullname"] && password_verify($passw, $key->Password)) {
            // check if the condition is true and redirect to the index.php
            header("location: main.php ");
            // start the session
            session_start();
            // set the session variable of fullname
            $_SESSION["FULLNAME"] = $_POST["Fullname"];
            // change the state of login to true
            $_SESSION["LOGIN"] = true;
        } else {
            // else change the state to false
            $_SESSION["LOGIN"] === false;
        }
    }
    if ($_SESSION["LOGIN"] === false) {
        // display the error
        echo '<div class="alert alert-danger mb-1"> error account not find </div> </br>';
    }
    if (empty($_POST["Fullname"]) || empty($passw)) {
        // if the password or the fullname are empty
        echo '<div class="alert alert-danger mb-1"> enter full name and password </div> </br>';
    }
}

require_once "includes/html.php";
