<!DOCTYPE html>

<?php
include('h.php');
?>
<?php if(isset($_GET['logout']) && $_GET['logout'] === 'true'){
        $message = "You've been logged out!";
    ?>

<div id="EditCourse" class="modal">
  
  <form class="modal-content animate" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%">แก้ไขข้อมูลรายวิชา</h3>

    <div class="input-textCourse">
        <div class="sizeText maginNumCourse"><b>รหัสวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NumCourse" value=<?php echo $_SESSION['NumberCourseEdit']; ?> >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginNameCourse"><b>ชื่อวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NameCourse" value=<?php echo $_SESSION['NameCourseEdit']; ?> >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginGroupCourse"><b>กลุ่มเรียน :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="GroupCourse" value=<?php echo $_SESSION['GroupCourseEdit']; ?> >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginTypeCourse"><b>ประเภท (Lecture/Lab) :</b></div>
        <!--<input type="checkbox" class="myinput large" checked="checked"style="margin-top:2.5%;" name="CheckBoxType[]" value="Lecture"/>
        <div style="margin-top:2.5%; margin-right:10%; margin-left:2%;"><b>Lecture</b></div>
        <input type="checkbox" class="myinput large" style="margin-top:2.5%;" name="CheckBoxType[]" value="Lab"/>
        <div style="margin-top:2.5%; margin-left:2%;"><b>Lab</b></div>--->

        <select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;">
            <?php
                echo $_SESSION["EditCourseFormType"] ;
            ?>
            <!--<option value="Lecture">Lecture</option>
            <option value="Lab">Lab</option>-->
        </select>

  </div>

  <div class="input-textCourse">
        <div class="sizeText maginRoomCourse"><b>ห้องเรียน :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="RoomCourse" value=<?php echo $_SESSION['RoomCourseEdit']; ?> >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginTimeLateCourse"><b>เวลามาสาย (นาที) :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="TimeLateCourse" value=<?php echo $_SESSION['TimelateCourseEdit']; ?> >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginDayCourse"><b>วันที่สอน :</b></div>
        <select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;">
            <?php
                echo $_SESSION["EditCourseFormDay"] ;
            ?>
            <!--<option value="Mo">จันทร์</option>
            <option value="Tu">อังคาร</option>
            <option value="We">พุธ</option>
            <option value="Th">พฤหัสบดี</option>
            <option value="Fr">ศุกร์</option>
            <option value="Sa">เสาร์</option>
            <option value="Su">อาทิตย์</option>-->
        </select>
  </div>
  
  <div class="input-textCourse" style="margin-bottom: 3%">
        <div class="sizeText maginTimeCourse"><b>เวลาที่สอน :</b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourse-1" value=<?php echo $_SESSION['TimeStartCourseEdit']; ?> >
        <div class="sizeText" style="margin: 1.8% 1.1% 0% 1.1%"><b> - </b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourse-2" value=<?php echo $_SESSION['TimeEndCourseEdit']; ?> >

        <!--<select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;">
            <option value="1">8:00-9:00</option>
            <option value="2">9:00-10:00</option>
            <option value="3">10:00-11:00</option>
            <option value="4">11:00-12:00</option>
            <option value="5">12:00-13:00</option>
            <option value="6">13:00-14:00</option>
            <option value="7">14:00-15:00</option>
            <option value="8">15:00-16:00</option>
            <option value="9">16:00-17:00</option>
            <option value="10">17:00-18:00</option>
            <option value="11">18:00-19:00</option>
            <option value="12">19:00-20:00</option>
            <option value="13">20:00-21:00</option>
        </select>-->
  </div>

  <!--<div class="input-textCourse">
        <div class="sizeText maginStudentCourse"><b>จำนวนนิสิต :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="StudentCourse" value="" >
  </div>-->

  <div class="button-course-zone">
  <button type="submit" class="register" name="editCourse"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('EditCourse').style.display='none'" class="register course-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>

    <?php } ?>

