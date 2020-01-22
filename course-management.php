<?php session_start();

include('condb.php');
$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];

$_SESSION["IDTermStudent"] = $_SESSION["IDTermFirstStudent"];
$_SESSION["PaginationSelectStudent"] = 1;

$_SESSION["IDTermVacation"] = $_SESSION["IDTermFirstVacation"];
$_SESSION["CheckTermVacation"] = true;
$_SESSION["PaginationVacation"] = 1;

$_SESSION["IDTermCheck"] = $_SESSION["IDTermFirstCheck"];
$_SESSION["PaginationSelectCheck"] = 1;

$_SESSION["NumberCheckStudent"] = "";
$_SESSION["IDCheckStudent"] = "";
$_SESSION["NameCheckStudent"] = "";
$_SESSION["TimeCheckStudent"] = ""; 
$_SESSION["StatusCheckStudent"] = "";
$_SESSION["NumberAbsentCheckStudent"] = "";
$_SESSION["NumberLateStudent"] = "";
$_SESSION["ScoreDeductedCheckStudent"] = "";


$queryTerm = "SELECT * FROM `inacs_term`";
$termSelect = mysqli_query($con,$queryTerm);

$optionsTerm = "";
$dataTerm = array();

while($rowTerm = mysqli_fetch_array($termSelect)){
    array_push($dataTerm,array($rowTerm[2],$rowTerm[1],$rowTerm[0]));
}

sort($dataTerm);

$_SESSION["IDTermFirst"] = $dataTerm[count($dataTerm)-1][2];

for ($x = count($dataTerm)-1; $x >= 0; $x-=1) {
    $idTerm = $dataTerm[$x][2];
    $NumTerm = $dataTerm[$x][1];
    $YearTerm = $dataTerm[$x][0];
    if($_SESSION["IDTerm"] == $idTerm){
        $optionsTerm  = $optionsTerm."<option value=$idTerm selected>$NumTerm/$YearTerm</option>";
    }else{
        $optionsTerm  = $optionsTerm."<option value=$idTerm>$NumTerm/$YearTerm</option>";
    } 
}

addCoursetoTable($_SESSION["IDTerm"]);
CreateEditFormType();
CreateEditFormDay();

?>



<?php
include('h.php');
include('condb.php');

function addCoursetoTable($IdTermSearch){
    include('condb.php');
    $queryCourse = "SELECT * FROM `inacs_course` WHERE IDTerm='$IdTermSearch' AND NameTeacher='".$_SESSION["Name"]."'";
    $CourseTable = mysqli_query($con,$queryCourse);
    $tableCourse = "";
    $dataCourse = array();

    if(mysqli_num_rows($CourseTable) > 0){
        while ($row = mysqli_fetch_assoc($CourseTable)) {
            array_push($dataCourse,array($row['Number'],$row['Name'],$row['GroupCourse'],$row['ID'],$row['Type'],$row['Room'],$row['TimeLate']));

        }
    }

    sort($dataCourse);

    if(mysqli_num_rows($CourseTable) > 0){
    for ($x = 0; $x < 5; $x+=1) {
        $page = ($_SESSION["Pagination"]-1) * 5;

        $rowNumber=$dataCourse[$x+$page][0];
        $rowName=$dataCourse[$x+$page][1];
        $rowGroupCourse=$dataCourse[$x+$page][2];
        $rowType=$dataCourse[$x+$page][4];
        $rowRoom=$dataCourse[$x+$page][5];
        $rowTimeLate=$dataCourse[$x+$page][6];
        $rowID=$dataCourse[$x+$page][3];

        $tableCourse  = $tableCourse."<tr>";
        $tableCourse  = $tableCourse."<td>$rowNumber</td>";
        $tableCourse  = $tableCourse."<td>$rowName</td>";
        $tableCourse  = $tableCourse."<td>$rowGroupCourse</td>";
        $tableCourse  = $tableCourse."<td>$rowType</td>";
        $tableCourse  = $tableCourse."<td>$rowRoom</td>";
        $tableCourse  = $tableCourse."<td>$rowTimeLate</td>";
        $tableCourse  = $tableCourse."<td style=cursor:pointer; ><button name=editCourseModal class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;แก้ไขข้อมูลรายวิชา value=$rowID>edit</button></td>";
        $tableCourse  = $tableCourse."<td style=cursor:pointer; > <button name=deleteCourseModal  class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;ลบข้อมูลรายวิชา value=$rowID>remove_circle_outline</button> </td>";
        $tableCourse  = $tableCourse."</tr>";

        if($x+$page >= count($dataCourse)-1){
            break;
        }
    }
    }

    CreatePagination(mysqli_num_rows($CourseTable));
    return $_SESSION["CourseTable"] = $tableCourse;
}

