<?php session_start();
include('condb.php');

$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];

$_SESSION["IDTerm"] = $_SESSION["IDTermFirst"];
$_SESSION["Pagination"] = 1;

$_SESSION["IDTermStudent"] = $_SESSION["IDTermFirstStudent"];
$_SESSION["PaginationSelectStudent"] = 1;

$_SESSION["IDTermVacation"] = $_SESSION["IDTermFirstVacation"];
$_SESSION["CheckTermVacation"] = true;
$_SESSION["PaginationVacation"] = 1;

$_SESSION["IDTermCheck"] = $_SESSION["IDTermFirstCheck"];
$_SESSION["PaginationSelectCheck"] = 1;

$_SESSION["IDTermResult"] = $_SESSION["IDTermFirstResult"];
$_SESSION["PaginationSelectResult"] = 1;

$_SESSION["NumberCheckStudent"] = "";
$_SESSION["IDCheckStudent"] = "";
$_SESSION["NameCheckStudent"] = "";
$_SESSION["TimeCheckStudent"] = ""; 
$_SESSION["StatusCheckStudent"] = "";
$_SESSION["NumberAbsentCheckStudent"] = "";
$_SESSION["NumberLateStudent"] = "";
$_SESSION["ScoreDeductedCheckStudent"] = "";

$_SESSION["NumberAbsentCheckStudentAll"] = "";
$_SESSION["NumberLateStudentAll"] = "";
$_SESSION["ScoreDeductedCheckStudentAll"] = "";

$_SESSION["TypeMessage"] = "all";
$_SESSION["PaginationMessage"] = 1;



$queryTerm = "SELECT * FROM `inacs_term` WHERE NameTeacher='".$_SESSION['Name']."' ";
$termSelect = mysqli_query($con,$queryTerm);

$dataTerm = array();

while($rowTerm = mysqli_fetch_array($termSelect)){
    array_push($dataTerm,array($rowTerm[2],$rowTerm[1],$rowTerm[0]));
}

sort($dataTerm);
$_SESSION["TermFirst"] = $dataTerm[count($dataTerm)-1][1]."/".$dataTerm[count($dataTerm)-1][0];







?>
<?php
include('h.php');
?>
<style>

.myinput.large {
  height: 26px;
  width: 26px;
}

.myinput.large[type="checkbox"]:before {
  width: 24px;
  height: 24px;
}

.myinput.large[type="checkbox"]:after {
  top: -24px;
  width: 20px;
  height: 20px;
}

</style>
<body>

<?php

?>

<div class="navbar-div">
        <nav class="navbarv-2 is-dodgerblue" aria-label="main navigation">
            <a class="navbar-item banner">
                <div>
                    <span class="navbar-banner-text">InACS</span>
                </div>
            </a>
            <button id="navbar-user" class="navbar-item user" onclick="if (document.getElementById('navbar-dropdown').classList.contains('is-active'))  return document.getElementById('navbar-dropdown').classList.remove('is-active'); else return document.getElementById('navbar-dropdown').classList.add('is-active');">
                <div class="user-container" title="คลิกเพื่อแสดง/ปิด navbar">
                    <svg class="navbar-user-iconv-2 iconv-2-user iconv-2-size-5"></svg>
                    <span class="navbar-user-text"><?php echo $name; ?></span>
                    <svg class="navbar-user-iconv-2 iconv-2-down-arrow iconv-2-size-6"></svg>
                </div>
                <div id="navbar-dropdown" class="dropdown-items">
                    <a onclick="document.getElementById('ChangePassFormv.2').style.display='block'">
                      <i class="iconv-2-lock"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนรหัสผ่าน</div>
                    </a>
                    <a onclick="document.getElementById('ChangeEmail').style.display='block'">
                    <i class="iconv-2-a"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนอีเมล</div>
                    </a>
                    <a href="logout.php">
                    <i class="iconv-2-logout"></i>
                      <div class="maginTextNavbar-dropdown">ออกจากระบบ</div>
                    </a>
                </div>
            </button>
        </nav>
