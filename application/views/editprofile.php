<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/editprofile.css">
</head>

<body>

<!--this is the edit profile page which is used to edit the user profile details-->
<!--edit profile container-->
<div class="editpropiccontainer">
<!--    edit profile box-->
    <div class="editpro-box">
<!--        display the profile picture of the user-->
        <div class="propicdiv">
            <div class="errmsg" id="errmsg"></div>
            <div class="profimagediv"></div>
            <input type="file" id="image" name="image" onchange="readURL(this);" />
            <div class="selectpictxt">Select Profile Picture</div>
        </div>
        <div class="texteditdiv">
            <div class="errmsg" id="errmsg2"></div>
            <div class="namechngediv"></div>
            <div class="emailchangediv"></div>
            <div class="changepassdiv">
                <a class="styled-button changepw-button" href="<?php echo base_url()?>index.php/users/passwordreset">Change Password</a>
            </div>
        </div>
        <div class="editprofdiv">
            <div id="editprofile" class="styled-button save-changes">SAVE CHANGES</div>
        </div>
    </div>
</div>


<script type="text/javascript" lang="javascript">
    var username="<?php echo $username ?>";
    var userimage="";
    var name="";
    var email="";

    $(document).ready(function () {
        event.preventDefault();
        //get user details when load and display
        $.ajax({
            url: "<?php echo base_url() ?>index.php/users/userdetails?username="+username,
            method: "GET"
        }).done(function (data) {
            //display the user details in the input fields
            userimage=data.UserImage;
            //get the name of theuser from the datbase and display it
            name=data.Name;
            //get the email of theuser from the databaseand display it
            email=data.Email;
            //display the profile picture
            var div = "<img id='profpicid' class='profile-image' src='<?php echo base_url() ?>images/profilepics/" + data.UserImage + "' alt='picture'/>";
            $('.profimagediv').append(div);

            var namediv = "<div class='labeldiv'>Name</div>" +
                "<div class='inputdiv'><input class='inputedit' onkeyup='getname()' type='text' id='name' name='name' value='" + data.Name + "'/></div>";
            $('.namechngediv').append(namediv);

            var emaildiv = "<div class='labeldiv'>Email</div>" +
                "<div class='inputdiv'><input class='inputedit' onkeyup='validateemail()' type='text' id='email' name='email' value='" + data.Email + "'/></div>";
            $('.emailchangediv').append(emaildiv);

        });
    });
    //validate the edited emailddr
    function validateemail() {
        var x = $("#email").val();
        //validate the email address entered by theuser
        var atposition = x.indexOf("@");
        var dotposition = x.lastIndexOf(".");
        if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= x.length) {
            document.getElementById("errmsg2").innerHTML = "Enter a valid e-mail address";
        }
        else {
            document.getElementById("errmsg2").innerHTML = "";
            email = x;
        }
    }
    function getname() {
        name = $("#name").val();
    }

    //to display the image as its uploaded
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var formdata = new FormData();
            var files = $('#image')[0].files;
            if(files.length > 0 ){
                formdata.append('image',files[0]);
                //store the image in folder and get the file name
                $.ajax({
                    url: "<?php echo base_url() ?>index.php/posts/profpic",//store the image in folder
                    data: formdata,
                    method: "POST",
                    contentType: false,
                    processData: false
                }).done(function (data) {
                    var result=data.result;
                    if (result=="done") {
                        userimage = data.image_metadata.file_name;//get file name
                        reader.onload = function (e) {
                        $('#profpicid').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                        document.getElementById("errmsg").innerHTML = '';
                    } else {
                        $error=data.error.slice(3,-4);
                        document.getElementById("errmsg").innerHTML = $error;
                    }
                });
            }
        }
    }
    //when button is clicked to save changes
    $("#editprofile").click(function(event) {
        event.preventDefault();
        //save the changes made by the user
        var postdata = {
                userimage: userimage,
                username:username,
                name:name,
                email:email
        }
        $.ajax({
            url: "<?php echo base_url() ?>index.php/users/editprofile",
            data: JSON.stringify(postdata),
            contentType: "application/json",
            method: "PUT"
            //display success message if successful
            }).done(function (data) {
            //get the result from the server
                var result=data.result;
                if(result=="done"){//redirect to my profile if successful
                    location.href="<?php echo base_url()?>index.php/myprofile";
                }//display error message if not successful
                else{
                    document.getElementById("errmsg2").innerHTML = "Couldn't save your changes";
                }
            });
        });                    
</script>
</body>
</html>