<!--
$EditCourseForm = $EditCourseForm."<h3 class=text-topic align=center style=margin-bottom:3%>แก้ไขข้อมูลรายวิชา</h3>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginNumCourse><b>รหัสวิชา :</b></div>";
$EditCourseForm = $EditCourseForm."<input class=is-pulled-right input-field-v5 type=textRegis name=NumCourse value=<?php echo $_SESSION[IDCourseEdit]; ?> >";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginNameCourse><b>ชื่อวิชา :</b></div>";
$EditCourseForm = $EditCourseForm."<input class=is-pulled-right input-field-v5 type=textRegis name=NameCourse value= >";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginGroupCourse><b>กลุ่มเรียน :</b></div>";
$EditCourseForm = $EditCourseForm."<input class=is-pulled-right input-field-v5 type=textRegis name=GroupCourse value= >";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginTypeCourse><b>ประเภท (Lecture/Lab) :</b></div>";
$EditCourseForm = $EditCourseForm."<input type=checkbox class=myinput large checked=checkedstyle=margin-top:2.5%; name=CheckBoxType[] value=Lecture/>";
$EditCourseForm = $EditCourseForm."<div style=margin-top:2.5%; margin-right:10%; margin-left:2%;><b>Lecture</b></div>";
$EditCourseForm = $EditCourseForm."<input type=checkbox class=myinput large style=margin-top:2.5%; name=CheckBoxType[] value=Lab/>";
$EditCourseForm = $EditCourseForm."<div style=margin-top:2.5%; margin-left:2%;><b>Lab</b></div>";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginRoomCourse><b>ห้องเรียน :</b></div>";
$EditCourseForm = $EditCourseForm."<input class=is-pulled-right input-field-v5 type=textRegis name=RoomCourse value= >";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginTimeLateCourse><b>เวลามาสาย (นาที) :</b></div>";
$EditCourseForm = $EditCourseForm."<input class=is-pulled-right input-field-v5 type=textRegis name=TimeLateCourse value= >";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginDayCourse><b>วันที่สอน :</b></div>";
$EditCourseForm = $EditCourseForm."<select style=width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;>";
$EditCourseForm = $EditCourseForm."<option value=Mo >จันทร์</option>";
$EditCourseForm = $EditCourseForm."<option value=Tu>อังคาร</option>";
$EditCourseForm = $EditCourseForm."<option value=We>พุธ</option>";
$EditCourseForm = $EditCourseForm."<option value=Th>พฤหัสบดี</option>";
$EditCourseForm = $EditCourseForm."<option value=Fr>ศุกร์</option>";
$EditCourseForm = $EditCourseForm."<option value=Sa>เสาร์</option>";
$EditCourseForm = $EditCourseForm."<option value=Su>อาทิตย์</option>";
$EditCourseForm = $EditCourseForm."</select>";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=input-textCourse style=margin-bottom: 3%>";
$EditCourseForm = $EditCourseForm."<div class=sizeText maginTimeCourse><b>เวลาที่สอน :</b></div>";
$EditCourseForm = $EditCourseForm."<input class=is-pulled-right input-field-v10 type=time name=TimeCourse-1 value= >";
$EditCourseForm = $EditCourseForm."<div class=sizeText style=margin: 1.8% 1.1% 0% 1.1%><b> - </b></div>";
$EditCourseForm = $EditCourseForm."<input class=is-pulled-right input-field-v10 type=time name=TimeCourse-2 value= >";
$EditCourseForm = $EditCourseForm."</div>";

$EditCourseForm = $EditCourseForm."<div class=button-course-zone>";
$EditCourseForm = $EditCourseForm."<button type=submit class=register name=editCourse><b>บันทึก</b></button>";
$EditCourseForm = $EditCourseForm."<button type=button onclick=document.getElementById('EditCourse').style.display='none' class=register course-cancle is-red><b>ยกเลิก</b></button>";
$EditCourseForm = $EditCourseForm."</div>";-->

<html>
<head>

<style type="text/css">
 li { list-style-type: none; display: inline; padding: 10px; text-align: center;}
// li:hover { background-color: yellow; }
</style>

</head>
<body>
<form action="." method="POST">
Name: <input type="text" name="name"/><br />
<input type="submit" value=" Enter "/>
</form>

<h1>List of companies ..</h1>
<ul>
<?php
	while( $row = mysql_fetch_array($res) )
	  echo "<li>$row[id]. <li>$row[name]</li> 
                <li><a href='edit.php?edit=$row[id]'>edit</a></li>
                <li><a href='delete.php?del=$row[id]'>delete</a></li><br />";
