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

            $startTime = date("H:i:s");
            $LateTime = $_SESSION["TimeLateCourseInCheckStudent"];

            $startTime = DateTime::createFromFormat( 'g:i:s', $startTime );
            $startTime->add( new DateInterval( 'PT' . ( (integer) $LateTime ) . 'M' ) );
            $_SESSION["TimeInCheckStudent"] = $startTime->format( 'g:i:s' );

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
                            $_SESSION["NumberAbsentCheckStudent"] = $_SESSION["NumberCheckCourseInCheckStudent"]-($row['NumberOnTime']+$row['NumberLate']);
                            $_SESSION["NumberLateStudent"] = $row['NumberLate'];
                            $_SESSION["ScoreDeductedCheckStudent"] = $row['ScoreDeducted'];
                        }
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

                    $dataCheckNameStudent = array();
                    array_push($dataCheckNameStudent,array($_SESSION["NumberCheckStudent"],$_SESSION["StatusCheckStudent"],$_SESSION["IDResult"]));
                    

                    Header("Location: name-check-student.php");
                }else{
                    $_SESSION["NumberCheckStudent"] = "";
                    $_SESSION["NameCheckStudent"] = "";
                    $_SESSION["TimeCheckStudent"] = ""; 
                    $_SESSION["StatusCheckStudent"] = "";
                    $_SESSION["NumberAbsentCheckStudent"] = "";
                    $_SESSION["NumberLateStudent"] = "";
                    $_SESSION["ScoreDeductedCheckStudent"] = "";
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
                $_SESSION["NumberLateStudent"] = "";
                $_SESSION["ScoreDeductedCheckStudent"] = "";
                echo "<script>";
                    echo "alert(\" โปรดใส่รหัสนิสิต หรือ แสกนบัตรนิสิต\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }
        }



        if(isset($_POST['saveDataCheck'])){ 
            echo $_POST['scoreDeducted'];
            echo "****************";
            echo $_POST['scoreExtra'];
        }

?>
        