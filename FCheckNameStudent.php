<?php require($_SERVER['DOCUMENT_ROOT']."/BUU checking system/lib/phpmailer/PHPMailerAutoload.php");?>
<?php 
session_start();
include('condb.php');
        $term = $_SESSION["IDTerm"];

        if(isset($_POST['terms'])){
            $_SESSION["IDTermCheck"] = $_POST['terms'];
            $_SESSION["PaginationSelectCheck"] = 1;
            Header("Location: select-course-check.php");
        }


        if(isset($_POST['Pagination'])){ 
            if($_POST['Pagination'] == "«"){
                $_SESSION["PaginationSelectCheck"]-=1;
                Header("Location: select-course-check.php");
            }else if($_POST['Pagination'] == "»"){
                $_SESSION["PaginationSelectCheck"]+=1;
                Header("Location: select-course-check.php");
            }else{
                $_SESSION["PaginationSelectCheck"] = intval($_POST['Pagination']);
                Header("Location: select-course-check.php");
            }
        }

        




        

/*
        if( isset($_POST['GoToCheckName']) ){
            if(!empty($_POST['CheckBoxCourseID'])){

                $dataCourseCheckID = $_POST['CheckBoxCourseID'];
                $dataNumberCourseCheck = array();
                $dataGroupCourseCheck = array();
                $dataTypeCourseCheck = array();
                $dataNumberCheck = array();
                $_SESSION["IDCourseInCheckStudent"] = array();
                $_SESSION["TimeLateCourseInCheckStudent"] = 0;
                $_SESSION["GroupCourseInCheckStudent"] = "";


                for($x = 0;$x < count($dataCourseCheckID);$x+=1){ 
                    $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='$dataCourseCheckID[$x]' ";
                    $CourseData = mysqli_query($con,$queryCourse); 

                    if(mysqli_num_rows($CourseData) == 1){
                        while ($row = mysqli_fetch_assoc($CourseData)) {
                            array_push($dataNumberCourseCheck,$row['Number']);
                            array_push($dataGroupCourseCheck,$row['GroupCourse']);
                            array_push($dataTypeCourseCheck,$row['Type']);
                        }
                    }

                    $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='$dataCourseCheckID[$x]' ";
                    $CheckData = mysqli_query($con,$queryCheck);
        
                    if(mysqli_num_rows($CheckData) == 1){
                        while ($row = mysqli_fetch_assoc($CheckData)) {
                            array_push($dataNumberCheck,$row['NumberCheck']);
                        }
                    }
                }


                $numberCourseBol = false;
                $numberCheckBol = false;
                $numberTypeBol = false;
                $numberGroupBol = false;

                for($x = 0;$x < count($dataCourseCheckID);$x+=1){ 

                }

                if(count(array_unique($dataNumberCourseCheck)) > 1 ){
                    $numberCourseBol = true;
                }

                if(count(array_unique($dataNumberCheck)) > 1){
                    $numberCheckBol = true;
                }

                if(count(array_unique($dataTypeCourseCheck)) > 1){
                    $numberTypeBol = true;
                }

                if(count(array_unique($dataGroupCourseCheck)) == 1 && count($dataGroupCourseCheck) > 1){
                    $numberGroupBol = true;
                }


                if($numberCourseBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตชื่อวิชาไม่ตรงกัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else if($numberCheckBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตที่เลือกมีจำนวนครั้งที่เช็คไม่เท่ากัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else if($numberTypeBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตที่เลือกมีประเภทต่างกัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else if($numberGroupBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตที่เลือกมีกลุ่มเหมือนกัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else{
                    for($x = 0;$x < count($dataCourseCheckID);$x+=1){ 

                        $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='$dataCourseCheckID[$x]' ";
                        $CourseData = mysqli_query($con,$queryCourse);  
                        
                        if(mysqli_num_rows($CourseData) == 1){
                            while ($row = mysqli_fetch_assoc($CourseData)) {
    
                                array_push($_SESSION["IDCourseInCheckStudent"],$dataCourseCheckID[$x]);
    
                                $_SESSION["NumCourseInCheckStudent"] = $row['Number'];
                                $_SESSION["NameCourseInCheckStudent"] = $row['Name'];
    
    
                                if($x < count($dataCourseCheckID)-1){
                                    $_SESSION["GroupCourseInCheckStudent"] = $_SESSION["GroupCourseInCheckStudent"].$row['GroupCourse'];
                                    $_SESSION["GroupCourseInCheckStudent"] = $_SESSION["GroupCourseInCheckStudent"]."+";
                                }else{
                                    $_SESSION["GroupCourseInCheckStudent"] = $_SESSION["GroupCourseInCheckStudent"].$row['GroupCourse'];
                                }
    
                                $_SESSION["TypeCourseInCheckStudent"] = $row['Type'];
    
                                if($_SESSION["TimeLateCourseInCheckStudent"] < $row['TimeLate']){
                                    $_SESSION["TimeLateCourseInCheckStudent"] = $row['TimeLate'];
                                }
                                
                            }
                        }
    
                        $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                        $CheckData = mysqli_query($con,$queryCheck);
            
                        if(mysqli_num_rows($CheckData) == 1){
                            while ($row = mysqli_fetch_assoc($CheckData)) {
                                $_SESSION["NumberCheckCourseInCheckStudent"] = $row['NumberCheck']+1;
                            }
                        }
            
    
                    }

                    $LateTime = $_SESSION["TimeLateCourseInCheckStudent"];
                    $_SESSION["TimeInCheckStudent"] = (new DateTime())->modify("+{$LateTime} minutes")->format("H:i:s");
        
                    $_SESSION["DataCheckNameStudent"] = array();

    
                    Header("Location: name-check-student.php");
                }


            }else{
                echo "<script>";
                    echo "alert(\" โปรดเลือกรายวิชาที่จะเช็คชื่อนิสิต\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }
        }*/



        if( isset($_POST['GoToCheckName']) ){
            if(!empty($_POST['CheckBoxCourseID'])){

                $dataCourseCheckID = $_POST['CheckBoxCourseID'];
                $dataNumberCourseCheck = array();
                $dataGroupCourseCheck = array();
                $dataTypeCourseCheck = array();
                $dataNumberCheck = array();
                $_SESSION["IDCourseInCheckStudent"] = array();
                $_SESSION["TimeLateCourseInCheckStudent"] = 0;
                $_SESSION["GroupCourseInCheckStudent"] = "";


                for($x = 0;$x < count($dataCourseCheckID);$x+=1){ 
                    $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='$dataCourseCheckID[$x]' ";
                    $CourseData = mysqli_query($con,$queryCourse); 

                    if(mysqli_num_rows($CourseData) == 1){
                        while ($row = mysqli_fetch_assoc($CourseData)) {
                            array_push($dataNumberCourseCheck,$row['Number']);
                            array_push($dataGroupCourseCheck,$row['GroupCourse']);
                            array_push($dataTypeCourseCheck,$row['Type']);
                        }
                    }

                    $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='$dataCourseCheckID[$x]' ";
                    $CheckData = mysqli_query($con,$queryCheck);
        
                    if(mysqli_num_rows($CheckData) == 1){
                        while ($row = mysqli_fetch_assoc($CheckData)) {
                            array_push($dataNumberCheck,$row['NumberCheck']);
                        }
                    }
                }


                $numberCourseBol = false;
                $numberCheckBol = false;
                $numberTypeBol = false;
                $numberGroupBol = false;

                for($x = 0;$x < count($dataCourseCheckID);$x+=1){ 

                }

                if(count(array_unique($dataNumberCourseCheck)) > 1 ){
                    $numberCourseBol = true;
                }

                if(count(array_unique($dataNumberCheck)) > 1){
                    $numberCheckBol = true;
                }

                if(count(array_unique($dataTypeCourseCheck)) > 1){
                    $numberTypeBol = true;
                }

                if(count(array_unique($dataGroupCourseCheck)) == 1 && count($dataGroupCourseCheck) > 1){
                    $numberGroupBol = true;
                }


                if($numberCourseBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตชื่อวิชาไม่ตรงกัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else if($numberCheckBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตที่เลือกมีจำนวนครั้งที่เช็คไม่เท่ากัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else if($numberTypeBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตที่เลือกมีประเภทต่างกัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else if($numberGroupBol){

                    echo "<script>";
                    echo "alert(\" รายวิชาที่จะเช็คชื่อนิสิตที่เลือกมีกลุ่มเหมือนกัน\");";
                    echo "window.history.back()";
                    echo "</script>";

                }else{
                    for($x = 0;$x < count($dataCourseCheckID);$x+=1){ 

                        $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='$dataCourseCheckID[$x]' ";
                        $CourseData = mysqli_query($con,$queryCourse);  
                        
                        if(mysqli_num_rows($CourseData) == 1){
                            while ($row = mysqli_fetch_assoc($CourseData)) {
    
                                array_push($_SESSION["IDCourseInCheckStudent"],$dataCourseCheckID[$x]);
    
                                $_SESSION["NumCourseInCheckStudent"] = $row['Number'];
                                $_SESSION["NameCourseInCheckStudent"] = $row['Name'];
    
    
                                if($x < count($dataCourseCheckID)-1){
                                    $_SESSION["GroupCourseInCheckStudent"] = $_SESSION["GroupCourseInCheckStudent"].$row['GroupCourse'];
                                    $_SESSION["GroupCourseInCheckStudent"] = $_SESSION["GroupCourseInCheckStudent"]."+";
                                }else{
                                    $_SESSION["GroupCourseInCheckStudent"] = $_SESSION["GroupCourseInCheckStudent"].$row['GroupCourse'];
                                }
    
                                $_SESSION["TypeCourseInCheckStudent"] = $row['Type'];
    
                                if($_SESSION["TimeLateCourseInCheckStudent"] < $row['TimeLate']){
                                    $_SESSION["TimeLateCourseInCheckStudent"] = $row['TimeLate'];
                                }
                                
                            }
                        }
    
                        $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                        $CheckData = mysqli_query($con,$queryCheck);
            
                        if(mysqli_num_rows($CheckData) == 1){
                            while ($row = mysqli_fetch_assoc($CheckData)) {
                                $_SESSION["IDCheckCourseInCheckStudent"] = $row['ID'];
                                $_SESSION["NumberCheckCourseInCheckStudent"] = $row['NumberCheck'];
                                $_SESSION["LastStartCheckTimeInCheckStudent"] = $row['LastStartCheckTime'];
                            }
                        }
            
    
                        if($_SESSION["LastStartCheckTimeInCheckStudent"] == ""){
                        
                            $LateTime = $_SESSION["TimeLateCourseInCheckStudent"];
                            $_SESSION["TimeInCheckStudent"] = (new DateTime())->modify("+{$LateTime} minutes")->format("H:i:s");
    
                            $queryCheck = "UPDATE `inacs_check` SET LastStartCheckTime='".$_SESSION["TimeInCheckStudent"]."' WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                            $CheckData = mysqli_query($con,$queryCheck);


                            //insert inacs_detail_check
                            $queryDetailCheck = "SELECT * FROM `inacs_detail_check` WHERE IDCheck='".$_SESSION["IDCheckCourseInCheckStudent"]."' AND NumberCheck='".$_SESSION["NumberCheckCourseInCheckStudent"]."'  ";
                            $detailCheckData = mysqli_query($con,$queryDetailCheck);
                            if(mysqli_num_rows($detailCheckData) == 0){

                                $starttime=strtotime($_SESSION["TimeInCheckStudent"]);
                                $endtime=strtotime("-".$LateTime." Minutes", $starttime);
                                $timeCreate = date("H:i:s", $endtime);

                                $dateCreate = date("j F Y");

                                $strSQL = "INSERT INTO inacs_detail_check ";
                                $strSQL .="(ID,IDCheck,NumberCheck,DateCheck,TimeCheck) ";
                                $strSQL .="VALUES ";
                                $strSQL .="(NULL,'".$_SESSION["IDCheckCourseInCheckStudent"]."','".$_SESSION["NumberCheckCourseInCheckStudent"]."','$dateCreate','$timeCreate') ";                 
                                $objQuery = mysqli_query($con,$strSQL);
                                
                            }

                        }else{
                            $_SESSION["TimeInCheckStudent"] = $_SESSION["LastStartCheckTimeInCheckStudent"];
                        }


                    }
        

                    //$_SESSION["DataCheckNameStudent"] = array();

    
                    Header("Location: name-check-student.php");
                }


            }else{
                echo "<script>";
                    echo "alert(\" โปรดเลือกรายวิชาที่จะเช็คชื่อนิสิต\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }
        }











        if(isset($_POST['CheckName'])){
            if(empty($_POST['CheckName'])){

                $_SESSION["NumberCheckStudent"] = "";
                $_SESSION["NameCheckStudent"] = "";
                $_SESSION["TimeCheckStudent"] = ""; 
                $_SESSION["StatusCheckStudent"] = "";
                $_SESSION["NumberAbsentCheckStudent"] = "";
                $_SESSION["NumberOnTimeCheckStudent"] = "";
                $_SESSION["NumberLateStudent"] = "";
                $_SESSION["ScoreDeductedCheckStudent"] = "";
                $_SESSION["IDCheckStudent"] = "";
                $_SESSION["IDResult"] = "";

                $_SESSION["NumberAbsentCheckStudentAll"] = "";
                $_SESSION["NumberLateStudentAll"] = "";
                $_SESSION["ScoreDeductedCheckStudentAll"] = "";

                echo "<script>";
                    echo "alert(\" โปรดใส่รหัสนิสิต หรือ แสกนบัตรนิสิต\");"; 
                    echo "window.history.back()";
                echo "</script>";
                
            }else{

                $NumberStudent = $_POST['CheckName'];
                if(strlen($NumberStudent) == 8){
                    $_SESSION["NumberCheckStudent"] = $NumberStudent;
                }else{
                    $_SESSION["NumberCheckStudent"] = substr($NumberStudent,5,-1);
                }

                for($x = 0;$x < count($_SESSION["IDCourseInCheckStudent"]);$x+=1){

                    $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION['IDCourseInCheckStudent'][$x]."' AND Number='".$_SESSION['NumberCheckStudent']."' ";
                    $StudentData = mysqli_query($con,$queryStudent);


                    $_SESSION["NumberAbsentCheckStudentAll"] = 0;
                    $_SESSION["NumberLateStudentAll"] = 0;
                    $_SESSION["ScoreDeductedCheckStudentAll"] = 0;

                    // startDataLec+Lab
                    
                    $queryCourseAgain = "SELECT * FROM `inacs_course` WHERE ID='".$_SESSION['IDCourseInCheckStudent'][$x]."'  ";
                    $CourseAgainData = mysqli_query($con,$queryCourseAgain);

                    $nameTeacherCourseOther = "";
                    $termCourseOther = "";
                    $numberCourseOther = "";
                    $groupCourseOther = "";

                    while ($row = mysqli_fetch_assoc($CourseAgainData)) {
                        $nameTeacherCourseOther = $row['NameTeacher'];
                        $termCourseOther = $row['IDTerm'];
                        $numberCourseOther = $row['Number'];
                        $groupCourseOther = $row['GroupCourse'];
                    }

                    $queryCourseOther = "SELECT * FROM `inacs_course` WHERE NameTeacher='$nameTeacherCourseOther'
                    AND IDTerm='$termCourseOther' AND Number='$numberCourseOther' AND GroupCourse='$groupCourseOther'
                      ";
                    $CourseOtherData = mysqli_query($con,$queryCourseOther);


                    $IDCourseOther = "";
                    if(mysqli_num_rows($CourseOtherData) == 2){
                        while ($row = mysqli_fetch_assoc($CourseOtherData)) {
                            if($_SESSION['IDCourseInCheckStudent'][$x] != $row['ID']){
                                $IDCourseOther = $row['ID'];
                            }
                        }
    
                        /*$queryCheckOther = "SELECT * FROM `inacs_check` WHERE IDCourse='$IDCourseOther'  ";
                        $CheckOtherData = mysqli_query($con,$queryCheckOther);
                        $NumberCheckOther = "";
                        while ($row = mysqli_fetch_assoc($CheckOtherData)) {
                            $NumberCheckOther = $row['NumberCheck'];
                        }*/

                        $dataStudentinCourseOther = array();
                        $queryStudentinCourseOther = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourseOther'  AND 	Number='".$_SESSION["NumberCheckStudent"]."'";
                        $StudentinCourseOtherData = mysqli_query($con,$queryStudentinCourseOther);
                        if(mysqli_num_rows($StudentinCourseOtherData) == 1){
                            while ($rowStudentOther = mysqli_fetch_assoc($StudentinCourseOtherData)) {
                                
                                $IDStudentOther = $rowStudentOther['ID'];
                                $queryResultOther = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudentOther' ";
                                $ResultOtherData = mysqli_query($con,$queryResultOther);

                                if(mysqli_num_rows($ResultOtherData) == 1){
                                    while ($rowResultOther = mysqli_fetch_assoc($ResultOtherData)) {

                                        $_SESSION["NumberAbsentCheckStudentAll"] = $rowResultOther['NumberAbsent'];

                                        $_SESSION["NumberLateStudentAll"] = $rowResultOther['NumberLate'];
                    
                                        $_SESSION["ScoreDeductedCheckStudentAll"] = $rowResultOther['ScoreDeducted'];

                                    }
                                }

                            }
                        }


                    }
                    //


                    

                    if(mysqli_num_rows($StudentData) == 1){

                        $_SESSION["CheckStudentRepeat"] = false;
                        
                        while ($row = mysqli_fetch_assoc($StudentData)) {
                            $IDStudent = $row['ID'];
                            $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudent' ";
                            $ResultData = mysqli_query($con,$queryResult);

                            if(mysqli_num_rows($ResultData) == 1){
                                while ($rowResult = mysqli_fetch_assoc($ResultData)) {
                                    if($_SESSION["NumberCheckCourseInCheckStudent"] == ($rowResult['NumberOnTime']+$rowResult['NumberLate']+$rowResult['NumberAbsent'])){
                                        $_SESSION["CheckStudentRepeat"] = true;
        
                                        $_SESSION["NameCheckStudent"] = $row['Name'];
                                        $_SESSION["TimeCheckStudent"] = $rowResult['LastCheckTime'];


                                        $queryCheckGetTime = "SELECT * FROM `inacs_check` WHERE IDCourse='".$_SESSION['IDCourseInCheckStudent'][$x]."'  ";
                                        $CheckTimeData = mysqli_query($con,$queryCheckGetTime);
                                        while($rowCheckTime = mysqli_fetch_assoc($CheckTimeData)){
                                            $_SESSION["TimeInCheckStudent"] = $rowCheckTime['LastStartCheckTime'];
                                        }
                                        

                                        $compareTime = array();
                                        array_push($compareTime,$_SESSION["TimeCheckStudent"]);
                                        array_push($compareTime,$_SESSION["TimeInCheckStudent"]);
                                        sort($compareTime);
                    
                                        if($compareTime[0] == $_SESSION["TimeCheckStudent"]){
                                            $_SESSION["StatusCheckStudent"] = "ทันเวลา";
                                        }else{
                                            $_SESSION["StatusCheckStudent"] = "มาสาย";
                                        }


                                        $_SESSION["NumberAbsentCheckStudentAll"] += $rowResult['NumberAbsent'];
                                        $_SESSION["NumberLateStudentAll"] += $rowResult['NumberLate'];
                                        $_SESSION["ScoreDeductedCheckStudentAll"] += $rowResult['ScoreDeducted'];
            
                                        $_SESSION["ScoreExtraCheckStudent"] = $rowResult['ScoreExtra'];
                                        $_SESSION["NumberOnTimeCheckStudent"] = $rowResult['NumberOnTime'];
            
                                        $_SESSION["IDCheckStudent"] = $rowResult['IDStudent'];
                                        $_SESSION["IDResult"] = $rowResult['ID'];
                                        break;
                                    }
                                }
                            }

                            
                        }

    
                        if(! $_SESSION["CheckStudentRepeat"]){
                            
                            $StudentData = mysqli_query($con,$queryStudent);
                            while ($row = mysqli_fetch_assoc($StudentData)) {        
                                $_SESSION["IDCheckStudent"] = $row['ID'];
                                $_SESSION["NameCheckStudent"] = $row['Name'];
                                $_SESSION["TimeCheckStudent"] =date("H:i:s"); 
                            }

                            
        
                            $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='".$_SESSION['IDCheckStudent']."' ";
                            $ResultData = mysqli_query($con,$queryResult);
        
                            if(mysqli_num_rows($ResultData) == 1){
                                while ($rowResult = mysqli_fetch_assoc($ResultData)) {
                                    $_SESSION["IDResult"] = $rowResult['ID'];

                                    $_SESSION["NumberAbsentCheckStudentAll"] += $rowResult['NumberAbsent'];
                                    $_SESSION["NumberLateStudentAll"] += $rowResult['NumberLate'];
                                    $_SESSION["ScoreDeductedCheckStudentAll"] += $rowResult['ScoreDeducted'];

                                    $_SESSION["ScoreExtraCheckStudent"] = $rowResult['ScoreExtra'];

                                    $_SESSION["NumberOnTimeCheckStudent"] = $rowResult['NumberOnTime'];
                                    $_SESSION["NumberLateStudent"] = $rowResult['NumberLate'];
                                }
                            }

                            
                            $compareTime = array();
                            array_push($compareTime,$_SESSION["TimeCheckStudent"]);
                            array_push($compareTime,$_SESSION["TimeInCheckStudent"]);
                            sort($compareTime);
        
                            if($compareTime[0] == $_SESSION["TimeCheckStudent"]){
                                $_SESSION["StatusCheckStudent"] = "ทันเวลา";
                                $_SESSION["NumberOnTimeCheckStudent"] +=1 ;
                            }else{
                                $_SESSION["StatusCheckStudent"] = "มาสาย";
                                $_SESSION["NumberLateStudent"] += 1;
                                $_SESSION["NumberLateStudentAll"] += 1;
                            }

                            /*array_push($_SESSION["DataCheckNameStudent"],array($_SESSION["NumberCheckStudent"],$_SESSION["NameCheckStudent"],$_SESSION["TimeCheckStudent"],$_SESSION["IDCheckStudent"],$_SESSION["StatusCheckStudent"],$_SESSION["NumberAbsentCheckStudent"],$_SESSION["NumberLateStudent"],$_SESSION["ScoreDeductedCheckStudent"],$_SESSION["ScoreExtraCheckStudent"],$_SESSION["NumberOnTimeCheckStudent"],$_SESSION["IDResult"]));*/


                            // start
                            $IDResult = 
                            $NumberOnTime = $_SESSION["NumberOnTimeCheckStudent"];
                            $NumberLate = $_SESSION["NumberLateStudent"];
                            $numberCheck = $_SESSION["NumberCheckCourseInCheckStudent"];

                            $scoreRoomNew = (($NumberOnTime+($NumberLate*0.5))/$numberCheck)*100;




                            $queryResult = "UPDATE `inacs_result` SET LastCheckTime='".$_SESSION["TimeCheckStudent"]."'
                            , NumberOnTime='".$_SESSION["NumberOnTimeCheckStudent"]."'
                            , NumberLate='".$_SESSION["NumberLateStudent"]."'
                            , ScoreRoom='$scoreRoomNew'
                             WHERE IDStudent='".$_SESSION["IDCheckStudent"]."' ";
                            $ResultData = mysqli_query($con,$queryResult);



                            //insert inacs_detail_result --> NumberOnTime,NumberLate
                            $queryDetailCheck = "SELECT * FROM `inacs_detail_check` WHERE IDCheck='".$_SESSION["IDCheckCourseInCheckStudent"]."' AND NumberCheck='".$_SESSION["NumberCheckCourseInCheckStudent"]."'  ";
                            $detailCheckData = mysqli_query($con,$queryDetailCheck);
                            if(mysqli_num_rows($detailCheckData) == 1){
                                while ($rowDetailCheck = mysqli_fetch_assoc($detailCheckData)) {
                                    $IDDetailCheck = $rowDetailCheck['ID'];
                                }
                            }


                            if($_SESSION["StatusCheckStudent"] == "ทันเวลา"){
                                $ScoreResult = 1;
                            }else{
                                $ScoreResult = 0.5;
                            }


                            $queryDetailResult = "SELECT * FROM `inacs_detail_result` WHERE IDResult='".$_SESSION["IDResult"]."' AND IDDetailCheck='$IDDetailCheck'  ";
                            $detailResultData = mysqli_query($con,$queryDetailResult);
                            if(mysqli_num_rows($detailResultData) == 0){

                                $strSQL = "INSERT INTO inacs_detail_result ";
                                $strSQL .="(ID,IDResult,IDDetailCheck,ScoreResult) ";
                                $strSQL .="VALUES ";
                                $strSQL .="(NULL,'".$_SESSION["IDResult"]."','$IDDetailCheck','$ScoreResult') ";                 
                                $objQuery = mysqli_query($con,$strSQL);
                                
                            }//END
    
                        }

                        $NoHaveDataInStudent = false;
                        break;
                        
                    }else{
                        $NoHaveDataInStudent = true;
                        continue;
                    }

                }

                if($NoHaveDataInStudent){
                    $_SESSION["NumberCheckStudent"] = "";
                    $_SESSION["NameCheckStudent"] = "";
                    $_SESSION["TimeCheckStudent"] = ""; 
                    $_SESSION["StatusCheckStudent"] = "";
                    $_SESSION["NumberAbsentCheckStudent"] = "";
                    $_SESSION["NumberOnTimeCheckStudent"] = "";
                    $_SESSION["NumberLateStudent"] = "";
                    $_SESSION["ScoreDeductedCheckStudent"] = "";
                    $_SESSION["IDCheckStudent"] = "";
                    $_SESSION["IDResult"] = "";

                    $_SESSION["NumberAbsentCheckStudentAll"] = "";
                    $_SESSION["NumberLateStudentAll"] = "";
                    $_SESSION["ScoreDeductedCheckStudentAll"] = "";

                    echo "<script>";
                        echo "alert(\" รหัสนิสิตไม่ตรงกับรหัสนิสิตในรายวิชานี้\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                }else{
                    Header("Location: name-check-student.php");
                }

            }
        }





















/*

        if(isset($_POST['CheckName1'])){ 
            if(! empty($_POST['CheckName'])){

                $NumberStudent = $_POST['CheckName'];
                if(strlen($NumberStudent) == 8){
                    $_SESSION["NumberCheckStudent"] = $NumberStudent;
                }else{
                    $_SESSION["NumberCheckStudent"] = substr($NumberStudent,5,-1);
                }
                
                for($x = 0;$x < count($_SESSION["IDCourseInCheckStudent"]);$x+=1){

                    $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION['IDCourseInCheckStudent'][$x]."' AND Number='".$_SESSION['NumberCheckStudent']."' ";
                    $StudentData = mysqli_query($con,$queryStudent);


                    // startDataLec+Lab
                    $queryCourseAgain = "SELECT * FROM `inacs_course` WHERE ID='".$_SESSION['IDCourseInCheckStudent'][$x]."'  ";
                    $CourseAgainData = mysqli_query($con,$queryCourseAgain);

                    $nameTeacherCourseOther = "";
                    $termCourseOther = "";
                    $numberCourseOther = "";
                    $groupCourseOther = "";

                    while ($row = mysqli_fetch_assoc($CourseAgainData)) {
                        $nameTeacherCourseOther = $row['NameTeacher'];
                        $termCourseOther = $row['IDTerm'];
                        $numberCourseOther = $row['Number'];
                        $groupCourseOther = $row['GroupCourse'];
                    }

                    $queryCourseOther = "SELECT * FROM `inacs_course` WHERE NameTeacher='$nameTeacherCourseOther'
                    AND IDTerm='$termCourseOther' AND Number='$numberCourseOther' AND GroupCourse='$groupCourseOther'
                      ";
                    $CourseOtherData = mysqli_query($con,$queryCourseOther);


                    $IDCourseOther = "";
                    if(mysqli_num_rows($CourseOtherData) == 2){
                        while ($row = mysqli_fetch_assoc($CourseOtherData)) {
                            if($_SESSION['IDCourseInCheckStudent'][$x] != $row['ID']){
                                $IDCourseOther = $row['ID'];
                            }
                        }
    
                        $queryCheckOther = "SELECT * FROM `inacs_check` WHERE IDCourse='$IDCourseOther'  ";
                        $CheckOtherData = mysqli_query($con,$queryCheckOther);
                        $NumberCheckOther = "";
                        while ($row = mysqli_fetch_assoc($CheckOtherData)) {
                            $NumberCheckOther = $row['NumberCheck'];
                        }

                        $dataStudentinCourseOther = array();
                        $queryStudentinCourseOther = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourseOther'  ";
                        $StudentinCourseOtherData = mysqli_query($con,$queryStudentinCourseOther);
                        if(mysqli_num_rows($StudentinCourseOtherData) > 0){
                            while ($rowStudentOther = mysqli_fetch_assoc($StudentinCourseOtherData)) {
                                
                                $IDStudentOther = $rowStudentOther['ID'];
                                $queryResultOther = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudentOther' ";
                                $ResultOtherData = mysqli_query($con,$queryResultOther);

                                if(mysqli_num_rows($ResultOtherData) == 1){
                                    while ($rowResultOther = mysqli_fetch_assoc($ResultOtherData)) {

                                        $NumberAbsentOther = $NumberCheckOther-$rowResultOther['NumberOnTime']-$rowResultOther['NumberLate'];

                                        array_push($dataStudentinCourseOther,array($rowStudentOther['Number'],$NumberAbsentOther,$rowResultOther['NumberLate'],$rowResultOther['ScoreDeducted']));

                                    }
                                }

                            }
                        }


                    }
                    


                    if(mysqli_num_rows($StudentData) == 1){

                        $_SESSION["CheckStudentRepeat"] = false;

                        
    
                        for($x = 0;$x < count($_SESSION["DataCheckNameStudent"]);$x+=1){
                            if($_SESSION["NumberCheckStudent"] == $_SESSION["DataCheckNameStudent"][$x][0]){
                                $_SESSION["CheckStudentRepeat"] = true;
                                
                                $_SESSION["NameCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][1];
                                $_SESSION["TimeCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][2]; 
                                $_SESSION["StatusCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][4];
                                $_SESSION["NumberAbsentCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][5];
                                $_SESSION["NumberLateStudent"] = $_SESSION["DataCheckNameStudent"][$x][6];
                                $_SESSION["ScoreDeductedCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][7];
    
                                $_SESSION["ScoreExtraCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][8];
                                $_SESSION["NumberOnTimeCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][9];
    
                                $_SESSION["IDCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][3];
                                $_SESSION["IDResult"] = $_SESSION["DataCheckNameStudent"][$x][10];
                                break;
                            }
                        }
    
                        if(! $_SESSION["CheckStudentRepeat"]){
                            while ($row = mysqli_fetch_assoc($StudentData)) {
                                $_SESSION["IDCheckStudent"] = $row['ID'];
                                $_SESSION["NameCheckStudent"] = $row['Name'];
                                $_SESSION["TimeCheckStudent"] =date("H:i:s"); 
                            }
        
                            $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='".$_SESSION['IDCheckStudent']."' ";
                            $ResultData = mysqli_query($con,$queryResult);
        
                            if(mysqli_num_rows($ResultData) == 1){
                                while ($row = mysqli_fetch_assoc($ResultData)) {
                                    $_SESSION["IDResult"] = $row['ID'];
                                    $_SESSION["NumberAbsentCheckStudent"] = $_SESSION["NumberCheckCourseInCheckStudent"]-($row['NumberOnTime']+$row['NumberLate']+1);
                                    $_SESSION["NumberLateStudent"] = $row['NumberLate'];
                                    $_SESSION["ScoreDeductedCheckStudent"] = $row['ScoreDeducted'];
                                    $_SESSION["ScoreExtraCheckStudent"] = $row['ScoreExtra'];
                                    $_SESSION["NumberOnTimeCheckStudent"] = $row['NumberOnTime'];
                                }
                            }
    
                            $compareTime = array();
                            array_push($compareTime,$_SESSION["TimeCheckStudent"]);
                            array_push($compareTime,$_SESSION["TimeInCheckStudent"]);
                            sort($compareTime);
        
                            if($compareTime[0] == $_SESSION["TimeCheckStudent"]){
                                $_SESSION["StatusCheckStudent"] = "ทันเวลา";
                                $_SESSION["NumberOnTimeCheckStudent"] +=1 ;
                            }else{
                                $_SESSION["StatusCheckStudent"] = "มาสาย";
                                $_SESSION["NumberLateStudent"] += 1;
                            }
        
                            array_push($_SESSION["DataCheckNameStudent"],array($_SESSION["NumberCheckStudent"],$_SESSION["NameCheckStudent"],$_SESSION["TimeCheckStudent"],$_SESSION["IDCheckStudent"],$_SESSION["StatusCheckStudent"],$_SESSION["NumberAbsentCheckStudent"],$_SESSION["NumberLateStudent"],$_SESSION["ScoreDeductedCheckStudent"],$_SESSION["ScoreExtraCheckStudent"],$_SESSION["NumberOnTimeCheckStudent"],$_SESSION["IDResult"]));
    
                        }
    
                        // start +Absent,Late,ScoreDeducted
                        $CheckHaveCourseOther = false;
                        for($y = 0;$y < count($dataStudentinCourseOther);$y+=1){
                            if($_SESSION["NumberCheckStudent"] == $dataStudentinCourseOther[$y][0]){
                                $_SESSION["NumberAbsentCheckStudentAll"] = $_SESSION["NumberAbsentCheckStudent"]+$dataStudentinCourseOther[$y][1];

                                $_SESSION["NumberLateStudentAll"] = $_SESSION["NumberLateStudent"]+$dataStudentinCourseOther[$y][2];

                                $_SESSION["ScoreDeductedCheckStudentAll"] = $_SESSION["ScoreDeductedCheckStudent"]+$dataStudentinCourseOther[$y][3];

                                $CheckHaveCourseOther = true;
                            }
                        }// end +Absent,Late,ScoreDeducted


                        echo $queryStudent;
                        $NoHaveDataInStudent = false;
                        break;
                        
                    }else{
                        $NoHaveDataInStudent = true;
                        continue;
                    }

                }

                if(!$CheckHaveCourseOther){
                    $_SESSION["NumberAbsentCheckStudentAll"] = $_SESSION["NumberAbsentCheckStudent"];

                    $_SESSION["NumberLateStudentAll"] = $_SESSION["NumberLateStudent"];

                    $_SESSION["ScoreDeductedCheckStudentAll"] = $_SESSION["ScoreDeductedCheckStudent"];
                }

                if($NoHaveDataInStudent){
                    $_SESSION["NumberCheckStudent"] = "";
                    $_SESSION["NameCheckStudent"] = "";
                    $_SESSION["TimeCheckStudent"] = ""; 
                    $_SESSION["StatusCheckStudent"] = "";
                    $_SESSION["NumberAbsentCheckStudent"] = "";
                    $_SESSION["NumberOnTimeCheckStudent"] = "";
                    $_SESSION["NumberLateStudent"] = "";
                    $_SESSION["ScoreDeductedCheckStudent"] = "";
                    $_SESSION["IDCheckStudent"] = "";
                    $_SESSION["IDResult"] = "";

                    $_SESSION["NumberAbsentCheckStudentAll"] = "";
                    $_SESSION["NumberLateStudentAll"] = "";
                    $_SESSION["ScoreDeductedCheckStudentAll"] = "";

                    echo "<script>";
                        echo "alert(\" รหัสนิสิตไม่ตรงกับรหัสนิสิตในรายวิชานี้\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                }else{
                    Header("Location: name-check-student.php");
                }
                
            }else{
                $_SESSION["NumberCheckStudent"] = "";
                $_SESSION["NameCheckStudent"] = "";
                $_SESSION["TimeCheckStudent"] = ""; 
                $_SESSION["StatusCheckStudent"] = "";
                $_SESSION["NumberAbsentCheckStudent"] = "";
                $_SESSION["NumberOnTimeCheckStudent"] = "";
                $_SESSION["NumberLateStudent"] = "";
                $_SESSION["ScoreDeductedCheckStudent"] = "";
                $_SESSION["IDCheckStudent"] = "";
                $_SESSION["IDResult"] = "";

                $_SESSION["NumberAbsentCheckStudentAll"] = "";
                $_SESSION["NumberLateStudentAll"] = "";
                $_SESSION["ScoreDeductedCheckStudentAll"] = "";

                echo "<script>";
                    echo "alert(\" โปรดใส่รหัสนิสิต หรือ แสกนบัตรนิสิต\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }
        }

*/

        if(isset($_POST['scoreDeducted'])){ 
            if(empty($_POST['scoreDeducted'])){
                echo "<script>";
                    echo "alert(\" โปรดใส่คะแนนที่หัก\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var($_POST['scoreDeducted'], FILTER_VALIDATE_INT)) {
                echo "<script>";
                    echo "alert(\" โปรดใส่คะแนนที่หักเป็นจำนวนเต็ม\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else{
                for($x = 0;$x < count($_SESSION["IDCourseInCheckStudent"]);$x+=1){

                    $checkScoreDeductedBool == false;

                    $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION['IDCourseInCheckStudent'][$x]."' AND Number='".$_SESSION['NumberCheckStudent']."' ";
                    $StudentData = mysqli_query($con,$queryStudent);
    
                    if(mysqli_num_rows($StudentData) == 1){
                        while ($row = mysqli_fetch_assoc($StudentData)) {
                            $IDStudent = $row['ID'];
                            $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudent' ";
                            $ResultData = mysqli_query($con,$queryResult);
    
                            if(mysqli_num_rows($ResultData) == 1){
                                while ($rowResult = mysqli_fetch_assoc($ResultData)) {
                                    $scoreDeductedNew = $rowResult['ScoreDeducted']+$_POST['scoreDeducted'];
                                }
                                $strResult = "UPDATE `inacs_result` SET ScoreDeducted='$scoreDeductedNew' WHERE IDStudent='$IDStudent' ";
                                $StrData = mysqli_query($con,$strResult);
                                
                                $_SESSION["ScoreDeductedCheckStudentAll"] = $scoreDeductedNew;

                                $checkScoreDeductedBool == true;
                            }
                        }
                    }

                    if($checkScoreDeductedBool){
                        break;
                    }
    
                }
                Header("Location: name-check-student.php");
            }     
        }



        if(isset($_POST['scoreExtra'])){ 
            if(empty($_POST['scoreExtra'])){
                echo "<script>";
                    echo "alert(\" โปรดใส่คะแนนที่เพิ่มพิเศษ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var($_POST['scoreExtra'], FILTER_VALIDATE_INT)) {
                echo "<script>";
                    echo "alert(\" โปรดใส่คะแนนที่เพิ่มพิเศษเป็นจำนวนเต็ม\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else{
                for($x = 0;$x < count($_SESSION["IDCourseInCheckStudent"]);$x+=1){

                    $checkScoreExtraBool == false;

                    $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION['IDCourseInCheckStudent'][$x]."' AND Number='".$_SESSION['NumberCheckStudent']."' ";
                    $StudentData = mysqli_query($con,$queryStudent);
    
                    if(mysqli_num_rows($StudentData) == 1){
                        while ($row = mysqli_fetch_assoc($StudentData)) {
                            $IDStudent = $row['ID'];
                            $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudent' ";
                            $ResultData = mysqli_query($con,$queryResult);
    
                            if(mysqli_num_rows($ResultData) == 1){
                                while ($rowResult = mysqli_fetch_assoc($ResultData)) {
                                    $scoreExtraNew = $rowResult['ScoreExtra']+$_POST['scoreExtra'];
                                }
                                $strResult = "UPDATE `inacs_result` SET ScoreExtra='$scoreExtraNew' WHERE IDStudent='$IDStudent' ";
                                $StrData = mysqli_query($con,$strResult);

                                $checkScoreExtraBool == true;
                            }
                        }
                    }

                    if($checkScoreExtraBool){
                        break;
                    }
    
                }
                Header("Location: name-check-student.php");
            }   
            
        }








        if(isset($_POST['saveDataCheck'])){ 

            for($x = 0;$x < count($_SESSION["IDCourseInCheckStudent"]);$x+=1){

                $NumberCheckOld = 0;
                $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                $CheckData = mysqli_query($con,$queryCheck);
    
                if(mysqli_num_rows($CheckData) == 1){
                    while ($rowCheck = mysqli_fetch_assoc($CheckData)) {
                        $NumberCheckOld = $rowCheck['NumberCheck'];
                        $NumberCheckNew = $NumberCheckOld+1;
                    }
                    $strCheck = "UPDATE `inacs_check` SET NumberCheck='$NumberCheckNew'
                    ,LastStartCheckTime='' WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                    $StrData = mysqli_query($con,$strCheck);
                }


                $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                $StudentData = mysqli_query($con,$queryStudent);

                if(mysqli_num_rows($StudentData) > 0){
                    while ($rowStudent = mysqli_fetch_assoc($StudentData)) {
                        
                        $IDStudentData = $rowStudent['ID'];
                        $NumberStudentData = $rowStudent['Number'];
                        $NameStudentData = $rowStudent['Name'];
                        $BranchStudentData = $rowStudent['Branch'];
                        
                        $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudentData' ";
                        $ResultData = mysqli_query($con,$queryResult);
                        
                        if(mysqli_num_rows($ResultData) == 1){
                            while ($rowResult = mysqli_fetch_assoc($ResultData)) {

                                if($NumberCheckOld != $rowResult['NumberOnTime']+$rowResult['NumberLate']+$rowResult['NumberAbsent']){


                                    $dataNumberOnTime = $rowResult['NumberOnTime'];
                                    $dataNumberLate = $rowResult['NumberLate'];
                                    $dataNumberAbsentNew = $rowResult['NumberAbsent']+1;

                                    $SumNumber = $dataNumberOnTime+$dataNumberLate+$dataNumberAbsentNew;

                                    $scoreRoomNew = (($dataNumberOnTime+($dataNumberLate*0.5))/$SumNumber)*100;

                                    $StrResult = "UPDATE `inacs_result` 
                                    SET LastCheckTime='' 
                                    , NumberAbsent='$dataNumberAbsentNew'
                                    , ScoreRoom='$scoreRoomNew'
                                    WHERE IDStudent='$IDStudentData' ";
                                    $StrData = mysqli_query($con,$StrResult);


                                    //insert inacs_detail_result --> NumberAbsent
                                    $queryDetailCheck = "SELECT * FROM `inacs_detail_check` WHERE IDCheck='".$_SESSION["IDCheckCourseInCheckStudent"]."' AND NumberCheck='".$_SESSION["NumberCheckCourseInCheckStudent"]."'  ";
                                    $detailCheckData = mysqli_query($con,$queryDetailCheck);
                                    if(mysqli_num_rows($detailCheckData) == 1){
                                        while ($rowDetailCheck = mysqli_fetch_assoc($detailCheckData)) {
                                            $IDDetailCheck = $rowDetailCheck['ID'];
                                        }
                                    }
        
                                    $IDResult = $rowResult['ID'];

                                    $queryDetailResult = "SELECT * FROM `inacs_detail_result` WHERE IDResult='$IDResult' AND IDDetailCheck='$IDDetailCheck'  ";
                                    $detailResultData = mysqli_query($con,$queryDetailResult);
                                    if(mysqli_num_rows($detailResultData) == 0){
        
                                        $strSQL = "INSERT INTO inacs_detail_result ";
                                        $strSQL .="(ID,IDResult,IDDetailCheck,ScoreResult) ";
                                        $strSQL .="VALUES ";
                                        $strSQL .="(NULL,'$IDResult','$IDDetailCheck','0') ";                 
                                        $objQuery = mysqli_query($con,$strSQL);
                                        
                                    }//END




                                    //Start Email and Message

                                    $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                                    $CourseData = mysqli_query($con,$queryCourse);
                                    if(mysqli_num_rows($CourseData) == 1){
                                        while ($rowCourse = mysqli_fetch_assoc($CourseData)) {
                                            $NumberCourse = $rowCourse['Number'];
                                            $NameCourse = $rowCourse['Name'];
                                            $GroupCourse = $rowCourse['GroupCourse'];
                                        }
                                    }

                                    // หา ID Course Lec+Lab
                                    $queryCourseLec = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirstCheck"]."' AND NameTeacher='".$_SESSION["Name"]."' AND Number='$NumberCourse' AND Name='$NameCourse' AND GroupCourse='$GroupCourse' AND Type='Lecture' ";
                                    $CourseLecData = mysqli_query($con,$queryCourseLec);
                                    if(mysqli_num_rows($CourseLecData) == 1){
                                        while ($rowCourseLec = mysqli_fetch_assoc($CourseLecData)) {
                                            $IDCourseLec = $rowCourseLec['ID'];
                                        }
                                    }

                                    $queryCourseLab = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirstCheck"]."' AND NameTeacher='".$_SESSION["Name"]."' AND Number='$NumberCourse' AND Name='$NameCourse' AND GroupCourse='$GroupCourse' AND Type='Lab' ";
                                    $CourseLabData = mysqli_query($con,$queryCourseLab);
                                    if(mysqli_num_rows($CourseLabData) == 1){
                                        while ($rowCourseLab = mysqli_fetch_assoc($CourseLabData)) {
                                            $IDCourseLab = $rowCourseLab['ID'];
                                        }
                                    }


                                    // หา ID Student Lec+Lab
                                    $queryStudentLecGetID = "SELECT * FROM `inacs_student` WHERE IDCourse='".$IDCourseLec."'  AND Number='$NumberStudentData' AND Name='$NameStudentData'";
                                    $StudentLecDataGetID = mysqli_query($con,$queryStudentLecGetID);
                                    if(mysqli_num_rows($StudentLecDataGetID) == 1){
                                        while ($rowStudentLec = mysqli_fetch_assoc($StudentLecDataGetID)) {
                                            $IDStudentLec = $rowStudentLec['ID'];
                                        }
                                    }

                                    $queryStudentLabGetID = "SELECT * FROM `inacs_student` WHERE IDCourse='".$IDCourseLab."' AND Number='$NumberStudentData' AND Name='$NameStudentData'";
                                    $StudentLabDataGetID = mysqli_query($con,$queryStudentLabGetID);
                                    if(mysqli_num_rows($StudentLabDataGetID) == 1){
                                        while ($rowStudentLab = mysqli_fetch_assoc($StudentLabDataGetID)) {
                                            $IDStudentLab = $rowStudentLab['ID'];
                                        }
                                    }

                                    // หา CheckNumber Lec+Lab
                                    $NumberCheckLec = 0;
                                    $NumberCheckLab = 0;

                                    $queryCheckLecGetID = "SELECT * FROM `inacs_check` WHERE IDCourse='".$IDCourseLec."' ";
                                    $CheckLecDataGetID = mysqli_query($con,$queryCheckLecGetID);
                                    if(mysqli_num_rows($CheckLecDataGetID) == 1){
                                        while ($rowCheckLec = mysqli_fetch_assoc($CheckLecDataGetID)) {
                                            $NumberCheckLec = $rowCheckLec['NumberCheck']-1;
                                        }
                                    }

                                    $queryCheckLabGetID = "SELECT * FROM `inacs_check` WHERE IDCourse='".$IDCourseLab."' ";
                                    $CheckLabDataGetID = mysqli_query($con,$queryCheckLabGetID);
                                    if(mysqli_num_rows($CheckLabDataGetID) == 1){
                                        while ($rowCheckLab = mysqli_fetch_assoc($CheckLabDataGetID)) {
                                            $NumberCheckLab = $rowCheckLab['NumberCheck']-1;
                                        }
                                    }


                                    // หา ผลการเข้าเรียนของทั้ง Lec+Lab
                                    $NumberOnTimeLec = 0;
                                    $NumberLateLec = 0;
                                    $NumberAbsentNewLec = 0;

                                    $NumberOnTimeLab = 0;
                                    $NumberLateLab = 0;
                                    $NumberAbsentNewLab = 0;


                                    $queryResultLec = "SELECT * FROM `inacs_result` WHERE IDStudent='".$IDStudentLec."'  ";
                                    $ResultLecData = mysqli_query($con,$queryResultLec);
                                    if(mysqli_num_rows($ResultLecData) == 1){
                                        while ($rowResultLec = mysqli_fetch_assoc($ResultLecData)) {
                                            $NumberOnTimeLec = $rowResultLec['NumberOnTime'];
                                            $NumberLateLec = $rowResultLec['NumberLate'];
                                            $NumberAbsentNewLec = $rowResultLec['NumberAbsent'];
                                        }
                                    }

                                    $queryResultLab = "SELECT * FROM `inacs_result` WHERE IDStudent='".$IDStudentLab."'  ";
                                    $ResultLabData = mysqli_query($con,$queryResultLab);
                                    if(mysqli_num_rows($ResultLabData) == 1){
                                        while ($rowResultLab = mysqli_fetch_assoc($ResultLabData)) {
                                            $NumberOnTimeLab = $rowResultLab['NumberOnTime'];
                                            $NumberLateLab = $rowResultLab['NumberLate'];
                                            $NumberAbsentNewLab = $rowResultLab['NumberAbsent'];
                                        }
                                    }


                                    $levelScore = ($NumberLateLec*0.5)+($NumberLateLab*0.5)+$NumberAbsentNewLec+$NumberAbsentNewLab;

                                    //echo $levelScore."<br>";
                                     /*echo $queryCourseLec."<br>";
                                    echo mysqli_num_rows($CourseLecData)."<br>";*/

                                    if($levelScore >= $_SESSION["LevelOrange"] && $levelScore < $_SESSION["LevelRed"]){
                                        $subject = "นิสิตขาดเรียน ".$_SESSION["LevelOrange"]." ครั้งหรือมากกว่าแต่ไม่เกิน ".$_SESSION["LevelRed"]." ครั้ง";
                                        $level = "เกือบถึง";
                                    }else if($levelScore == $_SESSION["LevelRed"]){
                                        $subject = "นิสิตขาดเรียน ".$_SESSION["LevelRed"]." ครั้ง";
                                        $level = "ถึง";


                                        $StrLecData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายถึงเกณฑ์' WHERE ID='$IDStudentLec' ");

                                        $StrLabData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายถึงเกณฑ์' WHERE ID='$IDStudentLab' ");

                                    }else if($levelScore > $_SESSION["LevelRed"]){
                                        $subject = "นิสิตขาดเรียนเกิน ".$_SESSION["LevelRed"]." ครั้ง";
                                        $level = "เกิน";

                                        $StrLecData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายเกินเกณฑ์' WHERE ID='$IDStudentLec' ");

                                        $StrLabData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายเกินเกณฑ์' WHERE ID='$IDStudentLab' ");
                                    }

                                    if($levelScore >= $_SESSION["LevelOrange"]){
                                        header('Content-Type: text/html; charset=utf-8');
 
                                        //start Email Student
                                        $mail_Student = new PHPMailer;
                                        $mail_Student->CharSet = "utf-8";
                                        $mail_Student->isSMTP();
                                        $mail_Student->Host = 'smtp.gmail.com';
                                        $mail_Student->Port = 587;
                                        $mail_Student->SMTPSecure = 'tls';
                                        $mail_Student->SMTPAuth = true;
                            
                                        $gmail_username = "INACSystem@gmail.com"; // gmail ที่ใช้ส่ง
                                        $gmail_password = "ProjectJoJo"; // รหัสผ่าน gmail
                                         
                                         
                                        $sender = "INACS"; // ชื่อผู้ส่ง
                                        $email_sender = "INACS@system.com"; // เมล์ผู้ส่ง 
    
    
                                        //$email_receiver = $_SESSION['Email']; // เมล์ผู้รับ ***
                                        $email_receiver_student = $NumberStudentData."@go.buu.ac.th";
    
                                        
                                        //$subject = "นิสิตขาดเรียนเกิน 3 ครั้ง"; // หัวข้อเมล์
                            
    
                                        $mail_Student->Username = $gmail_username;
                                        $mail_Student->Password = $gmail_password;
                                        $mail_Student->setFrom($email_sender, $sender);
                                        $mail_Student->addAddress($email_receiver_student);
                                        $mail_Student->Subject = $subject;
                            
                            
                                        $year = date('Y');
                                        $email_content_Student = "
                                        <!DOCTYPE html>
                                        <html>
                                            <head>
                                                <meta charset=utf-8'/>
                                                <title>".$subject."</title>
                                            </head>
                                            <body>
                                                <div style='background: #2c56d4;padding: 10px 0 20px 10px;margin-bottom:10px;font-size:30px;color:white; display: flex;'>
                                                    <img src='https://cdn.onlinewebfonts.com/svg/img_3015.png' style='width: 80px;'>
                                                    <div style='margin-top:26px; margin-left:15px;'><b>INACS</b></div>
                                                </div>
                                                <div style='padding:20px;'>
                                                    <!--<div style='text-align:center;margin-bottom:50px;'>
                                                        <img src='http://cdn.wccftech.com/wp-content/uploads/2017/02/Apple-logo.jpg' style='width:100%' />             
                                                    </div>-->
                                                    <div>             
                                                        <h2>เรื่อง ".$subject."<strong style='color:#0000ff;'></strong></h2>
                                                        <br>
                                                        <h2>เรียน ".$NameStudentData."<strong style='color:#0000ff;'></strong></h2>
                                                        <br><br>
                                                        <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        เนื่องด้วย คุณได้ขาดเรียนและมาสายในวิชา ".$NumberCourse." ".$NameCourse." ".$level."เกณฑ์ ที่กำหนดไว้แล้ว จึงได้แจ้งให้รับทราบ<strong style='color:#0000ff;'></strong></h2>
                                                    </div>
                                                    <div style='margin-top:30px;'>
                                                        <hr>
                                                        <h2 style='text-align: right;'>ดร.พิเชษ วะยะลุน<strong style='color:#0000ff;'></strong></h2>
                                                    </div>
                                                </div>
                                                <div style='background: #2c56d4;color: white;padding:30px;'>
                                                    <div style='text-align:center'> ".$year." © Burapha University
                                                    </div>
                                                </div>
                                            </body>
                                        </html>
                                        ";

                                        //start Email Teacher
                                        $mail_Teacher = new PHPMailer;
                                        $mail_Teacher->CharSet = "utf-8";
                                        $mail_Teacher->isSMTP();
                                        $mail_Teacher->Host = 'smtp.gmail.com';
                                        $mail_Teacher->Port = 587;
                                        $mail_Teacher->SMTPSecure = 'tls';
                                        $mail_Teacher->SMTPAuth = true;

                                        $email_receiver_teacher = $_SESSION['Email'];
                            
    
                                        $mail_Teacher->Username = $gmail_username;
                                        $mail_Teacher->Password = $gmail_password;
                                        $mail_Teacher->setFrom($email_sender, $sender);
                                        $mail_Teacher->addAddress($email_receiver_teacher);
                                        $mail_Teacher->Subject = $subject;


                                        $email_content_Teacher = "
                                        <!DOCTYPE html>

                                            <html>
                                                <head>
                                                    <meta charset=utf-8'/>
                                                    <title>".$subject."</title>
                                                </head>
                                                <body>
                                                    <div style='background: #2c56d4;padding: 10px 0 20px 10px;margin-bottom:10px;font-size:30px;color:white; display: flex;'>
                                                        <img src='https://cdn.onlinewebfonts.com/svg/img_3015.png' style='width: 80px;'>
                                                        <div style='margin-top:26px; margin-left:15px;'><b>INACS</b></div>
                                                    </div>
                                                    <div style='padding:20px;'>
                                                        <div>             
                                                            <h2>เรียน ".$_SESSION['Name']."<strong style='color:#0000ff;'></strong></h2>
                                                            <br><br>
                                                            <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            เนื่องด้วย ".$NameStudentData." รหัส ".$NumberStudentData." สาขา ".$BranchStudentData." ขาดเรียนและมาสายในวิชา ".$NumberCourse." ".$NameCourse." ".$level."เกณฑ์ ที่กำหนดไว้แล้ว โดย ".$NameStudentData." มีข้อมูลการเข้าเรียนในรายวิชา ".$NameCourse." ดังนี้<strong style='color:#0000ff;'></strong></h2>
                                                            <table style='font-family:Trebuchet MS, Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>
                                                            <tr>
                                                                <th rowspan='2' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>รหัสนิสิต</th>
                                                                <th rowspan='2' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>ชื่อนิสิต</th>
                                                                <th colspan='4' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>บรรยาย</th>
                                                                <th colspan='4' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>ปฎิบัติ</th>
                                                            </tr>
                                                            <tr>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> จำนวนที่เช็ค</th>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ทันเวลา</th>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> สาย</th>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ขาด</th>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> จำนวนที่เช็ค</th>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ทันเวลา</th>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> สาย</th>
                                                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ขาด</th>
                                                            </tr>
                                                            <tr>
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberStudentData."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NameStudentData."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberCheckLec."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberOnTimeLec."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberLateLec."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberAbsentNewLec."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberCheckLab."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberOnTimeLab."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberLateLab."</td> 
                                                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberAbsentNewLab."</td> 
                                                            </tr>
                                                            
                                                            </table>
                                                        </div>
                                                        <div style='margin-top:30px;'>
                                                            <hr>
                                                            <h2 style='text-align: right;'>ดร.พิเชษ วะยะลุน<strong style='color:#0000ff;'></strong></h2>
                                                        </div>
                                                    </div>
                                                    <div style='background: #2c56d4;color: white;padding:30px;'>
                                                        <div style='text-align:center'>".$year." © Burapha University
                                                        </div>
                                                    </div>
                                                </body>
                                            </html>
                                        ";


                                        //  ถ้ามี email ผู้รับ
                                        if($email_receiver_student){
                                            $mail_Student->msgHTML($email_content_Student);
                                            $mail_Student->send();
                                        }

                                        if($email_receiver_teacher){
                                            $mail_Teacher->msgHTML($email_content_Teacher);
                                            $mail_Teacher->send();
                                        }
                                        //End Email

                                        //Start Message
                                        $DateTODay = date("d/m/Y");

                                        $strSQL = "INSERT INTO inacs_message ";
                                        $strSQL .="(ID,IDCourse,IDStudent,Date,Name,Status) ";
                                        $strSQL .="VALUES ";
                                        $strSQL .="(NULL,'".$_SESSION['IDCourseInCheckStudent'][$x]."','$IDStudentData','$DateTODay','$subject','' ) ";
                                        
                                        $objResultQuery = mysqli_query($con,$strSQL);


                                    }
                                    

                                }else{
                                    $StrResult = "UPDATE `inacs_result` 
                                    SET LastCheckTime='' 
                                    WHERE IDStudent='$IDStudentData' ";
                                    $StrData = mysqli_query($con,$StrResult);
                                }

                            }
                        }


                    }
                }

            }

            Header("Location: select-course-check.php");

        }





        /*

        if(isset($_POST['saveDataCheck'])){ 

            for($y = 0;$y < count($_SESSION["IDCourseInCheckStudent"]);$y+=1){

                $queryCheck = "UPDATE `inacs_check` SET NumberCheck='".$_SESSION["NumberCheckCourseInCheckStudent"]."' WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$y]."' ";
                $CheckData = mysqli_query($con,$queryCheck);

                $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$y]."' ";
                $StudentData = mysqli_query($con,$queryStudent);

                if(mysqli_num_rows($StudentData) > 0){
                    while ($row = mysqli_fetch_assoc($StudentData)) {
                        $CheckStudentInCheckName = true;
                        for($x = 0;$x < count($_SESSION["DataCheckNameStudent"]);$x+=1){
                            if($row['ID']==$_SESSION["DataCheckNameStudent"][$x][3]){
                                $ScoreDeducted = $_SESSION["DataCheckNameStudent"][$x][7];
                                $ScoreExtra = $_SESSION["DataCheckNameStudent"][$x][8];
                                $NumberLate = $_SESSION["DataCheckNameStudent"][$x][6];
                
                                $NumberOnTime = $_SESSION["DataCheckNameStudent"][$x][9];
                
                                $numberCheck = $_SESSION["NumberCheckCourseInCheckStudent"];
                
                                $ScoreRoom = (($NumberOnTime+($NumberLate*0.5))/$numberCheck)*100;
                
                                $idResult = $_SESSION["DataCheckNameStudent"][$x][10];
                            
                                $queryResult = "UPDATE `inacs_result` 
                                SET ScoreRoom='$ScoreRoom' 
                                , ScoreDeducted='$ScoreDeducted' 
                                , ScoreExtra='$ScoreExtra' 
                                , NumberOnTime='$NumberOnTime' 
                                , NumberLate='$NumberLate' 
                                WHERE ID='$idResult' ";
                                $ResultData = mysqli_query($con,$queryResult);

                                $CheckStudentInCheckName = false;
                                break;
                            }
                        }
                        if($CheckStudentInCheckName){

                            $rowID = $row['ID'];
                            $numberCheck = $_SESSION["NumberCheckCourseInCheckStudent"];

                            $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$rowID' ";
                            $ResultData = mysqli_query($con,$queryResult);

                            while ($rowResult = mysqli_fetch_assoc($ResultData)) { 

                                $rowResultID = $rowResult['ID'];
                                $ScoreRoom = (($rowResult['NumberOnTime']+($rowResult['NumberLate']*0.5))/$numberCheck)*100;
                                
                                $queryAddResult = "UPDATE `inacs_result` SET ScoreRoom='$ScoreRoom' WHERE ID='$rowResultID' ";

                                $ResultAddData = mysqli_query($con,$queryAddResult);
                            }
                        }
                    }
                }
            }
                if($ResultData || $ResultAddData){
                    echo "<script>";
                        echo "alert(\" Save Data Checking Student Name Complete\");"; 
                    echo "</script>";
                    
                }else{
                    echo "<script>";
                        echo "alert(\" Save Data Checking Student Name Error\");"; 
                    echo "</script>";
                }
            
            Header("Location: select-course-check.php");
        }




*/








        if( isset($_GET['idCourse']) ){
            $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='".$_GET['idCourse']."' ";
            $CourseData = mysqli_query($con,$queryCourse);

            if(mysqli_num_rows($CourseData) == 1){
                while ($row = mysqli_fetch_assoc($CourseData)) {
                    $_SESSION["IDCourseInCheckStudent"] = $_GET['idCourse'];
                    $_SESSION["NumCourseInCheckStudent"] = $row['Number'];
                    $_SESSION["NameCourseInCheckStudent"] = $row['Name'];
                    $_SESSION["GroupCourseInCheckStudent"] = $row['GroupCourse'];
                    $_SESSION["TypeCourseInCheckStudent"] = $row['Type'];
                    $_SESSION["TimeLateCourseInCheckStudent"] = $row['TimeLate'];
                }
            }

            $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"]."' ";
            $CheckData = mysqli_query($con,$queryCheck);

            if(mysqli_num_rows($CheckData) == 1){
                while ($row = mysqli_fetch_assoc($CheckData)) {
                    $_SESSION["NumberCheckCourseInCheckStudent"] = $row['NumberCheck']+1;
                }
            }

            $LateTime = $_SESSION["TimeLateCourseInCheckStudent"];
            $_SESSION["TimeInCheckStudent"] = (new DateTime())->modify("+{$LateTime} minutes")->format("H:i:s");

            $_SESSION["DataCheckNameStudent"] = array();

            Header("Location: name-check-student.php");
        }










?>
        