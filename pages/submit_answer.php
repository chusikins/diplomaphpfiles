<?php
session_start();
if (isset($_POST['submit'])){
  require '../db/database_connection.php';

  $groupnumber = $_SESSION['userGroup'];
  $userid = $_SESSION['userid'];
  $ex_id = $_SESSION['current_ex_id'];
  $select_query = "SELECT * FROM exercise WHERE ex_id = " . $ex_id;
  $result = mysqli_query($link, $select_query);
  $row = mysqli_fetch_array($result);
  $sub_answers_amount = $row['sub_answers_amount'];
    for ($i=0; $i<$sub_answers_amount; $i++){
      $insert_exercise_sql = "INSERT INTO student_answers (studansExID, studansUID, studnasGroup, studansAnsNum, stuansAns) VALUES (?,?,?,?,?);";
      $studansAnsNum = $i;
      $stuansAns = $_POST['member' . $i];
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $insert_exercise_sql)) {
        header("location: ../pages/studenttasks.php?error=stmtfailed");
        exit();
      }
      mysqli_stmt_bind_param($stmt, "ddsds", $ex_id, $userid, $groupnumber,$studansAnsNum,$stuansAns);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    header("location: ../pages/studenttasks.php?error=submitted");

} else {
    header("location: ../pages/studenttasks.php");
}
 ?>
