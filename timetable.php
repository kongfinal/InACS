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


$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];


$queryCourse = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirst"]."' AND NameTeacher='".$_SESSION["Name"]."'";
$CourseTable = mysqli_query($con,$queryCourse);
$timeTableCourseMo = "";
$timeTableCourseTu = "";
$timeTableCourseWe = "";
$timeTableCourseTh = "";
$timeTableCourseFr = "";
$timeTableCourseSa = "";
$timeTableCourseSu = "";
$time_days = array('08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00');
$dataCourseMo = array();
$dataCourseTu = array();
$dataCourseWe = array();
$dataCourseTh = array();
$dataCourseFr = array();
$dataCourseSa = array();
$dataCourseSu = array();

if(mysqli_num_rows($CourseTable) > 0){
    while ($row = mysqli_fetch_assoc($CourseTable)) {
        if($row['Day'] == "Mo"){
            array_push($dataCourseMo,array($row['TimeStart'],$row['TimeEnd'],$row['Number'],$row['GroupCourse'],$row['Room'],$row['ID']));
        }else if($row['Day'] == "Tu"){
            array_push($dataCourseTu,array($row['TimeStart'],$row['TimeEnd'],$row['Number'],$row['GroupCourse'],$row['Room'],$row['ID']));
        }else if($row['Day'] == "We"){
            array_push($dataCourseWe,array($row['TimeStart'],$row['TimeEnd'],$row['Number'],$row['GroupCourse'],$row['Room'],$row['ID']));
        }else if($row['Day'] == "Th"){
            array_push($dataCourseTh,array($row['TimeStart'],$row['TimeEnd'],$row['Number'],$row['GroupCourse'],$row['Room'],$row['ID']));
        }else if($row['Day'] == "Fr"){
            array_push($dataCourseFr,array($row['TimeStart'],$row['TimeEnd'],$row['Number'],$row['GroupCourse'],$row['Room'],$row['ID']));
        }else if($row['Day'] == "Sa"){
            array_push($dataCourseSa,array($row['TimeStart'],$row['TimeEnd'],$row['Number'],$row['GroupCourse'],$row['Room'],$row['ID']));
        }else if($row['Day'] == "Su"){
            array_push($dataCourseSu,array($row['TimeStart'],$row['TimeEnd'],$row['Number'],$row['GroupCourse'],$row['Room'],$row['ID']));
        }
    }
}

sort($dataCourseMo);
$timeTableCourseMo  .= $timeTableCourseMo."<td class=is-dodgerblue >จันทร์</td>";
for ($x = 0; $x < count($time_days)-1;) {
    $timeCheck = true;
    for($y = 0; $y < count($dataCourseMo); $y+=1){
        if($time_days[$x]==$dataCourseMo[$y][0]){

            $duration = 0;
            for($z = 0; $time_days[$x+$z] != $dataCourseMo[$y][1]; $z+=1){
                $duration+=1;
            }
            $numberCourse = $dataCourseMo[$y][2];
            $groupCourse = $dataCourseMo[$y][3];
            $roomCourse = $dataCourseMo[$y][4];
            $timeTableCourseMo = $timeTableCourseMo."<td colspan=$duration class=is-grey ><a href=# class=is-black title=คลิกเพื่อไปหน้าเช็คชื่อนิสิตของวิชานี้><b>$numberCourse <br>$groupCourse,$roomCourse</b></a></td>";
            $timeCheck = false;
            $x+=$duration;

        }
    }
    if($timeCheck){
        $timeTableCourseMo = $timeTableCourseMo."<td>&nbsp</td>";
        $x+=1;
    }
}
$_SESSION["TimeTableCourseMo"] = $timeTableCourseMo;

sort($dataCourseTu);
$timeTableCourseTu  .= $timeTableCourseTu."<td class=is-dodgerblue>อังคาร</td>";
for ($x = 0; $x < count($time_days)-1;) {
    $timeCheck = true;
    for($y = 0; $y < count($dataCourseTu); $y+=1){
        if($time_days[$x]==$dataCourseTu[$y][0]){

            $duration = 0;
            for($z = 0; $time_days[$x+$z] != $dataCourseTu[$y][1]; $z+=1){
                $duration+=1;
            }
            $numberCourse = $dataCourseTu[$y][2];
            $groupCourse = $dataCourseTu[$y][3];
            $roomCourse = $dataCourseTu[$y][4];
            $timeTableCourseTu = $timeTableCourseTu."<td colspan=$duration class=is-grey><a href=# class=is-black title=คลิกเพื่อไปหน้าเช็คชื่อนิสิตของวิชานี้><b>$numberCourse <br>$groupCourse,$roomCourse</b></a></td>";
            $timeCheck = false;
            $x+=$duration;
            
        }
    }
    if($timeCheck){
        $timeTableCourseTu = $timeTableCourseTu."<td>&nbsp</td>";
        $x+=1;
    }
}
$_SESSION["TimeTableCourseTu"] = $timeTableCourseTu;

