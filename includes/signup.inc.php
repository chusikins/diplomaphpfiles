<?php

if (isset($_POST["submit"])){

  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdrepeat"];

  require_once '../db/database_connection.php';
  require_once 'functions.inc.php';

  if(emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false){
    header("location: ../pages/signup.php?error=emptyinput");
    exit();
  }
  if (invalidUid($username) !== false){
    header("location: ../pages/signup.php?error=invaliduid");
    exit();
  }
  if (invalidEmail($email) !== false){
    header("location: ../pages/signup.php?error=invalidemail");
    exit();
  }
  if (pwdMatch($pwd, $pwdRepeat) !== false){
    header("location: ../pages/signup.php?error=pwdmatch");
    exit();
  }
  if (uidExists($link, $username, $email) !== false){
    header("location: ../pages/signup.php?error=uidtaken");
    exit();
  }

  createUser($link, $name, $email, $username, $pwd);

}
else{
  header("location: ../pages/signup.php");
  exit();
}

  ?>
