<?php
session_start();
require_once '../db/database_connection.php';

// if ($_SESSION["userPermission"] !== 'teacher'){
//   header("location: ../pages/login.php?error=logerror");
//   exit();
// }



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<form class="" action="create_test.php" method="post">
  <input type="submit" value="Создать тест" />
</form>
<form class="" action="viewanswers.php" method="post">
    <input type="submit" value="Посмотреть ответы" />
</form>
  </body>
</html>
