<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/b9008b61cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/home1.css">
</head>

<body>
<!--The code of Sidebar navigation start here-->
<div class="sidebar">
<!--    <div class="searchdiv">-->
<!--        <input type="text" class="search1" id="search" placeholder="fa-star" onkeyup='searchusers()'/>-->
<!--    </div>-->

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
        <!-- <li><a href="#contact">Contact</a></li> -->
<!--        <a class="logoutlink" href="--><?php //echo base_url()?><!--index.php/users/logout">LOGOUT</a>-->
    </ul>

    <!-- Logout Link -->
    <div class="logout-section">
        <a class="logoutlink" href="<?php echo base_url()?>index.php/users/logout">LOGOUT</a>
    </div>

    <!--   444 the search bar inside the side bar end here-->

    <!-- Icon Links -->
<!--    <div class="link-div">-->
<!---->
<!--    </div>-->
</div>
<!--The code of Sidebar navigation end here -->

<div class="feedcontainer">
    <div class='notfollowing'>
        <div class='heading'>This is the home page </div>
        <div class='userlisting'></div>
    </div>
<div>

<script type="text/javascript" lang="javascript">
    var username="<?php echo $username ?>";

    // code to get follow count and suggest users to follow if follow count is 0 start------

    // $(document).ready(function () {
    //     event.preventDefault();
    //     $.ajax({//get follow count
    //         url: "<?php echo base_url() ?>index.php/myprofile/followcount?username="+username,
    //         method: "GET"
    //     }).done(function (data) {
    //         if (data.following==0){//if follow count is 0, display no posts and suggest users to follow
    //             $.ajax({
    //                 url: "<?php echo base_url() ?>index.php/users/user",
    //                 method: "GET"
    //             }).done(function (data) {
    //                 for (i = 0; i < 5; i++) {
    //                     var div ="<a href='<?php echo base_url() ?>index.php/users/userprofile/?username="
    //                      +data[i].Username+"'><div class='users'><div class= 'profilepicdiv'><img class='profilepic' src='<?php echo base_url() ?>images/profilepics/"
    //                      +data[i].UserImage+"'/></div>"+data[i].Username+"</br>"+data[i].Name+"</div></a>";
    //                     $('.userlisting').append(div);
    //                 }
    //             });
    //         }
    //         else{
    //             $('.notfollowing').remove();
    //         }
    //     });
    //     postCollection.fetch();//fetch backbone collection on start
    // });
    //code to get follow count and suggest users to follow if follow count is 0 end ------

    $(document).ready(function () {
        postCollection.fetch(); // Always fetch posts on start
    
      // Set the Tags link dynamically to navigate using the side bar start
      $('#tags-link').attr('href', '<?php echo base_url() ?>index.php/posts/locations');
      $('#Profile-link').attr('href', '<?php echo base_url() ?>index.php/myprofile');
      $('#home-link').attr('href', '<?php echo base_url() ?>index.php/home');
     // Set the Tags link dynamically to navigate using the side bar end
    
    });

    var PostCollection = Backbone.Collection.extend({
        url: "<?php echo base_url() ?>index.php/home/followingposts?username="+username,
    });
    var html = "";
    
    //code to display data with the questions and the other details  --- start---
    var PostDisplay = Backbone.View.extend({
    el: ".feedcontainer",//el is the element where the view is rendered
    initialize: function () {//initialize the function of the view
        this.listenTo(this.model, "add", this.showResults);
    },
    showResults: function (m) {//display all the details of the relavent questions in backbone view
        //html = html + "<div class='question-box'>" +
        //    "<div class='question-content'>" +
        //    "<a href='<?php //echo base_url() ?>//index.php/posts/locations?locationid=" + m.get('LocationId') + "'>" +
        //    "<span><i class='fa-solid fa-cube'></i>" + m.get('LocationName') + "</span></a></div>" +
        //    "<div class='userlikediv'>" +
        //    "<div class='usernamediv'><a href='<?php //echo base_url() ?>//index.php/users/userprofile/?username=" + m.get('Username') + "'>" +
        //    "<span>" + m.get('Username') + "</span></a></div>" +
        //    "<div class='likes-count' id='likediv" + m.get('PostId') + "'>" +
        //    "<i onclick='like(" + m.get('PostId') + ");' class='fa-solid fa-star '></i></div></div>" +
        //    "<div class='captiondiv'>" + m.get('Caption') +
        //
        //    "<a href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
        //    "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
        //    "<a class='styled-button' href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'><br>" +
        //    "<div class='comments-section' id='commentsdiv" + m.get('PostId') + "'></div></div>";//to display the comments
        //    // "<div class='commentsdiv'><span>Tags: " + m.get('QuestionTags') + "</span></div>"  // Display the tags

        html = html + "<div class='question-box'>" +
            "<div class='question-content'>" +
            "<a href='<?php echo base_url() ?>index.php/posts/locations?locationid=" + m.get('LocationId') + "'>" +
            "<span><i class='fa-solid fa-cube'></i>" + m.get('LocationName') + "</span></a></div>" +
            "<div class='userlikediv'>" +
            "<div class='usernamediv'><a href='<?php echo base_url() ?>index.php/users/userprofile/?username=" + m.get('Username') + "'>" +
            "<span>" + m.get('Username') + "</span></a></div>" +
            "<div class='likes-count' id='likediv" + m.get('PostId') + "'>" +
            "<i onclick='like(" + m.get('PostId') + ");' class='fa-solid fa-star '></i></div></div>" +
            "<div class='captiondiv'>" + m.get('Caption') +

            "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
            "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
            //"<a class='styled-button' href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'><br>" +
            "<div class='comments-section' id='commentsdiv" + m.get('PostId') + "'></div>"+
            "<a class='styled-button' href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>View answer</a>" +
            "<a class='styled-button reply-button' href='<?php echo base_url() ?>index.php/posts/reply?postid=" + m.get('PostId') + "'>Reply</a>" +
            "</div>"; //to display the comments
            // "<div class='commentsdiv'><span>Tags: " + m.get('QuestionTags') + "</span></div>"  // Display the tags

        //html = html + "<div class='question-box'>" +
        //    "<div class='question-content'>" +
        //    "<div class='user-info'>" +
        //    "<div class='profpicdiv'></div>" +
        //    "<span>" + m.get('Question') + "</span>" +
        //    "</div>" +
        //    "<a class='styled-button' href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'>View answer</a>" +
        //    "</div>" +
        //    "<div class='userlikediv'>" +
        //    "<div class='usernamediv'><a href='<?php //echo base_url() ?>//index.php/users/userprofile/?username=" + m.get('Username') + "'>" +
        //    "<span>" + m.get('Username') + "</span></a></div>" +
        //    "<div class='likes-count' id='likediv" + m.get('PostId') + "'>" +
        //    "<i onclick='like(" + m.get('PostId') + ");' class='fa-solid fa-star '></i></div></div>" +
        //    "<div class='captiondiv'>" + m.get('Caption') + "</div>" +
        //    "<div class='comments-section' id='commentsdiv" + m.get('PostId') + "'></div></div>";
        // "<div class='commentsdiv'><span>Tags: " + m.get('QuestionTags') + "</span></div>";  // Display the tags
            
           

            // "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'>" +
            // "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +

        this.$el.html(html);//this will render the html in the view

    //code to display data with questions --- end---

            //get the comments of the each posted questons and then it is used to display the questions accordingly
            $.ajax({
                url: "<?php echo base_url() ?>index.php/home/comments?postid="+m.get('PostId'),
                method: "GET"
            }).done(function (res) {
                if(res.length!=0){             
                    for (i = 0; i < res.length; i++) {
                        if(i<2){
                            var div ="<span><a class='commuserlink' href='<?php echo base_url() ?>index.php/users/userprofile/?username="+res[i].Username+"'>"+res[i].Username+"</a>"
                            +res[i].CommentBody+"</span></br>";
                            $('#commentsdiv'+m.get('PostId')).append(div);
                        }
		          } 
                }
            });
            $.ajax({//check if the user has already liked them or not and change color accordingly
                url: "<?php echo base_url() ?>index.php/home/checklikes?username="+username+"&postid="+m.get('PostId'),
                method: "GET"
            }).done(function (res) {
                if(res){
                    document.getElementById("likediv"+m.get('PostId')).style.color = "#FC6464";
                }
                else{
                    document.getElementById("likediv"+m.get('PostId')).style.color = "#666666";
                }
            });
        }
    });
    var postCollection = new PostCollection();
    var postDisplay = new PostDisplay({model: postCollection})

    //clicking on like buttons
    function like($postid){
        $.ajax({
                url: "<?php echo base_url() ?>index.php/home/like",
                data: JSON.stringify({username: username,postid:$postid}),
                contentType: "application/json",
                method: "POST"
        }).done(function (data) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/home/checklikes?username="+username+"&postid="+$postid,
                method: "GET"
            })
            .done(function (res) {
                if(res){
                    document.getElementById("likediv"+$postid).style.color = "#FC6464";
                }
                else{
                    document.getElementById("likediv"+$postid).style.color = "#666666";
                }
            });
        });
    }
</script>
</body>
</html>


