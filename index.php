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



$queryTerm = "SELECT * FROM `inacs_term` WHERE NameTeacher='".$_SESSION['Name']."' ";
$termSelect = mysqli_query($con,$queryTerm);

$optionsTerm = "";
$dataTerm = array();

while($rowTerm = mysqli_fetch_array($termSelect)){
    array_push($dataTerm,array($rowTerm[2],$rowTerm[1],$rowTerm[0]));
}

sort($dataTerm);
$_SESSION["IDTermFirst"] = $dataTerm[count($dataTerm)-1][2];
$_SESSION["TermFirst"] = $dataTerm[count($dataTerm)-1][1]."/".$dataTerm[count($dataTerm)-1][0];


for ($x = count($dataTerm)-1; $x >= 0; $x-=1) {
    $idTerm = $dataTerm[$x][2];
    $NumTerm = $dataTerm[$x][1];
    $YearTerm = $dataTerm[$x][0];
    if($_SESSION["IDTermGraphCheck"] == $idTerm){
        $optionsTerm  = $optionsTerm."<option value=$idTerm selected>$NumTerm/$YearTerm</option>";
    }else{
        $optionsTerm  = $optionsTerm."<option value=$idTerm>$NumTerm/$YearTerm</option>";
    } 
}



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


$queryCourseAll = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirst"]."' AND NameTeacher='".$_SESSION["Name"]."' ";
$CourseAllData = mysqli_query($con,$queryCourseAll);
$tableStudentRisk = "";

$CourseAllArray = array();
$CourseAllArrayCheck = array();

if(mysqli_num_rows($CourseAllData) > 0){
    while ($rowCourse = mysqli_fetch_assoc($CourseAllData)) {
        $IDCourseRisk = $rowCourse['ID'];
        $NameCourseRisk = $rowCourse['Name'];
        $NumberCourseRisk = $rowCourse['Number'];
        $GroupCourseRisk = $rowCourse['GroupCourse'];

        $queryStudentAll = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourseRisk' ";
        $StudentAllData = mysqli_query($con,$queryStudentAll);
        if(mysqli_num_rows($StudentAllData) > 0){
            while ($rowStudent = mysqli_fetch_assoc($StudentAllData)) {
                if($rowStudent['Status'] != null){
                    $NumberStudentRisk = $rowStudent['Number'];
                    $NameStudentRisk = $rowStudent['Name'];
                    $ParentalPhoneNumberRisk = $rowStudent['ParentalPhoneNumber'];
                    $StatusStudentRisk = $rowStudent['Status'];

                    array_push($CourseAllArray,array($NumberCourseRisk,$NameCourseRisk,$GroupCourseRisk,$NumberStudentRisk,$NameStudentRisk,$ParentalPhoneNumberRisk,$StatusStudentRisk));

                    array_push($CourseAllArrayCheck,array($NumberCourseRisk,$NameCourseRisk,$GroupCourseRisk,$NumberStudentRisk,$NameStudentRisk,$ParentalPhoneNumberRisk,$StatusStudentRisk));

                    /*$tableStudentRisk  = $tableStudentRisk."<tr>";
                    $tableStudentRisk  = $tableStudentRisk."<td>$NumberCourseRisk</td>";
                    $tableStudentRisk  = $tableStudentRisk."<td>$NameCourseRisk</td>";
                    $tableStudentRisk  = $tableStudentRisk."<td>$GroupCourseRisk</td>";
                    $tableStudentRisk  = $tableStudentRisk."<td>$NumberStudentRisk</td>";
                    $tableStudentRisk  = $tableStudentRisk."<td>$NameStudentRisk</td>";
                    $tableStudentRisk  = $tableStudentRisk."<td>$ParentalPhoneNumberRisk</td>";
                    $tableStudentRisk  = $tableStudentRisk."<td>$StatusStudentRisk</td>";
                    $tableStudentRisk  = $tableStudentRisk."</tr>";*/

                }
            }
        }

    }
}

