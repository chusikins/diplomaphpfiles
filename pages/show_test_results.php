<?php
//THIS IS ALL VERY BAD CODE DEF NEED TO REWORK. RUSHING FOR PROTOTYPE PURPOSES.
require_once 'navbar.php';
require_once '../db/database_connection.php';
$ex_id = $_REQUEST['ex_id'];

$sql_exercise_query ="SELECT * FROM exercise WHERE exID = " . $ex_id;
// $sub_subanswers_query = "SELECT * FROM sub_answers WHERE question_id = " . $ex_id . " AND sub_answer = 'image';";
$completed_query = "SELECT * FROM completedex WHERE ceExID = " . $ex_id;

$exersice_result = mysqli_query($link, $sql_exercise_query);
$exersice_row = mysqli_fetch_array($exersice_result);
$ex_name = $exersice_row['exName'];
$ex_text = $exersice_row['exText'];

$completed_result = mysqli_query($link, $completed_query);
$studID = array();
$imgStatus = array();
$user_names = array();
$links = array();
if (mysqli_num_rows($completed_result) !== 0){
    foreach($completed_result as $row){
      array_push($studID, $row['ceUserID']);
      array_push($imgStatus, $row['ceStatus']);
      if ($row['ceStatus'] != "0"){
        $links[$row['ceUserID']] = "http://localhost/myphp/diplomaphpfiles/pages/student_image_show.php?user_id=".$row['ceUserID']."&ex_id=".$ex_id;
      }
    }
    foreach($studID as $element){
      $user_query = "SELECT * FROM users WHERE usersID = " . $element;
      $user_result = mysqli_query($link, $user_query);
      $user_row = mysqli_fetch_array($user_result);
      array_push($user_names, $user_row['usersName']);
    }
}

$jsonStudentUserInfo = json_encode(array('Names' =>$user_names,
                                         'StudentID' =>$studID,
                                         'Status' =>$imgStatus,
                                         'Links' =>$links));
?>

  <div class="wrapper">
    <fieldset>
      <h1><?php echo $ex_name ?></h1>
      <div id="out" class="markdown-body"></div>
    </fieldset>
    <table>

    </table>
  </div>
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
  function generateTable(table, data) {
    for (let i=0; i < data["StudentID"].length; i++){
      let row = table.insertRow();
      let current_student_id = data["StudentID"][i];
      for (let key in Object.keys(data)){
        if (Object.keys(data)[key].localeCompare("Links") == 0){
          let cell = row.insertCell();
          if (data["Status"][i].localeCompare("0") == 0){
            let text = document.createTextNode("completed");
            cell.appendChild(text);
          } else if (data["Status"][i].localeCompare("2") == 0) {
            let text = document.createTextNode("sent back");
            cell.appendChild(text);
          } else {
            let a = document.createElement('a');
            let linkText = document.createTextNode("link");
            a.appendChild(linkText);
            a.href = data[Object.keys(data)[key]][current_student_id];
            cell.appendChild(a);
          }
        } else {
        let cell = row.insertCell();
        let text = document.createTextNode(data[Object.keys(data)[key]][i]);
        cell.appendChild(text);
         }
      }
    }
  }
  let obj = <?php echo $jsonStudentUserInfo ?>;
  let table = document.querySelector("table");
  let data = Object.keys(obj);
  generateTableHead(table, data);
  generateTable(table, obj);

  const str = <?php echo json_encode($ex_text); ?>;
  document.addEventListener("DOMContentLoaded", () => {
    const md = markdownit({html:true})
                  .use(texmath, { engine: katex,
                                  delimiters: 'dollars',
                                  katexOptions: { macros: {"\\RR": "\\mathbb{R}"} } } );
    out.innerHTML = md.render(str);
})
  </script>
</html>
