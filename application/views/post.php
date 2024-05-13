<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/b9008b61cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/post.css">
</head>
<body>
   <div class='postcontainer'>
        <div class='leftdiv'>            
            <div class='postimagediv'></div>
            <div class='locationlikediv'>
                <div class='likediv' id='likediv'></div>
                <div class='likecount'></div>
                <div class='locationdiv'></div>
            </div>
        </div>
        <div class='rightdiv'>
            <div class='usernameimgdiv'></div>
            <div class='captiondiv'></div>
            <div class='commentareadiv'>
                <textarea onkeyup='checkinputs();' name="comment" id="comment" maxlength="50"></textarea>
                <button onclick='postcomment();' id='commentbtn' disabled="disabled">Comment</button>
            </div>
            <div class='commentsdiv'></div>
        </div>
   </div>

<script type="text/javascript" lang="javascript">
    var username="<?php echo $username ?>";
    var postid="<?php echo $postid ?>";  
    $(document).ready(function () {
        event.preventDefault();
        //get comments and like count on start
        getComments();
        likecount();
        $.ajax({//get post details
            url: "<?php echo base_url() ?>index.php/posts/post/action/view?postid="+postid,
            method: "GET"
            }).done(function (data) {//display post details
                // var div ="<img class='postimage' src='<?php echo base_url() ?>images/userposts/"+data.PostImage+"' alt='picture'/>";
                // $('.postimagediv').append(div);
                var div2 ="<a href='<?php echo base_url() ?>index.php/posts/locations?locationid="
                + data.LocationId +"'><span><i class='fa-solid fa-location-dot'></i>"+ data.LocationName +"</span></a>";
                $('.locationdiv').append(div2);
                var div3 ="<div class= 'userimagediv'><img class='userimage' src='<?php echo base_url() ?>images/profilepics/"
                         +data.UserImage+"'/></div><div class='usernamediv'><a href='<?php echo base_url() ?>index.php/users/userprofile/?username="
                         +data.Username +"'><span>"+ data.Username +"</span></a></div>";
                $('.usernameimgdiv').append(div3);
                var div4 ="<i onclick='like();' class='fa-solid fa-heart'></i>";
                $('.likediv').append(div4);
                var div5 =data.Caption ;
                $('.captiondiv').append(div5);
            });
            $.ajax({//check if user has already liked the post
                url: "<?php echo base_url() ?>index.php/home/checklikes?username="+username+"&postid="+postid,
                method: "GET"
            }).done(function (res) {
                if(res){
                    document.getElementById("likediv").style.color = "#FC6464";
                }
                else{
                    document.getElementById("likediv").style.color = "#666666";
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
    //when post is liked, send post request and change color of button
    function like(){
        $.ajax({
            url: "<?php echo base_url() ?>index.php/home/like",
            data: JSON.stringify({username: username,postid:postid}),
            contentType: "application/json",
            method: "POST"
        }).done(function (data) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/home/checklikes?username="+username+"&postid="+postid,
                method: "GET"
            })
            .done(function (res) {
                if(res){
                    document.getElementById("likediv").style.color = "#FC6464";
                    likecount();
                }
                else{
                    document.getElementById("likediv").style.color = "#666666";
                    likecount();
                }
            });
        });
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
        $.ajax({
                url: "<?php echo base_url() ?>index.php/home/comments?postid="+postid,
                method: "GET"
        }).done(function (res) {
            if(res.length!=0){    
                $('.commentsdiv div').remove();       
                for (i = 0; i < res.length; i++) {
                    var div ="<div class='comments'><a href='<?php echo base_url() ?>index.php/users/userprofile/?username="+res[i].Username+"'>"+res[i].Username+"</a>"
                    +res[i].CommentBody+"</div>";
                    $('.commentsdiv').append(div);
                } 
            }
        });
    }
    //get the like count of the post
    function likecount(){
        $.ajax({
                url: "<?php echo base_url() ?>index.php/posts/likecount?postid="+postid,
                method: "GET"
        }).done(function (res) {
            $('.likecount span').remove();       
            if(res==1){
                var div ="<span>"+res+" like</span>";
            }
            else{
                var div ="<span>"+res+" likes</span>";
            }
            $('.likecount').append(div);
        });
    }    
</script>
</body>
</html>