//echo count($CourseAllArray);
//$CourseAllArray = array_unique($CourseAllArray);
for($x = 0;$x < count($CourseAllArray);$x+=1){

    for($y = $x+1;$y < count($CourseAllArray);){
        if($CourseAllArray[$x][0] == $CourseAllArray[$y][0]
            && $CourseAllArray[$x][2] == $CourseAllArray[$y][2]
            && $CourseAllArray[$x][3] == $CourseAllArray[$y][3]
        ){
            array_splice($CourseAllArray, $y, 1);
        }else{
            $y+=1;
        }
    }

}

$selectStudentRisk = array();

for($x = 0;$x < count($CourseAllArray);$x+=1){

    $dataOne = $CourseAllArray[$x][0];
    $dataTwo = $CourseAllArray[$x][1];
    $dataThree = $CourseAllArray[$x][2];
    $dataFour = $CourseAllArray[$x][3];
    $dataFive = $CourseAllArray[$x][4];
    $dataSix = $CourseAllArray[$x][5];
    $dataSeven = $CourseAllArray[$x][6];

    array_push($selectStudentRisk,$dataFour);

    $tableStudentRisk  = $tableStudentRisk."<tr>";
    $tableStudentRisk  = $tableStudentRisk."<td>$dataOne</td>";
    $tableStudentRisk  = $tableStudentRisk."<td>$dataTwo</td>";
    $tableStudentRisk  = $tableStudentRisk."<td>$dataThree</td>";
    $tableStudentRisk  = $tableStudentRisk."<td>$dataFour</td>";
    $tableStudentRisk  = $tableStudentRisk."<td>$dataFive</td>";
    $tableStudentRisk  = $tableStudentRisk."<td>$dataSix</td>";
    $tableStudentRisk  = $tableStudentRisk."<td>$dataSeven</td>";
    $tableStudentRisk  = $tableStudentRisk."</tr>";
}

$_SESSION["TableStudentRisk"] = $tableStudentRisk;


$selectStudentRisk = array_unique($selectStudentRisk);
sort($selectStudentRisk);
$optionsStudentRisk = "";
for($x = 0;$x < count($selectStudentRisk);$x+=1){
    
    $NumStudentRisk = $selectStudentRisk[$x];
    if($_SESSION["NumStudentRiskCheck"] == $NumStudentRisk){
        $optionsStudentRisk  = $optionsStudentRisk."<option value=$NumStudentRisk selected>$NumStudentRisk</option>";
    }else{
        $optionsStudentRisk  = $optionsStudentRisk."<option value=$NumStudentRisk>$NumStudentRisk</option>";
    }

}

$_SESSION["SelectStudentRisk"] = $optionsStudentRisk;



$dataCourseRisk = array();
$queryTermRisk = "SELECT * FROM `inacs_term` WHERE NameTeacher='".$_SESSION['Name']."' ";
$termRiskData = mysqli_query($con,$queryTermRisk);

if(mysqli_num_rows($termRiskData) > 0){
    while ($rowTermRisk = mysqli_fetch_assoc($termRiskData)) {

        $IDTerm = $rowTermRisk['ID'];
        $queryCourseRisk = "SELECT * FROM `inacs_course` WHERE IDTerm='$IDTerm' AND NameTeacher='".$_SESSION["Name"]."' ";
        $courseRiskData = mysqli_query($con,$queryCourseRisk);
        if(mysqli_num_rows($courseRiskData) > 0){
            while ($rowCourseRisk = mysqli_fetch_assoc($courseRiskData)) {

                $IDCourse = $rowCourseRisk['ID'];
                $queryStudentRisk = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourse' AND Number='".$_SESSION["NumStudentRiskCheck"]."' ";
                $studentRiskData = mysqli_query($con,$queryStudentRisk);
                if(mysqli_num_rows($studentRiskData) == 1){
                    while ($rowStudentRisk = mysqli_fetch_assoc($studentRiskData)) {

                        array_push($dataCourseRisk,array($rowTermRisk['Year']
                        ,$rowTermRisk['Term']
                        ,$rowCourseRisk['Number']
                        ,$rowCourseRisk['Name']
                        ,$rowCourseRisk['GroupCourse']
                        ,$rowCourseRisk['Type']
                        ));

                    }
                }

            }
        }

    }

}


