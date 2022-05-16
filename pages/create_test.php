<?php include_once "navbar.php" ?>

    <div class="wrapper">
    <div id="header"><h1>Создание Тест Страницы</h1></div>
    <div id="content">
        <p>Введите Задание</p>
        <div class="form">


        <form action="../includes/create_test.inc.php" method="post" enctype="multipart/form-data">

            <fieldset>
              <fieldset>
                <div id="out" class="markdown-body"></div>
              </fieldset>
              <div class="">
                <label>Название Задачи</label>
                <input type="text" name="ex_name">
                <label>Текст Задачи</label>
                <textarea name="exercise_text" id = "inp" oninput="parse()"></textarea>
              </div>
              <select id="group" name="group">
                <option value="101">101</option>
                <option value="102">102</option>
                <option value="103">103</option>
                <option value="104">104</option>
                <option value="105">105</option>
              </select>
            </fieldset>


            <fieldset>
              <button type="button" name="addfield" id="addfield" class="button" onclick="addFields()">Новая Контрольная Точка</button>
              <button type="button" name="button" onclick="deleteField()" class="button">Удалить последнее</button>
              <select id="addfieldselector" name="addfieldselector">
                <option value="0">Число</option>
                <option value="1">Изображение</option>
              </select>
                <div id="sub_answer_container">
                  <label>Число Конторльных Точек:</label>
                  Контрольная Точка 1:
                  <br>
                  <input type="hidden" name="sub_answer_amount" id = "sub_answer_amount" value="1">
                  <input type="text" id="sub_text1" name="sub_text1" placeholder="Вопрос">
                  <input type="text" id="member1" name="member1" placeholder="Ответ">
                  <br>
                </div>
            </fieldset>



            <fieldset>

              <label for="test_pic">Отправка изображения:</label>

              <input type="text" id="images_number" name="images_number" value=""/><br/>
              <a href="#" id="filldetails" onclick="addImages()">Вывести загрузку изображения</a>
              <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
              <div id="image_container">

              </div>
            </fieldset>
            <fieldset>

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
    <div id="footer"></div>
    <script type="text/javascript">
    var i = 1;
    //скрипт JS для создания ячеек для промежуточных заданий
    function addFields(){
        i++;
        var sub_answer_container = document.getElementById("sub_answer_container");
        var sub_answer_amount = document.getElementById("sub_answer_amount")
        var br = document.createElement("br");
        br.id = "br";

        var input = document.createElement("input");
        if (document.getElementById("addfieldselector").value == "1"){

          input.type = "hidden";
          input.value = "image";
          input.setAttribute("name", "member" + i);
          input.setAttribute("id", "member" + i);
        } else{
          input.type = "text";
          input.setAttribute("placeholder", "Ответ");
          input.setAttribute("name", "member" + i);
          input.setAttribute("id", "member"+ i);
        }


        var sub_answer_text = document.createElement("input");
        sub_answer_text.type = "text";
        sub_answer_text.name = "sub_text" + i;
        sub_answer_text.id = "sub_text" + i;
        sub_answer_text.setAttribute("placeholder", "Вопрос");

        var text = document.createElement("p");
        text.innerText = "Контрольная Точка " + i + ":";
        text.id = "text" + i;

        sub_answer_container.appendChild(text);
        sub_answer_container.appendChild(sub_answer_text);
        sub_answer_container.appendChild(input);
        if (input.type == "hidden") {
          sub_answer_container.appendChild(document.createTextNode("Ответ студента - изображение"));
        }
        sub_answer_container.appendChild(br);

        sub_answer_amount.setAttribute("value", i);


    }

    function deleteField(){
      if (i===1){return;}
      var divtodelete = document.getElementById("member"+i);
      var subtodelete = document.getElementById("sub_text"+i);
      var texttodelete = document.getElementById("text"+i);
      var brtodelete = document.getElementById("br");
      if (divtodelete){
      divtodelete.remove();
      subtodelete.remove();
      texttodelete.remove();
      brtodelete.remove();
      i--;
      sub_answer_amount.setAttribute("value", i);
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