sort($dataCourseWe);
$timeTableCourseWe  .= $timeTableCourseWe."<td class=is-dodgerblue>พุธ</td>";
for ($x = 0; $x < count($time_days)-1;) {
    $timeCheck = true;
    for($y = 0; $y < count($dataCourseWe); $y+=1){
        if($time_days[$x]==$dataCourseWe[$y][0]){

            $duration = 0;
            for($z = 0; $time_days[$x+$z] != $dataCourseWe[$y][1]; $z+=1){
                $duration+=1;
            }
            $numberCourse = $dataCourseWe[$y][2];
            $groupCourse = $dataCourseWe[$y][3];
            $roomCourse = $dataCourseWe[$y][4];
            $timeTableCourseWe = $timeTableCourseWe."<td colspan=$duration class=is-grey><a href=# class=is-black title=คลิกเพื่อไปหน้าเช็คชื่อนิสิตของวิชานี้><b>$numberCourse <br>$groupCourse,$roomCourse</b></a></td>";
            $timeCheck = false;
            $x+=$duration;
            
        }
    }
    if($timeCheck){
        $timeTableCourseWe = $timeTableCourseWe."<td>&nbsp</td>";
        $x+=1;
    }
}
$_SESSION["TimeTableCourseWe"] = $timeTableCourseWe;

sort($dataCourseTh);
$timeTableCourseTh  .= $timeTableCourseTh."<td class=is-dodgerblue>พฤหัสบดี</td>";
for ($x = 0; $x < count($time_days)-1;) {
    $timeCheck = true;
    for($y = 0; $y < count($dataCourseTh); $y+=1){
        if($time_days[$x]==$dataCourseTh[$y][0]){

            $duration = 0;
            for($z = 0; $time_days[$x+$z] != $dataCourseTh[$y][1]; $z+=1){
                $duration+=1;
            }
            $numberCourse = $dataCourseTh[$y][2];
            $groupCourse = $dataCourseTh[$y][3];
            $roomCourse = $dataCourseTh[$y][4];
            $timeTableCourseTh = $timeTableCourseTh."<td colspan=$duration class=is-grey><a href=# class=is-black title=คลิกเพื่อไปหน้าเช็คชื่อนิสิตของวิชานี้><b>$numberCourse <br>$groupCourse,$roomCourse</b></a></td>";
            $timeCheck = false;
            $x+=$duration;
            
        }
    }
    if($timeCheck){
        $timeTableCourseTh = $timeTableCourseTh."<td>&nbsp</td>";
        $x+=1;
    }
}
$_SESSION["TimeTableCourseTh"] = $timeTableCourseTh;

sort($dataCourseFr);
$timeTableCourseFr  .= $timeTableCourseFr."<td class=is-dodgerblue>ศุกร์</td>";
for ($x = 0; $x < count($time_days)-1;) {
    $timeCheck = true;
    for($y = 0; $y < count($dataCourseFr); $y+=1){
        if($time_days[$x]==$dataCourseFr[$y][0]){

            $duration = 0;
            for($z = 0; $time_days[$x+$z] != $dataCourseFr[$y][1]; $z+=1){
                $duration+=1;
            }
            $numberCourse = $dataCourseFr[$y][2];
            $groupCourse = $dataCourseFr[$y][3];
            $roomCourse = $dataCourseFr[$y][4];
            $timeTableCourseFr = $timeTableCourseFr."<td colspan=$duration class=is-grey><a href=# class=is-black title=คลิกเพื่อไปหน้าเช็คชื่อนิสิตของวิชานี้><b>$numberCourse <br>$groupCourse,$roomCourse</b></a></td>";
            $timeCheck = false;
            $x+=$duration;
            
        }
    }
    if($timeCheck){
        $timeTableCourseFr = $timeTableCourseFr."<td>&nbsp</td>";
        $x+=1;
    }
}
$_SESSION["TimeTableCourseFr"] = $timeTableCourseFr;

sort($dataCourseSa);
$timeTableCourseSa  .= $timeTableCourseSa."<td class=is-red>เสาร์</td>";
for ($x = 0; $x < count($time_days)-1;) {
    $timeCheck = true;
    for($y = 0; $y < count($dataCourseSa); $y+=1){
        if($time_days[$x]==$dataCourseSa[$y][0]){

            $duration = 0;
            for($z = 0; $time_days[$x+$z] != $dataCourseSa[$y][1]; $z+=1){
                $duration+=1;
            }
            $numberCourse = $dataCourseSa[$y][2];
            $groupCourse = $dataCourseSa[$y][3];
            $roomCourse = $dataCourseSa[$y][4];
            $timeTableCourseSa = $timeTableCourseSa."<td colspan=$duration class=is-grey><a href=# class=is-black title=คลิกเพื่อไปหน้าเช็คชื่อนิสิตของวิชานี้><b>$numberCourse <br>$groupCourse,$roomCourse</b></a></td>";
            $timeCheck = false;
            $x+=$duration;
            
        }
    }
    if($timeCheck){
        $timeTableCourseSa = $timeTableCourseSa."<td>&nbsp</td>";
        $x+=1;
    }
}
$_SESSION["TimeTableCourseSa"] = $timeTableCourseSa;