</div>

    <nav class="menu main-menu">
        <div class="menu-space"></div>
        <div class="menu-space"></div>
        <ul class="menu-list">
            <li>
                <a href="index.php">
                <svg class="menu-icon iconv-2-home"></svg>หน้าแรก
                </a>
            </li>
            <li>
                <a href="message.php">
                <svg class="menu-icon iconv-2-mail"></svg>ข้อความ
                </a>
            </li>
            <li>
                <a href="select-course-check.php">
                <svg class="menu-icon iconv-2-check"></svg>เช็คชื่อนิสิต
                </a>
            </li>
            <li>
                <a href="select-course-results.php">
                <svg class="menu-icon iconv-2-clipboard"></svg>ผลการเช็คชื่อ
                </a>
            </li>
            <li>
                <a href="course-management.php">
                <svg class="menu-icon iconv-2-bag"></svg>จัดการรายวิชา
                </a>
            </li>
            <li>
                <a href="select-course-student.php">
                <svg class="menu-icon iconv-2-student-cap"></svg>จัดการนิสิต
                </a>
            </li>
            <li>
                <a href="timetable.php">
                <svg class="menu-icon iconv-2-table"></svg>ตารางสอน
                </a>
            </li>
            <li>
                <a href="vacation.php">
                <svg class="menu-icon iconv-2-backpack"></svg>การลา
                </a>
            </li>
            <li>
                <a href="setting.php" class="is-black-blue">
                <svg class="menu-icon iconv-2-cog"></svg>ตั้งค่าระบบ
                </a>
            </li>
            <li>
                <a href="logout.php">
                <svg class="menu-icon iconv-2-logout"></svg>ออกจากระบบ
                </a>
            </li>
        </ul>
    </nav>

