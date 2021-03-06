<?php
session_start();
require_once '../db/database_connection.php';

$sql_exercise_query = "SELECT * FROM exercise;";
$result = mysqli_query($link, $sql_exercise_query);

$text = array();
$ex_id = array();
$tests = array();
$links = array();
while ($row = mysqli_fetch_array($result)){
  array_push($text, $row['exText']);
  array_push($ex_id, $row['exID']);
  array_push($links, "http://localhost/myphp/diplomaphpfiles/pages/show_test_results.php?ex_id=".$row['exID']);
}
$tests["text"] = $text;
$tests["ex_id"] = $ex_id;
$tests["link"] = $links;
$jsonTests = json_encode($tests);
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p id="test">Привет <?php echo $_SESSION["userName"] ?> !</p>
    <table>

    </table>
  </body>
  <script>
  function generateTableHead(table, data) {
    let thead = table.createTHead();
    let row = thead.insertRow();
    for (let key of data) {
      let th = document.createElement("th");
      let text = document.createTextNode(key);
      th.appendChild(text);
      row.appendChild(th);
    }
  }

  function generateTable(table, data) {
    for (let i=0; i < data["ex_id"].length; i++){
      let row = table.insertRow();
      for (let key in Object.keys(data)){
        if (Object.keys(data)[key].localeCompare("link") == 0){
          let a = document.createElement('a');
          let cell = row.insertCell();
          let linkText = document.createTextNode("link");
          a.appendChild(linkText);
          a.href = data[Object.keys(data)[key]][i];
          cell.appendChild(a);
        } else {
        let cell = row.insertCell();
        let text = document.createTextNode(data[Object.keys(data)[key]][i]);
        cell.appendChild(text);
         }
      }
    }
  }
  let obj = <?php echo $jsonTests; ?>;
  let table = document.querySelector("table");
  let data = Object.keys(obj);
  generateTableHead(table, data);
  generateTable(table, obj);
  </script>
</html>
