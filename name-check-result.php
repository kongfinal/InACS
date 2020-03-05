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


$queryCourse = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' 
AND NameTeacher='".$_SESSION['Name']."' 
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
$dataCheckResultAll = array();
$dataPhoneNumber = array();
$dataTypeCourse = array();
$numberCheck = 0;
$headerTable="";

if($_SESSION["TypeResult"] == "All"){

    $headerTable  = $headerTable."<tr>";
    $headerTable  = $headerTable."<th rowspan=2>รหัสนิสิต</th>";
    $headerTable  = $headerTable."<th rowspan=2>ชื่อนิสิต</th>";
    $headerTable  = $headerTable."<th colspan=4>บรรยาย</th>";
    $headerTable  = $headerTable."<th colspan=4>ปฎิบัติ</th>";
    //$headerTable  = $headerTable."<th rowspan=2>เบอร์ผู้ปกครอง</th>";
    $headerTable  = $headerTable."<th rowspan=2>เพิ่มเบอร์โทรศัพท์</th>";
    $headerTable  = $headerTable."</tr>";

    $headerTable  = $headerTable."<tr>";
    $headerTable  = $headerTable."<th>จำนวนที่เช็ค</th>";
    $headerTable  = $headerTable."<th>ทันเวลา</th>";
    $headerTable  = $headerTable."<th>สาย</th>";
    $headerTable  = $headerTable."<th>ขาด</th>";
    $headerTable  = $headerTable."<th>จำนวนที่เช็ค</th>";
    $headerTable  = $headerTable."<th>ทันเวลา</th>";
    $headerTable  = $headerTable."<th>สาย</th>";
    $headerTable  = $headerTable."<th>ขาด</th>";
    $headerTable  = $headerTable."</tr>";
    $_SESSION["HeaderResultTableInResult"] = $headerTable;

    for($y = 1;$y < count($dataTypeArray);$y+=1){

        $queryCourseToResult = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' 
        AND NameTeacher='".$_SESSION['Name']."' 
        AND Number='".$_SESSION['NumCourseInResultStudent']."' 
        AND Name='".$_SESSION['NameCourseInResultStudent']."'  
        AND GroupCourse='".$_SESSION['GroupCourseInResultStudent']."'
        AND Type='$dataTypeArray[$y]'
        ";
    
        $CourseDataToResult = mysqli_query($con,$queryCourseToResult);
        if(mysqli_num_rows($CourseDataToResult) == 1){
            while ($rowCourse = mysqli_fetch_assoc($CourseDataToResult)) {
    
                $rowCourseID = $rowCourse['ID'];
                $queryCheckToResult = "SELECT * FROM `inacs_check` WHERE IDCourse='$rowCourseID' ";
                $CheckDataToResult = mysqli_query($con,$queryCheckToResult);
                if(mysqli_num_rows($CheckDataToResult) == 1){
                    while ($rowCheck = mysqli_fetch_assoc($CheckDataToResult)) {
                        $numberCheck = $rowCheck['NumberCheck']-1;
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
                                        /*
                                        $dataResult[$x][3] += $numberCheck;
                                        $dataResult[$x][4] += $rowResult['NumberOnTime'];
                                        $dataResult[$x][5] += $rowResult['NumberLate'];
                                        */
    
                                        $dataResult[$x][8] += $rowResult['ScoreDeducted'];
                                        $dataResult[$x][9] += $rowResult['ScoreExtra'];
                                        
                                        if($rowCourse['Type'] == "Lecture"){
                                            $dataResult[$x][3] = $numberCheck;
                                            $dataResult[$x][4] = $rowResult['NumberOnTime'];
                                            $dataResult[$x][5] = $rowResult['NumberLate'];
                                            $dataResult[$x][6] = $rowResult['NumberAbsent'];
                                        }else{
                                            $dataResult[$x][10] = $numberCheck;
                                            $dataResult[$x][11] = $rowResult['NumberOnTime'];
                                            $dataResult[$x][12] = $rowResult['NumberLate'];
                                            $dataResult[$x][13] = $rowResult['NumberAbsent'];
                                        }
                                        

                                        $numberCheckCal = $dataResult[$x][3] + $numberCheck;
                                        $numberOnTimeCal = $dataResult[$x][4] + $rowResult['NumberOnTime'];
                                        $numberLateCal = $dataResult[$x][5] + $rowResult['NumberLate'];

                                        if($dataResult[$x][3] == 0){
                                            $dataResult[$x][7] = 0;
                                        }else{
                                            $dataResult[$x][7] = round((($numberOnTimeCal+($numberLateCal*0.5))/$numberCheckCal)*100);
                                        }

    
                                    }
                                }
                                
    
                                if($checkResultStudent){
                                    array_push($dataCheckResult,$rowStudent['Number']);
                                    
                                    array_push($dataTypeCourse,$rowCourse['Type']);

                                    if($rowCourse['Type'] == "Lecture"){
                                        array_push($dataResult,array($rowStudent['Number'],$rowStudent['Name'],$rowStudent['Branch'],$numberCheck,$rowResult['NumberOnTime'],$rowResult['NumberLate'],$rowResult['NumberAbsent'],$rowResult['ScoreRoom'],$rowResult['ScoreDeducted'],$rowResult['ScoreExtra'],0,0,0,0));
                                    }else{
                                        array_push($dataResult,array($rowStudent['Number'],$rowStudent['Name'],$rowStudent['Branch'],0,0,0,0,$rowResult['ScoreRoom'],$rowResult['ScoreDeducted'],$rowResult['ScoreExtra'],$numberCheck,$rowResult['NumberOnTime'],$rowResult['NumberLate'],$rowResult['NumberAbsent']));
                                    }

                                    

                                    array_push($dataPhoneNumber,array($rowStudent['Number'],$rowStudent['ParentalPhoneNumber']));
    
                                    /*
                                    array_push($dataResult,array($rowStudent['Number'],$rowStudent['Name'],$rowStudent['Branch'],$numberCheck,$rowResult['NumberOnTime'],$rowResult['NumberLate'],$rowResult['ScoreRoom'],$rowResult['ScoreDeducted'],$rowResult['ScoreExtra']));
                                    */
                                }
    
    
                            }
                        }
    
                    }
                }
    
            }
        }

    }

}else{

    $headerTable  = $headerTable."<tr>";
    $headerTable  = $headerTable."<th>รหัสนิสิต</th>";
    $headerTable  = $headerTable."<th>ชื่อนิสิต</th>";
    $headerTable  = $headerTable."<th>จำนวนที่เช็ค</th>";
    $headerTable  = $headerTable."<th>ทันเวลา</th>";
    $headerTable  = $headerTable."<th>สาย</th>";
    $headerTable  = $headerTable."<th>ขาด</th>";
    //$headerTable  = $headerTable."<th>เบอร์ผู้ปกครอง</th>";
    $headerTable  = $headerTable."<th>เพิ่มเบอร์โทรศัพท์</th>";
    $headerTable  = $headerTable."</tr>";

    $_SESSION["HeaderResultTableInResult"] = $headerTable;


    $queryCourseToResult = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' 
    AND NameTeacher='".$_SESSION['Name']."' 
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
                    $numberCheck = $rowCheck['NumberCheck']-1;
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
                            array_push($dataResult,array($rowStudent['Number'],$rowStudent['Name'],$rowStudent['Branch'],$numberCheck,$rowResult['NumberOnTime'],$rowResult['NumberLate'],$rowResult['NumberAbsent'],$rowResult['ScoreRoom'],$rowResult['ScoreDeducted'],$rowResult['ScoreExtra']));

                            array_push($dataPhoneNumber,array($rowStudent['Number'],$rowStudent['ParentalPhoneNumber']));
                        }
                    }

                }
            }

        }
    }

}


