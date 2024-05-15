<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/b9008b61cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/home.css">
</head>

<body>
    <div class="locationcontainer">
        <div class="locationlistdiv">
            <span id='locationname'></span>
            <div id="locationlist"> </div>
        </div>
        <div class="postlocadiv"></div>
    </div>

<script type="text/javascript" lang="javascript">
    var questtagid ="<?php echo $questtagid ?>";
    $(document).ready(function () {
        event.preventDefault();
        $.ajax({//get all posts from the given tag id at start and display the posts
            //"<a href='<?php //echo base_url() ?>//index.php/posts/parametered/action?key="
            url: "<?php echo base_url() ?>index.php/posts/location/action/id?questtagid="+questtagid,
            method: "GET"
            }).done(function (data) { 
                // document.getElementById("locationname").innerHTML = "<i class='fa-solid fa-cube'></i>"+data.LocationName;
                document.getElementById("locationname").innerHTML = "<i class='fa-solid fa-cube '></i>"+data.QuesttagName;
            });
        $.ajax({
            url: "<?php echo base_url() ?>index.php/posts/location/action/all",
            method: "GET"
        })
        .done(function (data) {
            for (i = (questtagid-8); i < (+questtagid+8); i++) {
                if(data[i]!=null){//display few other tags in the list for easier browsing
                    //"<a href='<?php //echo base_url() ?>//index.php/posts/notparametered
                    var span ="<a href='<?php echo base_url() ?>index.php/posts/locations?questtagid="
                    +data[i].QuesttagId+"'><span>"+data[i].QuesttagName+"</span></a></br>";
			        $('#locationlist').append(span);
                }
		    }  
        });
        postCollection.fetch();//backbone fetch to get the posts
    });    
    var PostCollection = Backbone.Collection.extend({
        //the location posts in posts.php controller
        url: "<?php echo base_url() ?>index.php/posts/locationposts?questtagid="+questtagid,
    });

    var html = "";
    var PostDisplay = Backbone.View.extend({
        el: ".postlocadiv",
        initialize: function () {
            this.listenTo(this.model, "add", this.showResults);
        },
        showResults: function (m) {
            //html = html + "<div class='imagelocdiv'><a href='<?php //echo base_url() ?>//index.php/posts/post?postid="+
            //// m.get('PostId')+"'><img class='locpostimage' src='<?php //echo base_url() ?>//images/userposts/"+m.get('PostImage')+"'/></a></div>"+
            //// "<a href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
            //// "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
            //// "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;
            //
            //// "<a href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
            //// "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div>"+
            //// "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></div>" +
            //// "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;
            //
            //"<a href='<?php //echo base_url() ?>//index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
            //"<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></div>" +
            //"<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;
            //this.$el.html(html);

            // "<div class='question-box'>" +
            // "<div class='question-content'>" +
            html = html + "<div class='question-box'>" +
                "<div class='question-content'>" +
                //used to display the posted question
                //"<a href='<?php //echo base_url() ?>//index.php/posts/post?postid="+
                "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
                "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></div>" +
                "<div class='comments-section' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;
            this.$el.html(html);


            //get the comments of the each posted questons and then it is used to display the questions accordingly start --------
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
            //get the comments of the each posted questons and then it is used to display the questions accordingly end --------
        }
    });

    var postCollection = new PostCollection();
    var postDisplay = new PostDisplay({model: postCollection})

</script>
</body>
</html>