sort($dataCourseRisk);
$optionsCouresRisk = "";
$optionsCouresRisk  = $optionsCouresRisk."<option value=All selected>All</option>";
for($x = 0;$x < count($dataCourseRisk);$x+=1){

    $dataRisk = $dataCourseRisk[$x][1]."/".$dataCourseRisk[$x][0]." ".$dataCourseRisk[$x][2]." ".$dataCourseRisk[$x][3]." กลุ่ม ".$dataCourseRisk[$x][4]." ประเภท ".$dataCourseRisk[$x][5] ;

    $dataRiskValue = $dataCourseRisk[$x][1]."/".$dataCourseRisk[$x][0]."/".$dataCourseRisk[$x][2]."/".$dataCourseRisk[$x][4]."/".$dataCourseRisk[$x][5] ;

    if($_SESSION["DataRiskCheck"] == $dataRiskValue){
        $optionsCouresRisk  = $optionsCouresRisk."<option value=$dataRiskValue selected>$dataRisk</option>";
    }else{
        $optionsCouresRisk  = $optionsCouresRisk."<option value=$dataRiskValue>$dataRisk</option>";
    }

}

$_SESSION["SelectCourseRisk"] = $optionsCouresRisk;



//สร้างกราฟ
/*
include("lib/charts4php-free-latest/lib/inc/chartphp_dist.php");


$p = new chartphp();


$p->data = array(
    array(
    array("Jan",48.25),
    array("Feb",238.75),
    array("Mar",95.50),
    array("Apr",300.50),
    array("May",286.80),
    array("Jun",400)),
    array(
    array("Jan",300.25),
    array("Feb",225.75),
    array("Mar",44.50),
    array("Apr",259.50),
    array("May",250.80),
    array("Jun",300))
    );

$p->chart_type = "line";


$p->title = "Line Chart";
$p->xlabel = "Months";
$p->ylabel = "Sales";
$p->series_label = array("2014","2015");

$out = $p->render('c1');
*/

