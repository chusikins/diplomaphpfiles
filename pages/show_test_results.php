<?php
//THIS IS ALL VERY BAD CODE DEF NEED TO REWORK. RUSHING FOR PROTOTYPE PURPOSES.
session_start();
require_once '../db/database_connection.php';
$ex_id = $_REQUEST['ex_id'];

$sql_exercise_query ="SELECT * FROM exercise WHERE ex_id = " . $ex_id;
$sql_answers_query = "SELECT * FROM student_answers WHERE studansExID =". $ex_id;
$sql_subanswers_query = "SELECT * FROM sub_answers WHERE question_id = " . $ex_id;
$result = mysqli_query($link, $sql_exercise_query);
$row = mysqli_fetch_array($result);
$answer_result = mysqli_query($link, $sql_answers_query);
$rows = mysqli_num_rows($answer_result);
$temp = $rows / $row['sub_answers_amount'];
$sub_answers_amount = $row['sub_answers_amount'];
$subans_result = mysqli_query($link, $sql_subanswers_query);
$sub_text_array = array(0 => "Name");
$answers = array();
$idnamearray =array();
$i = 0;
while($temprow= mysqli_fetch_array($answer_result)){
  $studId = $temprow['studansUID'];
  // array_push($answers[$studId][$i], $temprow['stuansAns']);
  $answers[$studId][$i] =  $temprow['stuansAns'];
  $i++;
  if ($i == $sub_answers_amount){
    array_push($idnamearray, $studId);
    $i=0;
  }
}
$jsonAnswers = json_encode($answers);
$nameassoc = array();
for ($i=0; $i < count($idnamearray); $i++){
  $sql_name_query = "SELECT * FROM users WHERE usersId = " . $idnamearray[$i];
  $result =  mysqli_query($link, $sql_name_query);
  $row2 = mysqli_fetch_array($result);
  $nameassoc[$idnamearray[$i]] = $row2['usersName'];
}
$jsonNames = json_encode($nameassoc);
while ($temprow = mysqli_fetch_array($subans_result)){
  $text = $temprow['sub_answers_text'];
  array_push($sub_text_array, $text);
}
$jsonText = json_encode($sub_text_array);
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
  <script type="text/javascript">
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
  function generateTable(table,names,data){
    for(var k in names) {
      console.log(k, names[k]);
      let row = table.insertRow();
      let cell = row.insertCell();
      let text = document.createTextNode(names[k])
      cell.appendChild(text);
      for (var j in data[k]){
        let cell = row.insertCell();
        let answer = document.createTextNode(data[k][j]);
        cell.appendChild(answer);
      }
    }

    // for (let i=0; i < names.length; i++){
    //   let row = table.insertRow();
    //   let cell = row.insertCell();
    //   let text = document.createTextNode()
    // }
  }
  // function generateTable(table, data) {
  //   for (let i=0; i < data["ex_id"].length; i++){
  //     let row = table.insertRow();
  //     for (let key in Object.keys(data)){
  //       if (Object.keys(data)[key].localeCompare("link") == 0){
  //         let a = document.createElement('a');
  //         let cell = row.insertCell();
  //         let linkText = document.createTextNode("link");
  //         a.appendChild(linkText);
  //         a.href = data[Object.keys(data)[key]][i];
  //         cell.appendChild(a);
  //       } else {
  //       let cell = row.insertCell();
  //       let text = document.createTextNode(data[Object.keys(data)[key]][i]);
  //       cell.appendChild(text);
  //        }
  //     }
  //   }
  // }
  let text = <?php echo $jsonText; ?>;
  let obj = <?php echo $jsonAnswers ; ?>;
  let names = <?php echo $jsonNames ; ?>;
  let table = document.querySelector("table");
  let data = Object.keys(obj);
  generateTableHead(table, text);
  generateTable(table,names, obj);
  </script>
</html>