sort($dataCourseSu);
$timeTableCourseSu  .= $timeTableCourseSu."<td class=is-red>อาทิตย์</td>";
for ($x = 0; $x < count($time_days)-1;) {
    $timeCheck = true;
    for($y = 0; $y < count($dataCourseSu); $y+=1){
        if($time_days[$x]==$dataCourseSu[$y][0]){

            $duration = 0;
            for($z = 0; $time_days[$x+$z] != $dataCourseSu[$y][1]; $z+=1){
                $duration+=1;
            }
            $numberCourse = $dataCourseSu[$y][2];
            $groupCourse = $dataCourseSu[$y][3];
            $roomCourse = $dataCourseSu[$y][4];
            $timeTableCourseSu = $timeTableCourseSu."<td colspan=$duration class=is-grey><a href=# class=is-black title=คลิกเพื่อไปหน้าเช็คชื่อนิสิตของวิชานี้><b>$numberCourse <br>$groupCourse,$roomCourse</b></a></td>";
            $timeCheck = false;
            $x+=$duration;
            
        }
    }
    if($timeCheck){
        $timeTableCourseSu = $timeTableCourseSu."<td>&nbsp</td>";
        $x+=1;
    }
}
$_SESSION["TimeTableCourseSu"] = $timeTableCourseSu;


?>
<?php
include('h.php');


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
                <a href="timetable.php" class="is-black-blue">
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
                    <svg class="menu-icon-topic iconv-2-table"></svg>ตารางสอน
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-8">
                       <br>
                    <table id="table-time">
                            <tr>
                                <th>Day/Time</th>
                                <th class="th-size-8" style="padding: 0px;">8:00-9:00</th>
                                <th class="th-size-8" style="padding: 0px;">9:00-10:00</th>
                                <th class="th-size-8" style="padding: 0px;">10:00-11:00</th>
                                <th class="th-size-8" style="padding: 0px;">11:00-12:00</th>
                                <th class="th-size-8" style="padding: 0px;">12:00-13:00</th>
                                <th class="th-size-8" style="padding: 0px;">13:00-14:00</th>
                                <th class="th-size-8" style="padding: 0px;">14:00-15:00</th>
                                <th class="th-size-8" style="padding: 0px;">15:00-16:00</th>
                                <th class="th-size-8" style="padding: 0px;">16:00-17:00</th>
                                <th class="th-size-8" style="padding: 0px;">17:00-18:00</th>
                                <th class="th-size-8" style="padding: 0px;">18:00-19:00</th>
                                <th class="th-size-8" style="padding: 0px;">19:00-20:00</th>
                                <th class="th-size-8" style="padding: 0px;">20:00-21:00</th>
                            </tr>
                            <tr>
                                <?php
                                    echo $_SESSION["TimeTableCourseMo"] ;
                                ?>
                            </tr>
                            <tr>
                                <?php
                                    echo $_SESSION["TimeTableCourseTu"] ;
                                ?>
                            </tr>
                            <tr>
                                <?php
                                    echo $_SESSION["TimeTableCourseWe"] ;
                                ?>
                            </tr>
                            <tr>
                                <?php
                                    echo $_SESSION["TimeTableCourseTh"] ;
                                ?>
                            </tr>
                            <tr>
                                <?php
                                    echo $_SESSION["TimeTableCourseFr"] ;
                                ?>
                            </tr>
                            <tr>
                                <?php
                                    echo $_SESSION["TimeTableCourseSa"] ;
                                ?>
                            </tr>
                            <tr>
                                <?php
                                    echo $_SESSION["TimeTableCourseSu"] ;
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>

<div id="ChangePassFormv.2" class="modal">
  
  <form class="modal-content animate" action="FChangePassword.php"  method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนรหัสผ่าน</h2> 

  <div class="input-textRegis">
        <div class="sizeText " style="margin: 2% 9% 2% 0%;"><b>New Password :</b></div>
        <input class="is-pulled-right input-field-v1 " type="textRegis" name="new-password" value="" autocomplete=off>
  </div>

  <div class="input-textRegis">
        <div class="sizeText " style="margin: 2% 3% 2% 0%;"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1 " type="password" name="curr-password" value="<?php echo $password; ?>" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText " style="margin: 2% 4% 2% 0%;"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1"  type="password" name="rep-password" value="" autocomplete=off>
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
        <div class="sizeText " style="margin: 2% 0.9% 2% 0%;"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v2" type="textRegis" name="email" value="<?php echo $email; ?>" autocomplete=off>
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changeEmail"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>




</body>
</html>







