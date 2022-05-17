<?php
require_once "navbar.php";


if ($_SESSION["userPermission"] !== 'student'){
  header("location: ../pages/login.php?error=logerror");
  exit();
}
require_once '../includes/functions.inc.php';
//weird '' and "" shit, look into it.......

$group = $_SESSION["userGroup"];
$userid = $_SESSION["userid"];
$jsonTests=displayTests($link,$group,$userid);
 ?>
    <div class="wrapper">
    <div class="indent">
       <p id="test">Привет <?php echo $_SESSION["userName"] ?> !</p>
    </div>
       <table>

       </table>
     </div>
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
           if ((data[Object.keys(data)[key]][i].localeCompare("completed") == 0) || (data[Object.keys(data)[key]][i].localeCompare("pending") == 0)) {
             let cell = row.insertCell();
             let text = document.createTextNode(data[Object.keys(data)[key]][i]);
             cell.appendChild(text);
           } else {
             let a = document.createElement('a');
             let cell = row.insertCell();
             let linkText = document.createTextNode("link");
             a.appendChild(linkText);
             a.href = data[Object.keys(data)[key]][i];
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
   let obj = <?php echo $jsonTests; ?>;
   let table = document.querySelector("table");
   let data = Object.keys(obj);
   generateTableHead(table, data);
   generateTable(table, obj);

   </script>
 </html>
