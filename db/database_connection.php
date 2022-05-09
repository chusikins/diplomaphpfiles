<?php
require_once 'app_config.php';

$link = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME,DATABASE_PASSWORD) //подавить системную ошибку
or die("<p> Ошибка подключения к базе данных: " . 
mysqli_error($link) . "</p>");
echo "<p> Вы подключились к MySQL! </p>";

mysqli_select_db($link, DATABASE_NAME)
or die("<p>Ошибка при выборе базы данных myDB: " . mysqli_error($link) . "</p>");
echo "<p> Вы поключены к MySQL с использованием базы данных myDB. </p>";

 ?> 