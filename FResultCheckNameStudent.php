<?php 
session_start();
include('condb.php');
        $term = $_SESSION["IDTerm"];

        if(isset($_POST['terms'])){
            $_SESSION["IDTermResult"] = $_POST['terms'];
            $_SESSION["PaginationSelectResult"] = 1;
            Header("Location: select-course-results.php");
        }

        if(isset($_POST['Pagination'])){ 
            if($_POST['Pagination'] == "«"){
                $_SESSION["PaginationSelectResult"]-=1;
                Header("Location: select-course-results.php");
            }else if($_POST['Pagination'] == "»"){
                $_SESSION["PaginationSelectResult"]+=1;
                Header("Location: select-course-results.php");
            }else{
                $_SESSION["PaginationSelectResult"] = intval($_POST['Pagination']);
                Header("Location: select-course-results.php");
            }
        }

        if( isset($_GET['idCourse']) ){
            Header("Location: name-check-student.php");
        }

?>
        