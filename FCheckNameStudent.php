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


        if(isset($_POST['CheckName'])){ 
            if(! empty($_POST['CheckName'])){

                $NumberStudent = $_POST['CheckName'];
                if(strlen($NumberStudent) == 8){
                    
                }else{
                    for($x = 0;$x < strlen($NumberStudent);$x+=1){

                    }     
                }
                
                $_SESSION["NumberCheckStudent"] = $NumberStudent;
                $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION['IDCourseInCheckStudent']."' AND Number='".$_SESSION['NumberCheckStudent']."' ";
                $StudentData = mysqli_query($con,$queryStudent);

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

                    Header("Location: name-check-student.php");
                    
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
                    echo "<script>";
                        echo "alert(\" รหัสนิสิตไม่ตรงกับรหัสนิสิตในรายวิชานี้\");"; 
                        echo "window.history.back()";
                    echo "</script>";
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

            $queryCheck = "UPDATE `inacs_check` SET NumberCheck='".$_SESSION["NumberCheckCourseInCheckStudent"]."' WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"]."' ";
            $CheckData = mysqli_query($con,$queryCheck);

            $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"]."' ";
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

?>
        