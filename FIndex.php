<?php //require($_SERVER['DOCUMENT_ROOT']."/BUU checking system/lib/phpmailer/PHPMailerAutoload.php");?>
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


        if(isset($_POST['selectStudents'])){
            $_SESSION["NumStudentRiskCheck"] = $_POST['selectStudents'];
            $_SESSION["DataRiskCheck"] = "All";
            Header("Location: index.php");
        }

        if(isset($_POST['selectCourses'])){
            $_SESSION["DataRiskCheck"] = $_POST['selectCourses'];
            Header("Location: index.php");
        }



        // Test Send Email
        /*if(isset($_POST['sendMail']) ){


            header('Content-Type: text/html; charset=utf-8');
 
            $mail = new PHPMailer;
            $mail->CharSet = "utf-8";
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;

            $gmail_username = "INACSystem@gmail.com"; // gmail ที่ใช้ส่ง
            $gmail_password = "ProjectJoJo"; // รหัสผ่าน gmail
            // ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1
             
             
            $sender = "INACS"; // ชื่อผู้ส่ง
            $email_sender = "INACS@system.com"; // เมล์ผู้ส่ง 
            $email_receiver = $_SESSION['Email']; // เมล์ผู้รับ ***
             
            $subject = "นิสิตขาดเรียนเกิน 3 ครั้ง"; // หัวข้อเมล์

            $mail->Username = $gmail_username;
            $mail->Password = $gmail_password;
            $mail->setFrom($email_sender, $sender);
            $mail->addAddress($email_receiver);
            $mail->Subject = $subject;


            $year = date('Y');
            $email_content = "
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset=utf-8'/>
                    <title>นิสิตขาดเรียนเกิน 3 ครั้ง</title>
                </head>
                <body>
                    <div style='background: #2c56d4;padding: 10px 0 20px 10px;margin-bottom:10px;font-size:30px;color:white; display: flex;'>
                        <img src='https://cdn.onlinewebfonts.com/svg/img_3015.png' style='width: 80px;'>
                        <div style='margin-top:26px; margin-left:15px;'><b>INACS</b></div>
                    </div>
                    <div style='padding:20px;'>
                        <!--<div style='text-align:center;margin-bottom:50px;'>
                            <img src='http://cdn.wccftech.com/wp-content/uploads/2017/02/Apple-logo.jpg' style='width:100%' />             
                        </div>-->
                        <div>             
                            <h2>เรื่อง นิสิตขาดเรียนเกิน 3 ครั้ง<strong style='color:#0000ff;'></strong></h2>
                            <br>
                            <h2>เรียน นาย กกกกก  ขขขขขข<strong style='color:#0000ff;'></strong></h2>
                            <br><br>
                            <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            เนื่องด้วย คุณได้ขาดเรียนและมาสายในวิชา รหัสวิชา ชื่อวิชา ถึง/เกิน เกณฑ์ ที่กำหนดไว้แล้ว จึงได้แจ้งให้รับทราบ<strong style='color:#0000ff;'></strong></h2>
                        </div>
                        <div style='margin-top:30px;'>
                            <hr>
                            <h2 style='text-align: right;'>ดร.พิเชษ วะยะลุน<strong style='color:#0000ff;'></strong></h2>
                        </div>
                    </div>
                    <div style='background: #2c56d4;color: white;padding:30px;'>
                        <div style='text-align:center'> ".$year." © Burapha University
                        </div>
                    </div>
                </body>
            </html>
        ";

        $email_content_Teacher = "
        <!DOCTYPE html>

            <html>
                <head>
                    <meta charset=utf-8'/>
                    <title>นิสิตขาดเรียนเกิน 3 ครั้ง</title>
                </head>
                <body>
                    <div style='background: #2c56d4;padding: 10px 0 20px 10px;margin-bottom:10px;font-size:30px;color:white; display: flex;'>
                        <img src='https://cdn.onlinewebfonts.com/svg/img_3015.png' style='width: 80px;'>
                        <div style='margin-top:26px; margin-left:15px;'><b>INACS</b></div>
                    </div>
                    <div style='padding:20px;'>
                        <div>             
                            <h2>เรียน อาจารย์ ......<strong style='color:#0000ff;'></strong></h2>
                            <br><br>
                            <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            เนื่องด้วย นาย.......... รหัส ........ สาขา ........... ขาดเรียนและมาสายในวิชา รหัสวิชา ชื่อวิชา ถึง/เกิน เกณฑ์ ที่กำหนดไว้แล้ว โดย นาย..........   มีข้อมูลการเข้าเรียนในรายวิชา.....ดังนี้<strong style='color:#0000ff;'></strong></h2>
                            <table style='font-family:Trebuchet MS, Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>
                            <tr>
                                <th rowspan='2' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>รหัสนิสิต</th>
                                <th rowspan='2' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>ชื่อนิสิต</th>
                                <th colspan='4' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>บรรยาย</th>
                                <th colspan='4' style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '>ปฎิบัติ</th>
                            </tr>
                            <tr>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> จำนวนที่เช็ค</th>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ทันเวลา</th>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> สาย</th>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ขาด</th>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> จำนวนที่เช็ค</th>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ทันเวลา</th>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> สาย</th>
                                <th style='border: 1px solid #ddd; padding: 8px; text-align: center; padding-top: 12px; padding-bottom: 12px; background-color: #2c56d4; color: white; '> ขาด</th>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>&nbsp</td> 
                            </tr>
                            
                            </table>
                        </div>
                        <div style='margin-top:30px;'>
                            <hr>
                            <h2 style='text-align: right;'>ดร.พิเชษ วะยะลุน<strong style='color:#0000ff;'></strong></h2>
                        </div>
                    </div>
                    <div style='background: #2c56d4;color: white;padding:30px;'>
                        <div style='text-align:center'>".$year." © Burapha University
                        </div>
                    </div>
                </body>
            </html>
        ";

         
        //  ถ้ามี email ผู้รับ
        if($email_receiver){
            $mail->msgHTML($email_content_Teacher);
         
         
            if (!$mail->send()) {  // สั่งให้ส่ง email
         
                // กรณีส่ง email ไม่สำเร็จ
                echo "<h3 class='text-center'>ระบบมีปัญหา กรุณาลองใหม่อีกครั้ง</h3>";
                echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
            }else{
                // กรณีส่ง email สำเร็จ
                echo "ระบบได้ส่งข้อความไปเรียบร้อย";
            }   
        }
    }*/
?>