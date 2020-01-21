<?php 
session_start();

        if(isset($_POST['changeEmail'])){
            $email = $_POST['email'];

            if (empty($_POST["email"])) {
                echo "<script>";
                    echo "alert(\" Email is required\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else {
                $email = trim(htmlspecialchars($_POST['email']));
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                if ($email === false) {
                  echo "<script>";
                    echo "alert(\" Invalid Email\");"; 
                    echo "window.history.back()";
                  echo "</script>";
                }else{
                    include("condb.php");

                    $searchSQL="SELECT * FROM inacs_teacher 
                    WHERE Name='".$_SESSION["Name"]."' ";
                    $result = mysqli_query($con,$searchSQL);
                
                    if(mysqli_num_rows($result)==1){

                        $strSQL = "UPDATE inacs_teacher SET Email='".$email."' WHERE Name='".$_SESSION["Name"]."' ";
                        $objQuery = mysqli_query($con,$strSQL);
                        if($objQuery){
                            $_SESSION["Email"] = $email;
                            echo "<script>";
                                echo "alert(\" Change Email Complete\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }else{
                            echo "<script>";
                                echo "alert(\" Change Email Error\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }
                    }else{
                    echo "<script>";
                        echo "alert(\" Error!!!\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                    }
              }
            }
        }

?>