<?php 
session_start();
include('condb.php');
        $term = $_SESSION["IDTermFirst"];



        if(isset($_POST['addTerm']) ){
            if(empty($_POST['Year'])){
                echo "<script>";
                    echo "alert(\" โปรดใส่ปีการศึกษา\");";
                    echo "window.history.back()";
                echo "</script>";
            }else if(empty($_POST['Term'])){
                echo "<script>";
                    echo "alert(\" โปรดใส่เทอม\");";
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var($_POST['Year'], FILTER_VALIDATE_INT)) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลปีการศึกษาเป็นตัวเลขอย่างเดียว\");";
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var($_POST['Term'], FILTER_VALIDATE_INT)) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลเทอมเป็นตัวเลขอย่างเดียว\");";
                    echo "window.history.back()";
                echo "</script>";
            }else{

                $queryTerm = "SELECT * FROM `inacs_term` WHERE Term='".$_POST['Term']."' AND Year='".$_POST['Year']."'";
                $termData = mysqli_query($con,$queryTerm);
                if(mysqli_num_rows($termData) == 0){

                    $strSQL = "INSERT INTO inacs_term ";
                    $strSQL .="(ID,Term,Year) ";
                    $strSQL .="VALUES ";
                    $strSQL .="(NULL,'".$_POST['Term']."','".$_POST['Year']."') ";                 
                    $objQuery = mysqli_query($con,$strSQL);

                    if($objQuery){
                        echo "<script>";
                            echo "alert(\" Add Term Complete\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else{
                        echo "<script>";
                        echo "alert(\" Add Term Error\");"; 
                        echo "window.history.back()";
                        echo "</script>"; 
                    }

                }else{
                    echo "<script>";
                        echo "alert(\" ข้อมูลปีการศึกษาซ้ำกับข้อมูลในระบบ\");";
                        echo "window.history.back()";
                    echo "</script>";
                }

            }

        }

?>