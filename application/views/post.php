<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/b9008b61cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/questionpost.css">
</head>
<body>
<!--//the container  of the posted questions start here-->
<div class='questpostcontainer'>
    <div class='usernameimgdiv'>
        <!-- Placeholder for user image and username -->
    </div>
    <div class='questtitlediv'>
        <!-- Placeholder for posttedquestions questtitle -->
<!--        <div class='ratediv' id='ratediv'></div>-->
        <div class='ratediv' id='ratediv'>
            <i class='fa-solid fa-star' id='star1' onclick='rate(1);'></i>
            <i class='fa-solid fa-star' id='star2' onclick='rate(2);'></i>
            <i class='fa-solid fa-star' id='star3' onclick='rate(3);'></i>
            <i class='fa-solid fa-star' id='star4' onclick='rate(4);'></i>
            <i class='fa-solid fa-star' id='star5' onclick='rate(5);'></i>
        </div>
        <div class='ratecount'></div>
        <div class='questtagdiv'></div>


    </div>
    <div class='questdiv'>
        <div class='questtitlediv1'></div>
        <div class='question-content'></div>
    </div>


    <div class='questcommentdiv'>
        <textarea onkeyup='checkinputs();' name="comment" id="comment" maxlength="200"></textarea>
        <button onclick='postcomment();' id='commentbtn' disabled="disabled">Reply</button>
    </div>
    <div class='usercommentsdiv'>
        <!-- Placeholder for comments -->
    </div>
</div>
<!--//the container  of the posted questions end here-->

<script type="text/javascript" lang="javascript">
    var username="<?php echo $username ?>";
    var postid="<?php echo $postid ?>";  
    $(document).ready(function () {
        event.preventDefault();
        //get comments and rate count on start
        getComments();
        ratecount();
        $.ajax({//get post details
            url: "<?php echo base_url() ?>index.php/posts/post/action/view?postid="+postid,
            method: "GET"
            }).done(function (data) {//display the details of the questions which are poested


                    // Thi s is used to Initializthe display of post details.


        // This is used to Append a link to the tag details including tag name and icon.
                    //to get tags notparametered
                    var div2 = "<a href='<?php echo base_url() ?>index.php/posts/questtags?questtagid=" +
                        data.QuesttagId + "'><span><i class='fa-solid fa-cube'></i>" +
                        data.QuesttagName + "</span></a>";
                    $('.questtagdiv').append(div2);

        // Create and append a user image and name block linking to the user's profile.
                    var div3 = "<div class='userimagediv'><img class='userimage' src='<?php echo base_url() ?>images/profilepics/" +
                        data.UserImage + "'/></div><div class='usernamediv'><a href='<?php echo base_url() ?>index.php/users/userprofile/?username=" +
                        data.Username + "'><span>" + data.Username + "</span></a></div>";
                    $('.usernameimgdiv').append(div3);

        // Add a 'rate' icon with an event handler for liking the post.
        //             var div4 = "<i onclick='rate();' class='fa-solid fa-star'></i>"+"<br/>";
        //             $('.ratediv').append(div4);

                    // var div4 = "<i onclick='rate();' class='fa-solid fa-star'></i>"+"<br/>";
                    // $('.ratediv').append(div4);
            // Append the questtitle data and add a line break for better layout.
        // Encapsulate the questtitle in a div for better styling control.
            var div5 = "<div class='questtitlediv'>" + data.QuestTitle + "<br/></div>";
            $('.questtitlediv').append(div5);

        // Append the question text if available, it appears below the questtitle in the layout.
        // Encapsulate the question in a div to maintain consistent styling and separation.
            var div6 = "<div class='question-content'>" + data.Question + "</div>";
            $('.question-content').append(div6);

            });
        $.ajax({
            url: "<?php echo base_url() ?>index.php/home/checkratings?username=" + username + "&postid=" + postid,
            method: "GET"
        }).done(function (res) {
            if (res) {
                highlightStars(res.rating);
            } else {
                highlightStars(0);
            }
        });
    });
    //disable comment button unless there is a value in the input
    function checkinputs() {
        if ($("#comment").val() != "") {
            document.getElementById('commentbtn').disabled = false;
        }
        else{
            document.getElementById('commentbtn').disabled = true;
        }
    }
    //when post is rated, send post request and change color of button
    //function rate(){
    //    $.ajax({
    //        url: "<?php //echo base_url() ?>//index.php/home/rate",
    //        data: JSON.stringify({username: username,postid:postid}),
    //        contentType: "application/json",
    //        method: "POST"
    //    }).done(function (data) {
    //        $.ajax({
    //            url: "<?php //echo base_url() ?>//index.php/home/checkratings?username="+username+"&postid="+postid,
    //            method: "GET"
    //        })
    //        .done(function (res) {
    //            if(res){
    //                document.getElementById("ratediv").style.color = "#FC6464";
    //                ratecount();
    //            }
    //            else{
    //                document.getElementById("ratediv").style.color = "#666666";
    //                ratecount();
    //            }
    //        });
    //    });
    //}
    function rate(rating) {
        $.ajax({
            url: "<?php echo base_url() ?>index.php/home/rate",
            data: JSON.stringify({username: username, postid: postid, rating: rating}),
            contentType: "application/json",
            method: "POST"
        }).done(function () {
            ratecount();
            highlightStars(rating);
        });
    }

    function highlightStars(rating) {
        for (var i = 1; i <= 5; i++) {
            if (i <= rating) {
                $('#star' + i).css('color', '#FC6464');
            } else {
                $('#star' + i).css('color', '#666666');
            }
        }
    }
    //when comment button is clicked, add comment to database
    function postcomment(){
        var comment = {
            postid: postid,
            comment:$("#comment").val()
        };
        $.ajax({
            url: "<?php echo base_url() ?>index.php/home/comments",
            data: JSON.stringify(comment),
            contentType: "application/json",
            method: "POST"
        }).done(function (data) {
            if (data) { 
                document.getElementById('comment').value = '';
                getComments();
            }
        });
    }
    //get all comments in the post
    function getComments(){
        //get the comments of the postedquestions using the postid
        $.ajax({
                url: "<?php echo base_url() ?>index.php/home/comments?postid="+postid,
                method: "GET"
        }).done(function (res) {
            if(res.length!=0){    
                $('.usercommentsdiv div').remove();
                for (i = 0; i < res.length; i++) {
                    var div ="<div class='comments'><a href='<?php echo base_url() ?>index.php/users/userprofile/?username="+res[i].Username+"'>"+res[i].Username+"</a>"
                    +res[i].CommentBody+"</div>";
                    $('.usercommentsdiv').append(div);
                } 
            }
        });
    }
     //get the rate count of the posted questions
    function ratecount() {
        $.ajax({
            //get the rate count of the posted questions using the postid
            url: "<?php echo base_url() ?>index.php/posts/ratecount?postid=" + postid,
            method: "GET"
        }).done(function (res) {
            $('.ratecount span').remove();
            //append the rate count to the ratecount div
            $('.ratecount').append(div);
        });
    }
</script>
</body>
</html>