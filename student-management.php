<?php session_start();

include('condb.php');
$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$password = $_SESSION['Password'];

$_SESSION["IDTermStudent"] = $_SESSION["IDTermFirstStudent"];
$_SESSION["PaginationSelectStudent"] = 1;

$_SESSION["IDTerm"] = $_SESSION["IDTermFirst"];
$_SESSION["Pagination"] = 1;

$_SESSION["IDTermVacation"] = $_SESSION["IDTermFirstVacation"];
$_SESSION["CheckTermVacation"] = true;
$_SESSION["PaginationVacation"] = 1;

$_SESSION["IDTermCheck"] = $_SESSION["IDTermFirstCheck"];
$_SESSION["PaginationSelectCheck"] = 1;

$_SESSION["NumberCheckStudent"] = "";
$_SESSION["IDCheckStudent"] = "";
$_SESSION["NameCheckStudent"] = "";
$_SESSION["TimeCheckStudent"] = ""; 
$_SESSION["StatusCheckStudent"] = "";
$_SESSION["NumberAbsentCheckStudent"] = "";
$_SESSION["NumberLateStudent"] = "";
$_SESSION["ScoreDeductedCheckStudent"] = "";


$queryStudent= "SELECT * FROM `inacs_student` WHERE IDCourse='".$_SESSION["IDCourseInManaStudent"]."'";
$StudentTable = mysqli_query($con,$queryStudent);
$tableStudent = "";
$dataStudent = array();

if(mysqli_num_rows($StudentTable) > 0){
  while ($row = mysqli_fetch_assoc($StudentTable)) {
      array_push($dataStudent,array($row['Number'],$row['Name'],$row['Branch'],$row['ID']));
  }
}

sort($dataStudent);

if(mysqli_num_rows($StudentTable) > 0){
  for ($x = 0; $x < 8; $x+=1) {
    $page = ($_SESSION["PaginationStudent"]-1) * 8;
    $rowNumber=$dataStudent[$x+$page][0];
    $rowName=$dataStudent[$x+$page][1];
    $rowBranch=$dataStudent[$x+$page][2];
    $rowID=$dataStudent[$x+$page][3];

    $SequenceStudent = $x+$page+1;

    $tableStudent  = $tableStudent."<tr>";
    $tableStudent  = $tableStudent."<td>$SequenceStudent</td>";
    $tableStudent  = $tableStudent."<td>$rowNumber</td>";
    $tableStudent  = $tableStudent."<td>$rowName</td>";
    $tableStudent  = $tableStudent."<td>$rowBranch</td>";
    $tableStudent  = $tableStudent."<td style=cursor:pointer; ><button name=editStudentModal class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;แก้ไขข้อมูลนิสิต value=$rowID>edit</button></td>";
    $tableStudent  = $tableStudent."<td style=cursor:pointer; > <button name=deleteStudentModal  class=material-icons title=คลิกเพื่อแสดงหน้า&nbsp;form&nbsp;ลบข้อมูลนิสิต value=$rowID>remove_circle_outline</button> </td>";
    $tableStudent  = $tableStudent."</tr>";

    if($x+$page >= count($dataStudent)-1){
        break;
    }
  }
}

CreatePagination(mysqli_num_rows($StudentTable));
$_SESSION["StudentTable"] = $tableStudent;

?>
<?php
include('h.php');
include('condb.php');

function CreatePagination($CourseNum){

  $lastPage = 0;
  if($_SESSION["PaginationStudent"] == 1){
      $Pagination = $Pagination."<input type=submit name=PaginationStudent value=&laquo; disabled></input>";
  }else{
      $Pagination = $Pagination."<input type=submit name=PaginationStudent title=คลิกเพื่อย้อนกลับไปตารางก่อนหน้า value=&laquo; ></input>";
  }
  
  for ($x = 0; $x*8 < $CourseNum;) {
      $x+=1;
      if($_SESSION["PaginationStudent"] == $x){
          $Pagination = $Pagination."<input type=submit name=PaginationStudent title=คลิกเพื่อไปตารางหน้า&nbsp;$x class=active value=$x ></input>";
      }else{
          $Pagination = $Pagination."<input type=submit name=PaginationStudent title=คลิกเพื่อไปตารางหน้า&nbsp;$x  value=$x ></input>";
      }
      $lastPage = $x;
  }

  if($_SESSION["PaginationStudent"] == $lastPage || ($_SESSION["PaginationStudent"] == 1 && $lastPage == 0)){
      $Pagination = $Pagination."<input type=submit name=PaginationStudent value=&raquo; disabled></input>";
  }else{
      $Pagination = $Pagination."<input type=submit name=PaginationStudent title=คลิกเพื่อไปตารางถัดไป value=&raquo; ></input>";
  }
  
  return $_SESSION["PaginationStudentTable"] = $Pagination;
}
?>

