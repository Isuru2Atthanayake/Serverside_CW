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
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo base_url()?><!--css/home2_myprofile_sidebar.css">-->
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
    //backbone fetch the post collection on start
    $(document).ready(function () {
        event.preventDefault();
        postCollection.fetch();
        $.ajax({//get user details through api
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
        $.ajax({//get follower/following counts
            url: "<?php echo base_url() ?>index.php/myprofile/followcount?username="+username,
            method: "GET"
        }).done(function (data) {
            document.getElementById("followingc").innerHTML = data.following
            document.getElementById("followerc").innerHTML = data.followers
        });

        // Set the Tags link dynamically to navigate using the side bar start
        // notparametered funton of Posts.php controller
        $('#tags-link').attr('href', '<?php echo base_url() ?>index.php/posts/questtags');
        $('#Profile-link').attr('href', '<?php echo base_url() ?>index.php/myprofile');
        $('#home-link').attr('href', '<?php echo base_url() ?>index.php/home');
        // Set the Tags link dynamically to navigate using the side bar end
    });
   
    var Post = Backbone.Model.extend({
        url: "<?php echo base_url() ?>index.php/myprofile/myposts"
    });

    var PostCollection = Backbone.Collection.extend({
        url: "<?php echo base_url() ?>index.php/myprofile/myposts",
        model: Post,
        parse: function(data) {
            return data;
        } 
    });
    //backbone view to display the posts
    // var html = "";
    var PostDisplay = Backbone.View.extend({
        el: "#postsdiv",
        initialize: function () {
            this.listenTo(this.model, "add", this.showResults);
        },
        showResults: function () {
            var html = "";
            this.model.each(function (m) {

                html = html + "<div class='questdiv'><a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>" +
                "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
                "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div>";

            });

            this.$el.html(html);
                //get comments for each post and display them
                // $.ajax({
                //     url: "<?php //echo base_url() ?>//index.php/home/comments?postid="+m.get('PostId'),
                //     method: "GET"
                // }).done(function (res) {
                //     if(res.length!=0){
                //         for (i = 0; i < res.length; i++) {
                //             if(i<2){
                //                 var div ="<span><a class='commuserlink' href='<?php //echo base_url() ?>//index.php/users/userprofile/?username="+res[i].Username+"'>"+res[i].Username+"</a>"
                //                 +res[i].CommentBody+"</span></br>";
                //                 $('#commentsdiv'+m.get('PostId')).append(div);
                //             }
                //     }
                //     }
                // });
                //$.ajax({//check if the user has already liked them or not and change color accordingly
                //    url: "<?php //echo base_url() ?>//index.php/home/checklikes?username="+username+"&postid="+m.get('PostId'),
                //    method: "GET"
                //}).done(function (res) {
                //    if(res){
                //        document.getElementById("likediv"+m.get('PostId')).style.color = "#FC6464";
                //    }
                //    else{
                //        document.getElementById("likediv"+m.get('PostId')).style.color = "#666666";
                //    }
                //});
        }
    });
    var postCollection = new PostCollection();
    var postDisplay = new PostDisplay({model: postCollection})
</script>
</body>
</html>