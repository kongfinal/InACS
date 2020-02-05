<?php session_start();

include('condb.php');
$_SESSION["IDTerm"] = $_SESSION["IDTermFirst"];
$_SESSION["Pagination"] = 1;

$_SESSION["IDTermStudent"] = $_SESSION["IDTermFirstStudent"];
$_SESSION["PaginationSelectStudent"] = 1;

$_SESSION["IDTermVacation"] = $_SESSION["IDTermFirstVacation"];
$_SESSION["CheckTermVacation"] = true;
$_SESSION["PaginationVacation"] = 1;

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

$_SESSION["IDTermResult"] = $_SESSION["IDTermFirstResult"];
$_SESSION["PaginationSelectResult"] = 1;


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

$_SESSION["IDTermFirstCheck"] = $dataTerm[count($dataTerm)-1][2];

for ($x = count($dataTerm)-1; $x >= 0; $x-=1) {
    $idTerm = $dataTerm[$x][2];
    $NumTerm = $dataTerm[$x][1];
    $YearTerm = $dataTerm[$x][0];
    if($_SESSION["IDTermCheck"] == $idTerm){
        $optionsTerm  = $optionsTerm."<option value=$idTerm selected>$NumTerm/$YearTerm</option>";
    }else{
        $optionsTerm  = $optionsTerm."<option value=$idTerm>$NumTerm/$YearTerm</option>";
    } 
}

addCoursetoTable($_SESSION["IDTermCheck"]);

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
            array_push($dataCourse,array($row['Number'],$row['GroupCourse'],$row['ID'],$row['Name'],$row['Type'],$row['Room'],$row['TimeLate']));

        }
    }

    sort($dataCourse);

    if(mysqli_num_rows($CourseTable) > 0){
    for ($x = 0; $x < count($dataCourse); $x+=1) {
//    for ($x = 0; $x < 5; $x+=1) {
 //       $page = ($_SESSION["PaginationSelectCheck"]-1) * 5;

        $rowNumber=$dataCourse[$x+$page][0];
        $rowName=$dataCourse[$x+$page][3];
        $rowGroupCourse=$dataCourse[$x+$page][1];
        $rowType=$dataCourse[$x+$page][4];
        $rowID=$dataCourse[$x+$page][2];
        $classMyinputLarge="myinput&nbsp;large";

        $tableCourse  = $tableCourse."<tr>";
        $tableCourse  = $tableCourse."<td>$rowNumber</td>";
        $tableCourse  = $tableCourse."<td>$rowName</td>";
        $tableCourse  = $tableCourse."<td>$rowGroupCourse</td>";
        $tableCourse  = $tableCourse."<td>$rowType</td>";
        $tableCourse  = $tableCourse."<td><input id=CheckName type=checkbox class='myinput large' 
         style=margin-top:2.5%; name=CheckBoxCourseID[] value=$rowID /></td>";
        $tableCourse  = $tableCourse."</tr>";

//        if($x+$page >= count($dataCourse)-1){
//            break;
//        }
    }
    }

//    CreatePagination(mysqli_num_rows($CourseTable));
    return $_SESSION["CourseTableInCheck"] = $tableCourse;
}

/*
function CreatePagination($CourseNum){

    $lastPage = 0;
    if($_SESSION["PaginationSelectCheck"] == 1){
        $Pagination = $Pagination."<input type=submit name=Pagination value=&laquo; disabled></input>";
    }else{
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อย้อนกลับไปตารางก่อนหน้า value=&laquo; ></input>";
    }
    
    for ($x = 0; $x*5 < $CourseNum;) {
        $x+=1;
        if($_SESSION["PaginationSelectCheck"] == $x){
            $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x class=active value=$x ></input>";
        }else{
            $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x value=$x ></input>";
        }
        $lastPage = $x;
    }

    if($_SESSION["PaginationSelectCheck"] == $lastPage || ($_SESSION["PaginationSelectCheck"] == 1 && $lastPage == 0)){
        $Pagination = $Pagination."<input type=submit name=Pagination value=&raquo; disabled></input>";
    }else{
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางถัดไป value=&raquo; ></input>";
    }
    
    return $_SESSION["PaginationCourseTableInCheck"] = $Pagination;
}
*/

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
                <a href="select-course-check.php"  class="is-black-blue">
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
                    <svg class="menu-icon-topic iconv-2-cart"></svg>รายวิชาที่สอน
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-8">
                        <br>
                        <div class="set-flex" >
                            <div style="margin-top: 1.5%; font-size: 18px;">ภาคเรียน :&nbsp</div>
                            <div class="select-margin-v1 select-input " style="width:13%; margin-right: 66%;">
                            <form name="changeTerm" action="FCheckNameStudent.php" method="post" style="margin-bottom: 0%;">
                                    <select name="terms" onchange="document.changeTerm.submit();" style="width:100%; height: auto; padding: 5px 2px; " title="คลิกเพื่อเลือกภาคเรียน">
                                        <?php echo $optionsTerm;?>
                                    </select>
                            </form>
                            </div>

                            <form name="GoCheckName" action="FCheckNameStudent.php" method="post" style="width: 12%; height: 2%; margin-bottom: 0%; margin-top: 0.45%;">
                            <button class="small-v3" name="GoToCheckName" style="margin-right: 0.5%; width: 100%; height: 100%;" title="คลิกเพื่อไปหน้าเช็คชื่อนิสิตของรายวิชาที่เลือก"
                            onclick="document.GoCheckName.submit();"><i class="material-icons" style="margin-top: 4%; margin-bottom: 4%; font-size: 30px;" >check_box</i></button>
                            

                            <!--<button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_left</i></button>
                            <button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_right</i></button>-->
                        </div>
                        <br>
                        <table id="table-no-click">
                            <tr>
                                <th>รหัสวิชา</th>
                                <th>ชื่อวิชา</th>
                                <th>กลุ่มเรียน</th>
                                <th>ประเภท</th>
                                <th>รายวิชาที่จะเช็คชื่อ</th>
                            </tr>
                            
                            <?php
                                echo $_SESSION["CourseTableInCheck"] ;
                            ?>
                        </table>
                        </form>
                        <!--<div class="pagination" style="width: 100%; text-align: center;">
                            <div style="display: inline-block;">
                            <form name="changePagination" action="FCheckNameStudent.php" method="post" style="margin-bottom: 0%;">
                                <?php
                                    // echo $_SESSION["PaginationCourseTableInCheck"] ;
                                ?>
                            </form>
                            </div>
                        </div>-->
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
        <input class="is-pulled-right input-field-v1-5" type="textRegis" name="new-password" value=""  autocomplete=off>
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
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19.2%;"><b>ยกเลิก</b></button>
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
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


</body>
</html>







