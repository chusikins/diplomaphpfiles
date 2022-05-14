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

  <body onload="showImages()">
    <div id="header"><h1>Filler</h1></div>
    <div id="example"></div>
    <fieldset>
      <div id="content">
        <div id="out" class="markdown-body">

        </div>
        <div id="container2">

        </div>
    </fieldset>
    <form class="" action="submit_answer.php" method="post">
      <a href="#" id="filldetails" onclick="addFields()">Вывести</a>
      <div id="container">

      </div>
      <button type="button" onclick="checkfunc()">Проверить</button>
      <br>
      <fieldset>
        <input type="submit" name="submit" value="submit">
      </fieldset>
      <div id="checker">
      </div>
    </div>
    </form>

  </body>

  <script type="text/javascript">
  //так же скрипты для создания ячеек для ответа студента
  var images = <?php echo json_encode($image_data); ?>;
  var answers = <?php echo json_encode($sub_answers); ?>;
  var sub_text = <?php echo json_encode($sub_answer_text); ?>;
    function showImages(){
       var number = images.length;
       var container2 = document.getElementById("container2");
       while (container2.hasChildNodes()) {
           container2.removeChild(container2.lastChild);
       }
       for (i=0; i<number; i++){
         var image = new Image();
         image.src = 'data:image/jpeg;base64,'+ images[i];
         container2.appendChild(image);
       }
    };
    function addFields(){
        // Number of inputs to create
        var number = answers.length;
        // Container <div> where dynamic content will be placed
        var container = document.getElementById("container");
        // Clear previous contents of the container
        while (container.hasChildNodes()) {
            container.removeChild(container.lastChild);
        }
        for (i=0;i<number;i++){
            // Append a node with a random text
            container.appendChild(document.createTextNode("Answer " + (i+1)));
            container.appendChild(document.createElement("br"))
            container.appendChild(document.createTextNode(sub_text[i] + "      "));
            // Create an <input> element, set its type and name attributes
            var input = document.createElement("input");
            input.type = "text";
            input.name = "member" + i;
            input.id = "member" + i;
            container.appendChild(input);
            // Append a line break
            container.appendChild(document.createElement("br"));
        }
    }
    // простая функция для сравнения строки. НЕ финальное решение задачи
    function checkfunc(){
      var number = answers.length;
      var div = document.getElementById('checker')
      while (div.hasChildNodes()){
        div.removeChild(div.lastChild);
      }
      for (i=0;i<number;i++){
        var student_answer = document.getElementById("member"+i).value;
        if (student_answer === answers[i]){
          div.innerHTML += i+1 + " is correct <br>";
        } else {
            div.innerHTML += i+1 + " is incorrect <br>";
        }
      }
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
