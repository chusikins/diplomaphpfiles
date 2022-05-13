<?php include_once "navbar.php" ?>

    <div class="wrapper">
    <div id="header"><h1>Создание Тест Страницы</h1></div>
    <div id="content">
        <p>Введите Задание</p>
        <div class="form">


        <form action="../includes/create_test.inc.php" method="post">

            <fieldset>
              <fieldset>
                <div id="out" class="markdown-body"></div>
              </fieldset>
              <div class="">
                <label>Текст Задание</label>

                <textarea name="exercise_text" id = "inp" oninput="parse()"></textarea>
                <!-- <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> -->
              </div>



                  <br>
                  <label for="test_pic">Отправка изображения:</label>
                  <input type="text" id="images_number" name="images_number" value=""/><br/>
                  <a href="#" id="filldetails" onclick="addImages()">Вывести загрузку изображения</a>

            </fieldset>


            <fieldset>
              <button type="button" name="addfield" id="addfield" class="button" onclick="addFields()">Новое задание</button>
              <button type="button" name="button" onclick="deleteField()">AAAAA</button>
                <div id="sub_answer_container">
                  <label for="answers">Число промежуточных:</label>
                  <br>
                  Задание 1:
                  <input type="hidden" name="sub_answer_amount" id = "sub_answer_amount" value="">
                  <input type="text" id="sub_text1" name="sub_text1" value="">
                  <input type="text" id="member1" name="member1" value="">
                  <br>
                </div>
            </fieldset>



            <fieldset>
              <div id="image_sub_answer_container">
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
            <fieldset>
                <input type="submit" name="submit" value="submit">
                <input type="reset" value="Очистить и начать все сначала" />

            </fieldset>



        </form>
        </div>
        </div>

    </div>
    </div>
    <div id="footer"></div>
    <script type="text/javascript">
    var i = 1;
    //скрипт JS для создания ячеек для промежуточных заданий
    function addFields(){
        i++;
        var sub_answer_container = document.getElementById("sub_answer_container");
        var sub_answer_amount = document.getElementById("sub_answer_amount")

        // var newDiv = document.createElement("div");
        // var oldDiv = document.getElementById("submarker");
        // if (oldDiv){
        //   oldDiv.setAttribute("id", "temp");
        // }
        //   newDiv.setAttribute("id", "marker"+i);



        var input = document.createElement("input");
        input.type = "text";
        input.setAttribute("placeholder", "Ответ");
        input.setAttribute("name", "member" + i);
        input.setAttribute("id", "member" + i);

        var sub_answer_text = document.createElement("input");
        sub_answer_text.type = "text";
        sub_answer_text.name = "sub_text" + i;
        sub_answer_text.id = "sub_text" + i;
        sub_answer_text.setAttribute("placeholder", "Вопрос");


        // var button = document.createElement("button");
        // var old_button = document.getElementById("addfield");
        // button.setAttribute("onclick", "addFields()");
        // button.setAttribute("id", "addfield");
        // button.setAttribute("class", "button");
        // button.textContent = "Добавить задание";
        // old_button.remove();




        // newDiv.appendChild(document.createTextNode("Задание " + (i) + ":"));
        // newDiv.appendChild(sub_answer_text);
        // newDiv.appendChild(input);
        // newDiv.appendChild(document.createElement("br"));
        // sub_answer_container.appendChild(newDiv);

        sub_answer_container.appendChild(document.createTextNode("Задание " + (i) + ":"));
        sub_answer_container.appendChild(sub_answer_text);
        sub_answer_container.appendChild(input);
        sub_answer_container.appendChild(document.createElement("br"));

        sub_answer_amount.setAttribute("value", i);

        // var lastfield = document.getElementById("temp");
        // lastfield.setAttribute("oninput", "dummy()");
        // lastfield.setAttribute("name", "member" + i);
        // lastfield.setAttribute("id", "member" + i );
        // sub_answer_container.appendChild(document.createTextNode("Задание " + (i)));
        // var input = document.createElement("input");
        // var sub_answer_text = document.createElement("input");
        // input.type = "text";
        // input.id = "temp";
        // input.setAttribute("placeholder", i);
        // input.setAttribute("oninput", "addFields()");
        // input.setAttribute("id","temp");
        // sub_answer_text.type = "text";
        // sub_answer_text.name = "sub_text" + i;
        // sub_answer_text.setAttribute("placeholder", "Вопрос");
        // sub_answer_container.appendChild(sub_answer_text);
        // sub_answer_container.appendChild(input);
        // sub_answer_container.appendChild(document.createElement("br"));

        // // Number of inputs to create
        // var number = document.getElementById("sub_answers_amount").value;
        // //  <div> where dynamic content will be placed
        // var sub_answer_container = document.getElementById("sub_answer_container");
        // // Clear previous contents of the sub_answer_container
        // while (sub_answer_container.hasChildNodes()) {
        //     sub_answer_container.removeChild(sub_answer_container.lastChild);
        // }

    }

    function deleteField(){
      var divtodelete = document.getElementById("marker"+i);
      if (divtodelete){
      divtodelete.remove();
      i--;
      sub_answer_amount.setAttribute("value", i);}

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
    <script type='text/javascript'>



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