<body>
<style>
    

</style>


<div class="navbar-div">
        <nav class="navbarv-2 is-dodgerblue" aria-label="main navigation">
            <a class="navbar-item banner">
                <div>
                    <span class="navbar-banner-text">InACS</span>
                </div>
            </a>
            <button id="navbar-user" name="navUser" class="navbar-item user" onclick="if (document.getElementById('navbar-dropdown').classList.contains('is-active'))  return document.getElementById('navbar-dropdown').classList.remove('is-active'); else return document.getElementById('navbar-dropdown').classList.add('is-active');">
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
                <a href="select-course-student.php" class="is-black-blue">
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
                    <svg class="menu-icon-topic iconv-2-student-cap"></svg>จัดการนิสิต
                </div>
                <div class="box">
                <div class="columns">
                    <div class="column is-8">
                        <br>
                        <div class="set-flex" style="margin-bottom: 1%;">
                            <div style="font-size: 18px; width: 61%;"><b><?php echo $_SESSION["NumCourseInManaStudent"] ?> : <?php echo $_SESSION["NameCourseInManaStudent"] ?></b></div>
                            <div style="font-size: 18px;  width: 24%;"><b>กลุ่มเรียน :</b> <?php echo $_SESSION["GroupCourseInManaStudent"] ?></div>
                            <div style="font-size: 18px;"><b>ประเภท :</b> <?php echo $_SESSION["TypeCourseInManaStudent"] ?></div>
                        </div>
                        <div class="set-flex">

                            <form name="AddGroup" action="FManagementStudent.php" method="post" style="width: 12%; height: 2%; margin-bottom: 0%; margin-top: 0.9%; margin-right: 76%;">
                            <button class="small-v3" name="addGroupStudentModal" style="width: 100%; height: 100%;" onclick="document.AddGroup.submit();" title="คลิกเพื่อแสดงหน้า form เพิ่มข้อมูลนิสิตแบบกลุ่ม">
                            <i class="material-icons" style="margin-top: 4%; margin-bottom: 4%; font-size: 30px;" >group_add</i></button>
                            </form>

                            <form name="Add" action="FManagementStudent.php" method="post" style="width: 12%; height: 2%; margin-bottom: 0%; margin-top: 0.9%;">
                            <button class="small-v3" name="addStudentModal" style=" width: 100%; height: 100%;" onclick="document.Add.submit();" title="คลิกเพื่อแสดงหน้า form เพิ่มข้อมูลนิสิต">
                            <i class="material-icons" style="margin-top: 4%; margin-bottom: 4%; font-size: 30px;" >add_circle_outline</i></button>
                            </form>

                            <!--<button class="small-v2" style="margin-right: 0.4%;" onclick="document.getElementById('EditStudent').style.display='block'"><i class="material-icons" style="margin-top: 7%; margin-bottom: 7%;">edit</i></button>
                            <button class="small-v2" style="margin-right: 8.5%;" onclick="document.getElementById('DeleteStudent').style.display='block'"><i class="material-icons" style="margin-top:  7%; margin-bottom: 7%;">remove_circle_outline</i></button>-->
                            
                            <!--<button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_left</i></button>
                            <button class="small-v2"><i class="material-icons" style="margin-top: 7%;">chevron_right</i></button>-->
                        </div>
                        <br>
                        <table id="table-no-click">
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสนิสิต</th>
                                <th>ชื่อนิสิต</th>
                                <th>สาขา</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            <form name="EditOrDelete" action="FManagementStudent.php" method="post" style="margin-bottom: 0%;">
                            <?php
                                echo $_SESSION["StudentTable"] ;
                            ?>
                            </form>
                        </table>
                        <div class="pagination" style="width: 100%; text-align: center;">
                            <div style="display: inline-block;">
                            <form name="changePagination" action="FManagementStudent.php" method="post" style="margin-bottom: 0%;">
                                <?php
                                    echo $_SESSION["PaginationStudentTable"] ;
                                ?>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>

