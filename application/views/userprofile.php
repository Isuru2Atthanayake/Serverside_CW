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
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo base_url()?><!--css/home2_userprofile_sidebar.css">-->
</head>

<body>
<!--The code of Sidebar  start here -->

<div class="sidebar">
    <!--  444  the search bar inside the side bar start here-->
    <div>
        <input type="text"  class="searchdiv" id="search" placeholder="Search..." onkeyup='searchusers()'/>
        <div class="searchresults2" id="searchresults"></div>
    </div>

    <!--These are the  Navigation Links -->
    <ul>
        <li><a id="home-link" >Home</a></li>
        <li><a id="tags-link" >Tags</a></li>
        <li><a id="Profile-link" >Profile</a></li>
    </ul>

    <!-- Logout Link -->
    <div class="logout-section">
        <a class="logoutlink" href="<?php echo base_url()?>index.php/users/logout">LOGOUT</a>
    </div>

    <!--   444 the search bar inside the side bar end here-->
</div>
<!--The code of Sidebar  end here -->

<!--<div class="profilecontainer">-->
<!--    <div class="profiledeetdiv">-->
<!--        <div class="topdiv">-->
<!--            <div class="profpicdiv"></div>-->
<!--        </div>-->
<!--        <div class="usernamediv">--><?php //echo $username ?><!--</div>-->
<!--            <div class="namediv"></div>-->
<!--        <div class="biodiv"></div>-->
<!--    </div>-->
<!--        <div class="postsdiv" id="postsdiv">-->
<!--    </div>-->
<!--</div>-->

<!--The code of profile  start here-->
<div class="profilecontainer">
    <div class="profiledeetdiv">
        <div class="topdiv">
            <div class="profpicdiv"></div>
        </div>
        <div class="usernamediv"><?php echo $username ?></div>
        <div class="namediv"></div>
        <!-- <div class="biodiv"></div> -->
        <div class="profbottomdiv">
            <a class="editprlink" href="<?php echo base_url()?>index.php/myprofile/editprofile">EDIT PROFILE</a>
            <!--            <a class="logoutlink1" href="--><?php //echo base_url()?><!--index.php/users/logout">LOGOUT</a>-->
        </div>
    </div>
    <div class="postsdiv" id="postsdiv"></div>
</div>
<!--The code of profile  end here-->

<script type="text/javascript" lang="javascript">
    var username="<?php echo $username ?>";
    $(document).ready(function () {
        event.preventDefault();
        postCollection.fetch();//fetch the posts from collection on start
        //checkfollow();//check if the current user follows this user
        $.ajax({//get user details and display
            url: "<?php echo base_url() ?>index.php/users/userdetails?username="+username,
            method: "GET"
        }).done(function (data) {
            var div ="<img class='profileimage' src='<?php echo base_url() ?>images/profilepics/"+data.UserImage+"'/>";
            $('.profpicdiv').append(div);
            var name ="<span>"+data.Name+"</span>";
            $('.namediv').append(name);
            var bio ="<span>"+data.UserBio+"</span>";
            $('.biodiv').append(bio);
        });
        // Set the Tags link dynamically to navigate using the side bar start
        $('#tags-link').attr('href', '<?php echo base_url() ?>index.php/posts/locations');
        $('#Profile-link').attr('href', '<?php echo base_url() ?>index.php/myprofile');
        $('#home-link').attr('href', '<?php echo base_url() ?>index.php/home');
        // Set the Tags link dynamically to navigate using the side bar end
    });
    var Post = Backbone.Model.extend({
        url: "<?php echo base_url() ?>index.php/posts/userposts?username="+username
    });
    var PostCollection = Backbone.Collection.extend({
        url: "<?php echo base_url() ?>index.php/posts/userposts?username="+username,
        model: Post,
        parse: function(data) {
            return data;
        } 
    });
    var PostDisplay = Backbone.View.extend({
        el: "#postsdiv",
        initialize: function () {
            this.listenTo(this.model, "add", this.showResults);
        },
        //to show the questions in the myprofile page 
        showResults: function () {
            var html = "";
            this.model.each(function (m) {
                // html = html + "<div class='postimagediv'><a href='<?php echo base_url() ?>index.php/posts/post?postid="
                // + m.get('PostId') +"'><img class='postimage' src='<?php echo base_url() ?>images/userposts/"
                // + m.get('PostImage') + "'/></a></div>";


                html = html + "<div class='questdiv'><a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>" +
                "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
                "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div>";

                //this is used to display the content to the user , the poted questions
                //html = html + "<div class='question-box'>" +
                //    "<div class='question-content'>" +
                //    //"<a href='<?php ////echo base_url() ?>////index.php/posts/post?postid="+
                //    "<a href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
                //    "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></div>" +
                //    "<div class='comments-section' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;
            });
            this.$el.html(html);
        }

    });
    var postCollection = new PostCollection();
    var postDisplay = new PostDisplay({model: postCollection})

    //to follow the user start
    // function followcount(){
    //     $.ajax({//get follower/following count and display
    //         url: "<?php echo base_url() ?>index.php/myprofile/followcount?username="+username,
    //         method: "GET"
    //     }).done(function (data) {
    //         document.getElementById("followingc").innerHTML = data.following
    //         document.getElementById("followerc").innerHTML = data.followers
    //     });
    // }
    // function follow(){//when follow button is clicked on
    //     $.ajax({
    //         url: "<?php echo base_url() ?>index.php/myprofile/follow",
    //         data: JSON.stringify({isfollowing: username}),
    //         contentType: "application/json",
    //         method: "POST"
    //     }).done(function () {
    //         checkfollow();
    //         followcount();
    //     });
    // }
    // function checkfollow(){//check if the user is already followed and change the button accordingly
    //     $.ajax({
    //         url: "<?php echo base_url() ?>index.php/myprofile"+username,
    //         method: "GET"
    //     }).done(function (data) {
    //         //to remove the following button
    //         // if (data) {
    //         //      document.getElementById("followbutton").innerHTML = "UNFOLLOW"
    //         // }
    //         // else {
    //         //     document.getElementById("followbutton").innerHTML = "FOLLOW"
    //         // }
    //     });
    // } 
    function user_profileimage(){
        //user profile image loader
        $.ajax({
            url: "<?php echo base_url() ?>index.php/myprofile"+username,
            method: "GET"
        }).done(function (data) {
            //to remove the following button
            // if (data) {
            //      document.getElementById("followbutton").innerHTML = "UNFOLLOW"
            // }
            // else {
            //     document.getElementById("followbutton").innerHTML = "FOLLOW"
            // }
        });
    }        
    //to follow the user end  
</script>
</body>
</html>