<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <section>
    <h2>Login</h2>
    <form action="../includes/login.inc.php" method="post">
      <input type="text" name="uid" placeholder="Email\Username">
      <input type="password" name="pwd" placeholder="Password">
      <button type="submit" name="submit">Log in</button>
    </form>
    <?php
      if (isset($_GET["error"])){
        if ($_GET["error"] == "emptyinput"){
          echo "<p>Заполните все поля!</p>";
        }
        else if ($_GET["error"] == "wronglogin"){
          echo "<p>нет такого закона!</p>";
        }
        if ($_GET["error"] == "loggedin"){
          echo "<p>Вы зашли!</p>";
        }
      }
     ?>
    </section>
  </body>
</html>
