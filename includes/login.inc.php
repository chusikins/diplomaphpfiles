<?php

if (isset($_POST['submit'])){
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    require_once '../db/database_connection.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($username, $pwd) !== false){
      header("location: ../pages/login.php?error=emptyinput");
      exit();
    }


    loginUser($link, $username, $pwd);

} else {
  header("location: ../pages/login.php");
  exit();
}


 ?>
