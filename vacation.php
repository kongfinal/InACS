<?php session_start();

include('condb.php');
$_SESSION["IDTerm"] = $_SESSION["IDTermFirst"];
$_SESSION["Pagination"] = 1;

$_SESSION["IDTermStudent"] = $_SESSION["IDTermFirstStudent"];
$_SESSION["PaginationSelectStudent"] = 1;

$_SESSION["IDTermCheck"] = $_SESSION["IDTermFirstCheck"];
$_SESSION["PaginationSelectCheck"] = 1;

$_SESSION["IDTermResult"] = $_SESSION["IDTermFirstResult"];
$_SESSION["PaginationSelectResult"] = 1;

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

$_SESSION["TypeMessage"] = "all";
$_SESSION["PaginationMessage"] = 1;


$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];


$queryTerm = "SELECT * FROM `inacs_term`";
$termSelect = mysqli_query($con,$queryTerm);

$optionsTerm = "";
$dataTerm = array();

while($rowTerm = mysqli_fetch_array($termSelect)){
    array_push($dataTerm,array($rowTerm[2],$rowTerm[1],$rowTerm[0]));
}

sort($dataTerm);

$_SESSION["IDTermFirstVacation"] = $dataTerm[count($dataTerm)-1][2];

for ($x = count($dataTerm)-1; $x >= 0; $x-=1) {
    $idTerm = $dataTerm[$x][2];
    $NumTerm = $dataTerm[$x][1];
    $YearTerm = $dataTerm[$x][0];
    if($_SESSION["IDTermVacation"] == $idTerm){
        $optionsTerm  = $optionsTerm."<option value=$idTerm selected>$NumTerm/$YearTerm</option>";
    }else{
        $optionsTerm  = $optionsTerm."<option value=$idTerm>$NumTerm/$YearTerm</option>";
    } 
}



$queryCourse = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermVacation"]."' AND NameTeacher='$name'";
$courseSelect = mysqli_query($con,$queryCourse);

$optionsCourse = "";
$dataCourse = array();

while($rowCourse = mysqli_fetch_assoc($courseSelect)){
  array_push($dataCourse,array($rowCourse['Number'],$rowCourse['Name'],$rowCourse['GroupCourse'],$rowCourse['ID'],$rowCourse['Type']));
}

sort($dataCourse);

$_SESSION["IDCourseFirstVacation"] = $dataCourse[0][3];
if($_SESSION["CheckTermVacation"]){
  $_SESSION["IDCourseVacation"] = $_SESSION["IDCourseFirstVacation"];
  $_SESSION["CheckTermVacation"] = false;
}

for ($x = 0; $x < count($dataCourse); $x+=1) {
  $NumCourse = $dataCourse[$x][0];
  $NameCourse = $dataCourse[$x][1];
  $GroupCourse = $dataCourse[$x][2];
  $TypeCourse = $dataCourse[$x][4];
  $idCourse = $dataCourse[$x][3];

  if($_SESSION["IDCourseVacation"] == $idCourse){
      $optionsCourse  = $optionsCourse."<option value=$idCourse selected>$NumCourse&nbsp$NameCourse&nbspกลุ่ม&nbsp$GroupCourse&nbspประเภท&nbsp$TypeCourse</option>";
      $_SESSION['NameCourseVacation'] = $NameCourse;
  }else{
      $optionsCourse  = $optionsCourse."<option value=$idCourse >$NumCourse&nbsp$NameCourse&nbspกลุ่ม&nbsp$GroupCourse&nbspประเภท&nbsp$TypeCourse</option>";
  } 
}

addVacationtoTable($_SESSION["IDCourseVacation"]);


?>
<?php
include('h.php');

