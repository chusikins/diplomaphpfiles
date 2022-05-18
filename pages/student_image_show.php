<?php
require_once 'navbar.php';
$ex_id = $_REQUEST['ex_id'];
$user_id = $_REQUEST['user_id'];
$sql_exercise_query ="SELECT * FROM exercise WHERE exID = " . $ex_id;
$sql_images_query ="SELECT * FROM studimages WHERE siExID = " . $ex_id. " AND siUserID =". $user_id;


$exersice_result = mysqli_query($link, $sql_exercise_query);
$exersice_row = mysqli_fetch_array($exersice_result);
$ex_name = $exersice_row['exName'];
$ex_text = $exersice_row['exText'];
$image_data = array();
$sub_answer_id = array();
$sub_answer_text = array();

$images_result = mysqli_query($link, $sql_images_query);

foreach ($images_result as $row) {
  array_push($image_data, base64_encode($row['siData']));
  array_push($sub_answer_id, $row['siSubAnsID']);
}

foreach ($sub_answer_id as $key) {
  $sub_answer_query = "SELECT saText FROM subanswers WHERE saExID = " . $ex_id. " AND saAnswerID = ". $key;
  $sub_answer_result = mysqli_query($link, $sub_answer_query);
  $sub_answer_row = mysqli_fetch_array($sub_answer_result);
  array_push($sub_answer_text, $sub_answer_row['saText']);
}

$imageencode = json_encode($image_data);
$textencode= json_encode($sub_answer_text);


 ?>
 <body onload="generateImages()">
 <div class="wrapper">
   <fieldset>
     <h1><?php echo $ex_name ?></h1>
     <div id="out" class="markdown-body"></div>
   </fieldset>
   <fieldset>
     <div id="show_image">

     </div>
   </fieldset>
   <fieldset>
     <form class="" action="../includes/student_image_show.inc.php" method="post">
       <input type="hidden" name="ex_id" value="<?php echo $ex_id; ?>">
       <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
       <label>Комментарии студенту</label>
       <br>
       <textarea name="comments" rows="5" cols="80"></textarea>
       <br>
       <select id="result" name="result">
         <option value="0">Зачет</option>
         <option value="2">Незачет</option>
       </select>
       <input type="submit" name="submit" value="submit">
     </form>
   </fieldset>
 </div>
 </body>
 <script type="text/javascript">

 function generateImages(){
   var image_data = <?php echo $imageencode; ?>;
   var sub_answer_text = <?php echo $textencode; ?>;
   var number = image_data.length;
   var show_image = document.getElementById("show_image");
   for(i=0; i<number; i++){
     var image = new Image();
     image.src = 'data:image/jpeg;base64,'+ image_data[i];


     show_image.appendChild(document.createTextNode(sub_answer_text[i]));
     show_image.appendChild(document.createElement("br"));
     show_image.appendChild(image);
   }
 }



 const str = <?php echo json_encode($ex_text); ?>;
 document.addEventListener("DOMContentLoaded", () => {
   const md = markdownit({html:true})
                 .use(texmath, { engine: katex,
                                 delimiters: 'dollars',
                                 katexOptions: { macros: {"\\RR": "\\mathbb{R}"} } } );
   out.innerHTML = md.render(str);
})
 </script>
