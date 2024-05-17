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
    <div class="questtagcontainer">
        <div class="questtaglistdiv">
            <span id='questtagname'></span>
            <div id="questtaglist"> </div>
        </div>
<!--        <div class="postlocadiv"></div>-->
            <div class="postquestdiv"></div>
    </div>

<script type="text/javascript" lang="javascript">
    var questtagid ="<?php echo $questtagid ?>";
    $(document).ready(function () {
        event.preventDefault();
        $.ajax({//get all posts from the given tag id at start and display the posts
            //"<a href='<?php //echo base_url() ?>//index.php/posts/parametered/action?key="
            url: "<?php echo base_url() ?>index.php/posts/questtag/action/id?questtagid="+questtagid,
            method: "GET"
            }).done(function (data) { 
               //used to display the questtag name along with the icon in the page
                document.getElementById("questtagname").innerHTML = "<i class='fa-solid fa-cube '></i>"+data.QuesttagName;
            });
        $.ajax({
            url: "<?php echo base_url() ?>index.php/posts/questtag/action/all",
            method: "GET"
        })
        .done(function (data) {
            for (i = (questtagid-8); i < (+questtagid+8); i++) {
                if(data[i]!=null){//display few other tags in the list for easier browsing
                    //"<a href='<?php //echo base_url() ?>//index.php/posts/notparametered
                    var span ="<a href='<?php echo base_url() ?>index.php/posts/questtags?questtagid="
                    +data[i].QuesttagId+"'><span>"+data[i].QuesttagName+"</span></a></br>";
			        $('#questtaglist').append(span);
                }
		    }  
        });
        postCollection.fetch();//backbone fetch to get the posts
    });    
    var PostCollection = Backbone.Collection.extend({
        //the questtag posts in posts.php controller
        url: "<?php echo base_url() ?>index.php/posts/questtagposts?questtagid="+questtagid,
    });

    var html = "";
    var PostDisplay = Backbone.View.extend({
        el: ".postquestdiv",
        initialize: function () {
            this.listenTo(this.model, "add", this.showResults);
        },
        showResults: function (m) {
            //this function is used to display the posts and the comments in the page
            html = html + "<div class='question-box'>" +
                "<div class='question-content'>" +
                //used to display the posted question
                //"<a href='<?php //echo base_url() ?>//index.php/posts/post?postid="+
                "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
                "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></div>" +
                "<div class='usercomments-section' id='usercommentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;
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
                            $('#usercommentsdiv'+m.get('PostId')).append(div);
                        }
                    }
                }
            });
            $.ajax({//check if the user has already rated them or not and change color accordingly
                url: "<?php echo base_url() ?>index.php/home/checkratings?username="+username+"&postid="+m.get('PostId'),
                method: "GET"
            }).done(function (res) {
                if(res){
                    document.getElementById("ratediv"+m.get('PostId')).style.color = "#FC6464";
                }
                else{
                    document.getElementById("ratediv"+m.get('PostId')).style.color = "#666666";
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