function addVacationtoTable($IdCourseSearch){
  include('condb.php');
  $queryVacation = "SELECT * FROM `inacs_vacation` WHERE IDCourse='$IdCourseSearch' ";
  $VacationTable = mysqli_query($con,$queryVacation);
  $tableVacation = "";
  $dataVacation = array();

  if(mysqli_num_rows($VacationTable) > 0){
    while ($row = mysqli_fetch_assoc($VacationTable)) {
        array_push($dataVacation,array($row['IDCourse'],$row['IDStudent'],$row['NotificationDate'],$row['Detail'],$row['TimeStart'],$row['TimeEnd'],$row['ID']));
    }
  }

  if(mysqli_num_rows($VacationTable) > 0){
      for ($x = 0; $x < 5; $x+=1) {
        $page = ($_SESSION["PaginationVacation"]-1) * 5;

        $rowID=$dataVacation[$x+$page][6];
        $rowIDStudent=$dataVacation[$x+$page][1];
        $rowNotificationDate=$dataVacation[$x+$page][2];
        $rowDetail=$dataVacation[$x+$page][3];
        $rowTimeStart=$dataVacation[$x+$page][4];
        $rowTimeEnd=$dataVacation[$x+$page][5];

        $queryStudent = "SELECT * FROM `inacs_student` WHERE ID='$rowIDStudent' ";
        $StudentTable = mysqli_query($con,$queryStudent);

        if(mysqli_num_rows($StudentTable) == 1){
          while ($row = mysqli_fetch_assoc($StudentTable)) {
            $rowNumberStudent = $row['Number'];
            $rowNameStudent = $row['Name'];
          }
        }

        $tableVacation  = $tableVacation."<tr>";
        $tableVacation  = $tableVacation."<td>$rowNotificationDate</td>";
        $tableVacation  = $tableVacation."<td>$rowNumberStudent</td>";
        $tableVacation  = $tableVacation."<td>$rowNameStudent</td>";
        $tableVacation  = $tableVacation."<td>$rowDetail</td>";
        $tableVacation  = $tableVacation."<td>$rowTimeStart&nbsp-&nbsp$rowTimeEnd</td>";
        $tableVacation  = $tableVacation."<td style=cursor:pointer; ><button name=editVacationModal class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;แก้ไขข้อมูลการลา value=$rowID>edit</button></td>";
        $tableVacation  = $tableVacation."<td style=cursor:pointer; > <button name=deleteVacationModal  class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;ลบข้อมูลการลา value=$rowID>remove_circle_outline</button> </td>";
        $tableVacation  = $tableVacation."</tr>";

        if($x+$page >= count($dataVacation)-1){
            break;
        }
    }
  }

  CreatePagination(mysqli_num_rows($VacationTable));
  return $_SESSION["VacationTable"] = $tableVacation;
}


function CreatePagination($VacationNum){

  $lastPage = 0;
  if($_SESSION["PaginationVacation"] == 1){
      $Pagination = $Pagination."<input type=submit name=Pagination value=&laquo; disabled></input>";
  }else{
      $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อย้อนกลับไปตารางก่อนหน้า value=&laquo; ></input>";
  }
  
  for ($x = 0; $x*5 < $VacationNum;) {
      $x+=1;
      if($_SESSION["PaginationVacation"] == $x){
          $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x class=active value=$x ></input>";
      }else{
          $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x value=$x ></input>";
      }
      $lastPage = $x;
  }

  if($_SESSION["PaginationVacation"] == $lastPage || ($_SESSION["PaginationVacation"] == 1 && $lastPage == 0)){
      $Pagination = $Pagination."<input type=submit name=Pagination value=&raquo; disabled></input>";
  }else{
      $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางถัดไป value=&raquo; ></input>";
  }
  
  return $_SESSION["PaginationVacationTable"] = $Pagination;
}

?>

<body>
<style>


</style>



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
                      <i class="iconv-2-cog"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนรหัสผ่าน</div>
                    </a>
                    <a onclick="document.getElementById('ChangeEmail').style.display='block'">
                    <i class="iconv-2-a"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนอีเมล</div>
                    </a>
                    <a href="login.php">
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
                <a href="message.php">
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
                <a href="vacation.php"  class="is-black-blue">
                <svg class="menu-icon iconv-2-backpack"></svg>การลา
                </a>
            </li>
            <li>
                <a href="login.php">
                <svg class="menu-icon iconv-2-logout"></svg>ออกจากระบบ
                            </a>
            </li>
        </ul>
    </nav>

