<?php include_once "navbar.php" ?>

    <section class="wrapper">
      <div class="form">


    <h2>Sign up</h2>
    <div class="errors">
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
    </div>


    <form action="../includes/signup.inc.php" method="post">
      <div class="form-group">
        <label>Name:</label>
        <input type="text" name="name" placeholder="">
      </div>
      <div class="form-group">
        <label>Email:</label>
        <input type="text" name="email" placeholder="">
      </div>
      <div class="form-group">
        <label>Username:</label>
        <input type="text" name="uid" placeholder="">
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="pwd" placeholder="">
      </div>
      <div class="form-group">
        <label>Repeat Password:</label>
        <input type="password" name="pwdrepeat" placeholder="">
      </div>
      <div class="form-group">
        <label>Group:</label>
        <select id="group" name="group">
          <option value="101">101</option>
          <option value="102">102</option>
          <option value="103">103</option>
          <option value="104">104</option>
          <option value="105">105</option>
        </select>
      </div>
      <button type="submit" name="submit" class="button">Sign Up</button>
    </form>
    </div>
    </section>



  </body>
</html>
