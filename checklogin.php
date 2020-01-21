<?php 
session_start();
        if(isset($_POST['username'])){
                  include("condb.php");
                  $username = $_POST['username'];
                  $password = $_POST['password'];
 
                  $sql="SELECT * FROM inacs_teacher 
                  WHERE  Username='".$username."' 
                  AND  Password='".$password."' ";
                  $result = mysqli_query($con,$sql);
				
                  if(mysqli_num_rows($result)==1){
                      $row = mysqli_fetch_array($result);
 
                      $_SESSION["Name"] = $row["Name"];
                      $_SESSION["Email"] = $row["Email"];
                      $_SESSION["Username"] = $row["Username"];
                      $_SESSION["Password"] = $row["Password"];
 
                      Header("Location: index.php");

                     
                  }else{
                    echo "<script>";
                        echo "alert(\" username หรือ  password ไม่ถูกต้อง\");"; 
                        echo "window.history.back()";
                    echo "</script>";
 
                  }
        }else{
             Header("Location: login.php"); 
        }
?>