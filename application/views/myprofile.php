<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/myprofile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/home1.css">
    <!--   this is used for the sidebar-->
</head>

<body>
<!--The code of Sidebar  start here -->
<div class="sidebar">
    <!--  444  the search bar inside the side bar start here-->
    <div>
        <input type="text"  class="searchdiv" id="search" placeholder="Search..." onkeyup='searchquest()'/>
        <div class="searchresults2" id="searchresults"></div>
    </div>

    <!--These are the  Navigation Links of the profile -->
    <ul>
        <li><a id="home-link" >Home</a></li>
        <li><a id="tags-link" >Tags</a></li>
        <li><a id="Profile-link" >Profile</a></li>
    </ul>

    <!-- Logout Link -->
    <div class="logout-section">
        <a class="userlogout" href="<?php echo base_url()?>index.php/users/logout">LOGOUT</a>
    </div>

    <!--   444 the search bar inside the side bar end here-->
</div>
<!--The code of Sidebar  end here -->

<!--The code of profile  start here-->
<div class="userprofilecontainer">
    <div class="profileheaderdiv">
        <div class="toppicdiv">
            <div class="propicdiv"></div>
        </div>
<!--        this code is used to display the user details-->
        <div class="usernamediv"><?php echo $username ?></div>
        <div class="namediv"></div>
<!--        this is used to edit the profile of the user-->
        <div class="profbottomdiv">
            <a class="editprlink" href="<?php echo base_url()?>index.php/myprofile/editprofile">EDIT PROFILE</a>
        </div>
    </div>
    <div class="postsdiv" id="postsdiv"></div>
</div>
<!--The code of profile  end here-->




<script type="text/javascript" lang="javascript">
    var username="<?php echo $username ?>";
    $(document).ready(function () {//when the page is loaded get the user details
        event.preventDefault();
        postCollection.fetch();//fetch the posted questions
        $.ajax({//get details of the user through api
            url: "<?php echo base_url() ?>index.php/users/userdetails?username="+username,
            method: "GET"
        }).done(function (data) {//display the user details in the page
            var div ="<img class='profileimage' src='<?php echo base_url() ?>images/profilepics/"+data.UserImage+"'/>";
            $('.propicdiv').append(div);
            var name ="<span>"+data.Name+"</span>";
            $('.namediv').append(name);
        });
        // Set the Tags link dynamically to navigate using the side bar start
        // notparametered funton of controller
        $('#tags-link').attr('href', '<?php echo base_url() ?>index.php/postquestctrl/questtags');
        $('#Profile-link').attr('href', '<?php echo base_url() ?>index.php/myprofile');
        $('#home-link').attr('href', '<?php echo base_url() ?>index.php/home');
        // Set the Tags link dynamically to navigate using the side bar end
    });
   
    var Post = Backbone.Model.extend({//backbone model to get the questionposts
        url: "<?php echo base_url() ?>index.php/myprofile/myposts" //myposted questions function in myprofile controller
    });

    var PostCollection = Backbone.Collection.extend({//backbone collection to get the posted questions
        url: "<?php echo base_url() ?>index.php/myprofile/myposts",
        model: Post,
        parse: function(data) {
            return data;
        } 
    });
    //backbone view to display the posted questions
    var PostDisplay = Backbone.View.extend({
        el: "#postsdiv",
        initialize: function () {
            this.listenTo(this.model, "add", this.showResults);
        },
        showResults: function () {//this function is used to show the questions in the myprofile page
            var html = "";
            this.model.each(function (m) {//this function is used to display the posts and the comments in the page

                html = html + "<div class='questdiv'><a href='<?php echo base_url() ?>index.php/postquestctrl/post?postid=" + m.get('PostId') + "'>" +
                "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
                "<div class='usercommentsdiv' id='usercommentsdiv" + m.get('PostId') + "'></div>";

            });//to display the posted questions in the myprofilepage

            this.$el.html(html);

        }
    });
    var postCollection = new PostCollection();//backbone collection to get the posted questions
    var postDisplay = new PostDisplay({model: postCollection})//backbone view to display the posted questions
</script>
</body>
</html>