<div class="subcontent-area">
        <div class="subcontent-main-div index">
            <div class="box with-title is-round">
                <div class="box-title is-dodgerblue">
                    <svg class="menu-icon-topic iconv-2-backpack"></svg>การลา
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-8">
                        <br>
                        <div class="set-flex" >
                            <div style="margin-top: 2%; font-size: 18px;">ภาคเรียน :&nbsp</div>
                            <div class="select-margin-v1 select-input " style="width:13%; margin-right: 4%; margin-top: 1.6%;">

                            <form name="changeTerm" action="FVacation.php" method="post" style="margin-bottom: 0%;">
                                    <select name="terms" onchange="document.changeTerm.submit();" style="width:100%; height: auto; padding: 5px 2px; " title="คลิกเพื่อเลือกภาคเรียน">
                                        <?php echo $optionsTerm;?>
                                    </select>
                              </form>

                            </div>
                            <div style="margin-top: 2%; font-size: 18px;">วิชา :&nbsp</div>
                            <div class="select-margin-v1 select-input " style="width:55%; margin-right: 2%; margin-top: 1.6%;">
                            <form name="changeCourse" action="FVacation.php" method="post" style="margin-bottom: 0%;">
                                    <select name="courses" onchange="document.changeCourse.submit();" style="width:100%; height: auto; padding: 5px 2px; font-size: 15px;" title="คลิกเพื่อเลือกรายวิชา">
                                        <?php echo $optionsCourse;?>
                                    </select>
                              </form> 

                            </div>  
            

                            <form name="Add" action="FVacation.php" method="post" style="width: 12%; height: 2%; margin-bottom: 0%; margin-top: 0.9%;">
                            <button class="small-v3" name="addVacationModal" style=" width: 100%; height: 100%;" onclick="document.Add.submit();" title="คลิกเพื่อแสดงหน้า form เพิ่มข้อมูลการลา">
                            <i class="material-icons" style="margin-top: 4%; margin-bottom: 4%; font-size: 30px;" >add_circle_outline</i></button>
                            </form>


                            <!--<button class="small-v2" style="margin-right: 0.4%;" onclick="document.getElementById('EditVacation').style.display='block'"><i class="material-icons" style="margin-top: 7%; margin-bottom: 7%;">edit</i></button>
                            <button class="small-v2" style="margin-right: 8.5%;" onclick="document.getElementById('DeleteVacation').style.display='block'"><i class="material-icons" style="margin-top: 7%; margin-bottom: 7%;">remove_circle_outline</i></button>
                            <button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_left</i></button>
                            <button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_right</i></button>-->
                        </div>
                        <br>
                        <table id="table-no-click">
                            <tr>
                                <th>วันที่แจ้ง</th>
                                <th>รหัสนิสิต</th>
                                <th>ชื่อนิสิต</th>
                                <th>สาเหตุที่ลา</th>
                                <th>วันที่ลา</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            <form name="EditOrDelete" action="FVacation.php" method="post" style="margin-bottom: 0%;">
                            <?php
                                echo $_SESSION["VacationTable"] ;
                            ?>
                            </form>
                        </table>
                        <div class="pagination" style="width: 100%; text-align: center;">
                            <div style="display: inline-block;">
                            <form name="changePagination" action="FVacation.php" method="post" style="margin-bottom: 0%;">
                                <?php
                                    echo $_SESSION["PaginationVacationTable"] ;
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
        <input class="is-pulled-right input-field-v1-5" type="textRegis" name="new-password" value="" autocomplete=off>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginCurPass"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1-5" type="password" name="curr-password" value="<?php echo $password; ?>" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginRepPass"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1-5"  type="password" name="rep-password" value="" autocomplete=off>
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePass"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red"  style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


  <div id="ChangeEmail" class="modal">
  
  <form class="modal-content animate" action="FChangeEmail.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนอีเมล</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v2-5" type="textRegis" name="email" value="<?php echo $email; ?>" autocomplete=off>
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changeEmail"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red"  style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>



