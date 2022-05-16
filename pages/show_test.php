<?php
require_once "navbar.php";
//вводим нужные переменные из таблиц.
$ex_id = $_REQUEST['ex_id'];
$_SESSION['current_ex_id'] = $ex_id;
$select_query = "SELECT * FROM exercise WHERE ex_id = " . $ex_id;
$result = mysqli_query($link, $select_query);
if ($result){
  $row = mysqli_fetch_array($result);
  $exercise = $row['exercise_text'];
  $sub_answers_amount = $row['sub_answers_amount'];
  $image_amount = $row['image_amount'];
  $ex_name = $row['exerciseName'];
  $sub_answers = array();
  $sub_answer_text = array();
  $image_data = array();
  if ($sub_answers_amount != 0) {
   for ($i=1; $i<=$sub_answers_amount; $i++){
     $answer_query = "SELECT * FROM sub_answers WHERE question_id = ". $ex_id . " AND sub_answer_id = ". $i;
     $ans_result = mysqli_query($link, $answer_query);
     $ans_row = mysqli_fetch_array($ans_result);
     $sub_answers[$i-1] = $ans_row['sub_answer'];
     $sub_answer_text[$i-1] = $ans_row['sub_answers_text'];
      }
    }
  //  $answer_query = "SELECT * FROM sub_answers WHERE question_id = ". $ex_id;
  //  $ans_result = mysqli_query($link, $answer_query);
  // if ($ans_result){
  //   while($row2 = mysqli_fetch_array($ans_result)){
  //     echo $row2[1]." ";
  //     echo $row2[2]." ";
  //   }
  if ($image_amount != 0){
    for($i=0; $i<$image_amount; $i++){
      $image_query = "SELECT * FROM images WHERE ex_id = ". $ex_id . " AND pic_ex_id = ". $i;
      $image_result = mysqli_query($link, $image_query);
      $image_row = mysqli_fetch_array($image_result);
      $image_data[$i] = $image_row['imagedata'];
      $image_data[$i] = base64_encode($image_data[$i]);
    }
  }

  //   array_push($answers, $row['answer_'.$i+1])
}else{
  die("Ошибка обнаружения задания с ID {$ex_id}");
}

 ?>

  <body onload="init()">
    <div class="wrapper">
    <div id="header"><h1><?php echo $ex_name; ?></h1></div>
    <div id="example"></div>
    <fieldset>
      <div id="content">
        <div id="out" class="markdown-body">
        </div>
        <div id="container2">
        </div>
    </fieldset>
    <form class="" action="../includes/show_test.inc.php" method="post" enctype="multipart/form-data" name="form">
      <div id="container">
      </div>
      <div class="contbutton">
        <button type="button" class="button" onclick="checkfunc()">Проверить</button>
      </div>

      <br>
      <!-- <fieldset>
        <input type="submit" name="submit" value="submit">
      </fieldset> -->
    </div>
    </form>
    </div>
  </body>

  <script type="text/javascript">
  //так же скрипты для создания ячеек для ответа студента
  var images = <?php echo json_encode($image_data); ?>;
  var answers = <?php echo json_encode($sub_answers); ?>;
  var sub_text = <?php echo json_encode($sub_answer_text); ?>;
  var sub_answers_amount = parseInt(<?php echo json_encode($sub_answers_amount); ?>);
  var j = 0;
    function showImages(){
       var number = images.length;
       var container2 = document.getElementById("container2");
       for (i=0; i<number; i++){
         var image = new Image();
         image.src = 'data:image/jpeg;base64,'+ images[i];
         container2.appendChild(image);
       }
    };
    function addFields(){
        if (j === sub_answers_amount) {
          return exitScript();
        }
        // Number of inputs to create
        var number = answers.length;
        // Container <div> where dynamic content will be placed
        var container = document.getElementById("container");
        // Clear previous contents of the container

        // Append a node with a random text
        container.appendChild(document.createTextNode("Answer " + (j+1)));
        container.appendChild(document.createElement("br"))
        container.appendChild(document.createTextNode(sub_text[j] + "      "));
        // Create an <input> element, set its type and name attributes
        var input = document.createElement("input");
        if (answers[j] === "image"){
          input.type = "file";
          input.name = "member" + j;
          input.id = "member" + j;
        }else{
          input.type = "text";
          input.name = "member" + j;
          input.id = "member" + j;
        }
        container.appendChild(input);
        // Append a line break
        container.appendChild(document.createElement("br"));

    }
    // простая функция для сравнения строки. НЕ финальное решение задачи
    function checkfunc(){
      var number = answers.length;
      var targetinput = document.getElementById("member"+j);
      var checkmark = new Image(20,20);
      var wrong = new Image(20,20);
      checkmark.src = "../images/checkmark.png";
      wrong.src = "../images/wrong.png";
      wrong.id = "wrong";
      if (document.getElementById("wrong")){
        document.getElementById("wrong").remove();
      }
      if (targetinput.type === "file") {
        if (targetinput.files.length !== 0) {
          targetinput.after(checkmark);
          j++;
          return addFields();
        } else {
          targetinput.after(wrong);
          return;
        }
      }

      var student_answer = targetinput.value;
        if (student_answer === answers[j]){
          targetinput.after(checkmark);
          targetinput.setAttribute("readonly", true);
          j++;
          addFields();
        } else {
          targetinput.after(wrong);
        }

      }

      function init(){
        addFields();
        showImages();
      }

      function exitScript(){
        document.form.submit();
      }




    const str = <?php echo json_encode($exercise); ?>;
    document.addEventListener("DOMContentLoaded", () => {
      const md = markdownit({html:true})
                    .use(texmath, { engine: katex,
                                    delimiters: 'dollars',
                                    katexOptions: { macros: {"\\RR": "\\mathbb{R}"} } } );
      out.innerHTML = md.render(str);
  })
  </script>
</html>
