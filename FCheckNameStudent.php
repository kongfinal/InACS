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
                                $_SESSION["NumberCheckCourseInCheckStudent"] = $row['NumberCheck'];
                                $_SESSION["LastStartCheckTimeInCheckStudent"] = $row['LastStartCheckTime'];
                            }
                        }
            
    
                        if($_SESSION["LastStartCheckTimeInCheckStudent"] == ""){
                        
                            $LateTime = $_SESSION["TimeLateCourseInCheckStudent"];
                            $_SESSION["TimeInCheckStudent"] = (new DateTime())->modify("+{$LateTime} minutes")->format("H:i:s");
    
                            $queryCheck = "UPDATE `inacs_check` SET LastStartCheckTime='".$_SESSION["TimeInCheckStudent"]."' WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][$x]."' ";
                            $CheckData = mysqli_query($con,$queryCheck);
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
        