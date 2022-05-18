<?php
  function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat){
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat) ){
      $result = true;
    } else{
      $result = false;
    }
    return $result;
  }

  function invalidUid($username){
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
      $result = true;
    }else {
      $result = false;
    }
    return $result;
  }

  function invalidEmail($email){
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $result = true;
    }else {
      $result = false;
    }
    return $result;
  }

  function pwdMatch($pwd, $pwdRepeat){
    $result;
    if ($pwd !== $pwdRepeat) {
      $result = true;
    }else {
      $result = false;
    }
    return $result;
  }

  function uidExists($link, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUID = ? or usersEmail = ?;";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../pages/signup.php?error=stmtfailed");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
      return $row;
    }
    else{
      $result = false;
      return $result;
    }
    mysqli_stmt_close($stmt);
  }


    function createUser($link, $name, $email, $username, $pwd, $group){
      $sql = "INSERT INTO users (usersName, usersEmail, usersUID, usersPwd,usersGroup, usersPermission) VALUES (?,?,?,?,?,'student');";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../pages/signup.php?error=stmtfailed");
        exit();
      }

      $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

      mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $username, $hashedPwd, $group);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      header("location: ../pages/signup.php?error=none");
      exit();
    }

    function emptyInputLogin($username, $pwd){
      $result;
      if (empty($username) || empty($pwd)){
        $result = true;
      } else{
        $result = false;
      }
      return $result;
    }

    function loginUser($conn, $username, $pwd){
      $uidExists = uidExists($conn, $username, $username);
      if ($uidExists === false) {
        header("location: ../pages/login.php?error=wronglogin");
        exit();
      }

      $pwdHashed = $uidExists["usersPwd"];
      $checkPwd = password_verify($pwd, $pwdHashed);

      if($checkPwd === false){
        header("location: ../pages/login.php?error=wronglogin");
        exit();
      }
      else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersID"];
        $_SESSION["useruid"] = $uidExists["usersUID"];
        $_SESSION["userPermission"] = $uidExists["usersPermission"];
        $_SESSION["userName"] = $uidExists["usersName"];
        $_SESSION["userGroup"] = $uidExists["usersGroup"];
        if ($_SESSION["userPermission"] === 'student'){
          header("location: ../pages/studenttasks.php");
          exit();
        } else if ($_SESSION["userPermission"] === 'teacher'){
          header("location: ../pages/teacher_landing.php");
          exit();
        }
        exit();
      }
    }

    function displayTests($link,$group,$userid){
      $sql_comleted_query = "SELECT * FROM completedex WHERE ceGroup = '". $group . "' AND ceUserID = ". $userid;
      $sql_exercise_query = "SELECT * FROM exercise WHERE exGroup = '". $group . "';";
      $result = mysqli_query($link, $sql_exercise_query);
      $completed_result = mysqli_query($link,$sql_comleted_query);
      $ex_name = array();
      $ex_id = array();
      $teacher = array();
      $tests = array();
      $links = array();
      $comments = array();
      $completed_ex_id = array();
      $completed_comments = array();
      $pending_ex_id = array();
      $pending_comments = array();
      $returned_ex_id = array();
      $returned_comments = array();

      while ($completed_row = mysqli_fetch_array($completed_result)) {
        if ($completed_row['ceStatus'] === '0') {
          array_push($completed_ex_id, $completed_row['ceExID']);
          $completed_comments[$completed_row['ceExID']] = $completed_row['ceComments'];
        }elseif ($completed_row['ceStatus'] === '1') {
          array_push($pending_ex_id, $completed_row['ceExID']);
          $pending_comments[$completed_row['ceExID']] = $completed_row['ceComments'];
        }else {
          array_push($returned_ex_id, $completed_row['ceExID']);
          $returned_comments[$completed_row['ceExID']] = $completed_row['ceComments'];
        }
      }
      while ($row = mysqli_fetch_array($result)){
        array_push($teacher, $row['exTeacherName']);
        array_push($ex_name, $row['exName']);
        array_push($ex_id, $row['exID']);
        if (in_array($row['exID'], $completed_ex_id)) {
            array_push($links, "completed");
            array_push($comments, $completed_comments[$row['exID']]);
        } elseif (in_array($row['exID'], $pending_ex_id)) {
            array_push($links, "pending");
            array_push($comments, $pending_comments[$row['exID']]);
        } elseif (in_array($row['exID'], $returned_ex_id)) {
            array_push($links, "http://localhost/myphp/diplomaphpfiles/pages/show_test.php?ex_id=".$row['exID']);
            array_push($comments, $returned_comments[$row['exID']]);
        } else {
          array_push($links, "http://localhost/myphp/diplomaphpfiles/pages/show_test.php?ex_id=".$row['exID']);
          array_push($comments, NULL);
        }


      }
      $tests["text"] = $ex_name;
      $tests["teacher"] = $teacher;
      $tests["ex_id"] = $ex_id;
      $tests["comments"] = $comments;
      $tests["link"] = $links;
      $jsonTests = json_encode($tests);
      return $jsonTests;
    }


    function update_submitted_answer($link, $result,$comments,$ex_id,$user_id){
      $result = "'". $result . "'";

      $sql_update_query = "UPDATE completedex SET ceStatus =". $result .", ceComments = ? WHERE ceExID = ? AND ceUserID = ?" ;
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $sql_update_query)) {
        header("location: ../pages/teacher_landing.php?error=stmtfailed");
        exit();
      }
      mysqli_stmt_bind_param($stmt, "sdd", $comments, $ex_id, $user_id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      header("location: ../pages/teacher_landing.php?ex_id=". $ex_id);
      exit();
    }

 ?>