<?php if($_SESSION['CheckOpenModalAddVacation'] == true){ ?>
<div id="AddVacation" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FVacation.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เพิ่มข้อมูลการลา</h3>

  <div class="input-textVacation">
        <div class="sizeText maginVacationDay"><b>วันที่แจ้ง :</b></div>
        <input class="is-pulled-right input-field-v4" type="date" name="VacationDay" value="" >
  </div>

  <div class="input-textVacation">
        <div class="sizeText maginVacationNumStudent"><b>รหัสนิสิต :</b></div>
        <input class="is-pulled-right input-field-v4" type="textRegis" name="VacationNumStudent" value="" >
  </div>

  <div class="input-textVacation" style="display: none;">
        <div class="sizeText maginVacationNameStudent"><b>ชื่อนิสิต :</b></div>
        <input class="is-pulled-right input-field-v4" type="textRegis" name="VacationNameStudent" value="" >
  </div>

  <div class="input-textVacation">
        <div class="sizeText maginTextarea"><b>สาเหตุที่ลา :</b></div>
        <textarea rows="5" cols="43" style="resize: none;" class="is-pulled-right" type="textRegis" name="VacationTextarea" value="" ></textarea>
  </div>

  <div class="input-textVacation">
        <div class="sizeText maginVacationDays"><b>วันที่ลา :</b></div>
        <input class="is-pulled-right input-field-v9" type="date" name="VacationDays-1" value="" >
        <div class="sizeText" style="margin: 1.8% 1% 0% 1%"><b> - </b></div> 
        <input class="is-pulled-right input-field-v9" type="date" name="VacationDays-2" value="" >
  </div>


  <div class="button-zone">
  <button type="submit" class="register" name="addVacation"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('AddVacation').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 18.5%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalAddVacation'] = false;
} ?>


<?php if($_SESSION['CheckOpenModalEditVacation'] == true){ ?>
<div id="EditVacation" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FVacation.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">แก้ไขข้อมูลการลา</h3>

    <div class="input-textVacation">
        <div class="sizeText maginVacationDay"><b>วันที่แจ้ง :</b></div>
        <input class="is-pulled-right input-field-v4" type="date" name="VacationDay" value="<?php echo $_SESSION['NotificationDateVacationEdit']; ?>" >
  </div>

  <div class="input-textVacation">
        <div class="sizeText maginVacationNumStudent"><b>รหัสนิสิต :</b></div>
        <input class="is-pulled-right input-field-v4" type="textRegis" name="VacationNumStudent" value="<?php echo $_SESSION['NumStudentVacationEdit']; ?>" >
  </div>

  <div class="input-textVacation" style="display: none;">
        <div class="sizeText maginVacationNameStudent"><b>ชื่อนิสิต :</b></div>
        <input class="is-pulled-right input-field-v4" type="textRegis" name="VacationNameStudent" value="" >
  </div>

  <div class="input-textVacation">
        <div class="sizeText maginTextarea"><b>สาเหตุที่ลา :</b></div>
        <textarea rows="5" cols="43" style="resize: none;" class="is-pulled-right" type="textRegis" name="VacationTextarea" ><?php echo $_SESSION['DetailVacationEdit']; ?></textarea>
  </div>

  <div class="input-textVacation">
        <div class="sizeText maginVacationDays"><b>วันที่ลา :</b></div>
        <input class="is-pulled-right input-field-v9" type="date" name="VacationDays-1" value="<?php echo $_SESSION['TimeStartVacationEdit']; ?>" >
        <div class="sizeText" style="margin: 1.8% 1% 0% 1%"><b> - </b></div> 
        <input class="is-pulled-right input-field-v9" type="date" name="VacationDays-2" value="<?php echo $_SESSION['TimeEndVacationEdit']; ?>" >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="editVacation"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('EditVacation').style.display='none'" class="register register-cancle is-red"  style="margin: 0% 0% 0% 18.5%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalEditVacation'] = false;
} ?>



<?php if($_SESSION['CheckOpenModalDeleteVacation'] == true){ ?>
<div id="DeleteVacation" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FVacation.php" method="post">

    <h3 class="text-topic" align="center">ต้องการลบข้อมูลการลาหรือไม่ ?</h3>
    <br>

  <div class="button-zone">
  <button class="register" name="deleteVacation"><b>ใช่</b></button>
  <button type="button" onclick="document.getElementById('DeleteVacation').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalDeleteVacation'] = false;
} ?>



</body>
</html>







