<?php session_start();
include('condb.php');

$_SESSION["IDTerm"] = $_SESSION["IDTermFirst"];
$_SESSION["Pagination"] = 1;

$_SESSION["IDTermStudent"] = $_SESSION["IDTermFirstStudent"];
$_SESSION["PaginationSelectStudent"] = 1;

$_SESSION["IDTermVacation"] = $_SESSION["IDTermFirstVacation"];
$_SESSION["CheckTermVacation"] = true;
$_SESSION["PaginationVacation"] = 1;

$_SESSION["IDTermCheck"] = $_SESSION["IDTermFirstCheck"];
$_SESSION["PaginationSelectCheck"] = 1;

$_SESSION["IDTermResult"] = $_SESSION["IDTermFirstResult"];
$_SESSION["PaginationSelectResult"] = 1;

$_SESSION["IDTermGraphCheck"] = $_SESSION["IDTermFirst"];

$_SESSION["NumberCheckStudent"] = "";
$_SESSION["IDCheckStudent"] = "";
$_SESSION["NameCheckStudent"] = "";
$_SESSION["TimeCheckStudent"] = ""; 
$_SESSION["StatusCheckStudent"] = "";
$_SESSION["NumberAbsentCheckStudent"] = "";
$_SESSION["NumberLateStudent"] = "";
$_SESSION["ScoreDeductedCheckStudent"] = "";

$_SESSION["NumberAbsentCheckStudentAll"] = "";
$_SESSION["NumberLateStudentAll"] = "";
$_SESSION["ScoreDeductedCheckStudentAll"] = "";


$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];


$optionsType = "";
$dataTypeArray = array();
$dataNameTypeArray = array();

$tableMessage = "";

array_push($dataTypeArray,"all");
array_push($dataTypeArray,"star");
array_push($dataTypeArray,"delete");

array_push($dataNameTypeArray,"ข้อความทั้งหมด");
array_push($dataNameTypeArray,"ติดดาว");
array_push($dataNameTypeArray,"ถังขยะ");

for($x = 0;$x < count($dataTypeArray);$x+=1){
  if($_SESSION["TypeMessage"] == $dataTypeArray[$x]){
      $optionsType  = $optionsType."<option value=$dataTypeArray[$x] selected>$dataNameTypeArray[$x]</option>";
  }else{
      $optionsType  = $optionsType."<option value=$dataTypeArray[$x] >$dataNameTypeArray[$x]</option>";
  }
}

$optionsMessage = "";
$dataMessageArray = array();
$tableMessage = "";

$queryMessage = "SELECT * FROM `inacs_message`";
$MessageData = mysqli_query($con,$queryMessage);

while($rowMessage = mysqli_fetch_assoc($MessageData)){
  if($_SESSION["TypeMessage"] == "all" && ($rowMessage['Status'] == "star" || $rowMessage['Status'] == "")){
    array_push($dataMessageArray,array($rowMessage['ID'],$rowMessage['Date'],$rowMessage['IDCourse'],$rowMessage['IDStudent'],$rowMessage['Name'],$rowMessage['Status']));
  }else if($_SESSION["TypeMessage"] == "star" && $rowMessage['Status'] == "star"){
    array_push($dataMessageArray,array($rowMessage['ID'],$rowMessage['Date'],$rowMessage['IDCourse'],$rowMessage['IDStudent'],$rowMessage['Name'],$rowMessage['Status']));
  }else if($_SESSION["TypeMessage"] == "delete" && $rowMessage['Status'] == "delete"){
    array_push($dataMessageArray,array($rowMessage['ID'],$rowMessage['Date'],$rowMessage['IDCourse'],$rowMessage['IDStudent'],$rowMessage['Name'],$rowMessage['Status']));
  }
}

rsort($dataMessageArray);



$_SESSION["CountDataMessageArray"] = count($dataMessageArray);

if($_SESSION["CountDataMessageArray"] == ($_SESSION["PaginationMessage"]-1)*5){
  $_SESSION["PaginationMessage"]-=1;
}




if(count($dataMessageArray) > 0){
  for ($x = 0; $x < 5; $x+=1) {
    $page = ($_SESSION["PaginationMessage"]-1) * 5;

    $rowDate=$dataMessageArray[$x+$page][1];
    $rowName=$dataMessageArray[$x+$page][4];
    $rowID = $dataMessageArray[$x+$page][0];
    $rowStatus=$dataMessageArray[$x+$page][5];

    $tableMessage  = $tableMessage."<tr ondblclick=document.location.href='FMessage.php?idMessage=$rowID' title=ดับเบิลคลิกเพื่อแสดงรายละเอียดของข้อความนี้>";
    $tableMessage  = $tableMessage."<td>$rowDate</td>";
    $tableMessage  = $tableMessage."<td>$rowName</td>";
    
    if($rowStatus == "star"){
      $tableMessage  = $tableMessage."<td style=text-align:center;><button name=starred class=material-icons style=color:#4CAF50;  title=คลิกเพื่อติดดาวให้ข้อความนี้ value=$rowID>star</button></td>";
    }else{
      $tableMessage  = $tableMessage."<td style=text-align:center;><button name=starred class=material-icons  title=คลิกเพื่อติดดาวให้ข้อความนี้ value=$rowID>star</button></td>";
    }

    if($rowStatus == "delete"){
      $tableMessage  = $tableMessage."<td style=text-align:center;><button name=trash class=material-icons style=color:#4CAF50; title=คลิกเพื่อให้ข้อความนี้ลงถังขยะ value=$rowID>delete</button></td>";
    }else{
      $tableMessage  = $tableMessage."<td style=text-align:center;><button name=trash class=material-icons title=คลิกเพื่อให้ข้อความนี้ลงถังขยะ  value=$rowID>delete</button></td>";
    }

    $tableMessage  = $tableMessage."</tr>";

    if($x+$page >= count($dataMessageArray)-1){
        break;
    }

  }
}