sort($dataResult);
sort($dataPhoneNumber);
$tableResult = "";
for($x = 0;$x < count($dataResult);$x+=1){

    $numberStudent = $dataResult[$x][0];
    $nameStudent = $dataResult[$x][1];
    $branchStudent = $dataResult[$x][2];
    $numberCheckCheck = $dataResult[$x][3];
    $numberOnTimeResult = $dataResult[$x][4];
    $numberLateResult = $dataResult[$x][5];
    $numberAbsentResult = $dataResult[$x][6];
    $ScoreRoomResult = $dataResult[$x][7];
    $ScoreDeductedResult = $dataResult[$x][8];
    $ScoreExtraResult = $dataResult[$x][9];


    $numberCheckCheckOther = $dataResult[$x][10];
    $numberOnTimeResultOther = $dataResult[$x][11];
    $numberLateResultOther = $dataResult[$x][12];
    $numberAbsentResultOther = $dataResult[$x][13];

    $numberPhoneResult = $dataPhoneNumber[$x][1];

    $RiskLevel = $numberAbsentResult+$numberAbsentResultOther+(0.5*$numberLateResult)+(0.5*$numberLateResultOther);


    if($RiskLevel < $_SESSION["LevelOrange"]){
        $tableResult  = $tableResult."<tr style=background-color:white;>";
    }else if ($RiskLevel >= $_SESSION["LevelOrange"] && $RiskLevel < $_SESSION["LevelRed"]){
        $tableResult  = $tableResult."<tr style=background-color:orange;>";
    }else{
        $tableResult  = $tableResult."<tr style=background-color:red;>";
    }

    if($RiskLevel >= $_SESSION["LevelRed"]){
        $tableResult  = $tableResult."<td style=color:white;><b>$numberStudent</b></td>";  
        $tableResult  = $tableResult."<td style=color:white;><b>$nameStudent</b></td>"; 
        $tableResult  = $tableResult."<td style=color:white;><b>$numberCheckCheck</b></td>"; 
        $tableResult  = $tableResult."<td style=color:white;><b>$numberOnTimeResult</b></td>"; 
        $tableResult  = $tableResult."<td style=color:white;><b>$numberLateResult</b></td>";  
        $tableResult  = $tableResult."<td style=color:white;><b>$numberAbsentResult</b></td>"; 
    }else{
        $tableResult  = $tableResult."<td ><b>$numberStudent</b></td>";  
        $tableResult  = $tableResult."<td ><b>$nameStudent</b></td>"; 
        $tableResult  = $tableResult."<td ><b>$numberCheckCheck</b></td>"; 
        $tableResult  = $tableResult."<td ><b>$numberOnTimeResult</b></td>"; 
        $tableResult  = $tableResult."<td ><b>$numberLateResult</b></td>";  
        $tableResult  = $tableResult."<td ><b>$numberAbsentResult</b></td>"; 
    }

    if($_SESSION["TypeResult"] == "All"){
        if($RiskLevel >= $_SESSION["LevelRed"]){
            $tableResult  = $tableResult."<td style=color:white;><b>$numberCheckCheckOther</b></td>"; 
            $tableResult  = $tableResult."<td style=color:white;><b>$numberOnTimeResultOther</b></td>";
            $tableResult  = $tableResult."<td style=color:white;><b>$numberLateResultOther</b></td>";
            $tableResult  = $tableResult."<td style=color:white;><b>$numberAbsentResultOther</b></td>"; 
            //$tableResult  = $tableResult."<td style=color:white;><b>$numberPhoneResult</b></td>";
        }else{
            $tableResult  = $tableResult."<td><b>$numberCheckCheckOther</b></td>"; 
            $tableResult  = $tableResult."<td><b>$numberOnTimeResultOther</b></td>";
            $tableResult  = $tableResult."<td><b>$numberLateResultOther</b></td>";
            $tableResult  = $tableResult."<td><b>$numberAbsentResultOther</b></td>";
            //$tableResult  = $tableResult."<td><b>$numberPhoneResult</b></td>"; 
        }
    }else{
        if($RiskLevel >= 3){
            //$tableResult  = $tableResult."<td style=color:white;><b>$numberPhoneResult</b></td>";
        }else{
            //$tableResult  = $tableResult."<td><b>$numberPhoneResult</b></td>";
        }
    }

    if($numberPhoneResult == Null || $numberPhoneResult == ""){
        $tableResult  = $tableResult."<td style=cursor:pointer;text-align:center; ><button name=addPhoneModal class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;เพิ่มข้อมูลเบอร์โทรศัพท์ผู้ปกครอง style=width:68px; value=$numberStudent>add_circle_outline</button></td>";
    }else{
        $tableResult  = $tableResult."<td style=cursor:pointer;text-align:center; ><button name=addPhoneModal class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;เพิ่มข้อมูลเบอร์โทรศัพท์ผู้ปกครอง style=background-color:#4CAF50;width:68px; value=$numberStudent>add_circle_outline</button></td>";
    }
    


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

.input-field-v2-6 {
  width: 68.5%;
  padding: 10px;
  outline: none;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.iconv-2-export-xlsx {
    -webkit-mask-image: url('pic/export-xlsx.png');

    width: 30px;
    height: 30px;

    background-color: currentColor;
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
                            <?php
                                echo $_SESSION["HeaderResultTableInResult"] ;
                            ?>

                            <form name="AddPhone" action="FResultCheckNameStudent.php" method="post" style="margin-bottom: 0%;">
                            <?php
                                echo $_SESSION["ResultTableInResult"] ;
                            ?>
                            </form>
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
                        <button class="small-v3" style="margin-top: 2%; margin-left: 86%;" name="exportEX" title="คลิกเพื่อเอ็กพอร์ตข้อมูลผลการเช็คชื่อออกมาเป็น Excel">
                        <svg class="iconv-2-export-xlsx" style="margin-top: 3%;"></svg>
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


<?php if($_SESSION['CheckOpenModalAddPhone'] == true){ ?>
<div id="AddPhoneNumber" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FResultCheckNameStudent.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:4%;margin-top:3%;">เบอร์โทรศัพท์ผู้ปกครอง</h2>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>Phone Number :</b></div>
        <input class="is-pulled-right input-field-v2-6" type="textRegis" name="Phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  value="<?php echo $_SESSION['ParentalPhoneNumber']; ?>" autocomplete=off>
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="addParentalPhoneNumber"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('AddPhoneNumber').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalAddPhone'] = false;
} ?>




</body>
</html>







