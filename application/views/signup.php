<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>HolidayGram</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"
        type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js"
        type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/verify.css">

</head>

<body>
    <div class="logodiv"><img class="logoimage" src="<?php echo base_url() ?>images/logo.png" alt="Logo" /> </div>

    <div class="signform">
        <form class="authforms" name="signupform">
            <div class="errormsg" id="errormsg"></div>
            <div class="input">
                <input class="signfield" type=text id="username" name='username'
                    onkeyup='checkusername(); checkinputs();' required />
                <label class="signlabel">Username <span style="color:#EB9494">*</span></label>
            </div>
            <div class="input">
                <input class="signfield" type=text id="email" name='email' onkeyup='checkinputs(); validateemail()'
                    required />
                <label class="signlabel">Email <span style="color:#EB9494">*</span></label>
            </div>
            <div class="input">
                <input class="signfield" type=text id="name" name='name' onkeyup='checkinputs();' required />
                <label class="signlabel">Name</label>
            </div>
            <div class="input">
                <input class="signfield" type=password id="password" name='password' onkeyup='checkinputs();'
                    required />
                <label class="signlabel">Password <span style="color:#EB9494">*</span></label>
            </div>
            <div class="action">
                <input class="signupbtn" type=submit id="createUser" disabled="disabled" value="SIGN UP" />
            </div>
        </form>
        <div class="signspandiv">
            <span>Already have an account? <a href="<?php echo base_url() ?>index.php/users/login">Login</a> </span>
        </div>
    </div>

    <script type="text/javascript" lang="javascript">
    //check if required inputs are empty
    function checkinputs() {
        if (document.forms["signupform"]["username"].value != "" && document.forms["signupform"]["email"].value != "" &&
            document.forms["signupform"]["password"].value != "" && document.getElementById("errormsg").innerHTML == "") {
            document.getElementById('createUser').disabled = false;
        }
        else{
            document.getElementById('createUser').disabled = true;
        }
    }
    function validateemail() {//valid email before sending through api
        var x = document.forms["signupform"]["email"].value;
        var atposition = x.indexOf("@");
        var dotposition = x.lastIndexOf(".");
        if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= x.length) {
            document.getElementById("errormsg").innerHTML = "Please enter a valid e-mail address";
        }
        else {
            document.getElementById("errormsg").innerHTML = "";
            checkinputs();
        }
    }
    function checkusername() {//check if the username is taken or not
        $.ajax({
            url: "<?php echo base_url() ?>index.php/users/user/action/checkuser",
            data: { 'username': "@" + $('#username').val().toLowerCase() },
            method: "POST"
        }).done(function (data) {
            if (data == 0) {
                document.getElementById("errormsg").innerHTML = "";
                checkinputs();
            }
            else {
                document.getElementById("errormsg").innerHTML = "Username Already Exists!"
            }
        });
    }
    $(document).ready(function () {
        $('#createUser').click(function (event) {//call function when button is clicked
            event.preventDefault();
            userSignup();
        });
    });
    var User = Backbone.Model.extend({
        url: "<?php echo base_url() ?>index.php/users/user/action/signup"
    });
    var UserCollection = Backbone.Collection.extend({
        model: User
    });
    var usersCollection = new UserCollection();
    function userSignup() {
        var newUser = new User();
        newUser.set('username', "@" + $("#username").val().toLowerCase());
        newUser.set('email', $("#email").val());
        newUser.set('name', $("#name").val());
        newUser.set('password', $("#password").val());
        usersCollection.create(newUser, {
            success: function () {//redirect to login on success
                location.href = "<?php echo base_url() ?>index.php/users/login";
            }
        });
    }
    </script>
</body>

</html>