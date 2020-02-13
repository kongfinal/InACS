<?php 
session_start();
include('condb.php');
        $term = $_SESSION["IDTermFirst"];



        if( isset($_GET['idCourse']) ){
            $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='".$_GET['idCourse']."' ";
            $CourseData = mysqli_query($con,$queryCourse);

            //echo $queryCourse;

            $_SESSION["IDCourseInCheckStudent"] = array();
            if(mysqli_num_rows($CourseData) == 1){
                while ($row = mysqli_fetch_assoc($CourseData)) {

                    array_push($_SESSION["IDCourseInCheckStudent"],$_GET['idCourse']);

                    $_SESSION["NumCourseInCheckStudent"] = $row['Number'];
                    $_SESSION["NameCourseInCheckStudent"] = $row['Name'];
                    $_SESSION["GroupCourseInCheckStudent"] = $row['GroupCourse'];
                    $_SESSION["TypeCourseInCheckStudent"] = $row['Type'];
                    $_SESSION["TimeLateCourseInCheckStudent"] = $row['TimeLate'];
                }
            }

            $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][0]."' ";
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

                $queryCheck = "UPDATE `inacs_check` SET LastStartCheckTime='".$_SESSION["TimeInCheckStudent"]."' WHERE IDCourse='".$_SESSION["IDCourseInCheckStudent"][0]."' ";
                $CheckData = mysqli_query($con,$queryCheck);
            }else{
                $_SESSION["TimeInCheckStudent"] = $_SESSION["LastStartCheckTimeInCheckStudent"];
            }

            //$_SESSION["DataCheckNameStudent"] = array();

            Header("Location: name-check-student.php");
        }










?>
        