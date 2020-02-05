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


$queryCourse = "SELECT * FROM `inacs_course` WHERE NameTeacher='".$_SESSION['Name']."' 
AND Number='".$_SESSION['NumCourseInResultStudent']."' 
AND Name='".$_SESSION['NameCourseInResultStudent']."'  ";
$CourseData = mysqli_query($con,$queryCourse);

$optionsType = "";
$dataTypeArray = array();

if(mysqli_num_rows($CourseData) > 0){
    array_push($dataTypeArray,"All");
    while ($row = mysqli_fetch_assoc($CourseData)) {
        $courseType = $row['Type'];
        $courseGroup = $row['GroupCourse'];
        $dataCourseGroupArray = explode("+", $courseGroup);

        if($_SESSION["GroupCourseInResultStudent"] == $courseGroup){
            array_push($dataTypeArray,$courseType);
        }else{
            for($x = 0;$x < count($dataCourseGroupArray);$x+=1){
                if($_SESSION["GroupCourseInResultStudent"] == $dataCourseGroupArray[$x]){
                    array_push($dataTypeArray,$courseType);
                }
            }
        }

    }
}

if(count($dataTypeArray) == 3){
    if($dataTypeArray[2] == "Lecture" && $dataTypeArray[1] == "Lab"){
        $dataTypeArray[2] = "Lab";
        $dataTypeArray[1] = "Lecture";
    }
}


for($x = 0;$x < count($dataTypeArray);$x+=1){
    if($_SESSION["TypeResult"] == $dataTypeArray[$x]){
        $optionsType  = $optionsType."<option value=$dataTypeArray[$x] selected>$dataTypeArray[$x]</option>";
    }else{
        $optionsType  = $optionsType."<option value=$dataTypeArray[$x] >$dataTypeArray[$x]</option>";
    }
}


$dataResult = array();
$dataCheckResult = array();
$numberCheck = 0;

