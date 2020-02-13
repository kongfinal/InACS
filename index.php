<?php session_start();
include('condb.php');

$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];

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



$queryTerm = "SELECT * FROM `inacs_term`";
$termSelect = mysqli_query($con,$queryTerm);

$dataTerm = array();

while($rowTerm = mysqli_fetch_array($termSelect)){
    array_push($dataTerm,array($rowTerm[2],$rowTerm[1],$rowTerm[0]));
}

sort($dataTerm);
$_SESSION["IDTermFirst"] = $dataTerm[count($dataTerm)-1][2];
$_SESSION["TermFirst"] = $dataTerm[count($dataTerm)-1][1]."/".$dataTerm[count($dataTerm)-1][0];

$ToDay = substr(date("l"),0,2);

$queryCourse = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirst"]."' AND NameTeacher='".$_SESSION["Name"]."' AND Day='$ToDay' ";
$CourseTable = mysqli_query($con,$queryCourse);
$tableCourse = "";


if(mysqli_num_rows($CourseTable) > 0){
    while ($row = mysqli_fetch_assoc($CourseTable)) {
            $IDCourseToDay = $row['ID'];
            $numberCourseToDay = $row['Number'];
            $nameCourseToDay = $row['Name'];
            $groupCourseToDay = $row['GroupCourse'];
            $typeCourseToDay = $row['Type'];
            $roomCourseToDay = $row['Room'];

            $tableCourse  = $tableCourse."<tr ondblclick=document.location.href='FIndex.php?idCourse=$IDCourseToDay'>";
            $tableCourse  = $tableCourse."<td>$numberCourseToDay</td>";
            $tableCourse  = $tableCourse."<td>$nameCourseToDay</td>";
            $tableCourse  = $tableCourse."<td>$groupCourseToDay</td>";
            $tableCourse  = $tableCourse."<td>$typeCourseToDay</td>";
            $tableCourse  = $tableCourse."<td>$roomCourseToDay</td>";
            $tableCourse  = $tableCourse."</tr>";

    }
}

$_SESSION["TableCourseToDay"] = $tableCourse;



?>
<?php
include('h.php');
?>
<style>



</style>
<body>

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
                <a href="index.php" class="is-black-blue">
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
                    <svg class="menu-icon-topic iconv-2-home"></svg>หน้าหลัก
                </div>
                <div class="box">
                <form name="Send" action="FIndex.php" method="post" style=" margin-bottom: 0%;">
                <div class="columns">

                    <h3>Tset Send Email : </h3>

                    <button class="small-v3" name="sendMail" style="margin-left: 4%; width: 12%;"  onclick="document.Send.submit();">
                        <b  style="margin-top: 4%; margin-bottom: 4%; font-size: 32px;" >ส่งเมล</b>
                        <!--<svg class="menu-icon iconv-2-add-box"></svg>-->
                    </button>
                </div>
                </form>
                <form name="Add" action="FIndex.php" method="post" style=" margin-bottom: 0%;">
                    <div class="columns">
                    
                        <h3 style="margin-right:1%;"><b>ภาคเรียนล่าสุด :</b></h3>
                        <h3><?php echo $_SESSION["TermFirst"];?></h3>

                        <h2 style="margin-right:4%; margin-left:4%;"><b>|</b></h2>


                        
                        <h3 style="margin-left:1%;"><b>ปีการศึกษา :</b></h3>
                        <input class="input-field-v8-2" style="width: 10%; height:30px; margin-top:1%; margin-left:1%;" type="textRegis" name="Year" value="" title="ใส่ปีการศึกษาเป็น พ.ศ." autocomplete=off>

                        <h3 style="margin-left:2%; margin-right:1%;"><b>เทอม :</b></h3>
                        <input class="input-field-v8-2" style="width: 10%; height:30px; margin-top:1%;" type="textRegis" name="Term" value="" title="ใส่เทอมเป็น 1 หรือ 2 หรือ 3 (3 เป็น Summer)" autocomplete=off>

                        <button class="small-v3" name="addTerm" style="margin-left: 4%; width: 12%;" title="คลิกเพื่อเพิ่มเทอม" onclick="document.Add.submit();">
                        <i class="material-icons" style="margin-top: 4%; margin-bottom: 4%; font-size: 32px;" >add_box</i>
                        <!--<svg class="menu-icon iconv-2-add-box"></svg>-->
                        </button>
                        

                    </div>
                </form>

                <div class="columns">
                    <div class="column is-3">
                        <h3>วิชาที่สอนวันนี้</h3>
                    </div>
                </div>

                <div class="columns">
                <table id="table-starter">
                    <tr>
                        <th>รหัสวิชา</th>
                        <th>ชื่อวิชา</th>
                        <th>กลุ่มเรียน</th>
                        <th>ประเภท (Lecture/Lab)</th>
                        <th>ห้องเรียน</th>
                    </tr>
                    <?php
                        echo $_SESSION["TableCourseToDay"] ;
                    ?>
                  
                </table>
                </div>

                <div class="columns">
                    <div class="column is-9">
                        <h3>กราฟข้อมูลการเช็คชื่อ</h3>
                        <div class="set-flex">
                            <h4>ภาคเรียน :&nbsp</h4>
                            <div class="select-margin-v1 select-input" style="width:11%;">
                                <select>
                                <option >Select :</option>
                                </select>
                            </div>
                            <h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspเดือน :&nbsp</h4>
                            <div class="select-margin-v1 select-input" style="width:11%;">
                                <select>
                                <option >Select :</option>
                                </select>
                            </div>
                            <h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspรายวิชา:&nbsp</h4>
                            <div class="select-margin-v1 select-input" style="width:11%;">
                                <select>
                                <option >Select :</option>
                                </select>
                            </div>
                        </div>

                        <div class="set-flex">
                            <div class="div-graph">
                                <br><br><br><br><br><br>
                            </div>

                            <div class="magin-clicle">
                                <span class="dot dot-color-1"></span><b>&nbsp&nbspมาเรียนทันเวลา</b><br>
                                <span class="dot dot-color-2"></span><b>&nbsp&nbspมาเรียนสาย</b><br>
                                <span class="dot dot-color-3"></span><span ><b>&nbsp&nbspขาดเรียน</b></span>
                            </div>
                        </div>

                    </div>
                    <div class="column is-10">
                        <h3>นิสิตกลุ่มเสี่ยง</h3>
                        
                        <table id="table-starter">
                        <tr>
                            <th>ชื่อนิสิต</th>
                            <th>ชื่อวิชา</th>
                        </tr>
                        <tr>
                            <td>นาย กกกก ขขขขขข</td>
                            <td>Web Programming</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                        </table>

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
        <input class="is-pulled-right input-field-v1-5"  type="password" name="rep-password" value="" autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePass"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


  <div id="ChangeEmail" class="modal">
  
  <form class="modal-content animate" action="FChangeEmail.php" method="post">

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




</body>
</html>







