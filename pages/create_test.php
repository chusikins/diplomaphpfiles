<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex/dist/katex.min.css">
    <link rel="stylesheet" href="css/texmath.css">
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex/dist/katex.min.js"></script>
    <script src="texmath.js"></script>
    <script type='text/javascript'>

    //скрипт JS для создания ячеек для промежуточных заданий
        function addFields(){
            // Number of inputs to create
            var number = document.getElementById("sub_answers_amount").value;
            //  <div> where dynamic content will be placed
            var container = document.getElementById("container");
            // Clear previous contents of the container
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i=0;i<number;i++){
                // Append a node with a random text
                container.appendChild(document.createTextNode("Задание " + (i+1)));
                // Create an <input> element, set its type and name attributes
                var sub_answer_text = document.createElement("input");
                sub_answer_text.type = "text";
                sub_answer_text.name = "sub_text" + i;
                sub_answer_text.setAttribute("placeholder", "Вопрос");
                var input = document.createElement("input");
                input.type = "text";
                input.name = "member" + i;
                input.setAttribute("placeholder", "Ответ на задание");
                container.appendChild(sub_answer_text);
                container.appendChild(input);
                // Append a line break
                container.appendChild(document.createElement("br"));
            }
        }
        function addImages(){
          var number = document.getElementById("images_number").value;
          var image_container = document.getElementById("image_container");
          while(image_container.hasChildNodes()){
            image_container.removeChild(image_container.lastChild);
          }
          for (i=0; i<number;i++){
            // Append a node with a random text
            image_container.appendChild(document.createTextNode("Изображение " + (i+1)));
            // Create an <input> element, set its type and name attributes
            var upload = document.createElement("input");
            upload.type = "file";
            upload.name = "image" + i;
            image_container.appendChild(upload);
            // Append a line break
            image_container.appendChild(document.createElement("br"));
          }
        }
    </script>
    <meta charset="utf-8">
      <link href="../css/phpMM.css" rel="stylesheet" type="text/css" />
    <title></title>
  </head>
  <body>
    <div id="header"><h1>Создание Тест Страницы</h1></div>
    <div id="content">
        <h1>Создание Тест Страницы</h1>
        <p>Введите Задание</p>
        <form action="../includes/create_test.inc.php" method="post"
            enctype="multipart/form-data">
            <fieldset align="right">
              <fieldset style="height:200px">
                <div id="out" class="markdown-body" align = "left">

                </div>
              </fieldset>


                <label for="exercise">Текст Задание</label>
                <textarea name="exercise_text" id = "inp" cols="40" rows="10" oninput="parse()"></textarea>

                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                <div>
                  <label for="answers", align='right'>Число промежуточных:</label>
                  <input type="text" id="sub_answers_amount" name="sub_answers_amount" value=""><br />
                  <a href="#" id="filldetails" onclick="addFields()">Вывести поля для заданий</a>
                  <br>
                  <label for="test_pic">Отправка изображения:</label>
                  <input type="text" id="images_number" name="images_number" value=""/><br/>
                  <a href="#" id="filldetails" onclick="addImages()">Вывести загрузку изображения</a>
                </div>





            </fieldset>
            <fieldset>
              <div id="container", align='right'>
            </fieldset>
            <fieldset>
              <div id="image_container", align='right'>
            </fieldset>
            <fieldset>
              <select id="group" name="group">
                <option value="101">101</option>
                <option value="102">102</option>
                <option value="103">103</option>
                <option value="104">104</option>
                <option value="105">105</option>
              </select>
            </fieldset>
            <br />
            <fieldset class="center">
                <input type="submit" name="submit" value="submit">
                <input type="reset" value="Очистить и начать все сначала" />

            </fieldset>



        </form>
    </div>
    <div id="footer"></div>
    <script>

      let md, inp, out, parse;
      document.addEventListener("DOMContentLoaded", () => {
          let tm = texmath.use(katex);
          // overwrite texmath render function (suppressing katex)
          // tm.render = function(tex, isblock) { return tex; }
          md = markdownit({html:true}).use(tm,{delimiters:'dollars'});
          inp = document.getElementById('inp');
          out = document.getElementById('out');
          parse = () => { out.innerHTML = md.render(inp.value); }
          parse();
      });

    </script>
  </body>
</html>
