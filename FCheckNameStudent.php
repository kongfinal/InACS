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

                /*if(count(array_unique($dataNumberCourseCheck)) == 1 && count(array_unique($dataGroupCourseCheck)) > 1 && count(array_unique($dataTypeCourseCheck)) > 1){
                    $numberGroupTypeBol = true;
                }*/

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

                    /*if(count(array_unique($dataNumberCourseCheck)) == 1 && count(array_unique($dataGroupCourseCheck)) == 1 && count(array_unique($dataTypeCourseCheck)) > 1){
                        $_SESSION["GroupCourseInCheckStudent"] = $dataGroupCourseCheck[0];
                    }*/
    
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



        if(isset($_POST['scoreDeducted'])){ 
            for($x = 0;$x < count($_SESSION["DataCheckNameStudent"]);$x+=1){
                if($_SESSION["NumberCheckStudent"] == $_SESSION["DataCheckNameStudent"][$x][0]){

                    $_SESSION["DataCheckNameStudent"][$x][7]+=$_POST['scoreDeducted'];
                    $_SESSION["ScoreDeductedCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][7];

                    break;
                }
            }
            Header("Location: name-check-student.php");
        }

        if(isset($_POST['scoreExtra'])){ 
            for($x = 0;$x < count($_SESSION["DataCheckNameStudent"]);$x+=1){
                if($_SESSION["NumberCheckStudent"] == $_SESSION["DataCheckNameStudent"][$x][0]){

                    $_SESSION["DataCheckNameStudent"][$x][8]+=$_POST['scoreExtra'];
                    $_SESSION["ScoreExtraCheckStudent"] = $_SESSION["DataCheckNameStudent"][$x][8];

                    break;
                }
            }
            Header("Location: name-check-student.php");
        }


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
        