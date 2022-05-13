<?php include_once 'navbar.php' ?>
    <section class="wrapper">
      <div class="form">


    <h2>Login</h2>
    <form action="../includes/login.inc.php" method="post" class="login-form">
      <div class="form-group">
        <label>Email\Username:</label>
        <input type="text" name="uid" "Email\Username">
      </div>
      <div class="form-group">
          <label>Password:</label>
          <input type="password" name="pwd">
      </div>
      <button type="submit" name="submit" class="button">Log in</button>
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
     </div>
    </section>
  </body>
</html>
