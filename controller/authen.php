<?php
include "../conf.inc.php";
include "../connect.inc.php";
include "../function.inc.php";

if(!isset($_GET['stage'])){
  mysqli_close($conn);
  die();
}

$return = array();

$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'login'){
  if((!isset($_POST['username'])) || (!isset($_POST['password']))){
    mysqli_close($conn);
    die();
  }
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, base64_encode($_POST['password']));

  $strSQL = "SELECT * FROM useraccount
             WHERE
             username = '$username'
             AND password = '$password'
             AND use_status = '1'
             AND delete_status = '0'
             ";
  $result = mysqli_query($conn, $strSQL);
  $buffer = array();

  if(($result) && (mysqli_num_rows($result) > 0)){
    $buffer['status'] = 'Success';
    while ($row = mysqli_fetch_array($result)) {
      foreach ($row as $key => $value) {
          if(!is_int($key)){
            $buffer[$key] = $value;
          }
      }
      $return[] = $buffer;
    }
  }

  echo json_encode($return);
  mysqli_close($conn);
  die();

}

if($stage == 'register'){
  if((!isset($_POST['username'])) || (!isset($_POST['password'])) || (!isset($_POST['fname'])) || (!isset($_POST['lname']))){
    mysqli_close($conn);
    die();
  }

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, base64_encode($_POST['password']));
  $fname = mysqli_real_escape_string($conn, $_POST['fname']);
  $lname = mysqli_real_escape_string($conn, $_POST['lname']);

  // Check email or phone
  $b = explode('@', $username);
  $regtype = 'email';
  if(sizeof($b) == 1){
    $regtype = 'phone';
  }

  $buffer = array();

  $strSQL = "SELECT * FROM useraccount WHERE username = '$username' AND use_status = '1' AND delete_status = '0'";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){
    $buffer['status'] = 'Duplicate';
    $return[] = $buffer;
    echo json_encode($return);
    mysqli_close($conn);
    die();
  }

  $uid = base64_encode($sysdateu);

  $phone = ''; $email = '';
  if($regtype == 'phone'){ $phone = $username; }
  if($regtype == 'email'){ $email = $username; }

  $strSQL = "INSERT INTO useraccount (uid, username, password, regtype, fname, lname, email, phone, reg_date)
             VALUES ('$uid', '$username', '$password', '$regtype', '$fname', '$lname', '$email', '$phone', '$sysdatetime')
            ";
  $resultInsert = mysqli_query($conn, $strSQL);
  if($resultInsert){
    $buffer['status'] = 'Success';
    $buffer['uid'] = $uid;
    $buffer['role'] = 'common';
    $return[] = $buffer;
  }else{
    $buffer['status'] = 'Fail';
    $buffer['info'] = $strSQL;
    $return[] = $buffer;
  }

  echo json_encode($return);
  mysqli_close($conn);
  die();

}


?>
