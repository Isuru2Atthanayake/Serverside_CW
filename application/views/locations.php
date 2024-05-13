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
    var locationid="<?php echo $locationid ?>";    
    $(document).ready(function () {
        event.preventDefault();
        $.ajax({//get all posts from the given location id at start and display the posts
            url: "<?php echo base_url() ?>index.php/posts/location/action/id?locationid="+locationid,
            method: "GET"
            }).done(function (data) { 
                // document.getElementById("locationname").innerHTML = "<i class='fa-solid fa-location-dot'></i>"+data.LocationName;
                document.getElementById("locationname").innerHTML = "<i class='fa-solid fa-cube '></i>"+data.LocationName;
            });
        $.ajax({
            url: "<?php echo base_url() ?>index.php/posts/location/action/all",
            method: "GET"
        })
        .done(function (data) {
            for (i = (locationid-8); i < (+locationid+8); i++) {
                if(data[i]!=null){//display few other locations in the list for easier browsing
                    var span ="<a href='<?php echo base_url() ?>index.php/posts/locations?locationid="
                    +data[i].LocationId+"'><span>"+data[i].LocationName+"</span></a></br>";
			        $('#locationlist').append(span);
                }
		    }  
        });
        postCollection.fetch();//backbone fetch to get the posts
    });    
    var PostCollection = Backbone.Collection.extend({
        url: "<?php echo base_url() ?>index.php/posts/locationposts?locationid="+locationid,
    });

    var html = "";
    var PostDisplay = Backbone.View.extend({
        el: ".postlocadiv",
        initialize: function () {
            this.listenTo(this.model, "add", this.showResults);
        },
        showResults: function (m) {
            html = html + "<div class='imagelocdiv'><a href='<?php echo base_url() ?>index.php/posts/post?postid="+
            // m.get('PostId')+"'><img class='locpostimage' src='<?php echo base_url() ?>images/userposts/"+m.get('PostImage')+"'/></a></div>"+
            // "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
            // "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></a></div>" +
            // "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;

            // "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
            // "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div>"+
            // "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></div>" +
            // "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;

            "<a href='<?php echo base_url() ?>index.php/posts/post?postid=" + m.get('PostId') + "'></br>" +
            "<span><i class='fa-solid fa-post_id'></i>" + m.get('Question') + "</span></div>" +
            "<div class='commentsdiv' id='commentsdiv" + m.get('PostId') + "'></div></div>" ;//to display the comments on the post;
            this.$el.html(html);  
        }
    });

    var postCollection = new PostCollection();
    var postDisplay = new PostDisplay({model: postCollection})

</script>
</body>
</html>