?>
</ul>
</body>
</html>




<?php
			$targetDate = strtotime("2020-01-5 12:00:00"); // whatever your target date is
			$current=strtotime('now'); //setting current date
 
			$diffference =($targetDate-$current);//getting diffference between 2 date
 
			$days=floor($diffference / (60*60*24));
			echo "$days days left on Diwali";
		?>

<script>
$(document).ready(function() {
    setInterval(function(){
        $('#time').load('time.php')
    } ,1000);
});
  </script>


<html> 
    <body> 
        <!--name.php to be called on form submission--> 
        <form method = 'post'>  
        <div id="time">
          00 : 00 : 00
        </div>

            <h4>SELECT SUJECTS</h4> 
              
            <select name = 'subject[]' multiple size = 6>   
                <option value = 'english'>ENGLISH</option> 
                <option value = 'maths'>MATHS</option> 
                <option value = 'computer'>COMPUTER</option> 
                <option value = 'physics'>PHYSICS</option> 
                <option value = 'chemistry'>CHEMISTRY</option> 
                <option value = 'hindi'>HINDI</option> 
            </select> 
            <input type = 'submit' name = 'submit' value = Submit> 
        </form>
        
        
    </body> 
</html> 
<?php 
      
      if (isset($_POST['Register']))
      {
          $ErrorArrays = array (); //Empty array for input errors 
  
          $Input_Username = $_POST['Username'];
          $Input_Password = $_POST['Password'];
          $Input_Confirm = $_POST['ConfirmPass'];
          $Input_Email = $_POST['Email'];
  
          if (empty($Input_Username))
          {
              $ErrorArrays[] = "Username Is Empty";
          }
          if (empty($Input_Password))
          {
              $ErrorArrays[] = "Password Is Empty";
          }
          if ($Input_Password !== $Input_Confirm)
          {
              $ErrorArrays[] = "Passwords Do Not Match!";
          }
          if (!filter_var($Input_Email, FILTER_VALIDATE_EMAIL))
          {
              $ErrorArrays[] = "Incorrect Email Formatting";
          }
  
          if (count($ErrorArrays) == 0)
          {
              // No Errors
          }
          else
          {
              foreach ($ErrorArrays AS $Errors)
              {
                  echo "<font color='red'><b>".$Errors."</font></b><br>";
              }
          }
      }
  
  ?>
  

      <form method="POST"> 
          Username: <input type='text' name='Username'> <br>
          Password: <input type='password' name='Password'><br>
          Confirm Password: <input type='password' name='ConfirmPass'><br>
          Email: <input type='text' name='Email'> <br><br>
  
          <input type='submit' name='Register' value='Register'>
  
  
      </form> 





















<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
/*the container must be positioned relative:*/
.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element:*/
}

.select-selected {
  background-color: DodgerBlue;
}

/*style the arrow inside the select element:*/
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

/*style the items (options), including the selected item:*/
.select-items div,.select-selected {
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}

/*style items (options):*/
.select-items {
  position: absolute;
  background-color: DodgerBlue;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}

/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}
</style>
</head>     

<body>

<h2>Custom Select</h2>

<!--surround the select box with a "custom-select" DIV element. Remember to set the width:-->
<div class="custom-select" style="width:11%;">
  <select name="car">
    <option value="0">Select car:</option>
    <option value="1">Audi</option>
    <option value="2">BMW</option>
    <option value="3">Citroen</option>
    <option value="4">Ford</option>
    <option value="5">Honda</option>
    <option value="6">Jaguar</option>
    <option value="7">Land Rover</option>
    <option value="8">Mercedes</option>
    <option value="9">Mini</option>
    <option value="10">Nissan</option>
    <option value="11">Toyota</option>
    <option value="12">Volvo</option>
  </select>
</div>

<h2>JavaScript Alert</h2>

<button onclick="myFunction()">Try it</button>

<script>
function myFunction() {
  alert("I am an alert box!");
}
</script>

<?php
echo $_POST["car"];

echo "<hr>";
?>

<script>
var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}


function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>

</body>
</html>

