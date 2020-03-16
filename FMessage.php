<?php 
session_start();
include('condb.php');
        $term = $_SESSION["IDTermFirst"];


        if(isset($_POST['types'])){
            $_SESSION["TypeMessage"] = $_POST['types'];
            $_SESSION["PaginationMessage"]=1;
            Header("Location: message.php");
        }
        
        if(isset($_POST['Pagination'])){ 
            if($_POST['Pagination'] == "«"){
                $_SESSION["PaginationMessage"]-=1;
                Header("Location: message.php");
            }else if($_POST['Pagination'] == "»"){
                $_SESSION["PaginationMessage"]+=1;
                Header("Location: message.php");
            }else{
                $_SESSION["PaginationMessage"] = intval($_POST['Pagination']);
                Header("Location: message.php");
            }
        }

        if(isset($_GET['idMessage'])){

            $_SESSION["DateMessage"] = "";
            $_SESSION["NameMessage"] = "";
            $_SESSION["NameCourseMessage"] = "";
            $_SESSION["NumberStudentMessage"] = "";
            $_SESSION["NameStudentMessage"] = "";

            $_SESSION['CheckOpenModalMessageDetail'] = true;
            $IDMessage = $_GET['idMessage'];

            $queryMessage = "SELECT * FROM `inacs_message` WHERE ID='$IDMessage'";
            $MessageData = mysqli_query($con,$queryMessage);

            if(mysqli_num_rows($MessageData) == 1){
                while ($rowMessage = mysqli_fetch_assoc($MessageData)) {

                    $_SESSION["DateMessage"] = $rowMessage['Date'];
                    $_SESSION["NameMessage"] = $rowMessage['Name'];

                    $IDCourse = $rowMessage['IDCourse'];
                    $IDStudent = $rowMessage['IDStudent'];

                    $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='$IDCourse'";
                    $CourseData = mysqli_query($con,$queryCourse);

                    $queryStudent = "SELECT * FROM `inacs_student` WHERE ID='$IDStudent'";
                    $StudentData = mysqli_query($con,$queryStudent);

                    if(mysqli_num_rows($CourseData) == 1){
                        while ($rowCourse = mysqli_fetch_assoc($CourseData)) {
                            $_SESSION["NameCourseMessage"] = $rowCourse['Name'];
                        }
                    }

                    echo mysqli_num_rows($StudentData);
                    if(mysqli_num_rows($StudentData) == 1){
                        while ($rowStudent = mysqli_fetch_assoc($StudentData)) {
                            $_SESSION["NumberStudentMessage"] = $rowStudent['Number'];
                            $_SESSION["NameStudentMessage"] = $rowStudent['Name'];
                        }
                    }

                }
            }

            Header("Location: message.php");
        }


        if(isset($_POST['setStarred'])){
            
            $IDMessage = $_POST['setStarred'];

            $queryMessage = "SELECT * FROM `inacs_message` WHERE ID='$IDMessage'";
            $MessageData = mysqli_query($con,$queryMessage);

            if(mysqli_num_rows($MessageData) == 1){
                while ($rowMessage = mysqli_fetch_assoc($MessageData)) {

                    $MessageStatus = $rowMessage['Status'];
                    if($MessageStatus == "star"){
                        $Strquery = "UPDATE `inacs_message` SET Status='' 
                         WHERE ID='$IDMessage' ";
                        $StrData = mysqli_query($con,$Strquery);
                    }else{
                        $Strquery = "UPDATE `inacs_message` SET Status='star' 
                         WHERE ID='$IDMessage' ";
                        $StrData = mysqli_query($con,$Strquery);
                    }

                }
            }


            Header("Location: message.php");
        }


        if(isset($_POST['setTrash'])){
            
            $IDMessage = $_POST['setTrash'];

            $queryMessage = "SELECT * FROM `inacs_message` WHERE ID='$IDMessage'";
            $MessageData = mysqli_query($con,$queryMessage);

            if(mysqli_num_rows($MessageData) == 1){
                while ($rowMessage = mysqli_fetch_assoc($MessageData)) {

                    $MessageStatus = $rowMessage['Status'];
                    if($MessageStatus == "delete"){
                        $Strquery = "UPDATE `inacs_message` SET Status='' 
                         WHERE ID='$IDMessage' ";
                        $StrData = mysqli_query($con,$Strquery);
                    }else{
                        $Strquery = "UPDATE `inacs_message` SET Status='delete' 
                         WHERE ID='$IDMessage' ";
                        $StrData = mysqli_query($con,$Strquery);
                    }

                }
            }

            Header("Location: message.php");
        }

?>