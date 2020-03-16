
<?php require($_SERVER['DOCUMENT_ROOT']."/BUU checking system/lib/phpmailer/PHPMailerAutoload.php");?><?php 
session_start();
        if(isset($_POST['Login'])){
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

                      $querySetting = "SELECT * FROM `inacs_setting` WHERE NameTeacher='".$_SESSION['Name']."' ";
                      $settingData = mysqli_query($con,$querySetting);
                      if(mysqli_num_rows($settingData) == 1){
                        while ($rowSetting = mysqli_fetch_assoc($settingData)) {
                          $_SESSION["LevelOrange"] = $rowSetting['LevelOrange'];
                          $_SESSION["LevelRed"] = $rowSetting['LevelRed'];

                          $_SESSION["StatusEmailTeacherOne"] = $rowSetting['EmailTeacherOne'];
                          $_SESSION["StatusEmailTeacherTwo"] = $rowSetting['EmailTeacherTwo'];
                          $_SESSION["StatusEmailTeacherThree"] = $rowSetting['EmailTeacherThree'];
                          $_SESSION["StatusEmailStudentOne"] = $rowSetting['EmailStudentOne'];
                          $_SESSION["StatusEmailStudentTwo"] = $rowSetting['EmailStudentTwo'];
                          $_SESSION["StatusEmailStudentThree"] = $rowSetting['EmailStudentThree'];
                        }
                      }  



                      //Start Save Data By Time
                      $queryTerm = "SELECT * FROM `inacs_term` WHERE NameTeacher='".$_SESSION['Name']."' ";
                      $termSelect = mysqli_query($con,$queryTerm);
                      
                      $dataTerm = array();
  
                      while($rowTerm = mysqli_fetch_array($termSelect)){
                          array_push($dataTerm,array($rowTerm[2],$rowTerm[1],$rowTerm[0]));
                      }
                      
                      sort($dataTerm);
                      $_SESSION["IDTermFirst"] = $dataTerm[count($dataTerm)-1][2];
                      $_SESSION["TermFirst"] = $dataTerm[count($dataTerm)-1][1]."/".$dataTerm[count($dataTerm)-1][0];

                      $Lastdate = date("Y/m/d");

                      $queryCourseALL = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirst"]."' AND NameTeacher='".$_SESSION["Name"]."'  ";
                      $CourseDataALL = mysqli_query($con,$queryCourseALL);
                      if(mysqli_num_rows($CourseDataALL) > 0){
                        while ($rowCourseALL = mysqli_fetch_assoc($CourseDataALL)) {
                           
                          $NumberCheckOld = 0;
                          $CheckDate = array();
                          $IDCourse = $rowCourseALL['ID'];
                          $StartsaveDataCheck = false;

                          $queryCheck = "SELECT * FROM `inacs_check` WHERE IDCourse='$IDCourse' ";
                          $CheckData = mysqli_query($con,$queryCheck);

                          if(mysqli_num_rows($CheckData) == 1){
                              while ($rowCheck = mysqli_fetch_assoc($CheckData)) {

                                  if($rowCheck['LastStartCheckDate'] != $Lastdate && $rowCheck['LastStartCheckDate'] != ""){
                                    array_push($CheckDate,$rowCheck['LastStartCheckDate']);
                                    array_push($CheckDate,$Lastdate);
                                    sort($CheckDate);


                                    //echo $IDCourse."<br>";
                                    //echo count($CheckDate)."<br>";
                                    //echo $CheckDate[0]."<br>";
                                    //echo $CheckDate[1]."<br>";


                                    if($CheckDate[1] == $Lastdate){
                                       
                                      $NumberCheckOld = $rowCheck['NumberCheck'];
                                      $NumberCheckNew = $NumberCheckOld+1;
                                      $StartsaveDataCheck = true;
                                      
                                    }
                                  }
                              }
                          }

                          

                          if($StartsaveDataCheck){

                            $strCheck = "UPDATE `inacs_check` SET NumberCheck='$NumberCheckNew'
                            ,LastStartCheckTime='',LastStartCheckDate='' WHERE IDCourse='$IDCourse' ";
                            $StrData = mysqli_query($con,$strCheck);

                            $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourse' ";
                            $StudentData = mysqli_query($con,$queryStudent);

                            if(mysqli_num_rows($StudentData) > 0){
                              while ($rowStudent = mysqli_fetch_assoc($StudentData)) {

                                $IDStudentData = $rowStudent['ID'];
                                $NumberStudentData = $rowStudent['Number'];
                                $NameStudentData = $rowStudent['Name'];
                                $BranchStudentData = $rowStudent['Branch'];
                        
                                $queryResult = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudentData' ";
                                $ResultData = mysqli_query($con,$queryResult);
                                
                                if(mysqli_num_rows($ResultData) == 1){
                                    while ($rowResult = mysqli_fetch_assoc($ResultData)) {

                                      // start เช็ค คนมาสาย เพื่อตรวจเกณฑ์ความเสี่ยง
                                      $IDResult = $rowResult['ID'];
                                      $dataNumberCheckLast = 0;
                                      $dataNumberCheck = null;
                                      $dataScoreResultLast = null;
                                      $dataCheckLateBool = false;

                                      $queryDetailResultCheck = "SELECT * FROM `inacs_detail_result` WHERE IDResult='$IDResult' ";
                                      $detailResultDataCheck = mysqli_query($con,$queryDetailResultCheck);
                                      if(mysqli_num_rows($detailResultDataCheck) > 0){
                                          while ($rowDetailResultCheck = mysqli_fetch_assoc($detailResultDataCheck)) {

                                            $IDDCheck = $rowDetailResultCheck['IDDetailCheck'];
                                            $queryDetailCheckC = "SELECT * FROM `inacs_detail_check` WHERE ID='$IDDCheck' ";
                                            $detailCheckDataC = mysqli_query($con,$queryDetailCheckC);
                                            if(mysqli_num_rows($detailCheckDataC) == 1){
                                                while ($rowDetailCheckC = mysqli_fetch_assoc($detailCheckDataC)) {
                                                    $dataNumberCheck = $rowDetailCheckC['NumberCheck'];
                                                    $dataScoreResult = $rowDetailResultCheck['ScoreResult'];
                                                }
                                            }
    
                                            if($dataNumberCheck > $dataNumberCheckLast){
                                                $dataNumberCheckLast = $dataNumberCheck;
                                                $dataScoreResultLast = $dataScoreResult;
                                            }

                                          }//END rowDetailResultCheck
                                      }//END IF detailResultDataCheck

                                      if($NumberCheckOld == $dataNumberCheckLast && $dataScoreResultLast == 0.5){
                                        $dataCheckLateBool = true;
                                      }


                                      if($NumberCheckOld != $rowResult['NumberOnTime']+$rowResult['NumberLate']+$rowResult['NumberAbsent'] || $dataCheckLateBool){

                                        $dataNumberOnTime = $rowResult['NumberOnTime'];
                                        $dataNumberLate = $rowResult['NumberLate'];
    
                                        if(!$dataCheckLateBool){
                                            $dataNumberAbsentNew = $rowResult['NumberAbsent']+1;
                                        }else{
                                            $dataNumberAbsentNew = $rowResult['NumberAbsent'];
                                        }
                                        
    
                                        $SumNumber = $dataNumberOnTime+$dataNumberLate+$dataNumberAbsentNew;
    
                                        $scoreRoomNew = (($dataNumberOnTime+($dataNumberLate*0.5))/$SumNumber)*100;

                                        if(!$dataCheckLateBool){

                                          $StrResult = "UPDATE `inacs_result` 
                                              SET LastCheckTime='' 
                                              , NumberAbsent='$dataNumberAbsentNew'
                                              , ScoreRoom='$scoreRoomNew'
                                              WHERE IDStudent='$IDStudentData' ";
                                          $StrData = mysqli_query($con,$StrResult);
                                      

                                      
                                          //insert inacs_detail_result --> NumberAbsent
                                          $queryCheckGetData = "SELECT * FROM `inacs_check` WHERE IDCourse='$IDCourse' ";
                                          $CheckDataGet = mysqli_query($con,$queryCheckGetData);
                                          if(mysqli_num_rows($CheckDataGet) == 1){
                                              while ($rowCheckDataGet = mysqli_fetch_assoc($CheckDataGet)) {
                                                  $_SESSION["IDCheckCourseInCheckStudent"] = $rowCheckDataGet['ID'];
                                                  $_SESSION["NumberCheckCourseInCheckStudent"] = $rowCheckDataGet['NumberCheck']-1;
                                              }
                                          }

                                          $queryDetailCheck = "SELECT * FROM `inacs_detail_check` WHERE IDCheck='".$_SESSION["IDCheckCourseInCheckStudent"]."' AND NumberCheck='".$_SESSION["NumberCheckCourseInCheckStudent"]."'  ";
                                          $detailCheckData = mysqli_query($con,$queryDetailCheck);
                                          if(mysqli_num_rows($detailCheckData) == 1){
                                              while ($rowDetailCheck = mysqli_fetch_assoc($detailCheckData)) {
                                                  $IDDetailCheck = $rowDetailCheck['ID'];
                                              }
                                          }

                                          echo $queryDetailCheck."<br>";
                                          echo $IDDetailCheck."<br>";
                                          
  
                                          $queryDetailResult = "SELECT * FROM `inacs_detail_result` WHERE IDResult='$IDResult' AND IDDetailCheck='$IDDetailCheck'  ";
                                          $detailResultData = mysqli_query($con,$queryDetailResult);
                                          if(mysqli_num_rows($detailResultData) == 0){
              
                                              $strSQL = "INSERT INTO inacs_detail_result ";
                                              $strSQL .="(ID,IDResult,IDDetailCheck,ScoreResult) ";
                                              $strSQL .="VALUES ";
                                              $strSQL .="(NULL,'$IDResult','$IDDetailCheck','0') ";                 
                                              $objQuery = mysqli_query($con,$strSQL);
                                              
                                          }//END
  
                                        }


                                        //Start Email and Message
                                        $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='$IDCourse' ";
                                        $CourseData = mysqli_query($con,$queryCourse);
                                        if(mysqli_num_rows($CourseData) == 1){
                                            while ($rowCourse = mysqli_fetch_assoc($CourseData)) {
                                                $NumberCourse = $rowCourse['Number'];
                                                $NameCourse = $rowCourse['Name'];
                                                $GroupCourse = $rowCourse['GroupCourse'];
                                            }
                                        }

                                        //echo $NumberCourse."<br>";
                                        //echo $NameCourse."<br>";
                                        //echo $GroupCourse."<br>";

                                        $IDCourseLec = null;
                                        $IDCourseLab = null;
                                        $IDStudentLec = null;
                                        $IDStudentLab = null;


                                        // หา ID Course Lec+Lab
                                        $queryCourseLec = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirst"]."' AND NameTeacher='".$_SESSION["Name"]."' AND Number='$NumberCourse' AND Name='$NameCourse' AND GroupCourse='$GroupCourse' AND Type='Lecture' ";
                                        $CourseLecData = mysqli_query($con,$queryCourseLec);
                                        if(mysqli_num_rows($CourseLecData) == 1){
                                            while ($rowCourseLec = mysqli_fetch_assoc($CourseLecData)) {
                                                $IDCourseLec = $rowCourseLec['ID'];
                                            }
                                        }

                                        $queryCourseLab = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermFirst"]."' AND NameTeacher='".$_SESSION["Name"]."' AND Number='$NumberCourse' AND Name='$NameCourse' AND GroupCourse='$GroupCourse' AND Type='Lab' ";
                                        $CourseLabData = mysqli_query($con,$queryCourseLab);
                                        if(mysqli_num_rows($CourseLabData) == 1){
                                            while ($rowCourseLab = mysqli_fetch_assoc($CourseLabData)) {
                                                $IDCourseLab = $rowCourseLab['ID'];
                                            }
                                        }


                                        // หา ID Student Lec+Lab
                                        $queryStudentLecGetID = "SELECT * FROM `inacs_student` WHERE IDCourse='".$IDCourseLec."'  AND Number='$NumberStudentData' AND Name='$NameStudentData'";
                                        $StudentLecDataGetID = mysqli_query($con,$queryStudentLecGetID);
                                        if(mysqli_num_rows($StudentLecDataGetID) == 1){
                                            while ($rowStudentLec = mysqli_fetch_assoc($StudentLecDataGetID)) {
                                                $IDStudentLec = $rowStudentLec['ID'];
                                            }
                                        }

                                        $queryStudentLabGetID = "SELECT * FROM `inacs_student` WHERE IDCourse='".$IDCourseLab."' AND Number='$NumberStudentData' AND Name='$NameStudentData'";
                                        $StudentLabDataGetID = mysqli_query($con,$queryStudentLabGetID);
                                        if(mysqli_num_rows($StudentLabDataGetID) == 1){
                                            while ($rowStudentLab = mysqli_fetch_assoc($StudentLabDataGetID)) {
                                                $IDStudentLab = $rowStudentLab['ID'];
                                            }
                                        }

                                        // หา CheckNumber Lec+Lab
                                        $NumberCheckLec = 0;
                                        $NumberCheckLab = 0;

                                        $queryCheckLecGetID = "SELECT * FROM `inacs_check` WHERE IDCourse='".$IDCourseLec."' ";
                                        $CheckLecDataGetID = mysqli_query($con,$queryCheckLecGetID);
                                        if(mysqli_num_rows($CheckLecDataGetID) == 1){
                                            while ($rowCheckLec = mysqli_fetch_assoc($CheckLecDataGetID)) {
                                                $NumberCheckLec = $rowCheckLec['NumberCheck']-1;
                                            }
                                        }

                                        $queryCheckLabGetID = "SELECT * FROM `inacs_check` WHERE IDCourse='".$IDCourseLab."' ";
                                        $CheckLabDataGetID = mysqli_query($con,$queryCheckLabGetID);
                                        if(mysqli_num_rows($CheckLabDataGetID) == 1){
                                            while ($rowCheckLab = mysqli_fetch_assoc($CheckLabDataGetID)) {
                                                $NumberCheckLab = $rowCheckLab['NumberCheck']-1;
                                            }
                                        }

                                        // หา ผลการเข้าเรียนของทั้ง Lec+Lab
                                        $NumberOnTimeLec = 0;
                                        $NumberLateLec = 0;
                                        $NumberAbsentNewLec = 0;

                                        $NumberOnTimeLab = 0;
                                        $NumberLateLab = 0;
                                        $NumberAbsentNewLab = 0;


                                        $queryResultLec = "SELECT * FROM `inacs_result` WHERE IDStudent='".$IDStudentLec."'  ";
                                        $ResultLecData = mysqli_query($con,$queryResultLec);
                                        if(mysqli_num_rows($ResultLecData) == 1){
                                            while ($rowResultLec = mysqli_fetch_assoc($ResultLecData)) {
                                                $NumberOnTimeLec = $rowResultLec['NumberOnTime'];
                                                $NumberLateLec = $rowResultLec['NumberLate'];
                                                $NumberAbsentNewLec = $rowResultLec['NumberAbsent'];
                                            }
                                        }
    
                                        $queryResultLab = "SELECT * FROM `inacs_result` WHERE IDStudent='".$IDStudentLab."'  ";
                                        $ResultLabData = mysqli_query($con,$queryResultLab);
                                        if(mysqli_num_rows($ResultLabData) == 1){
                                            while ($rowResultLab = mysqli_fetch_assoc($ResultLabData)) {
                                                $NumberOnTimeLab = $rowResultLab['NumberOnTime'];
                                                $NumberLateLab = $rowResultLab['NumberLate'];
                                                $NumberAbsentNewLab = $rowResultLab['NumberAbsent'];
                                            }
                                        }


                                        $levelScore = ($NumberLateLec*0.5)+($NumberLateLab*0.5)+$NumberAbsentNewLec+$NumberAbsentNewLab;

                                        //echo $IDCourseLec."<br>";
                                        //echo $IDCourseLab."<br>";
                                        //echo $IDStudentLec."<br>";
                                        //echo $IDStudentLab."<br>";

                                        if($levelScore >= $_SESSION["LevelOrange"] && $levelScore < $_SESSION["LevelRed"]){
                                          $subject = "นิสิตขาดเรียน ".$_SESSION["LevelOrange"]." ครั้งหรือมากกว่าแต่ไม่เกิน ".$_SESSION["LevelRed"]." ครั้ง";
                                          $level = "เกือบถึง";

                                          if($_SESSION["StatusEmailTeacherOne"] == "checked"){
                                                $CheckSendEmailTeacher = true;
                                          }else{
                                                $CheckSendEmailTeacher = false;
                                          }

                                          if($_SESSION["StatusEmailStudentOne"] == "checked"){
                                                $CheckSendEmailStudent = true;
                                          }else{
                                                $CheckSendEmailStudent = false;
                                          }

                                        }else if($levelScore == $_SESSION["LevelRed"]){
                                          $subject = "นิสิตขาดเรียน ".$_SESSION["LevelRed"]." ครั้ง";
                                          $level = "ถึง";
  
                                          if($_SESSION["StatusEmailTeacherTwo"] == "checked"){
                                                $CheckSendEmailTeacher = true;
                                          }else{
                                                $CheckSendEmailTeacher = false;
                                          }

                                          if($_SESSION["StatusEmailStudentTwo"] == "checked"){
                                                $CheckSendEmailStudent = true;
                                          }else{
                                                $CheckSendEmailStudent = false;
                                          }
  
                                          $StrLecData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายถึงเกณฑ์' WHERE ID='$IDStudentLec' ");
  
                                          $StrLabData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายถึงเกณฑ์' WHERE ID='$IDStudentLab' ");
  
                                        }else if($levelScore > $_SESSION["LevelRed"]){
                                          $subject = "นิสิตขาดเรียนเกิน ".$_SESSION["LevelRed"]." ครั้ง";
                                          $level = "เกิน";

                                          if($_SESSION["StatusEmailTeacherThree"] == "checked"){
                                                $CheckSendEmailTeacher = true;
                                          }else{
                                                $CheckSendEmailTeacher = false;
                                          }

                                          if($_SESSION["StatusEmailStudentThree"] == "checked"){
                                                $CheckSendEmailStudent = true;
                                          }else{
                                                $CheckSendEmailStudent = false;
                                          }
  
                                          $StrLecData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายเกินเกณฑ์' WHERE ID='$IDStudentLec' ");
  
                                          $StrLabData = mysqli_query($con,"UPDATE `inacs_student` SET Status='ขาดเรียนและมาสายเกินเกณฑ์' WHERE ID='$IDStudentLab' ");
                                        }

                                        if($levelScore >= $_SESSION["LevelOrange"]){
                                          header('Content-Type: text/html; charset=utf-8');
   
                                          //start Email Student
                                          $mail_Student = new PHPMailer;
                                          $mail_Student->CharSet = "utf-8";
                                          $mail_Student->isSMTP();
                                          $mail_Student->Host = 'smtp.gmail.com';
                                          $mail_Student->Port = 587;
                                          $mail_Student->SMTPSecure = 'tls';
                                          $mail_Student->SMTPAuth = true;
                              
                                          $gmail_username = "INACSystem@gmail.com"; // gmail ที่ใช้ส่ง
                                          $gmail_password = "ProjectJoJo"; // รหัสผ่าน gmail
                                           
                                           
                                          $sender = "INACS"; // ชื่อผู้ส่ง
                                          $email_sender = "INACS@system.com"; // เมล์ผู้ส่ง 
      
      
                                          //$email_receiver = $_SESSION['Email']; // เมล์ผู้รับ ***
                                          $email_receiver_student = $NumberStudentData."@go.buu.ac.th";
      
                                          
                                          //$subject = "นิสิตขาดเรียนเกิน 3 ครั้ง"; // หัวข้อเมล์
                              
      
                                          $mail_Student->Username = $gmail_username;
                                          $mail_Student->Password = $gmail_password;
                                          $mail_Student->setFrom($email_sender, $sender);
                                          $mail_Student->addAddress($email_receiver_student);
                                          $mail_Student->Subject = $subject;
                              
                              
                                          $year = date('Y');
                                          $email_content_Student = "
                                          <!DOCTYPE html>
                                          <html>
                                              <head>
                                                  <meta charset=utf-8'/>
                                                  <title>".$subject."</title>
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
                                                          <h2>เรื่อง ".$subject."<strong style='color:#0000ff;'></strong></h2>
                                                          <br>
                                                          <h2>เรียน ".$NameStudentData."<strong style='color:#0000ff;'></strong></h2>
                                                          <br><br>
                                                          <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                          เนื่องด้วย คุณได้ขาดเรียนและมาสายในวิชา ".$NumberCourse." ".$NameCourse." ".$level."เกณฑ์ ที่กำหนดไว้แล้ว จึงได้แจ้งให้รับทราบ<strong style='color:#0000ff;'></strong></h2>
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
  
                                          //start Email Teacher
                                          $mail_Teacher = new PHPMailer;
                                          $mail_Teacher->CharSet = "utf-8";
                                          $mail_Teacher->isSMTP();
                                          $mail_Teacher->Host = 'smtp.gmail.com';
                                          $mail_Teacher->Port = 587;
                                          $mail_Teacher->SMTPSecure = 'tls';
                                          $mail_Teacher->SMTPAuth = true;
  
                                          $email_receiver_teacher = $_SESSION['Email'];
                              
      
                                          $mail_Teacher->Username = $gmail_username;
                                          $mail_Teacher->Password = $gmail_password;
                                          $mail_Teacher->setFrom($email_sender, $sender);
                                          $mail_Teacher->addAddress($email_receiver_teacher);
                                          $mail_Teacher->Subject = $subject;
  
  
                                          $email_content_Teacher = "
                                          <!DOCTYPE html>
  
                                              <html>
                                                  <head>
                                                      <meta charset=utf-8'/>
                                                      <title>".$subject."</title>
                                                  </head>
                                                  <body>
                                                      <div style='background: #2c56d4;padding: 10px 0 20px 10px;margin-bottom:10px;font-size:30px;color:white; display: flex;'>
                                                          <img src='https://cdn.onlinewebfonts.com/svg/img_3015.png' style='width: 80px;'>
                                                          <div style='margin-top:26px; margin-left:15px;'><b>INACS</b></div>
                                                      </div>
                                                      <div style='padding:20px;'>
                                                          <div>             
                                                              <h2>เรียน ".$_SESSION['Name']."<strong style='color:#0000ff;'></strong></h2>
                                                              <br><br>
                                                              <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                              เนื่องด้วย ".$NameStudentData." รหัส ".$NumberStudentData." สาขา ".$BranchStudentData." ขาดเรียนและมาสายในวิชา ".$NumberCourse." ".$NameCourse." ".$level."เกณฑ์ ที่กำหนดไว้แล้ว โดย ".$NameStudentData." มีข้อมูลการเข้าเรียนในรายวิชา ".$NameCourse." ดังนี้<strong style='color:#0000ff;'></strong></h2>
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
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberStudentData."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NameStudentData."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberCheckLec."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberOnTimeLec."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberLateLec."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberAbsentNewLec."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberCheckLab."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberOnTimeLab."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberLateLab."</td> 
                                                                  <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>".$NumberAbsentNewLab."</td> 
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
                                        //  ตั้งค่าการส่งอีเมล อาจารย์+นิสิต
                                        if($email_receiver_student){
                                            if($CheckSendEmailStudent){
                                                $mail_Student->msgHTML($email_content_Student);
                                                $mail_Student->send();
                                            }
                                        }

                                        if($email_receiver_teacher){
                                            if($CheckSendEmailTeacher){
                                                $mail_Teacher->msgHTML($email_content_Teacher);
                                                $mail_Teacher->send();
                                            }
                                        }
                                          //End Email
  
                                          //Start Message
                                          $DateTODay = date("d/m/Y");
  
                                          $strSQL = "INSERT INTO inacs_message ";
                                          $strSQL .="(ID,IDCourse,IDStudent,Date,Name,Status) ";
                                          $strSQL .="VALUES ";
                                          $strSQL .="(NULL,'$IDCourse','$IDStudentData','$DateTODay','$subject','' ) ";
                                          
                                          $objResultQuery = mysqli_query($con,$strSQL);
  
  
                                      }





                                      }else{
                                        $StrResult = "UPDATE `inacs_result` 
                                        SET LastCheckTime='' 
                                        WHERE IDStudent='$IDStudentData' ";
                                        $StrData = mysqli_query($con,$StrResult);
                                      }


                                    }//END rowResult
                                }//END IF ResultData

                              } //END rowStudent
                            } //END IF StudentData
                            
                          }

                        }//END rowCourse
                      } //END Save Data By Time





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