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
<!--  444  the search bar inside the side bar start here-->
    <div>
        <input type="text"  class="searchdiv" id="search" placeholder="Search..." onkeyup='searchquest()'/>
        <div class="searchresults2" id="searchresults"></div>
    </div>

    <!--These are the  Navigation Links which are used to navigate in the page -->
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
<!--The code of Sidebar navigation end here -->
<!--the code of the homecontainer is used to show the home content-->
<div class="homecontainer">
    <div class='heading1'>
        <div class='heading'>This is the home page </div>
        <div class='homelist'></div>
    </div>
<div>

<script type="text/javascript" lang="javascript">//this is the javascript code to display the questions in the home page
    var username="<?php echo $username ?>";

    $(document).ready(function () {
        postCollection.fetch(); // Always fetch posts on start

      // Set the Tags link dynamically to navigate using the side bar start
      //navigate to the tags page
      $('#tags-link').attr('href', '<?php echo base_url() ?>index.php/postquestctrl/questtags');
      //navigate to the profilepage
      $('#Profile-link').attr('href', '<?php echo base_url() ?>index.php/myprofile');
      $('#home-link').attr('href', '<?php echo base_url() ?>index.php/home');
     // Set the Tags link dynamically to navigate using the side bar end

    });

    // The username is being appended to the url as a query parameter.
    var PostCollection = Backbone.Collection.extend({
        url: "<?php echo base_url() ?>index.php/home/postquestions?username="+username,
    });
    var html = "";

    //code to display data with the questions and the other details  --- start---
    var PostDisplay = Backbone.View.extend({
    el: ".homecontainer",//el is the element where the view is rendered
    initialize: function () {//initialize the function of the view
        this.listenTo(this.model, "add", this.showResults);
    },
    showResults: function (m) {
        // m gets its data from the server response to the fetch request made by the PostCollection.
        //display all the details of the relavent questions in backbone view
        html = html + "<div class='question-box'>" +
            "<div class='question-content'>" +
            //"<a href='<?php //echo base_url() ?>//index.php/postquestctrl/notparametered?key=" + m.get('dbcolumnname') + "'>" +
            "<a href='<?php echo base_url() ?>index.php/postquestctrl/questtags?questtagid=" + m.get('QuesttagId') + "'>" +
            "<span><i class='fa-solid fa-cube'></i>" + m.get('QuesttagName') + "</span></a></div>" +
            "<div class='userratediv'>" +
            "<div class='usernamediv'><a href='<?php echo base_url() ?>index.php/users/userprofile/?username=" + m.get('Username') + "'>" +
            "<span>" + m.get('Username') + "</span></a></div>" +
            "<div class='rate-count' id='ratediv" + m.get('PostId') + "'>" +
            "<i onclick='rate(" + m.get('PostId') + ");' class='fa-solid fa-star '></i></div></div>" +
            "<div class='questtitlediv'>" + m.get('QuestTitle') +

            "<a href='<?php echo base_url() ?>index.php/postquestctrl/post?postid=" + m.get('PostId') + "'></br>" +
            "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
            //"<a class='styled-button' href='<?php //echo base_url() ?>//index.php/postquestctrl/post?postid=" + m.get('PostId') + "'><br>" +
            "<div class='usercomments-section' id='usercommentsdiv" + m.get('PostId') + "'></div>"+
            "<a class='styled-button' href='<?php echo base_url() ?>index.php/postquestctrl/post?postid=" + m.get('PostId') + "'>View Question</a>" +
            "<a class='styled-button reply-button' href='<?php echo base_url() ?>index.php/postquestctrl/post?postid=" + m.get('PostId') + "'>Reply</a>" +
            "</div>"; //to display the comments

        this.$el.html(html);//this will render the html in the view

    //code to display data with questions --- end---

        $.ajax({//this is used to check if the user has already rated them or not and change color accordingly
            url: "<?php echo base_url() ?>index.php/home/comments?postid="+m.get('PostId'),
            method: "GET"
        }).done(function (res) {
            if(res.length!=0){
                for (i = 0; i < res.length; i++) {
                    if(i<2){
                        var div ="<span><a class='commuserlink' href='<?php echo base_url() ?>index.php/users/userprofile/?username="+res[i].Username+"'>"+res[i].Username+"</a>"
                            +res[i].CommentBody+"</span></br>";
                        $('#usercommentsdiv'+m.get('PostId')).append(div);
                    }
                }
            }
        });

            $.ajax({//check if the user has already rated them or not and change color accordingly
                url: "<?php echo base_url() ?>index.php/home/checkratings?username="+username+"&postid="+m.get('PostId'),
                method: "GET"
            }).done(function (res) {//change the color of the rate icon if the user has already rated
                if(res){//change the color of the rate icon if the user has already rated
                    document.getElementById("ratediv"+m.get('PostId')).style.color = "#FC6464";//change the color of the rate icon
                }
                else{
                    document.getElementById("ratediv"+m.get('PostId')).style.color = "#666666";
                }
            });
        }
    });
    var postCollection = new PostCollection();//create a new instance of the PostCollection
    var postDisplay = new PostDisplay({model: postCollection})

    //function to rate the questions and change the color of the rate icon
    function rate($postid){
        $.ajax({
                url: "<?php echo base_url() ?>index.php/home/rate",
                data: JSON.stringify({username: username,postid:$postid}),
                contentType: "application/json",
                method: "POST"
        }).done(function (data) {//
            $.ajax({
                url: "<?php echo base_url() ?>index.php/home/checkratings?username="+username+"&postid="+$postid,
                method: "GET"
            })
            .done(function (res) {//
                if(res){
                    document.getElementById("ratediv"+$postid).style.color = "#FC6464";
                }
                else{
                    document.getElementById("ratediv"+$postid).style.color = "#666666";
                }
            });
        });
    }
</script>
</body>
</html>


