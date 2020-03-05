<?php session_start();

$clear = "";
?>
<?php
include('h.php');
?>

<body>


<div class="layout-full page-login widthImage-login" >
<div class="two-tone-one">
    <div>
		<div class="logo">
			<img class="brand-img" src="./pic/calendar-check-logo.png" alt="...">
		</div>
		<div class="logo-name">
			<img class="brand-img" src="./pic/name-logo-black.png" alt="...">
		</div>
	</div>

</div>


<div class="two-tone-two">
  <!--<div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="avatar">
  </div>-->

  <div class="container">
    <h3 class="psw">Log In</h3>

    <!--<label for="uname"><b>Username</b></label><br>-->
    <div class="form-material">

    <!--<label class="floating-label" for="inputUsername">
      <i aria-hidden="true"></i>&nbsp;&nbsp;Username
    </label>-->

    <!--<i class="material-icons">person</i>-->
    <form  action="checklogin.php" method="POST">
    <input class="form-material form-material.form fontAwesome input-login" type="text" placeholder="&#61447;  Username"  name="username" >
    </div>

    <!--<label for="psw"><b>Password</b></label><br>-->
    <div class="form-material">

    <!--<label class="floating-label" for="inputPassword">
      <i aria-hidden="true"></i>&nbsp;&nbsp;Password
    </label>-->
    
    <input class="form-material form-material.form fontAwesome input-login" type="password" placeholder="&#61475;   Password" name="password" >
    </div>

    <span class="psw"><a href="#" onclick="document.getElementById('ChangePassForm').style.display='block'">Forgot password?</a></span>

    <button type="login" onClick="document.location.href='checklogin.php'"><b>Login</b></button>
    </form>
    <button onclick="document.getElementById('RegisterForm').style.display='block'" type="register" ><b>Register</b></button>

  </div>
  </div>
</div>



<div id="id01" class="modal">
  
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <h2 class="text-topic" align="center">สมัครสมาชิก</h2>
    
  <div class="input-container">
    <i class="material-icons icon">portrait</i>
    <input class="input-field" type="textRegis" placeholder="Name" name="usrnm">
  </div>

  <div class="input-container">
    <i class="material-icons icon">email</i>
    <input class="input-field" type="textRegis" placeholder="Email" name="email">
  </div>

  <div class="input-container">
    <i class="material-icons icon">person</i>
    <input class="input-field" type="textRegis" placeholder="Username" name="usrnm">
  </div>
  
  <div class="input-container">
    <i class="material-icons icon">lock</i>
    <input class="input-field" type="textRegis" placeholder="Password" name="psw">
  </div>

  <div class="input-container">
    <i class="material-icons icon">vpn_key</i>
    <input class="input-field" type="textRegis" placeholder="Confrim-Password" name="psw">
  </div>

  <div class="button-zone">
  <button class="register"><b>สมัครสมาชิก</button>
  <button type="button" onclick="document.getElementById('id01').style.display='none'" class="register register-cancle"><b>ยกเลิก</button>
  </div>

  </form>
</div>


<div id="RegisterForm" class="modal">

  <form class="modal-content animate" action="FRegister.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">สมัครสมาชิก</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginName"><b>ชื่อ-สกุล :</b></div>
        <input class="is-pulled-right input-field-v1 " type="textRegis" name="nameRegis" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginEmail"><b>E-mail :</b></div>
        <input class="is-pulled-right input-field-v1 " type="textRegis" name="emailRegis" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginUser"><b>Username :</b></div>
        <input class="is-pulled-right input-field-v1 " type="textRegis" name="usernameRegis" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginPass"><b>Password :</b></div>
        <input class="is-pulled-right input-field-v1 " type="password" name="passwordRegis" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginConPass"><b>Confirm Password : </b></div>
        <input class="is-pulled-right input-field-v1"  type="password" name="corn-passwordRegis" value=""autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="register"><b>สมัครสมาชิก</b></button>
  <button type="button" onclick="document.getElementById('RegisterForm').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>


<div id="ChangePassForm" class="modal">
  
  <form class="modal-content animate" action="FChangePassword.php" method="post">

    <h2 class="text-topic" align="center" style="margin-bottom:3%;margin-top:3%;">เปลี่ยนรหัสผ่าน</h2> 

  <div class="input-textRegis">
        <div class="sizeText maginUser"><b>Username :</b></div>
        <input class="is-pulled-right input-field-v1 " type="textRegis" name="username-change" value="" autocomplete=off  >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginNewPass"><b>New Password :</b></div>
        <input class="is-pulled-right input-field-v1 " type="textRegis" name="new-password" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginCurPass"><b>Current Password :</b></div>
        <input class="is-pulled-right input-field-v1 " type="password" name="current-password" value="" autocomplete=off >
  </div>

  <div class="input-textRegis">
        <div class="sizeText maginRepPass"><b>Repeat Password :</b></div>
        <input class="is-pulled-right input-field-v1"  type="password" name="repeat-password" value=""autocomplete=off >
  </div>

  <div class="button-zone">
  <button type="submit" class="register" name="changePassLogin"><b>บันทึก</b></button>
  <button type="button" onclick="document.getElementById('ChangePassForm').style.display='none'" class="register register-cancle is-red"><b>ยกเลิก</b></button>
  </div>
  </form>
</div>

    

</body>
</html>







