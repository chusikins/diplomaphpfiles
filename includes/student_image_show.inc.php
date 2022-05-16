<?php

if (isset($_POST['submit'])){
  session_start();
  $result = $_POST["result"];
  $comments = $_POST["comments"];
  $ex_id = $_POST["ex_id"];
  $user_id = $_POST["user_id"];
  require_once '../db/database_connection.php';
  require_once 'functions.inc.php';
  update_submitted_answer($link, $result,$comments,$ex_id,$user_id);
} else{
  header("show_test_results.php?ex_id=".$ex_id);
  exit();
  }
 ?>
