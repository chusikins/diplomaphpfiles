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
    $sql = "SELECT * FROM users WHERE usersUid = ? or usersEmail = ?;";
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
      $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, usersPermission, usersGroup) VALUES (?,?,?,?, 'student', ?);";
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
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
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



 ?>