$_SESSION["Messagetable"] = $tableMessage;




$lastPage = 0;
if($_SESSION["PaginationMessage"] == 1){
    $Pagination = $Pagination."<input type=submit name=Pagination value=&laquo; disabled></input>";
}else{
    $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อย้อนกลับไปตารางก่อนหน้า value=&laquo; ></input>";
}

for ($x = 0; $x*5 < count($dataMessageArray);) {
    $x+=1;
    if($_SESSION["PaginationMessage"] == $x){
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x class=active value=$x ></input>";
    }else{
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x value=$x ></input>";
    }
    $lastPage = $x;
}

if($_SESSION["PaginationMessage"] == $lastPage || ($_SESSION["PaginationMessage"] == 1 && $lastPage == 0)){
    $Pagination = $Pagination."<input type=submit name=Pagination value=&raquo; disabled></input>";
}else{
    $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางถัดไป value=&raquo; ></input>";
}

$_SESSION["PaginationMessageTable"] = $Pagination;



?>
<?php
include('h.php');
?>

<body>
<style>
    

</style>

<?php



?>

<div class="navbar-div">
        <nav class="navbarv-2 is-dodgerblue" aria-label="main navigation">
            <a class="navbar-item banner">
                <div>
                    <span class="navbar-banner-text">InACS</span>
                </div>
            </a>
            <button id="navbar-user" class="navbar-item user" onclick="if (document.getElementById('navbar-dropdown').classList.contains('is-active'))  return document.getElementById('navbar-dropdown').classList.remove('is-active'); else return document.getElementById('navbar-dropdown').classList.add('is-active');">
                <div class="user-container" title="คลิกเพื่อแสดง/ปิด navbar">
                    <svg class="navbar-user-iconv-2 iconv-2-user iconv-2-size-5"></svg>
                    <span class="navbar-user-text"><?php echo $name; ?></span>
                    <svg class="navbar-user-iconv-2 iconv-2-down-arrow iconv-2-size-6"></svg>
                </div>
                <div id="navbar-dropdown" class="dropdown-items">
                    <a onclick="document.getElementById('ChangePassFormv.2').style.display='block'">
                      <i class="iconv-2-lock"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนรหัสผ่าน</div>
                    </a>
                    <a onclick="document.getElementById('ChangeEmail').style.display='block'">
                    <i class="iconv-2-a"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนอีเมล</div>
                    </a>
                    <a href="logout.php">
                    <i class="iconv-2-logout"></i>
                      <div class="maginTextNavbar-dropdown">ออกจากระบบ</div>
                    </a>
                </div>
            </button>
        </nav>
</div>

    <nav class="menu main-menu">
        <div class="menu-space"></div>
        <div class="menu-space"></div>
        <ul class="menu-list">
            <li>
                <a href="index.php">
                <svg class="menu-icon iconv-2-home"></svg>หน้าแรก
                </a>
            </li>
            <li>
                <a href="message.php" class="is-black-blue">
                <svg class="menu-icon iconv-2-mail"></svg>ข้อความ
                </a>
            </li>
            <li>
                <a href="select-course-check.php">
                <svg class="menu-icon iconv-2-check"></svg>เช็คชื่อนิสิต
                </a>
            </li>
            <li>
                <a href="select-course-results.php">
                <svg class="menu-icon iconv-2-clipboard"></svg>ผลการเช็คชื่อ
                </a>
            </li>
            <li>
                <a href="course-management.php">
                <svg class="menu-icon iconv-2-bag"></svg>จัดการรายวิชา
                </a>
            </li>
            <li>
                <a href="select-course-student.php">
                <svg class="menu-icon iconv-2-student-cap"></svg>จัดการนิสิต
                </a>
            </li>
            <li>
                <a href="timetable.php">
                <svg class="menu-icon iconv-2-table"></svg>ตารางสอน
                </a>
            </li>
            <li>
                <a href="vacation.php">
                <svg class="menu-icon iconv-2-backpack"></svg>การลา
                </a>
            </li>
            <li>
                <a href="setting.php">
                <svg class="menu-icon iconv-2-cog"></svg>ตั้งค่าระบบ
                </a>
            </li>
            <li>
                <a href="logout.php">
                <svg class="menu-icon iconv-2-logout"></svg>ออกจากระบบ
                </a>
            </li>
        </ul>
    </nav>