if($_SESSION["DataRiskCheck"] == "All"){

    $dataOnTime = array();
    $dataLateTime = array();
    $dataAbsentTime = array();

    for($x = 0;$x < count($dataCourseRisk);$x+=1){

        $termChart = $dataCourseRisk[$x][1];
        $yearChart = $dataCourseRisk[$x][0];

        $numberCourseChart = $dataCourseRisk[$x][2];
        $groupCourseChart = $dataCourseRisk[$x][4];
        $typeCourseChart = $dataCourseRisk[$x][5];

        $dataRiskChart = $dataCourseRisk[$x][1]."/".$dataCourseRisk[$x][0]." ".$dataCourseRisk[$x][2]." ".$dataCourseRisk[$x][5];
        
        //echo $termChart." ".$yearChart." ".$numberCourseChart." ".$groupCourseChart." ".$typeCourseChart." ";

        $queryTermChart = "SELECT * FROM `inacs_term` WHERE NameTeacher='".$_SESSION['Name']."' AND Term='$termChart'  AND Year='$yearChart' ";
        $termDataChart = mysqli_query($con,$queryTermChart);
        if(mysqli_num_rows($termDataChart) == 1){
            while ($rowTermChart = mysqli_fetch_assoc($termDataChart)) {
                $IDTermChart = $rowTermChart['ID'];
            }
        }

        $queryCourseChart = "SELECT * FROM `inacs_course` WHERE IDTerm='$IDTermChart' AND NameTeacher='".$_SESSION["Name"]."' AND Number='$numberCourseChart' AND GroupCourse='$groupCourseChart' AND Type='$typeCourseChart' ";
        $courseDataChart = mysqli_query($con,$queryCourseChart);
        if(mysqli_num_rows($courseDataChart) == 1){
            while ($rowCourseChart = mysqli_fetch_assoc($courseDataChart)) {
                $IDCourseChart = $rowCourseChart['ID'];
            }
        }
    
        $queryStudentChart = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourseChart' AND Number='".$_SESSION["NumStudentRiskCheck"]."' ";
        $studentDataChart = mysqli_query($con,$queryStudentChart);
        if(mysqli_num_rows($studentDataChart) == 1){
            while ($rowStudentChart = mysqli_fetch_assoc($studentDataChart)) {
                $IDStudentChart = $rowStudentChart['ID'];
            }
        }

        $queryResultChart = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudentChart' ";
        $resultDataChart = mysqli_query($con,$queryResultChart);
        if(mysqli_num_rows($resultDataChart) == 1){
            while ($rowResultChart = mysqli_fetch_assoc($resultDataChart)) {
                
                array_push($dataOnTime,array("y" => $rowResultChart['NumberOnTime'] , "label" => $dataRiskChart));

                array_push($dataLateTime,array("y" => $rowResultChart['NumberLate'] , "label" => $dataRiskChart));

                array_push($dataAbsentTime,array("y" => $rowResultChart['NumberAbsent'] , "label" => $dataRiskChart));

            }
        }

    }


}else{

    $DataArray = explode("/", $_SESSION["DataRiskCheck"]);

    $termChart = $DataArray[0];
    $yearChart = $DataArray[1];

    $numberCourseChart = $DataArray[2];
    $groupCourseChart = $DataArray[3];
    $typeCourseChart = $DataArray[4];

    $queryTermChart = "SELECT * FROM `inacs_term` WHERE NameTeacher='".$_SESSION['Name']."' AND Term='$termChart'  AND Year='$yearChart' ";
    $termDataChart = mysqli_query($con,$queryTermChart);
    if(mysqli_num_rows($termDataChart) == 1){
        while ($rowTermChart = mysqli_fetch_assoc($termDataChart)) {
            $IDTermChart = $rowTermChart['ID'];
        }
    }

    $queryCourseChart = "SELECT * FROM `inacs_course` WHERE IDTerm='$IDTermChart' AND NameTeacher='".$_SESSION["Name"]."' AND Number='$numberCourseChart' AND GroupCourse='$groupCourseChart' AND Type='$typeCourseChart' ";
    $courseDataChart = mysqli_query($con,$queryCourseChart);
    if(mysqli_num_rows($courseDataChart) == 1){
        while ($rowCourseChart = mysqli_fetch_assoc($courseDataChart)) {
            $IDCourseChart = $rowCourseChart['ID'];
        }
    }

    $queryStudentChart = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourseChart' AND Number='".$_SESSION["NumStudentRiskCheck"]."' ";
    $studentDataChart = mysqli_query($con,$queryStudentChart);
    if(mysqli_num_rows($studentDataChart) == 1){
        while ($rowStudentChart = mysqli_fetch_assoc($studentDataChart)) {
            $IDStudentChart = $rowStudentChart['ID'];
        }
    }

    $queryResultChart = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudentChart' ";
    $resultDataChart = mysqli_query($con,$queryResultChart);
    if(mysqli_num_rows($resultDataChart) == 1){
        while ($rowResultChart = mysqli_fetch_assoc($resultDataChart)) {
            $IDResultChart = $rowResultChart['ID'];
        }
    }

    $dataPoints = array();

    $queryDetailResultChart = "SELECT * FROM `inacs_detail_result` WHERE IDResult='$IDResultChart' ";
    $detailResultDataChart = mysqli_query($con,$queryDetailResultChart);
    if(mysqli_num_rows($detailResultDataChart) > 0){
        while ($rowDetailResultChart = mysqli_fetch_assoc($detailResultDataChart)) {

            $IDDetailCheck = $rowDetailResultChart['IDDetailCheck'];
            $queryDetailCheckChart = "SELECT * FROM `inacs_detail_check` WHERE ID='$IDDetailCheck' ";
            $detailCheckDataChart = mysqli_query($con,$queryDetailCheckChart);
            if(mysqli_num_rows($detailCheckDataChart) == 1){
                while ($rowDetailCheckChart = mysqli_fetch_assoc($detailCheckDataChart)) {

                    array_push($dataPoints,array("y" => $rowDetailResultChart['ScoreResult'] , "label" => $rowDetailCheckChart['NumberCheck']));

                }
            }

        }
    }

}