if($_SESSION["TypeResult"] == "All"){

    $queryCourseToResult = "SELECT * FROM `inacs_course` WHERE NameTeacher='".$_SESSION['Name']."' 
    AND Number='".$_SESSION['NumCourseInResultStudent']."' 
    AND Name='".$_SESSION['NameCourseInResultStudent']."'  
    AND GroupCourse='".$_SESSION['GroupCourseInResultStudent']."'
    ";
    $CourseDataToResult = mysqli_query($con,$queryCourseToResult);
    if(mysqli_num_rows($CourseDataToResult) > 0){
        while ($rowCourse = mysqli_fetch_assoc($CourseDataToResult)) {

            $rowCourseID = $rowCourse['ID'];
            $queryCheckToResult = "SELECT * FROM `inacs_check` WHERE IDCourse='$rowCourseID' ";
            $CheckDataToResult = mysqli_query($con,$queryCheckToResult);
            if(mysqli_num_rows($CheckDataToResult) == 1){
                while ($rowCheck = mysqli_fetch_assoc($CheckDataToResult)) {
                    $numberCheck = $rowCheck['NumberCheck'];
                }
            }
            

            $queryStudentToResult = "SELECT * FROM `inacs_student` WHERE IDCourse='$rowCourseID' ";
            $StudentDataToResult = mysqli_query($con,$queryStudentToResult);
            if(mysqli_num_rows($StudentDataToResult) > 0){
                while ($rowStudent = mysqli_fetch_assoc($StudentDataToResult)) {
                    
                    $rowStudentID = $rowStudent['ID'];
                    $queryResultToResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$rowStudentID' ";
                    $ResultDataToResult = mysqli_query($con,$queryResultToResult);
                    if(mysqli_num_rows($ResultDataToResult) == 1){
                        while ($rowResult = mysqli_fetch_assoc($ResultDataToResult)) {

                            $checkResultStudent = true;
                            for($x = 0;$x < count($dataCheckResult);$x+=1){
                                if($dataCheckResult[$x] == $rowStudent['Number']){
                                    $checkResultStudent = false;

                                    $dataResult[$x][3] += $numberCheck;
                                    $dataResult[$x][4] += $rowResult['NumberOnTime'];
                                    $dataResult[$x][5] += $rowResult['NumberLate'];


                                    if($dataResult[$x][3] == 0){
                                        $dataResult[$x][6] = 0;
                                    }else{
                                        $dataResult[$x][6] = round((($dataResult[$x][4]+($dataResult[$x][5]*0.5))/$dataResult[$x][3])*100);
                                    }
                                    
                                    
                                    $dataResult[$x][7] += $rowResult['ScoreDeducted'];
                                    $dataResult[$x][8] += $rowResult['ScoreExtra'];
                                }
                            }


                            if($checkResultStudent){
                                array_push($dataCheckResult,$rowStudent['Number']);
                                array_push($dataResult,array($rowStudent['Number'],$rowStudent['Name'],$rowStudent['Branch'],$numberCheck,$rowResult['NumberOnTime'],$rowResult['NumberLate'],$rowResult['ScoreRoom'],$rowResult['ScoreDeducted'],$rowResult['ScoreExtra']));
                            }


                        }
                    }

                }
            }

        }
    }

}else{

    $queryCourseToResult = "SELECT * FROM `inacs_course` WHERE NameTeacher='".$_SESSION['Name']."' 
    AND Number='".$_SESSION['NumCourseInResultStudent']."' 
    AND Name='".$_SESSION['NameCourseInResultStudent']."'  
    AND GroupCourse='".$_SESSION['GroupCourseInResultStudent']."'
    AND Type='".$_SESSION['TypeResult']."'
    ";
    $CourseDataToResult = mysqli_query($con,$queryCourseToResult);
    
    if(mysqli_num_rows($CourseDataToResult) == 1){
        while ($rowCourse = mysqli_fetch_assoc($CourseDataToResult)) {
            
            $rowCourseID = $rowCourse['ID'];
            $queryCheckToResult = "SELECT * FROM `inacs_check` WHERE IDCourse='$rowCourseID' ";
            $CheckDataToResult = mysqli_query($con,$queryCheckToResult);
            if(mysqli_num_rows($CheckDataToResult) == 1){
                while ($rowCheck = mysqli_fetch_assoc($CheckDataToResult)) {
                    $numberCheck = $rowCheck['NumberCheck'];
                }
            }

            $queryStudentToResult = "SELECT * FROM `inacs_student` WHERE IDCourse='$rowCourseID' ";
            $StudentDataToResult = mysqli_query($con,$queryStudentToResult);
            if(mysqli_num_rows($StudentDataToResult) > 0){
                while ($rowStudent = mysqli_fetch_assoc($StudentDataToResult)) {
                    
                    $rowStudentID = $rowStudent['ID'];
                    $queryResultToResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$rowStudentID' ";
                    $ResultDataToResult = mysqli_query($con,$queryResultToResult);
                    if(mysqli_num_rows($ResultDataToResult) == 1){
                        while ($rowResult = mysqli_fetch_assoc($ResultDataToResult)) {
                            array_push($dataResult,array($rowStudent['Number'],$rowStudent['Name'],$rowStudent['Branch'],$numberCheck,$rowResult['NumberOnTime'],$rowResult['NumberLate'],$rowResult['ScoreRoom'],$rowResult['ScoreDeducted'],$rowResult['ScoreExtra']));
                        }
                    }

                }
            }

        }
    }

}


sort($dataResult);
$tableResult = "";
for($x = 0;$x < count($dataResult);$x+=1){

    $numberStudent = $dataResult[$x][0];
    $nameStudent = $dataResult[$x][1];
    $branchStudent = $dataResult[$x][2];
    $numberCheckCheck = $dataResult[$x][3];
    $numberOnTimeResult = $dataResult[$x][4];
    $numberLateResult = $dataResult[$x][5];
    $ScoreRoomResult = $dataResult[$x][6];
    $ScoreDeductedResult = $dataResult[$x][7];
    $ScoreExtraResult = $dataResult[$x][8];

    $tableResult  = $tableResult."<tr>";

    $tableResult  = $tableResult."<td >$numberStudent</td>";  
    $tableResult  = $tableResult."<td >$nameStudent</td>"; 
    $tableResult  = $tableResult."<td >$branchStudent</td>"; 
    $tableResult  = $tableResult."<td >$numberCheckCheck</td>"; 
    $tableResult  = $tableResult."<td >$numberOnTimeResult</td>"; 
    $tableResult  = $tableResult."<td >$numberLateResult</td>"; 
    $tableResult  = $tableResult."<td >$ScoreRoomResult</td>"; 
    $tableResult  = $tableResult."<td >$ScoreDeductedResult</td>";
    $tableResult  = $tableResult."<td >$ScoreExtraResult</td>";   

    $tableResult  = $tableResult."</tr>";
}

$_SESSION["ResultTableInResult"] = $tableResult;

$_SESSION["ResultStudentData"] = $dataResult;


?>
<?php
include('h.php');
?>

<body>
<style>

.column.is-11 {
  flex: none;
  width: 15%;
}