<div id="ChangePassFormv.2" class="modal">
  
  <form class="modal-content animate" action="FChangePassword.php" method="post">

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



<?php if($_SESSION['CheckOpenModalAddStudentGroup'] == true){ ?>
<div id="AddGroupStudent" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FManagementStudent.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เพิ่มข้อมูลนิสิตแบบกลุ่ม</h3>

    <div class="input-textRegis">
            <div class="sizeText maginTextarea"><b>ข้อมูลนิสิต :</b></div>
            <textarea name="dataStudent" rows="19" cols="44" class="is-pulled-right" type="textRegis" placeholder="รหัสนิสิต คำนำหน้า ชื่อจริง นามสกุล สาขา" value="" ></textarea>
    </div>

  <div class="button-zone">
  <button class="register" name="addGroupStudent"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('AddGroupStudent').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19.1%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalAddStudentGroup'] = false;
} ?>



<?php if($_SESSION['CheckOpenModalAddStudent'] == true){ ?>
<div id="AddStudent" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FManagementStudent.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เพิ่มข้อมูลนิสิต</h3>

    <div class="input-textRegis">
            <div class="sizeText maginNumStudent"><b>รหัสนิสิต :</b></div>
            <input class="is-pulled-right input-field-v6" type="textRegis" name="NumStudent" value="" >
    </div>

    <div class="input-textRegis">
            <div class="sizeText maginNameStudent"><b>ชื่อนิสิต :</b></div>
            <input class="is-pulled-right input-field-v6" type="textRegis" name="NameStudent" value="" >
    </div>

    <div class="input-textRegis">
            <div class="sizeText magirBanchStudent"><b>สาขา :</b></div>
            <input class="is-pulled-right input-field-v6" type="textRegis" name="BranchStudent" value="" >
    </div>

  <div class="button-zone">
  <button type="submit" class="register" name="addStudent"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('AddStudent').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19.1%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalAddStudent'] = false;
} ?>



<?php if($_SESSION['CheckOpenModalEditStudent'] == true){ ?>
<div id="EditStudent" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FManagementStudent.php" method="post">

    <h3 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">แก้ไขข้อมูลนิสิต</h3>

    <div class="input-textRegis">
            <div class="sizeText maginNumStudent"><b>รหัสนิสิต :</b></div>
            <input class="is-pulled-right input-field-v6" type="textRegis" name="NumStudent" value="<?php echo $_SESSION['NumberStudentEdit']; ?>" >
    </div>

    <div class="input-textRegis">
            <div class="sizeText maginNameStudent"><b>ชื่อนิสิต :</b></div>
            <input class="is-pulled-right input-field-v6" type="textRegis" name="NameStudent" value="<?php echo $_SESSION['NameStudentEdit']; ?>" >
    </div>

    <div class="input-textRegis">
            <div class="sizeText magirBanchStudent"><b>สาขา :</b></div>
            <input class="is-pulled-right input-field-v6" type="textRegis" name="BranchStudent" value="<?php echo $_SESSION['BranchStudentEdit']; ?>" >
    </div>

  <div class="button-course-zone">
  <button type="submit" class="register" name="editStudent"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('EditStudent').style.display='none'" class="register register-cancle is-red" style="margin: 0% 0% 0% 19.1%;"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalEditStudent'] = false;
} ?>



<?php if($_SESSION['CheckOpenModalDeleteStudent'] == true){ ?>
<div id="DeleteStudent" class="modal" style="display: block;">
  
  <form class="modal-content animate" action="FManagementStudent.php" method="post">

    <h3 class="text-topic" align="center">ต้องการลบข้อมูลนิสิตหรือไม่ ?</h3>
    <br>

  <div class="button-zone">
  <button class="register" name="deleteStudent"><b>ใช่</b></button>
  <button type="button" onclick="document.getElementById('DeleteStudent').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>
<?php 
$_SESSION['CheckOpenModalDeleteStudent'] = false;
} ?>


</body>
</html>







