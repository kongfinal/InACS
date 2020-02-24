<?php 
session_start();
        $name = $_POST['nameRegis'];
        $email = $_POST['emailRegis'];
        $username = $_POST['usernameRegis'];
        $password = $_POST['passwordRegis'];

        if(isset($_POST['register'])){
            if (empty($_POST["nameRegis"])) {
                echo "<script>";
                    echo "alert(\" Name is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["emailRegis"])) {
                echo "<script>";
                    echo "alert(\" Email is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["usernameRegis"])) {
                echo "<script>";
                    echo "alert(\" Username is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["passwordRegis"])) {
                echo "<script>";
                    echo "alert(\" Password is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            } else if (empty($_POST["corn-passwordRegis"])) {
                echo "<script>";
                    echo "alert(\" Cornfirm Password is required\");"; 
                    echo "window.history.back()";
                 echo "</script>";
            }else {
              $emailCheck = trim(htmlspecialchars($_POST['emailRegis']));
              $emailCheck = filter_var($email, FILTER_VALIDATE_EMAIL);
              $passCheck = trim(htmlspecialchars($_POST['passwordRegis']));
              $cornCheck = trim(htmlspecialchars($_POST['corn-passwordRegis']));
              if ($emailCheck === false) {
                echo "<script>";
                    echo "alert(\" Invalid Email\");"; 
                    echo "window.history.back()";
                echo "</script>";
              }else if($passCheck !== $cornCheck){
                echo "<script>";
                    echo "alert(\" Password not same Cornfirm Password\");"; 
                    echo "window.history.back()";
                echo "</script>";
              }else{
                include("condb.php");

                $checkNameSQL="SELECT * FROM inacs_teacher 
                WHERE  Name='".$name."' 
                OR  Username='".$username."' ";
                $result = mysqli_query($con,$checkNameSQL);
                if(mysqli_num_rows($result)==0){

                    $strSQL = "INSERT INTO inacs_teacher ";
                    $strSQL .="(Name,Email,Username,Password) ";
                    $strSQL .="VALUES ";
                    $strSQL .="('".$_POST['nameRegis']."','".$_POST['emailRegis']."','".$_POST['usernameRegis']."','".$_POST['passwordRegis']."') ";
                    $objQuery = mysqli_query($con,$strSQL);
                    if($objQuery){
                        $_SESSION["Name"] = $name;
                        $_SESSION["Email"] = $email;
                        $_SESSION["Username"] = $username;
                        $_SESSION["Password"] = $password;


                        $strSQLSetting = "INSERT INTO inacs_setting ";
                        $strSQLSetting .="(ID,NameTeacher,LevelOrange,LevelRed) ";
                        $strSQLSetting .="VALUES ";
                        $strSQLSetting .="(NULL,'".$_SESSION["Name"]."','2','3') ";
                        $objQuerySetting = mysqli_query($con,$strSQLSetting);
                        if($objQuerySetting){
                            Header("Location: index.php");
                        }

                    }else{
                        echo "<script>";
                            echo "alert(\" Register Error\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }
                   
                }else{
                  echo "<script>";
                      echo "alert(\" ชื่อ-สกุล หรือ Username ที่ใส่ซ้ำกับในระบบ\");"; 
                      echo "window.history.back()";
                  echo "</script>";
                }
              }
            }
        }

?>