<?php
define("DEBUG_MODE", true);
if(DEBUG_MODE) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}
define("DATABASE_HOST", "localhost");
define("DATABASE_USERNAME", "root");
define("DATABASE_PASSWORD", "");
define("DATABASE_NAME", "teacher_student_test");

function debug_print($message){
  if (DEBUG_MODE){
    echo $message;
  }
}

function handle_error($user_error_message, $system_error_message) {
header("Location: ../ch07/show_error.php?" .
"error_message={$user_error_message}&" .
"system_error_message={$system_error_message}");
exit();
}

function get_web_path($file_system_path){
  return str_replace($_SERVER['DOCUMENT_ROOT'], '', $file_system_path);
}
?>
