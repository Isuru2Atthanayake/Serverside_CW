<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>QuestEdu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../../css/verify.css">

</head>
<body>

<div class="pwform">
    <!--    this does the passwordreset using the username and newpassword -->
    <div class="pwdresetheading"><span>RESET PASSWORD</span></div>
    <div class="errmsg" id="errmsg"></div>
    <form class="authenticateform" name="loginform">
        <div class="input">
            <input class="logfield" type=text id="username" name='username' onkeyup='checkuserinputs();' required/>
            <label class="loginlbl">Username<span style="color:#EB9494">*</label>
        </div>
        <div class="input">
            <input class="logfield" type=password id="password" name='password' onkeyup='checkuserinputs();' required/>
            <label class="loginlbl">New Password<span style="color:#EB9494">*</label>
        </div>
        <div class="action">
            <input class="loginbtn" type=submit disabled="disabled" id="changepw" value="RESET" />
        </div>
    </form>

    <div class="logintxtdiv">
        <span>Or <a href="<?php echo base_url()?>index.php/users/signup">Sign Up</a> here</span>
    </div>
</div>

<script type="text/javascript" lang="javascript">
//check inputs to see if theyre are empty if the inputs are not empty, the button is enabled
function checkuserinputs() {
    if (document.forms["loginform"]["username"].value != "" && document.forms["loginform"]["password"].value != "") {
        document.getElementById('changepw').disabled = false;
    }
    else{
        document.getElementById('changepw').disabled = true;
    }
}


//this is used to reset the password when the reset button is clicked
$("#changepw").click(function(event) {
    event.preventDefault();
    var pwdata = {
        username: "@" + $('#username').val().toLowerCase(),
        password: $('#password').val()
    };
    $.ajax({//this is used to send the data to the database to reset the password
        url: "<?php echo base_url() ?>index.php/users/user/action/passwordreset",
        data: JSON.stringify(pwdata),
        contentType: "application/json",
        method: "POST"
    }).done(function (data) {//this is used to display the error message if the username is not valid
        var result = data.result;
        if (result == "success") {
            location.href = "<?php echo base_url() ?>index.php/users/login";
        }
        else if (result == "logged") {//if result is logged, means user is changing pw while logged in
            location.href = "<?php echo base_url() ?>index.php/myprofile";
        }
        else {
            document.getElementById("errmsg").innerHTML = "Username Doesn't Exist!"
        }
    });
    });
</script>
</body>
</html>