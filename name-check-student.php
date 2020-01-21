<?php session_start();

$_SESSION["IDTerm"] = $_SESSION["IDTermFirst"];
$_SESSION["Pagination"] = 1;

$_SESSION["IDTermStudent"] = $_SESSION["IDTermFirstStudent"];
$_SESSION["PaginationSelectStudent"] = 1;

$_SESSION["IDTermVacation"] = $_SESSION["IDTermFirstVacation"];
$_SESSION["CheckTermVacation"] = true;
$_SESSION["PaginationVacation"] = 1;

$_SESSION["IDTermCheck"] = $_SESSION["IDTermFirstCheck"];
$_SESSION["PaginationSelectCheck"] = 1;

$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];




?>
<?php
include('h.php');
?>

<body>
<style>

.input-field-v8-2{
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 1px;
  padding-bottom: 1px;
  outline: none;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

</style>


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
                      <i class="iconv-2-cog"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนรหัสผ่าน</div>
                    </a>
                    <a onclick="document.getElementById('ChangeEmail').style.display='block'">
                    <i class="iconv-2-a"></i>
                      <div class="maginTextNavbar-dropdown">เปลี่ยนอีเมล</div>
                    </a>
                    <a href="login.php">
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
                <a href="select-course-check.php"  class="is-black-blue">
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
                <a href="login.php">
                <svg class="menu-icon iconv-2-logout"></svg>ออกจากระบบ
                </a>
            </li>
        </ul>
    </nav>

<div class="subcontent-area">
        <div class="subcontent-main-div index">
            <div class="box with-title is-round">
                <div class="box-title is-dodgerblue">
                    <svg class="menu-icon-topic iconv-2-check"></svg>เช็คชื่อนิสิต
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-8">
                        <br>
                        <div class="set-flex" style="margin-bottom: 1%;">
                            <div style="font-size: 18px; margin-top: 0.5%; margin-right: 1%;"><b><?php echo $_SESSION["NumCourseInCheckStudent"]; ?> :</b></div>
                            <div style="font-size: 18px; margin-top: 0.5%; width: 49.5%;"><b><?php echo $_SESSION["NameCourseInCheckStudent"]; ?></b></div>
                            <div style="font-size: 18px; margin-top: 0.5%; width: 24%;"><b>กลุ่มเรียน :</b> <?php echo $_SESSION["TypeCourseInCheckStudent"] ?></div>
                            <div style="font-size: 18px; margin-top: 0.5%; margin-right: 2%;"><b>ครั้งที่ :</b><?php echo $_SESSION["NumberCheckCourseInCheckStudent"]; ?></div>
                        </div>
                        <div class="set-flex" style="margin-top: 2%;">
                            <form name="Check" action="FCheckNameStudent.php" method="post" style="margin-right: 1.5%;  margin-bottom: 0%; width: 83%;">
                                <input class="is-pulled-right" name="CheckName" style="text-align: center; font-size: 24px; width: 100%; height: 100%" type="textRegis" value="" 
                                autocomplete=off autofocus>
                            </form>
                        <form name="SaveCheck" action="FCheckNameStudent.php" method="post" >
                            <button class="small-v3" style="margin-top: 0%; width: 135px; height: 45px;" name="saveDataCheck" onclick="document.SaveCheck.submit();">
                                <i class="material-icons" style="font-size: 40px;">save</i>
                            </button>
                        </form>
                        </div>
                        <div class="set-flex" style="margin-bottom: 1%;">
                            <div style="font-size: 16px; margin-top: 2%; margin-right: 1%;"><b>หักคะแนน (เครื่องแต่งกาย/ลืมบัตรนิสิต) :</b></div>

                            <form name="SaveScoreDeducted" action="FCheckNameStudent.php" method="post" style="margin-top: 1.5%; margin-right: 6%; width: 15%; height: 35px;" >
                            <input class="is-pulled-right input-field-v8-2" type="textRegis" name="scoreDeducted" value="" style="width: 100%; height: 100%"></form>

                            <div style="font-size: 16px; margin-top: 2%; margin-right: 1%;"><b>คะแนนเพิ่มพิเศษ :</b></div>

                            <form name="SaveScoreExtra" action="FCheckNameStudent.php" method="post" style="margin-top: 1.5%; width: 15%; height: 35px;" >
                            <input class="is-pulled-right input-field-v8-2" type="textRegis" name="scoreExtra" value="" style="width: 100%; height: 100%"></form>

                        </div>
                        <div class="set-flex" >
                            <div class ="maginLeft-check" style="font-size: 18px; margin-top: 2%; margin-right: 12.2%;"><b>รหัสนิสิต :</b></div>
                            <div class="div-check" style="font-size: 18px; margin-top: 1%;">
                               <b><?php echo $_SESSION["NumberCheckStudent"]; ?></b>
                            </div>
                        </div>
                        <div class="set-flex" >
                            <div class ="maginLeft-check" style="font-size: 18px; margin-top: 2%; margin-right: 13.1%;"><b>ชื่อนิสิต :</b></div>
                            <div class="div-check" style="font-size: 18px; margin-top: 1%;">
                               <b><?php echo $_SESSION["NameCheckStudent"]; ?></b>
                            </div>
                        </div>
                        <div class="set-flex" >
                            <div class ="maginLeft-check" style="font-size: 18px; margin-top: 2%; margin-right: 8.2%;"><b>เวลาที่เช็คชื่อ :</b></div>
                            <div class="div-check" style="font-size: 18px; margin-top: 1%;">
                               <b><?php echo $_SESSION["TimeCheckStudent"]; ?></b>
                            </div>
                        </div>
                        <div class="set-flex" >
                            <div class ="maginLeft-check" style="font-size: 18px; margin-top: 2%; margin-right: 13.9%;"><b>สถานะ :</b></div>
                            <div class="div-check" style="font-size: 18px; margin-top: 1%;">
                               <b><?php echo $_SESSION["StatusCheckStudent"]; ?></b>
                            </div>
                        </div>
                        <div class="set-flex">
                            <div class ="maginLeft-check" style="font-size: 18px; margin-top: 2%; margin-right: 1%;"><b>จำนวนครั้งที่ขาดเรียน :</b></div>
                            <div class="div-check" style="font-size: 18px; margin-top: 1%;">
                                <b><?php echo $_SESSION["NumberAbsentCheckStudent"]; ?></b>
                            </div>
                        </div>
                        <div class="set-flex" >
                            <div class ="maginLeft-check" style="font-size: 18px; margin-top: 2%; margin-right: 3.1%;"><b>จำนวนครั้งที่มาสาย :</b></div>
                            <div class="div-check" style="font-size: 18px; margin-top: 1%;">
                                <b><?php echo $_SESSION["NumberLateStudent"]; ?></b>
                            </div>
                        </div>
                        <div class="set-flex" >
                            <div class ="maginLeft-check" style="font-size: 18px; margin-top: 2%; margin-right: 3.6%; "><b>จำนวนคะแนนที่หัก :</b></div>
                            <div class="div-check" style="font-size: 18px; margin-top: 1%;">
                                <b><?php echo $_SESSION["ScoreDeductedCheckStudent"]; ?></b>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>

<div id="ChangePassFormv.2" class="modal">
  
  <form class="modal-content animate"  action="FChangePassword.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนรหัสผ่าน</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginNewPass"><b>New Password :</b></div>
        <input class="is-pulled-right input-field-v1-5" type="textRegis" name="new-password" value="" autocomplete=off>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginCurPass"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1-5" type="password" name="curr-password" value="<?php echo $password; ?>" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginRepPass"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1-5"  type="password" name="rep-password" value="" autocomplete=off>
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePass"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19.2%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


  <div id="ChangeEmail" class="modal">
  
  <form class="modal-content animate" action="FChangeEmail.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนอีเมล</h2>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v2-5" type="textRegis" name="email" value="<?php echo $email; ?>" autocomplete=off>
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changeEmail"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>



</body>
</html>







