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
                    echo "alert(\" โปรดใส่ข้อมูลปีการศึกษาเป็นจำนวนเต็มอย่างเดียว\");";
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var($_POST['Term'], FILTER_VALIDATE_INT)) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลเทอมเป็นจำนวนเต็มอย่างเดียว\");";
                    echo "window.history.back()";
                echo "</script>";
            }else{

                $queryTerm = "SELECT * FROM `inacs_term` WHERE NameTeacher='".$_SESSION['Name']."' AND Term='".$_POST['Term']."' AND Year='".$_POST['Year']."'";
                $termData = mysqli_query($con,$queryTerm);
                if(mysqli_num_rows($termData) == 0){

                    $strSQL = "INSERT INTO inacs_term ";
                    $strSQL .="(ID,Term,Year,NameTeacher) ";
                    $strSQL .="VALUES ";
                    $strSQL .="(NULL,'".$_POST['Term']."','".$_POST['Year']."','".$_SESSION['Name']."') ";                 
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

        if(isset($_POST['SaveChange']) ){
            if(empty($_POST['LevelOrange'])){
                echo "<script>";
                    echo "alert(\" โปรดใส่ตัวเลขที่จะใช่ลบกับจำนวนที่เช็คเพื่อขึ้นแถบสีส้ม\");";
                    echo "window.history.back()";
                echo "</script>";
            }else if(empty($_POST['LevelRed'])){
                echo "<script>";
                    echo "alert(\" โปรดใส่ตัวเลขที่จะใช่ลบกับจำนวนที่เช็คเพื่อขึ้นแถบสีแดง\");";
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var($_POST['LevelOrange'], FILTER_VALIDATE_INT)) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลที่ใช้ลบให้ขึ้นแถบสีส้มเป็นจำนวนเต็มอย่างเดียว\");";
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var($_POST['LevelRed'], FILTER_VALIDATE_INT)) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลที่ใช้ลบให้ขึ้นแถบสีแดงเป็นจำนวนเต็มอย่างเดียว\");";
                    echo "window.history.back()";
                echo "</script>";
            }else{

                $LevelOrange = $_POST['LevelOrange'];
                $LevelRed = $_POST['LevelRed'];

                if($LevelOrange >= $LevelRed){
                    echo "<script>";
                        echo "alert(\" จำนวนที่ใช้ลบเพื่อขึ้นแถบสีส้มมากกว่าหรือเท่ากับจำนวนที่ใช้้ลบเพื่อขึ้นแถบสีแดง \");";
                        echo "window.history.back()";
                    echo "</script>";
                }else{
                    $strQuery = "UPDATE `inacs_setting` SET LevelOrange='$LevelOrange' , LevelRed='$LevelRed'
                    WHERE NameTeacher='".$_SESSION['Name']."' ";
                    $strData = mysqli_query($con,$strQuery);

                    if($strData){

                        $_SESSION["LevelOrange"] = $LevelOrange;
                        $_SESSION["LevelRed"] = $LevelRed;

                        echo "<script>";
                            echo "alert(\" Save Change Complete \");";
                            echo "window.history.back()";
                        echo "</script>";
                    }else{
                        echo "<script>";
                            echo "alert(\" Save Change Error \");";
                            echo "window.history.back()";
                        echo "</script>";
                    }
                }

            }
        }

?>