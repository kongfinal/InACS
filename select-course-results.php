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

$_SESSION["TypeResult"] = "All";

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

$_SESSION["IDTermFirstResult"] = $dataTerm[count($dataTerm)-1][2];

for ($x = count($dataTerm)-1; $x >= 0; $x-=1) {
    $idTerm = $dataTerm[$x][2];
    $NumTerm = $dataTerm[$x][1];
    $YearTerm = $dataTerm[$x][0];
    if($_SESSION["IDTermResult"] == $idTerm){
        $optionsTerm  = $optionsTerm."<option value=$idTerm selected>$NumTerm/$YearTerm</option>";
    }else{
        $optionsTerm  = $optionsTerm."<option value=$idTerm>$NumTerm/$YearTerm</option>";
    } 
}

addCoursetoTable($_SESSION["IDTermResult"]);

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
    $dataCourseCheck = array();

    if(mysqli_num_rows($CourseTable) > 0){
        while ($row = mysqli_fetch_assoc($CourseTable)) {

            $CheckUnique = false;
            for($x = 0;$x < count($dataCourse);$x+=1){
                if($dataCourse[$x][0]==$row['Number'] && $dataCourse[$x][1]==$row['GroupCourse'] && $dataCourse[$x][2]==$row['Name']){
                    $CheckUnique = true;
                    break;
                }
            }
            if(!$CheckUnique){
                array_push($dataCourse,array($row['Number'],$row['GroupCourse'],$row['Name']));
                array_push($dataCourseCheck,array($row['Number'],$row['GroupCourse'],$row['Name']));
            }

        }
    }

    for($x = 0;$x < count($dataCourseCheck);$x+=1){
        $CheckGroup = false;

        if(strpos($dataCourseCheck[$x][1],"+")){
            $array = explode("+", $dataCourseCheck[$x][1]);

            for($y = 0;$y < count($array);$y+=1){
                $dataCourseNew = array($dataCourseCheck[$x][0],$array[$y],$dataCourseCheck[$x][2]);
                if(array_search($dataCourseNew,$dataCourseCheck,true)){
                    $CheckGroup = true;
                    break;
                }
            }
        }

        if($CheckGroup){
            $dataCourse[$x][1] = "Delete";
        }
    }
    
    for($x = 0;$x < count($dataCourse);){
        if($dataCourse[$x][1] == "Delete"){
            array_splice($dataCourse, $x, 1);
        }else{
            $x+=1;
        }
    }

    sort($dataCourse);

    if(count($dataCourse) > 0){
    for ($x = 0; $x < 5; $x+=1) {
        $page = ($_SESSION["PaginationSelectResult"]-1) * 5;

        $rowNumber=$dataCourse[$x+$page][0];
        $rowName=$dataCourse[$x+$page][2];
        $rowGroupCourse=$dataCourse[$x+$page][1];


        $tableCourse  = $tableCourse."<tr ondblclick=document.location.href='FResultCheckNameStudent.php?dataCourse=$rowNumber/$rowGroupCourse' title=ดับเบิลคลิกเพื่อไปหน้าผลการเช็คชื่อนิสิตของรายวิชานี้>";
        $tableCourse  = $tableCourse."<td>$rowNumber</td>";
        $tableCourse  = $tableCourse."<td>$rowName</td>";
        $tableCourse  = $tableCourse."<td>$rowGroupCourse</td>";
        $tableCourse  = $tableCourse."</tr>";

        if($x+$page >= count($dataCourse)-1){
            break;
        }
    }
    }

    CreatePagination(count($dataCourse));
    return $_SESSION["CourseTableInResult"] = $tableCourse;
}


function CreatePagination($CourseNum){

    $lastPage = 0;
    if($_SESSION["PaginationSelectResult"] == 1){
        $Pagination = $Pagination."<input type=submit name=Pagination value=&laquo; disabled></input>";
    }else{
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อย้อนกลับไปตารางก่อนหน้า value=&laquo; ></input>";
    }
    
    for ($x = 0; $x*5 < $CourseNum;) {
        $x+=1;
        if($_SESSION["PaginationSelectResult"] == $x){
            $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x class=active value=$x ></input>";
        }else{
            $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางหน้า&nbsp;$x value=$x ></input>";
        }
        $lastPage = $x;
    }

    if($_SESSION["PaginationSelectResult"] == $lastPage || ($_SESSION["PaginationSelectResult"] == 1 && $lastPage == 0)){
        $Pagination = $Pagination."<input type=submit name=Pagination value=&raquo; disabled></input>";
    }else{
        $Pagination = $Pagination."<input type=submit name=Pagination title=คลิกเพื่อไปตารางถัดไป value=&raquo; ></input>";
    }
    
    return $_SESSION["PaginationCourseTableInResult"] = $Pagination;
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
                      <i class="iconv-2-lock"></i>
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
                <a href="select-course-results.php" class="is-black-blue">
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
                            <form name="changeTerm" action="FResultCheckNameStudent.php" method="post" style="margin-bottom: 0%;">
                                    <select name="terms" onchange="document.changeTerm.submit();" style="width:100%; height: auto; padding: 5px 2px; " title="คลิกเพื่อเลือกภาคเรียน">
                                        <?php echo $optionsTerm;?>
                                    </select>
                            </form>

                            </div>

                            <!--<button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_left</i></button>
                            <button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_right</i></button>-->
                        </div>
                        <br>
                        <table id="table-starter">
                            <tr>
                                <th>รหัสวิชา</th>
                                <th>ชื่อวิชา</th>
                                <th>กลุ่มเรียน</th>
                            </tr>
                            <?php
                                echo $_SESSION["CourseTableInResult"] ;
                            ?>
                        </table>
                        <div class="pagination" style="width: 100%; text-align: center;">
                            <div style="display: inline-block;">
                            <form name="changePagination" action="FResultCheckNameStudent.php" method="post" style="margin-bottom: 0%;">
                                <?php
                                    echo $_SESSION["PaginationCourseTableInResult"] ;
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







