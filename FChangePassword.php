<?php 
session_start();

        if(isset($_POST['changePassLogin'])){
            $username = $_POST['username-change'];
            $newpass = $_POST['new-password'];
            $curpass = $_POST['current-password'];
            $reppass = $_POST['repeat-password'];
            if (empty($_POST["username-change"])) {
                echo "<script>";
                    echo "alert(\" Username is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["new-password"])) {
                echo "<script>";
                    echo "alert(\" New Password is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["current-password"])) {
                echo "<script>";
                    echo "alert(\" Current Password is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["repeat-password"])) {
                echo "<script>";
                    echo "alert(\" Repeat Password is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else {
                if ($newpass !== $reppass) {
                echo "<script>";
                    echo "alert(\" New Password not same Repeat Password\");"; 
                    echo "window.history.back()";
                echo "</script>";
                }else if($curpass === $newpass) {
                echo "<script>";
                    echo "alert(\" New Password same Current Password\");"; 
                    echo "window.history.back()";
                echo "</script>";
              }else{
                include("condb.php");

                $searchSQL="SELECT * FROM inacs_teacher 
                WHERE Username='".$username."' AND Password='".$curpass."' ";
                $result = mysqli_query($con,$searchSQL);
              
                if(mysqli_num_rows($result)==1){

                    $strSQL = "UPDATE inacs_teacher SET Password='".$newpass."' WHERE Username='".$username."'";
                    $objQuery = mysqli_query($con,$strSQL);
                    if($objQuery){

                        echo "<script>";
                            echo "alert(\" Change Password Complete\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else{
                        echo "<script>";
                            echo "alert(\" Change Password Error\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }
                }else{
                  echo "<script>";
                      echo "alert(\" Username หรือ Current Passwoed ไม่ถูกต้อง\");"; 
                      echo "window.history.back()";
                  echo "</script>";
                }
              }
            }
        }

        if(isset($_POST['changePass'])){
            $newpass = $_POST['new-password'];
            $curpass = $_POST['curr-password'];
            $reppass = $_POST['rep-password'];
            if (empty($_POST["new-password"])) {
                echo "<script>";
                    echo "alert(\" New Password is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["curr-password"])) {
                echo "<script>";
                    echo "alert(\" Current Password is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["rep-password"])) {
                echo "<script>";
                    echo "alert(\" Repeat Password is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else {
                if ($newpass !== $reppass) {
                echo "<script>";
                    echo "alert(\" New Password not same Repeat Password\");"; 
                    echo "window.history.back()";
                echo "</script>";
                }else if($curpass === $newpass) {
                echo "<script>";
                    echo "alert(\" New Password same Current Password\");"; 
                    echo "window.history.back()";
                echo "</script>";
              }else{
                include("condb.php");

                $searchSQL="SELECT * FROM inacs_teacher 
                WHERE Username='".$_SESSION["Username"]."' AND Password='".$curpass."' ";
                $result = mysqli_query($con,$searchSQL);
              
                if(mysqli_num_rows($result)==1){
                    $strSQL = "UPDATE inacs_teacher SET Password='".$newpass."' WHERE Username='".$_SESSION["Username"]."'";
                    $objQuery = mysqli_query($con,$strSQL);
                    if($objQuery){
                        
                        $_SESSION["Password"] = $newpass;
                        echo "<script>";
                            echo "alert(\" Change Password Complete\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                        
                    }else{
                        echo "<script>";
                            echo "alert(\" Change Password Error\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }
                }else{
                  echo "<script>";
                      echo "alert(\" Current Passwoed ไม่ถูกต้อง\");"; 
                      echo "window.history.back()";
                  echo "</script>";
                }
              }
            }
        }

?>