function CreatePagination($CourseNum){

    $lastPage = 0;
    if($_SESSION["Pagination"] == 1){
        $Pagination = $Pagination."<input type=submit name=Pagination value=&laquo; disabled></input>";
    }else{
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อย้อนกลับไปตารางก่อนหน้า value=&laquo; ></input>";
    }
    
    for ($x = 0; $x*5 < $CourseNum;) {
        $x+=1;
        if($_SESSION["Pagination"] == $x){
            $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x class=active value=$x ></input>";
        }else{
            $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x  value=$x ></input>";
        }
        $lastPage = $x;
    }

    if($_SESSION["Pagination"] == $lastPage || ($_SESSION["Pagination"] == 1 && $lastPage == 0)){
        $Pagination = $Pagination."<input type=submit name=Pagination value=&raquo; disabled></input>";
    }else{
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางถัดไป value=&raquo; ></input>";
    }
    
    return $_SESSION["PaginationCourseTable"] = $Pagination;
}

function CreateEditFormType(){
    $EditCourseFormType = "";
    if($_SESSION["TypeCourseEdit"] == "Lecture"){
        $EditCourseFormType = $EditCourseFormType."<option value=Lecture selected>Lecture</option>";
        $EditCourseFormType = $EditCourseFormType."<option value=Lab >Lab</option>";
    }else{
        $EditCourseFormType = $EditCourseFormType."<option value=Lecture >Lecture</option>";
        $EditCourseFormType = $EditCourseFormType."<option value=Lab selected>Lab</option>";
    }

    return $_SESSION["EditCourseFormType"] = $EditCourseFormType;
}

function CreateEditFormDay(){
    $EditCourseFormDay = "";
    if($_SESSION["DayCourseEdit"] == "Mo"){
        $EditCourseFormDay = $EditCourseFormDay."<option value=Mo selected>จันทร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Tu>อังคาร</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=We>พุธ</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Th>พฤหัสบดี</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Fr>ศุกร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Sa>เสาร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Su>อาทิตย์</option>";
    }else if($_SESSION["DayCourseEdit"] == "Tu"){
        $EditCourseFormDay = $EditCourseFormDay."<option value=Mo>จันทร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Tu selected>อังคาร</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=We>พุธ</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Th>พฤหัสบดี</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Fr>ศุกร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Sa>เสาร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Su>อาทิตย์</option>";
    }else if($_SESSION["DayCourseEdit"] == "We"){
        $EditCourseFormDay = $EditCourseFormDay."<option value=Mo>จันทร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Tu>อังคาร</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=We selected>พุธ</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Th>พฤหัสบดี</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Fr>ศุกร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Sa>เสาร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Su>อาทิตย์</option>";
    }else if($_SESSION["DayCourseEdit"] == "Th"){
        $EditCourseFormDay = $EditCourseFormDay."<option value=Mo>จันทร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Tu>อังคาร</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=We>พุธ</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Th selected>พฤหัสบดี</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Fr>ศุกร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Sa>เสาร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Su>อาทิตย์</option>";
    }else if($_SESSION["DayCourseEdit"] == "Fr"){
        $EditCourseFormDay = $EditCourseFormDay."<option value=Mo>จันทร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Tu>อังคาร</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=We>พุธ</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Th>พฤหัสบดี</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Fr selected>ศุกร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Sa>เสาร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Su>อาทิตย์</option>";
    }else if($_SESSION["DayCourseEdit"] == "Sa"){
        $EditCourseFormDay = $EditCourseFormDay."<option value=Mo>จันทร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Tu>อังคาร</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=We>พุธ</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Th>พฤหัสบดี</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Fr>ศุกร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Sa selected>เสาร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Su>อาทิตย์</option>";
    }else if($_SESSION["DayCourseEdit"] == "Su"){
        $EditCourseFormDay = $EditCourseFormDay."<option value=Mo>จันทร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Tu>อังคาร</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=We>พุธ</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Th>พฤหัสบดี</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Fr>ศุกร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Sa>เสาร์</option>";
        $EditCourseFormDay = $EditCourseFormDay."<option value=Su selected>อาทิตย์</option>";
    }
    return $_SESSION["EditCourseFormDay"] = $EditCourseFormDay;
}


?>

<body>
<style>

