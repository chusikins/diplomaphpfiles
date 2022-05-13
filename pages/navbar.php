<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PHP Project</title>
    <link rel="stylesheet" href="master.css">
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex/dist/katex.min.css">
    <link rel="stylesheet" href="css/texmath.css">
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex/dist/katex.min.js"></script>
    <script src="texmath.js"></script>
  </head>
  <body>
      <nav id="navbar">
        <div class="wrapper">
          <ul align = 'right'>
            <li><a href="index.php">Home</a></li>
            <?php
              if (isset($_SESSION["useruid"])){
                echo "<li><a href='index.php'>View</a></li>";
                echo "<li><a href='../includes/logout.inc.php'>Log Out</a></li>";
              } else{
                echo "<li><a href='signup.php'>Sign Up</a></li>";
                echo "<li><a href='login.php'>Log In</a></li>";
              }
             ?>

          </ul>

        </div>
      </nav>