<div class="subcontent-area">
        <div class="subcontent-main-div index">
            <div class="box with-title is-round">
                <div class="box-title is-dodgerblue">
                    <svg class="menu-icon-topic iconv-2-cog"></svg>ตั้งค่าระบบ
                </div>
                <div class="box">
                <!--<form name="Send" action="FIndex.php" method="post" style=" margin-bottom: 0%;">
                <div class="columns">

                    <h3>Tset Send Email : </h3>

                    <button class="small-v3" name="sendMail" style="margin-left: 4%; width: 12%;"  onclick="document.Send.submit();">
                        <b  style="margin-top: 4%; margin-bottom: 4%; font-size: 32px;" >ส่งเมล</b>
                        
                    </button>
                </div>
                </form>-->
                <form name="Add" action="FSetting.php" method="post" style=" margin-bottom: 0%;">
                    <div class="columns">
                    
                        <h3 style="margin-right:1%;">ภาคเรียนล่าสุด :</h3>
                        <h3><?php echo $_SESSION["TermFirst"];?></h3>

                        <h2 style="margin-right:2%; margin-left:2%;"><b>|</b></h2>


                        
                        <h3 style="margin-left:1%;">ปีการศึกษา :</h3>
                        <input class="input-field-v8-2" style="width: 10%; height:30px; margin-top:1%; margin-left:1%;" type="textRegis" name="Year" value="" title="ใส่ปีการศึกษาเป็น พ.ศ." autocomplete=off onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                        <h3 style="margin-left:2%; margin-right:1%;">เทอม :</h3>
                        <input class="input-field-v8-2" style="width: 10%; height:30px; margin-top:1%;" type="textRegis" name="Term" value="" title="ใส่เทอมเป็น 1 หรือ 2 หรือ 3 (3 เป็น Summer)" autocomplete=off>

                        <button class="small-v3" name="addTerm" style="margin-left: 4%; width: 16%; height: 40px; background-color: #3366ff; color: white;" title="คลิกเพื่อเพิ่มเทอม" onclick="document.Add.submit();">
                        <b style="padding-top: 10%; padding-bottom: 10%; font-size: 18px;" >เพิ่มปีการศึกษา</b>
                        <!--<svg class="menu-icon iconv-2-add-box"></svg>-->
                        </button>
                    </div>
                </form>

                <hr style="border-top: 1px solid #777777a1;">

                <div class="columns" style="margin-bottom:1%;">
                    <div class="column is-4">
                        <h3>กำหนดเกณฑ์ในการตรวจสอบผลการเช็คชื่อ</h3>
                    </div>
                </div>

                <form name="Change" action="FSetting.php" method="post" style=" margin-bottom: 0%;">
                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:3%;">ขึ้นแถบ<b style="color:orange">สีส้ม</b>เมื่อนิสิตขาดเรียน </h4>

                        <input class="input-field-v8-2" style="width: 10%; height:30px;" type="textRegis" name="LevelOrange" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $_SESSION["LevelOrange"];?>" title="ใส่ตัวเลขที่จะใช่ลบกับจำนวนที่เช็คเพื่อขึ้นแถบสีส้ม" autocomplete=off>

                        <h4 style="margin-left:2%;">ครั้ง</h4>
                    </div>

                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:2%;">ขึ้นแถบ<b style="color:red">สีแดง</b>เมื่อนิสิตขาดเรียน </h4>

                        <input class="input-field-v8-2" style="width: 10%; height:30px;" type="textRegis" name="LevelRed" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $_SESSION["LevelRed"];?>" title="ใส่ตัวเลขที่จะใช่ลบกับจำนวนที่เช็คเพื่อขึ้นแถบสีแดง" autocomplete=off>

                        <h4 style="margin-left:2%;">ครั้ง</h4>
                    </div>

                    <br>
                    <div class="columns" style="margin-bottom:1%;">
                        <div class="column is-3">
                            <h3>กำหนดการส่งอีเมลของอาจารย์</h3>
                        </div>
                    </div>

                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:3%;">ส่งอีเมลให้อาจารย์เมื่อนิสิตขาดเรียน <b style="color:orange"><?php echo $_SESSION["LevelOrange"];?></b> ครั้ง</h4>

                        <input id="CheckEmailTeacherOne" type="checkbox" class="myinput large" 
                        style="margin-left: 2.9%;" name="EmailTeacherOne" value="checked" <?php echo $_SESSION["StatusEmailTeacherOne"];?> onclick=""/>
                    </div>

                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:3%;">ส่งอีเมลให้อาจารย์เมื่อนิสิตขาดเรียน <b style="color:red"><?php echo $_SESSION["LevelRed"];?></b> ครั้ง</h4>

                        <input id="CheckEmailTeacherTwo" type="checkbox" class="myinput large" 
                        style="margin-left: 2.9%;" name="EmailTeacherTwo" value="checked" <?php echo $_SESSION["StatusEmailTeacherTwo"];?> onclick=""/>
                    </div>

                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:3%;">ส่งอีเมลให้อาจารย์เมื่อนิสิตขาดเรียนเกิน <b style="color:red"><?php echo $_SESSION["LevelRed"];?></b> ครั้ง</h4>

                        <input id="CheckEmailTeacherThree" type="checkbox" class="myinput large"   
                        style="" name="EmailTeacherThree" value="checked" <?php echo $_SESSION["StatusEmailTeacherThree"];?> onclick=""/>
                    </div>

                    <br>
                    <div class="columns" style="margin-bottom:1%;">
                        <div class="column is-3">
                            <h3>กำหนดการส่งอีเมลของนิสิต</h3>
                        </div>
                    </div>

                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:3%;">ส่งอีเมลให้นิสิตเมื่อนิสิตขาดเรียน <b style="color:orange"><?php echo $_SESSION["LevelOrange"];?></b> ครั้ง</h4>

                        <input id="CheckEmailStudentOne" type="checkbox" class="myinput large" 
                        style="margin-left: 5.4%;" name="EmailStudentOne" value="checked" <?php echo $_SESSION["StatusEmailStudentOne"];?> onclick=""/>
                    </div>

                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:3%;">ส่งอีเมลให้นิสิตเมื่อนิสิตขาดเรียน <b style="color:red"><?php echo $_SESSION["LevelRed"];?></b> ครั้ง</h4>

                        <input id="CheckEmailStudentTwo" type="checkbox" class="myinput large" 
                        style="margin-left: 5.4%;" name="EmailStudentTwo" value="checked" <?php echo $_SESSION["StatusEmailStudentTwo"];?> onclick=""/>
                    </div>

                    <div class="columns">
   
                        <h4 style="margin-left: 1%; margin-right:3%;">ส่งอีเมลให้นิสิตเมื่อนิสิตขาดเรียนเกิน <b style="color:red"><?php echo $_SESSION["LevelRed"];?></b> ครั้ง</h4>

                        <input id="CheckEmailStudentThree" type="checkbox" class="myinput large"   style="margin-left: 2.5%;" name="EmailStudentThree" value="checked" <?php echo $_SESSION["StatusEmailStudentThree"];?> onclick=""/>
                    </div>
                    
                    <button class="small-v3" name="SaveChange" style="margin-left: 1%; margin-top:3%; width: 25%; height: 40px; background-color: #3366ff; color: white;" title="คลิกเพื่อบันทึกการเปลี่ยนแปลงของข้อมูล" onclick="document.Change.submit();">
                        <b style="padding-top: 10%; padding-bottom: 10%; font-size: 18px;" >บันทึกการเปลี่ยนแปลง</b>
                        <!--<svg class="menu-icon iconv-2-add-box"></svg>-->
                    </button>
                </form>

                </div>
            </div>
        </div>
</div>

<div id="ChangePassFormv.2" class="modal">
  
  <form class="modal-content animate" action="FChangePassword.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนรหัสผ่าน</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginNewPass"><b>New Password :</b></div>
        <input class="is-pulled-right input-field-v1-5" type="textRegis" name="new-password" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginCurPass"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1-5" type="password" name="curr-password" value="<?php echo $password; ?>" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginRepPass"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1-5"  type="password" name="rep-password" value="" autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePass"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


  <div id="ChangeEmail" class="modal">
  
  <form class="modal-content animate" action="FChangeEmail.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนอีเมล</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v2-5" type="textRegis" name="email" value="<?php echo $email; ?>" autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changeEmail"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>




</body>
</html>







