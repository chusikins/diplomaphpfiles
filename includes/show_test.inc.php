<?php

  require_once '../db/database_connection.php';
  require_once 'functions.inc.php';
  session_start();
  $groupnumber = $_SESSION['userGroup'];
  $userid = $_SESSION['userid'];
  $ex_id = $_SESSION['current_ex_id'];
  $upload_dir = "D:/xammp/htdocs/myPHP/" . "uploads/test_images/";
  $upload_dir_temp = "D:/xammp/htdocs/myPHP/upload";
  if (count($_FILES) === 0){
    $status = '0';
  } else {
    $status = '1';
  }

  $select_query = "SELECT * FROM exercise WHERE exID = " . $ex_id;
  $result = mysqli_query($link, $select_query);
  $row = mysqli_fetch_array($result);
  $exSubAmount = $row['exSubAmount'];

  $insert_complition_sql = "INSERT INTO completedex (ceExID, ceUserID, ceGroup, ceStatus) VALUES (?,?,?,?);";
  $stmt = mysqli_stmt_init($link);
  if (!mysqli_stmt_prepare($stmt, $insert_complition_sql)) {
    header("location: ../pages/studenttasks.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ddss", $ex_id, $userid, $groupnumber, $status);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  $sub_answer_query = "SELECT * FROM subanswers WHERE saExID = " . $ex_id . " AND saAnswer = 'image';";
  $sub_result = mysqli_query($link, $sub_answer_query);
  $subansimages = array();
  while ($row = mysqli_fetch_array($sub_result)){
    array_push($subansimages, $row['saAnswerID']);
  }




  $i = 0;
  foreach ($_FILES as $image) {

    ($image['error'] == 0)
     or handle_error("сервер не может получить выбранное вами изображение.",
    $php_error[$_FILES [$image_fieldname]['error']]);;

    @getimagesize($image['tmp_name'])
    or handle_error("вы выбрали файл для своего фото," .
    "which is not an image.",
    "{$image['tmp_name']}" .
    " не явл файлом изображения");

    $now = time();
    while (file_exists($upload_filename = $upload_dir_temp . "/" . $now .
    '-' .
    $image['name'])){
      $now++;
    }

    $image_filename = $image['name'];
    $image_info = getimagesize($image['tmp_name']);
    $image_mime_type = $image_info['mime'];
    $image_size = $image['size'];
    $image_data = file_get_contents($image['tmp_name']);

    $insert_image_sql = sprintf("INSERT INTO studimages " .
    "(siExID, siSubAnsID, siUserID, siMimetype," .
    " siFilesize,	siData, siFileName)" .
    "VALUES (%d, %d, %d, '%s', %d, '%s','%s');",
    mysqli_real_escape_string($link, $ex_id),
    mysqli_real_escape_string($link, $subansimages[$i]),
    mysqli_real_escape_string($link, $userid),
    mysqli_real_escape_string($link, $image_mime_type),
    mysqli_real_escape_string($link, $image_size),
    mysqli_real_escape_string($link, $image_data),
    mysqli_real_escape_string($link, $image_filename)
    );
    mysqli_query($link, $insert_image_sql);
    $i++;
  }


  header("location: ../pages/studenttasks.php?error=submitted");

 ?>