/*$dataPoints = array(
	array("y" => 25, "label" => "Sunday"),
	array("y" => 15, "label" => "Monday"),
	array("y" => 25, "label" => "Tuesday"),
	array("y" => 5, "label" => "Wednesday"),
	array("y" => 10, "label" => "Thursday"),
	array("y" => 0, "label" => "Friday"),
	array("y" => 20, "label" => "Saturday")
);*/

$checkCreateChart = $_SESSION["DataRiskCheck"];

?>
<?php
include('h.php');
?>
<style>



</style>

<script>

    window.onload = function() {
 
    var dataOnTime = <?php echo json_encode($dataOnTime, JSON_NUMERIC_CHECK); ?>;
    var dataLateTime = <?php echo json_encode($dataLateTime, JSON_NUMERIC_CHECK); ?>;
    var dataAbsentTime = <?php echo json_encode($dataAbsentTime, JSON_NUMERIC_CHECK); ?>;
    
    var dataPoints = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;

    if("<?php echo $checkCreateChart ?>" === "All"){

        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            title: {
               // text: "กราฟข้อมูลการเช็คชื่อของนิสิตกลุ่มเสี่ยง"
            },
            subtitles: [{
                //text: "1 เท่ากับมาทันเวลา      0.5 เท่ากับ มาสาย     0 เท่ากับ ขาดเรียน",
                //fontSize: 18
            }],
            axisX:{
                title: "รายวิชาที่เรียน"
            },
            axisY:{
                title: "จำนวนครั้ง",
                includeZero: false
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor:"pointer",
                verticalAlign: "top",
                fontSize: 22,
                fontColor: "dimGrey",
                itemclick : toggleDataSeries
            },
            data: [
                {
                    type: "line",
                    name: "มาเรียนทันเวลา",
                    yValueFormatString: "#,##0.0#",
                    showInLegend: true,
                    legendText: "{name} ",
                    dataPoints: dataOnTime
                },
                {
                    type: "line",
                    name: "มาเรียนสาย",
                    yValueFormatString: "#,##0.0#",
                    showInLegend: true,
                    legendText: "{name} ",
                    dataPoints: dataLateTime
                },
                {
                    type: "line",
                    name: "ไม่มาเรียน",
                    yValueFormatString: "#,##0.0#",
                    showInLegend: true,
                    legendText: "{name} ",
                    dataPoints: dataAbsentTime
                }
            ]
        });

    }else{
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            title: {
              //  text: "กราฟข้อมูลการเช็คชื่อของนิสิตกลุ่มเสี่ยง"
            },
            subtitles: [{
                text: "1 เท่ากับ ทันเวลา      0.5 เท่ากับ มาสาย     0 เท่ากับ ขาดเรียน",
                fontSize: 18
            }],
            axisX:{
                title: "ครั้งที่เช็คชื่อนิสิต"
            },
            axisY:{
                title: "สถานะการเข้าห้อง",
                includeZero: false
            },
            legend: {
                cursor:"pointer",
                verticalAlign: "top",
                fontSize: 22,
                fontColor: "dimGrey",
                //itemclick : toggleDataSeries
            },
            data: [
                {
                type: "line",
                //name: "มาเรียนทันเวลา",
                yValueFormatString: "#,##0.0#",
                //showInLegend: true,
                //legendText: "{name} ",
                dataPoints: dataPoints
                }
            ]
        });
    }
    
    chart.render();

    function toggleDataSeries(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else {
            e.dataSeries.visible = true;
        }
        chart.render();
    }
}




