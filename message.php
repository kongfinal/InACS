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
?>
<?php
include('h.php');
?>

<body>
<style>
    

</style>

<?php

if(isset($_POST['changePass'])){
  if (empty($_POST["new-password"])) {
    echo "<script type='text/javascript'>alert('New Password is required');</script>";
  } else if (empty($_POST["curr-password"])) {
    echo "<script type='text/javascript'>alert('Current Password is required');</script>";
  } else if (empty($_POST["rep-password"])) {
    echo "<script type='text/javascript'>alert('Repeat Password is required');</script>";
  } else{
    $new = trim(htmlspecialchars($_POST['new-password']));
    $current = trim(htmlspecialchars($_POST['curr-password']));
    $repeat = trim(htmlspecialchars($_POST['rep-password']));
    if ($new !== $repeat) {
      echo "<script type='text/javascript'>alert('New Password not same Repeat Password');</script>";
    }else if($current === $new) {
      echo "<script type='text/javascript'>alert('New Password same Current Password');</script>";
    }
  }
}

if(isset($_POST['changeEmail'])){
  if (empty($_POST["email"])) {
    echo "<script type='text/javascript'>alert('Email is required');</script>";
  }else {
    $email = trim(htmlspecialchars($_POST['email']));
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
      echo "<script type='text/javascript'>alert('Invalid Email');</script>";
    }
  }
}

?>

<div class="navbar-div">
        <nav class="navbarv-2 is-dodgerblue" aria-label="main navigation">
            <a class="navbar-item banner">
                <div>
                    <span class="navbar-banner-text">InACS</span>
                </div>
            </a>
            <button id="navbar-user" class="navbar-item user" onclick="switchNavBarDropDown()">
                <div class="user-container">
                    <svg class="navbar-user-iconv-2 iconv-2-user iconv-2-size-5"></svg>
                    <span class="navbar-user-text">Teacher Name</span>
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
                <a href="message.php" class="is-black-blue">
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
                    <svg class="menu-icon-topic iconv-2-mail"></svg>ข้อความ
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-2">
                    <br>
                    <div class="div-message">
                        <button class="message" onClick="document.location.href='message.php'"><b>ข้อความทั้งหมด</b></button><br>
                        <button class="message-no-click" onClick="document.location.href='message-star.php'"><b>ติดดาว</b></button><br>
                        <button class="message-no-click" onClick="document.location.href='message-bin.php'"><b>ถังขยะ</b></button><br>
                        <br><br><br><br><br>
                    </div>
                    </div>
                    <div class="column is-6">
                    <br>
                    <div class="set-flex">
                        <h4 style="padding-top: 0; margin-top: 1.5%; margin-left: 3%; margin-right: 40%;">ข้อความทั้งหมด</h4>
                        <button class="small"><i class="material-icons">star</i></button>
                        <button class="small" style="margin-right: 8.5%;"><i class="material-icons">delete</i></button>
                        <button class="small"><i class="material-icons">chevron_left</i></button>
                        <button class="small"><i class="material-icons">chevron_right</i></button>
                    </div>
                    <table class="table-message" id="table-starter" style="margin-top: 1.5%; margin-left: 3%; width:97%;">
                        <tr>
                            <th>วันที่ส่ง</th>
                            <th>เรื่อง</th>
                        </tr>
                        <tr ondblclick="document.getElementById('MessageDetail').style.display='block'">
                            <td>7/12/2019</td>
                            <td>นิสิตขาดเรียนเกิน 3 ครั้ง</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>

<div id="ChangePassFormv.2" class="modal">
  
  <form class="modal-content animate" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนรหัสผ่าน</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginNewPass"><b>New Password :</b></div>
        <input class="is-pulled-right input-field-v1 " type="textRegis" name="new-password" value="" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginCurPass"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1 " type="password" name="curr-password" value="" >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginRepPass"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1"  type="password" name="rep-password" value="">
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePass"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassFormv.2').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


  <div id="ChangeEmail" class="modal">
  
  <form class="modal-content animate" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนอีเมล</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v2" type="textRegis" name="email" value="" >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changeEmail"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangeEmail').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>

<div id="MessageDetail" class="modal">
  
  <form class="modal-content animate" action="/action_page.php" method="post">

    <h2 class="text-topic" align="center">ข้อความ</h2>
    
  <div class="input-container"></div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>วันที่ส่ง :</b></div>
        <div class="sizeText maginChangEmail">7/12/2019</div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>เรื่อง :</b></div>
        <div class="sizeText maginChangEmail">นิสิตขาดเรียนเกิน 3 ครั้ง</div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>ชื่อวิชา :</b></div>
        <div class="sizeText maginChangEmail">Web Programming</div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>รหัสนิสิต :</b></div>
        <div class="sizeText maginChangEmail">59160000</div>
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginChangEmail"><b>ชื่อนิสิต :</b></div>
        <div class="sizeText maginChangEmail">นาย กกกก ขขขขขข</div>
  </div>

  <div class="button-zone">
  <button type="button" onclick="document.getElementById('MessageDetail').style.display='none'" class="cancel"><b>ออก</b></button>
  </div>
  </form>
</div>


<script>
var modalChangePass = document.getElementById('ChangePassFormv.2');
var modalChangeEmail = document.getElementById('ChangeEmail');
var modalMessageDetail = document.getElementById('MessageDetail');

window.onclick = function(event) {
    if(event.target == modalChangePass) {
        modalChangePass.style.display = "none";
    }else if(event.target == modalChangeEmail) {
        modalChangeEmail.style.display = "none";
    }else if(event.target == modalChangeEmail) {
        modalMessageDetail.style.display = "none";
    }
}

function switchNavBarDropDown() {
    var dropdown = document.getElementById('navbar-dropdown');
    if (dropdown.classList.contains('is-active')) {
        dropdown.classList.remove('is-active');
    } else {
        dropdown.classList.add('is-active');
    }
}
</script>

</body>
</html>