.pagination input {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}

.pagination input.active {
  background-color: dodgerblue;
  color: white;
}

.pagination input:hover:not(.active) {background-color: #ddd;}

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
            <button id="navbar-user" name="navUser" class="navbar-item user" onclick="if (document.getElementById('navbar-dropdown').classList.contains('is-active'))  return document.getElementById('navbar-dropdown').classList.remove('is-active'); else return document.getElementById('navbar-dropdown').classList.add('is-active');" >
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
                <a href="course-management.php" class="is-black-blue">
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
                    <svg class="menu-icon-topic iconv-2-bag"></svg>จัดการรายวิชา
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-8">
                        <br>
                        <div class="set-flex" >
                            <div style="margin-top: 1.9%; font-size: 18px;">ภาคเรียน :&nbsp</div>
                            <div class="select-margin-v1 select-input " style="width:13%; margin-right: 65.8%; margin-top: 1.6%;" title="คลิกเพื่อเลือกภาคเรียน">
                                <form name="changeTerm" action="FManagementCourse.php" method="post" style="margin-bottom: 0%;">
                                    <select name="terms" onchange="document.changeTerm.submit();" style="width:100%; height: auto; padding: 5px 2px; ">
                                        <?php echo $optionsTerm;?>
                                    </select>
                                </form>
                            </div>

                            <form name="Add" action="FManagementCourse.php" method="post" style="width: 12%; height: 2%; margin-bottom: 0%; margin-top: 0.9%;">
                            <button class="small-v3" name="addCourseModal" style="margin-right: 0.5%; width: 100%; height: 100%;" title="คลิกเพื่อแสดงหน้า form เพิ่มข้อมูลรายวิชา"
                            onclick="document.Add.submit();"><i class="material-icons" style="margin-top: 4%; margin-bottom: 4%; font-size: 30px;" >add_circle_outline</i></button>
                            </form>
                            
                            <!--<button class="small-v2" style="margin-right: 0.4%;" onclick="document.getElementById('EditCourse').style.display='block'"><i class="material-icons" style="margin-top: 7%;margin-bottom: 7%;">edit</i></button>
                            <button class="small-v2" onclick="document.getElementById('DeleteCourse').style.display='block'"><i class="material-icons" style="margin-top: 7%;margin-bottom: 7%;">remove_circle_outline</i></button>-->
                            <!--<button class="small-v2"><i class="material-icons" style="margin-top: 7%; margin-bottom: 7%;">chevron_left</i></button>
                            <button class="small-v2"><i class="material-icons" style="margin-top: 7%; margin-bottom: 7%;">chevron_right</i></button>-->
                        </div>
                        <br>
                        <table id="table-no-click">
                            <tr>
                                <th>รหัสวิชา</th>
                                <th>ชื่อวิชา</th>
                                <th>กลุ่มเรียน</th>
                                <th>ประเภท (Lecture/Lab)</th>
                                <th>ห้องเรียน</th>
                                <th>เวลาที่มาสาย</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            <form name="EditOrDelete" action="FManagementCourse.php" method="post" style="margin-bottom: 0%;">
                            <?php
                                echo $_SESSION["CourseTable"] ;
                            ?>
                            </form>
                            </div>
                        </table>
                        <div class="pagination" style="width: 100%; text-align: center;">
                            <div style="display: inline-block;">
                            <form name="changePagination" action="FManagementCourse.php" method="post" style="margin-bottom: 0%;">
                                <?php
                                    echo $_SESSION["PaginationCourseTable"] ;
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
        <input class="is-pulled-right input-field-v1-5" type="textRegis" name="new-password" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginCurPass"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1-5" type="password" name="curr-password" value="<?php echo $password; ?>" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginRepPass"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1-5"  type="password" name="rep-password" value=""autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePass"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


  <div id="ChangeEmail" class="modal">
  
  <form class="modal-content animate" action="FChangeEmail.php"  method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนอีเมล</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v2-5" type="textRegis" name="email" value="<?php echo $email; ?>" autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changeEmail"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>



<?php if($_SESSION['CheckOpenModalAdd'] == true){ ?>
<div id="AddCourse" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FManagementCourse.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%">เพิ่มข้อมูลรายวิชา</h3>

  <div class="input-textCourse">
        <div class="sizeText maginNumCourse"><b>รหัสวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NumCourse" value="" autocomplete=off >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginNameCourse"><b>ชื่อวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NameCourse" value="" autocomplete=off >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginGroupCourse"><b>กลุ่มเรียน :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="GroupCourse" value="" autocomplete=off >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginTypeCourse"><b>ประเภท (Lecture/Lab) :</b></div>
        <input id="CheckLec" type="checkbox" class="myinput large" checked="checked"style="margin-top:2.5%;" name="CheckBoxType[]" value="Lecture" onclick="if (document.getElementById('CheckLec').checked == true) return document.getElementById('CategoryLec').style.display = 'block'; else return document.getElementById('CategoryLec').style.display = 'none';"/>
        <div style="margin-top:2.5%; margin-right:10%; margin-left:2%;"><b>Lecture</b></div>
        <input id="CheckLab" type="checkbox" class="myinput large" style="margin-top:2.5%;" name="CheckBoxType[]" value="Lab" onclick="if (document.getElementById('CheckLab').checked == true) return document.getElementById('CategoryLab').style.display = 'block'; else return document.getElementById('CategoryLab').style.display = 'none';"/>
        <div style="margin-top:2.5%; margin-left:2%;"><b>Lab</b></div>
         <!--<label class="checkboxes" style="margin-top:2%;">
            <input type="checkbox" checked="checked">
            <span class="checkmark"></span>
        </label>
        <div style="margin-top:2.5%; margin-right:10%;"><b>Lecture</b></div>
        <label class="checkboxes" style="margin-top:2%">
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>
        <div style="margin-top:2.5%;"><b>Lab</b></div>-->
        <!--<select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;">
            <option value="Lecture">Lecture</option>
            <option value="Lab">Lab</option>
        </select>-->
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginTimeLateCourse"><b>เวลามาสาย (นาที) :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="TimeLateCourse" value="" autocomplete=off >
  </div>


  <div id="CategoryLec" style="display:block">
  <div class="input-textCourse">
        <div class="sizeText maginRoomCourse-2"><b>ห้องเรียน (Lecture) :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="RoomCourseLec" value="" autocomplete=off >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginDayCourse-2"><b>วันที่สอน (Lecture) :</b></div>
        <select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px; " name="DayCourseLec">
            <option value="Mo">จันทร์</option>
            <option value="Tu">อังคาร</option>
            <option value="We">พุธ</option>
            <option value="Th">พฤหัสบดี</option>
            <option value="Fr">ศุกร์</option>
            <option value="Sa">เสาร์</option>
            <option value="Su">อาทิตย์</option>
        </select>
  </div>
  
  <div class="input-textCourse">
        <div class="sizeText maginTimeCourse-2"><b>เวลาที่สอน (Lecture) :</b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourseLec-1" value="" autocomplete=off >
        <div class="sizeText" style="margin: 1.8% 1.1% 0% 1.1%"><b> - </b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourseLec-2" value="" autocomplete=off >
  </div>
  </div>


  <div id="CategoryLab" style="display:none">
  <div class="input-textCourse">
        <div class="sizeText maginRoomCourse-3"><b>ห้องเรียน (Lab) :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="RoomCourseLab" value="" autocomplete=off >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginDayCourse-3"><b>วันที่สอน (Lab) :</b></div>
        <select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px; " name="DayCourseLab" autocomplete=off >
            <option value="Mo">จันทร์</option>
            <option value="Tu">อังคาร</option>
            <option value="We">พุธ</option>
            <option value="Th">พฤหัสบดี</option>
            <option value="Fr">ศุกร์</option>
            <option value="Sa">เสาร์</option>
            <option value="Su">อาทิตย์</option>
        </select>
  </div>
  
  <div class="input-textCourse" style="margin-bottom: 3%">
        <div class="sizeText maginTimeCourse-3"><b>เวลาที่สอน (Lab) :</b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourseLab-1" value="" autocomplete=off >
        <div class="sizeText" style="margin: 1.8% 1.1% 0% 1.1%"><b> - </b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourseLab-2" value="" autocomplete=off >
  </div>
  </div>
  <!--<div class="input-textCourse">
        <div class="sizeText maginStudentCourse"><b>จำนวนนิสิต :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="StudentCourse" value="" >
  </div>-->

  <div class="button-course-zone">
  <button type="submit" class="register" name="addCourse"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('AddCourse').style.display='none'" class="register course-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalAdd'] = false;
} ?>





<?php if($_SESSION['CheckOpenModalEdit'] == true){ ?>
<div id="editCourseModal" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FManagementCourse.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%">แก้ไขข้อมูลรายวิชา</h3>

    <div class="input-textCourse">
        <div class="sizeText maginNumCourse"><b>รหัสวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NumCourse" value=<?php echo $_SESSION['NumberCourseEdit']; ?>>
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginNameCourse"><b>ชื่อวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NameCourse" value="<?php echo $_SESSION['NameCourseEdit']; ?>" >
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

        <select name="TypeCourse" style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;">
            <?php
                echo $_SESSION["EditCourseFormType"] ;
            ?>
            <!--<option value="Lecture">Lecture</option>
            <option value="Lab">Lab</option>-->
        </select>

  </div>

  <div class="input-textCourse">
        <div class="sizeText maginRoomCourse"><b>ห้องเรียน :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="RoomCourse" value="<?php echo $_SESSION['RoomCourseEdit']; ?>" >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginTimeLateCourse"><b>เวลามาสาย (นาที) :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="TimeLateCourse" value=<?php echo $_SESSION['TimelateCourseEdit']; ?> >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginDayCourse"><b>วันที่สอน :</b></div>
        <select name="DayCourse" style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;">
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
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourse-1" value="<?php echo $_SESSION['TimeStartCourseEdit']; ?>" >
        <div class="sizeText" style="margin: 1.8% 1.1% 0% 1.1%"><b> - </b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourse-2" value="<?php echo $_SESSION['TimeEndCourseEdit']; ?>" >

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
  <button type="button" onclick="document.getElementById('editCourseModal').style.display='none'" class="register course-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>

<?php 
$_SESSION['CheckOpenModalEdit'] = false;
} ?>




<?php if($_SESSION['CheckOpenModalDelete'] == true){ ?>
<div id="DeleteCourse" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FManagementCourse.php" method="post">

    <h3 class="text-topic" align="center">ต้องการลบข้อมูลรายวิชาหรือไม่ ?</h3>
    <br>

  <div class="button-zone">
  <button type="submit" class="register" name="deleteCourse"><b>ใช่</b></button>
  <button type="button" onclick="document.getElementById('DeleteCourse').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalDelete'] = false;
} ?>










<div id="AddCourse-2" class="modal">
  
  <form class="modal-content animate" action="FManagementCourse.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%">เพิ่มข้อมูลรายวิชา</h3>

  <div class="input-textCourse">
        <div class="sizeText maginNumCourse"><b>รหัสวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NumCourse" value="" >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginNameCourse"><b>ชื่อวิชา :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="NameCourse" value="" >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginGroupCourse"><b>กลุ่มเรียน :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="GroupCourse" value="" >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginTypeCourse"><b>ประเภท (Lecture/Lab) :</b></div>

         <!--<label class="checkboxes" style="margin-top:2%;">
            <input type="checkbox" checked="checked">
            <span class="checkmark"></span>
        </label>
        <div style="margin-top:2.5%; margin-right:10%;"><b>Lecture</b></div>
        <label class="checkboxes" style="margin-top:2%">
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>
        <div style="margin-top:2.5%;"><b>Lab</b></div>-->
        <select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px;" name="TypeCourse">
            <option value="Lecture">Lecture</option>
            <option value="Lab">Lab</option>
        </select>
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginRoomCourse"><b>ห้องเรียน :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="RoomCourse" value="" >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginTimeLateCourse"><b>เวลามาสาย (นาที) :</b></div>
        <input class="is-pulled-right input-field-v5" type="textRegis" name="TimeLateCourse" value="" >
  </div>

  <div class="input-textCourse">
        <div class="sizeText maginDayCourse"><b>วันที่สอน :</b></div>
        <select style="width:56.5%; border: 1px solid #ccc; padding-left: 10px; padding-right: 10px; " name="DayCourse">
            <option value="Mo">จันทร์</option>
            <option value="Tu">อังคาร</option>
            <option value="We">พุธ</option>
            <option value="Th">พฤหัสบดี</option>
            <option value="Fr">ศุกร์</option>
            <option value="Sa">เสาร์</option>
            <option value="Su">อาทิตย์</option>
        </select>
  </div>
  
  <div class="input-textCourse" style="margin-bottom: 3%">
        <div class="sizeText maginTimeCourse"><b>เวลาที่สอน :</b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourse-1" value="" >
        <div class="sizeText" style="margin: 1.8% 1.1% 0% 1.1%"><b> - </b></div>
        <input class="is-pulled-right input-field-v10" type="time" name="TimeCourse-2" value="" >
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
  <button type="submit" class="register" name="addCourse"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('AddCourse-2').style.display='none'" class="register course-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>




</body>
</html>