.column.is-12 {
  flex: none;
  width: 85%;
}

#table-no-click-result {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }
  
  #table-no-click-result td, #table-no-click-result th {
    border: 1px solid #ddd;
    padding: 4px;
    text-align: center;
  }
  
  #table-no-click-result tr:nth-child(even){background-color: #f2f2f2;}

  
  #table-no-click-result th {
    padding-top: 12px;
    padding-bottom: 12px;
    background-color: #2c56d4;
    color: white;
  }

</style>



<div class="navbar-div">
        <nav class="navbarv-2 is-dodgerblue" aria-label="main navigation">
            <a class="navbar-item banner">
                <div>
                    <span class="navbar-banner-text">InACS</span>
                </div>
            </a>
            <button id="navbar-user" class="navbar-item user" onclick="if (document.getElementById('navbar-dropdown').classList.contains('is-active'))  return document.getElementById('navbar-dropdown').classList.remove('is-active'); else return document.getElementById('navbar-dropdown').classList.add('is-active');">
                <div class="user-container">
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
                    <svg class="menu-icon-topic iconv-2-clipboard"></svg>ผลการเช็คชื่อ
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-8">
                        <br>
                        <div class="set-flex" style="margin-bottom: 1%;">
                            <div style="font-size: 18px; margin-top: 0.5%; margin-right: 1%;"><b><?php echo $_SESSION["NumCourseInResultStudent"]; ?> : </b></div>
                            <div style="font-size: 18px; margin-top: 0.5%; width: 49.5%;"><b><?php echo $_SESSION["NameCourseInResultStudent"]; ?></b></div>
                            <div style="font-size: 18px; margin-top: 0.5%; width: 20.1%;"><b>กลุ่มเรียน :</b> <?php echo $_SESSION["GroupCourseInResultStudent"]; ?></div>
                            <div style="font-size: 18px; margin-top: 0.5%; margin-right: 0.3%;"><b>ประเภท :</b></div>

                            <div class="select-input " style="width:11.5%; margin-top: 0.5%;">
                            <form name="changeType" action="FResultCheckNameStudent.php" method="post" style="margin-bottom: 0%;">
                            <select name="types" onchange="document.changeType.submit();" style="width:100%; height: auto; padding: 2px 2px;" title="คลิกเพื่อเลือกประเภทของรายวิชาที่ต้องการดูผลการเช็คชื่อ"> 
                                <?php echo $optionsType;?>
                            </select>
                            </form>
                            </div>

                        </div>
                        <table id="table-no-click-result" style="margin-top: 1.5%; font-size:15px;" >
                            <tr>
                                <th>รหัสนิสิต</th>
                                <th>ชื่อนิสิต</th>
                                <th>สาขา</th>
                                <th>จำนวนที่เช็ค</th>
                                <th>ทันเวลา</th>
                                <th>สาย</th>
                                <th>คะแนนเข้าห้อง</th>
                                <th>คะแนนที่หัก</th>
                                <th>คะแนนพิเศษ</th>
                            </tr>
                            <?php
                                echo $_SESSION["ResultTableInResult"] ;
                            ?>
                            <!--<tr>
                                <td>59160000</td>
                                <td>นาย กกกกก ขขขขขข</td>
                                <td>วิทยาการคอมพิวเตอร์</td>
                                <td>15</td>
                                <td>7</td>
                                <td>4</td>
                                <td>60</td>
                                <td>6</td>
                                <td>0</td>
                            </tr>-->
                        </table>

                        <form name="exportResult" action="FResultCheckNameStudent.php" method="post" style="margin-bottom: 0%;">
                        <button class="small-v3" style="margin-top: 2%; margin-left: 86%;" name="export" title="คลิกเพื่อเอ็กพอร์ตข้อมูลผลการเช็คชื่อออกมาเป็น CSV">
                        <svg class="iconv-2-export-csv" style="margin-top: 1%;"></svg>
                        </button>
                        </form>

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





<script>
var modalChangePass = document.getElementById('ChangePassFormv.2');
var modalChangeEmail = document.getElementById('ChangeEmail');

window.onclick = function(event) {
    if(event.target == modalChangePass) {
        modalChangePass.style.display = "none";
    }else if(event.target == modalChangeEmail) {
        modalChangeEmail.style.display = "none";
    }
}

function switchNavBarDropDown() {
    var dropdown = document.getElementById('navbar-dropdown');
    if (dropdown.classList.contains('is-active')) {
        dropdown.classList.remove('is-active');
    } else {
        dropdown.classList.add('is-active');
    }
}
</script>

</body>
</html>