</script>

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
                    <svg class="menu-icon-topic iconv-2-home"></svg>หน้าหลัก
                </div>
                <div class="box">
                <!--<form name="Send" action="FIndex.php" method="post" style=" margin-bottom: 0%;">
                <div class="columns">

                    <h3>Tset Send Email : </h3>

                    <button class="small-v3" name="sendMail" style="margin-left: 4%; width: 12%;"  onclick="document.Send.submit();">
                        <b  style="margin-top: 4%; margin-bottom: 4%; font-size: 32px;" >ส่งเมล</b>
                        
                    </button>
                </div>
                </form>-->
                <!--<form name="Add" action="FIndex.php" method="post" style=" margin-bottom: 0%;">
                    <div class="columns">
                    
                        <h3 style="margin-right:1%;"><b>ภาคเรียนล่าสุด :</b></h3>
                        <h3><?php //echo $_SESSION["TermFirst"];?></h3>

                        <h2 style="margin-right:2%; margin-left:2%;"><b>|</b></h2>


                        
                        <h3 style="margin-left:1%;"><b>ปีการศึกษา :</b></h3>
                        <input class="input-field-v8-2" style="width: 10%; height:30px; margin-top:1%; margin-left:1%;" type="textRegis" name="Year" value="" title="ใส่ปีการศึกษาเป็น พ.ศ." autocomplete=off>

                        <h3 style="margin-left:2%; margin-right:1%;"><b>เทอม :</b></h3>
                        <input class="input-field-v8-2" style="width: 10%; height:30px; margin-top:1%;" type="textRegis" name="Term" value="" title="ใส่เทอมเป็น 1 หรือ 2 หรือ 3 (3 เป็น Summer)" autocomplete=off>

                        <button class="small-v3" name="addTerm" style="margin-left: 4%; width: 16%; height: 40px;" title="คลิกเพื่อเพิ่มเทอม" onclick="document.Add.submit();">
                        <b style="padding-top: 10%; padding-bottom: 10%; font-size: 18px;" >เพิ่มปีการศึกษา</b>
                        
                        </button>
                        

                    </div>
                </form>-->

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
                    <div class="column is-3">
                        <h3>นิสิตกลุ่มเสี่ยง</h3>
                    </div>
                </div>

                <div class="columns">
                <table id="table-no-click">
                    <tr>
                        <th>รหัสวิชา</th>
                        <th>ชื่อวิชา</th>
                        <th>กลุ่มเรียน</th>
                        <th>รหัสนิสิต</th>
                        <th>ชื่อนิสิต</th>
                        <th>เบอร์โทรศัพท์ผู้ปกครอง</th>
                        <th>สถานะ</th>
                    </tr>
                    <?php
                        echo $_SESSION["TableStudentRisk"] ;
                    ?>
                  
                </table>
                </div>

                <div class="columns">
                    <div class="column is-8">
                        <h3>กราฟข้อมูลการเช็คชื่อ</h3>
                        <div class="set-flex">
                            <h4 style="margin-top: 1.6%;">รหัสนิสิต :&nbsp</h4>
                            <div class="select-margin-v1 select-input" style="width:12%;">
                            <form name="changeStudent" action="FIndex.php" method="post" style="margin-bottom: 0%;">
                                    <select name="Students" onchange="document.changeStudent.submit();" style="width:100%; height: auto; padding: 5px 2px; " title="คลิกเพื่อเลือกรหัสนิสิต">
                                        <?php echo $_SESSION["SelectStudentRisk"]; ?> 
                                    </select>
                            </form>
                            </div>
                            <h4 style="margin-top: 1.6%; margin-left: 3%;">รายวิชา :&nbsp</h4>
                            <div class="select-margin-v1 select-input" style="width:54%;">
                            <form name="changeCourse" action="FIndex.php" method="post" style="margin-bottom: 0%;">
                                    <select name="Courses" onchange="document.changeCourse.submit();" style="width:100%; height: auto; padding: 5px 2px; " title="คลิกเพื่อเลือกรายวิชา">
                                        <?php echo $_SESSION["SelectCourseRisk"]; ?> 
                                    </select>
                            </form>
                            </div>
                            
                        </div>

                        <div class="set-flex">
                            <div class="div-graph">
                                <!--<br><br><br><br><br><br>-->
                                <?php //echo $out; ?>
                                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                            </div>

                            <!--<div class="magin-clicle">
                                <span class="dot dot-color-1"></span><b>&nbsp&nbspมาเรียนทันเวลา</b><br>
                                <span class="dot dot-color-2"></span><b>&nbsp&nbspมาเรียนสาย</b><br>
                                <span class="dot dot-color-3"></span><span ><b>&nbsp&nbspขาดเรียน</b></span>
                            </div>-->
                        </div>
                        
                    </div>
                    <!--
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
                -->

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







