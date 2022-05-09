<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <section>
    <h2>Sign up</h2>
    <form action="../includes/signup.inc.php" method="post">
      <input type="text" name="name" placeholder="Имя...">
      <input type="text" name="email" placeholder="Почта...">
      <input type="text" name="uid" placeholder="Имя пользователя...">
      <input type="password" name="pwd" placeholder="Пароль...">
      <input type="password" name="pwdrepeat" placeholder="Повторить...">
      <button type="submit" name="submit">Sign Up</button>
    </form>
    <?php
      if (isset($_GET["error"])){
        if ($_GET["error"] == "emptyinput"){
          echo "<p>Заполните все поля!</p>";
        }
        else if ($_GET["error"] == "invaliduid"){
          echo "<p>Неподходящие имя</p>";
        }
        else if ($_GET["error"] == "pwdmatch"){
          echo "<p>пароль не совпал!</p>";
        }
        else if ($_GET["error"] == "stmtfailed"){
          echo "<p>что-то пошло не так</p>";
        }
        if ($_GET["error"] == "usernametaken"){
          echo "<p>Имя пользователя занято!</p>";
        }
        if ($_GET["error"] == "none"){
          echo "<p>Вы подписались!</p>";
        }
      }
     ?>
    </section>



  </body>
</html>