<div class="subcontent-area">
        <div class="subcontent-main-div index">
            <div class="box with-title is-round">
                <div class="box-title is-dodgerblue">
                    <svg class="menu-icon-topic iconv-2-mail"></svg>ข้อความ
                </div>
                <div class="box">
                <div class="columns">
                    <!--<div class="column is-2">
                    <br>
                    <div class="div-message">
                        <button class="message" onClick="document.location.href='message.php'"><b>ข้อความทั้งหมด</b></button><br>
                        <button class="message-no-click" onClick="document.location.href='message-star.php'"><b>ติดดาว</b></button><br>
                        <button class="message-no-click" onClick="document.location.href='message-bin.php'"><b>ถังขยะ</b></button><br>
                        <br><br><br><br><br>
                    </div>
                    </div>-->
                    <div class="column is-8">
                    <br>
                    <div class="set-flex">
                        <h4 style="padding-top: 0; margin-top: 1.5%; margin-left: 3%; margin-right: 1%;">หมวด : </h4>
                        <div class="select-input " style="width:15%; margin-top: 0.8%; margin-right: 59.3%;">
                            <form name="changeType" action="FMessage.php" method="post" style="margin-bottom: 0%;">
                            <select name="types" onchange="document.changeType.submit();" style="width:100%; height: auto; padding: 5px 2px;" title="คลิกเพื่อเลือกหมวดของข้อความที่ต้องการดู"> 
                                <?php echo $optionsType;?>
                            </select>
                            </form>
                        </div>
                        <!--<button class="small"><i class="material-icons">star</i></button>
                        <button class="small"><i class="material-icons">delete</i></button>-->
                        <!--<button class="small"><i class="material-icons">chevron_left</i></button>
                        <button class="small"><i class="material-icons">chevron_right</i></button>-->
                    </div>
                    <table class="table-message" id="table-starter" style="margin-top: 1.5%; margin-left: 3%; width:97%;">
                        <tr>
                            <th>วันที่ส่ง</th>
                            <th>เรื่อง</th>
                            <th>ติดดาว</th>
                            <th>ถังขยะ</th>
                        </tr>
                        <form name="StarOrBin" action="FMessage.php" method="post" style="margin-bottom: 0%;">
                            <?php
                                echo $_SESSION["Messagetable"] ;
                            ?>
                        </form>
                    </table>
                    <div class="pagination" style="width: 100%; text-align: center;">
                            <div style="display: inline-block;">
                            <form name="changePagination" action="FMessage.php" method="post" style="margin-bottom: 0%;">
                                <?php
                                    echo $_SESSION["PaginationMessageTable"] ;
                                ?>
                            </form>
                            </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>

<div id="ChangePassFormv.2" class="modal">
  
<form class="modal-content animate" action="FChangePassword.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนรหัสผ่าน</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginNewPass"><b>New Password :</b></div>
        <input class="is-pulled-right input-field-v1 " style="width: 60.5%;" type="textRegis" name="new-password" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginCurPass"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1 " style="width: 60.5%;" type="password" name="curr-password" value="<?php echo $password; ?>" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginRepPass"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1" style="width: 60.5%;"  type="password" name="rep-password" value="" autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePass"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>



  <div id="ChangeEmail" class="modal">
  
  <form class="modal-content animate" action="FChangeEmail.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนอีเมล</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v2" style="width: 84.5%;" type="textRegis" name="email" value="<?php echo $email; ?>" autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changeEmail"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>



<?php if($_SESSION['CheckOpenModalMessageDetail'] == true){ ?>
<div id="MessageDetail" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="/action_page.php" method="post">

    <h2 class="text-topic" align="center">ข้อความ</h2>
    
  <div class="input-container"></div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>วันที่ส่ง :</b></div>
        <div class="sizeText maginChangEmail"><?php echo $_SESSION["DateMessage"]; ?></div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>เรื่อง :</b></div>
        <div class="sizeText maginChangEmail"><?php echo $_SESSION["NameMessage"]; ?></div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>ชื่อวิชา :</b></div>
        <div class="sizeText maginChangEmail"><?php echo $_SESSION["NameCourseMessage"]; ?></div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>รหัสนิสิต :</b></div>
        <div class="sizeText maginChangEmail"><?php echo $_SESSION["NumberStudentMessage"]; ?></div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>ชื่อนิสิต :</b></div>
        <div class="sizeText maginChangEmail"><?php echo $_SESSION["NameStudentMessage"]; ?></div>
  </div>

  <div class="button-zone">
  <button type="button" onclick="document.getElementById('MessageDetail').style.display='none'" class="cancel"><b>ออก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalMessageDetail'] = false;
} ?>



</body>
</html>







