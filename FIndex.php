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


        // Test Send Email
        if(isset($_POST['sendMail']) ){
            //echo "Hello";
            $to = "somebody@example.com, somebodyelse@example.com";
            $subject = "HTML email";
            
            $message = "
            <html>
            <head>
            <title>HTML email</title>
            </head>
            <body>
            <p>This email contains HTML Tags!</p>
            <table>
            <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            </tr>
            <tr>
            <td>John</td>
            <td>Doe</td>
            </tr>
            </table>
            </body>
            </html>
            ";
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <webmaster@example.com>' . "\r\n";
            $headers .= 'Cc: myboss@example.com' . "\r\n";
            
            mail($_SESSION['Email'],$subject,$message,$headers);
        }
?>