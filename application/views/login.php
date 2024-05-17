<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>QuestEdu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/verify.css">
</head>

<body>
<div class="weblogodiv"><img class="logoimage" src="<?php echo base_url()?>images/logo.png" alt="Logo"/> </div>

<div class="loginform">
    <div class="loginheading"><span>LOGIN</span></div>
    <!-- error message if necessary -->
    <?php if (isset($login_error_msg)) { ?>
    <div class="errmsg">
        <?php echo $login_error_msg ?> 
    </div> <?php } ?>

    <form class="authenticateform" name="loginform">
        <div class="input">
            <input class="logfield" type=text id="username" name='username' onkeyup='checkinputs();' required/>
            <label class="loginlbl">Username<span style="color:#EB9494">*</span></label>
        </div>
        <div class="input">
            <input class="logfield" type=password id="password" name='password' onkeyup='checkinputs();' required/>
            <label class="loginlbl">Password<span style="color:#EB9494">*</span></label>
        </div>

        <div class="action">
            <input class="loginbtn" type=submit disabled="disabled" id="login" value="LOGIN" />
        </div>
    </form>

    <div class="logintxtdiv">
        <a href="<?php echo base_url()?>index.php/users/passwordreset">Forgot Password?</a><br>
        <span>Don't have an account? <a href="<?php echo base_url()?>index.php/users/signup">Sign Up</a> here </span>
    </div>
</div>

    <script type="text/javascript" lang="javascript">
        //check if all inputs are not empty
        function checkinputs() {
            if (document.forms["loginform"]["username"].value != "" && document.forms["loginform"]["password"].value != "") {
                document.getElementById('login').disabled = false;
            }
            else{
                document.getElementById('login').disabled = true;
            }
        }
        $(document).ready(function () {
            //when login is clicked
            $('#login').click(function (event) {
                event.preventDefault();
                userLogin();
            });
        });
        var Login = Backbone.Model.extend({
            url:"<?php echo base_url()?>index.php/users/user/action/login"
        });
        var LoginCollection = Backbone.Collection.extend({
            model: Login,
        });
        var loginCollection = new LoginCollection();
        function userLogin() {
            var newLogin = new Login();
            newLogin.set('username', "@"+$("#username").val().toLowerCase());//username is converted to lowercase
            newLogin.set('password', $("#password").val());
            loginCollection.create(newLogin,{
                success: function(response){
                    var result=response.changed.result;
                    if (result=="success") {//redirect to home on success
                        location.href="<?php echo base_url()?>index.php/home/";  
                    } else {//else redirect back to login
                        location.href="<?php echo base_url()?>index.php/users/login";
                    }
                }
            });
        }
    </script>
</body>
</html>