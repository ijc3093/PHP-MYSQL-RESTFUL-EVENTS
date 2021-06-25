<?php
session_start();

if(!isset($_SESSION['userRole'])){
  echo '<script>window.location.replace("login.php");</script>';
}


// -----------------  use a filter_var(param1,param2,param3)  -----------------

// validate input to only string
function validate_str($input){
  return filter_var($input);
}

// validate input to only numeric
function validate_int($input){ 
  return filter_var($input, FILTER_VALIDATE_INT === 0 || !filter_var($input,FILTER_VALIDATE_INT) === false);
}

// validate input to only date format following: yyyy-mm-dd
function validate_date($input){
  $validateStatus =  preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$input);
  return $validateStatus !== false ? true : false;
}