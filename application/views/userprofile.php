<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/myprofile.css">
</head>

<body>
<div class="profilecontainer">
<div class="profiledeetdiv">
    <div class="topdiv">
        <div class="profpicdiv"></div>
        <div class="followdiv">
            <div class="flabel">FOLLOWING</div>
            <div class="fcount" id="followingc"></div>
            <div class="flabel">FOLLOWERS</div>
            <div class="fcount" id="followerc"></div>
        </div>
    </div>
    <div class="usernamediv"><?php echo $username ?></div>
    <div class="namediv"></div>
    <div class="biodiv"></div>
    <div class="profbottomdiv">
    <a href="#" onclick='follow();'><div id="followbutton">  </div></a>
    </div>
</div>
<div class="postsdiv" id="postsdiv">
</div>
</div>

<script type="text/javascript" lang="javascript">
    var username="<?php echo $username ?>";
    $(document).ready(function () {
        event.preventDefault();
        postCollection.fetch();//fetch the posts from collection on start
        checkfollow();//check if the current user follows this user
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
        followcount();
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
                html = html + "<div class='postimagediv'><a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>" +
                "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
                "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div>";
            });
            this.$el.html(html);
        }
        // showResults: function () {
        //     var html = "";
        //     this.model.each(function (m) {
        //         // html = html + "<div class='postimagediv'>" +
        //         // <a href='<?php echo base_url() ?>index.php/posts/post?postid="
        //         // + m.get('PostId') +"'><img class='postimage' src='<?php echo base_url() ?>images/userposts/"
        //         // + m.get('PostImage') + "'/></a></div>";
        //         "<div class='locationdiv'>" +
        //         "<a href='<?php echo base_url() ?>index.php/posts/locations?locationid=" + m.get('LocationId') + "'>" +
        //         // "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>" +
        //         "<span><i class='fa-solid fa-location-dot'></i>" + m.get('LocationName') + "</span></a></div>" +
        //         // "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>" +
        //         // "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +

        //         "<div class='questiondiv'><p>" + m.get('Question') + "</p></div>" + // Display the question
        //         "<div class='userlikediv'>" +
        //         "<div class='usernamediv'><a href='<?php echo base_url() ?>index.php/users/userprofile/?username=" + m.get('Username') + "'>" +
        //         "<span>" + m.get('Username') + "</span></a></div>" +
        //         "<div class='likediv' id='likediv" + m.get('PostId') + "'>" +
        //         "<i onclick='like(" + m.get('PostId') + ");' class='fa-solid fa-heart'></i></div></div>" +
        //         "<div class='captiondiv'>" + m.get('Caption') + 
                
        //         "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>" +
        //         "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
        //         "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div></div>";
        //         });
        //     this.$el.html(html);
        //     //get comments for each post and display them
        //     $.ajax({
        //             url: "<?php echo base_url() ?>index.php/home/comments?postid="+m.get('PostId'),
        //             method: "GET"
        //         }).done(function (res) {
        //             if(res.length!=0){             
        //                 for (i = 0; i < res.length; i++) {
        //                     if(i<2){
        //                         var div ="<span><a class='commuserlink' href='<?php echo base_url() ?>index.php/users/userprofile/?username="+res[i].Username+"'>"+res[i].Username+"</a>"
        //                         +res[i].CommentBody+"</span></br>";
        //                         $('#commentsdiv'+m.get('PostId')).append(div);
        //                     }
        //             } 
        //             }
        //         });
        //         $.ajax({//check if the user has already liked them or not and change color accordingly
        //             url: "<?php echo base_url() ?>index.php/home/checklikes?username="+username+"&postid="+m.get('PostId'),
        //             method: "GET"
        //         }).done(function (res) {
        //             if(res){
        //                 document.getElementById("likediv"+m.get('PostId')).style.color = "#FC6464";
        //             }
        //             else{
        //                 document.getElementById("likediv"+m.get('PostId')).style.color = "#666666";
        //             }
        //         });
        //     }
        

    });
    var postCollection = new PostCollection();
    var postDisplay = new PostDisplay({model: postCollection})
    function followcount(){
        $.ajax({//get follower/following count and display
            url: "<?php echo base_url() ?>index.php/myprofile/followcount?username="+username,
            method: "GET"
        }).done(function (data) {
            document.getElementById("followingc").innerHTML = data.following
            document.getElementById("followerc").innerHTML = data.followers
        });
    }
    function follow(){//when follow button is clicked on
        $.ajax({
            url: "<?php echo base_url() ?>index.php/myprofile/follow",
            data: JSON.stringify({isfollowing: username}),
            contentType: "application/json",
            method: "POST"
        }).done(function () {
            checkfollow();
            followcount();
        });
    }
    function checkfollow(){//check if the user is already followed and change the button accordingly
        $.ajax({
            url: "<?php echo base_url() ?>index.php/myprofile/checkfollow?isfollowing="+username,
            method: "GET"
        }).done(function (data) {
            if (data) {
                 document.getElementById("followbutton").innerHTML = "UNFOLLOW"
            }
            else {
                document.getElementById("followbutton").innerHTML = "FOLLOW"
            }
        });
    }        
</script>
</body>
</html>