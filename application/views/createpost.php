<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/createpost.css">
</head>
<body>
    <div class="uppostcontainer">
        <!-- <div class="filediv"> -->
        <div class="captiondiv">
            <div class="errormsg" id="errormsg"></div>
            <div class="caplabel"> <label for="caption">Enter the Question Below</label></div>
            <div><textarea name="question" id="question" maxlength="255"></textarea></div>
            <div class="caplabel"> <label for="caption">Caption</label></div>
            <div><textarea name="caption" id="caption"  maxlength="100"></textarea></div>

            <div class="loclabel"><label for="questtags">Tags</label></div>
            <div>
                <select onchange='getquesttag();' id="questtags">
                    <option id ='questtagName' value=""></option>
                </select>
            </div>
            <div class="postsubmitdiv"><div id="uploadpost" >Post Question</div></div>
        </div>
    </div>
        <script type="text/javascript" lang="javascript">
        var $questtagid = "1";
        //load tag posts at start and display in drop down
        $.ajax({
            //to get tags parametered from Posts.php controller,and it is used to display the dropdown of the ask question form
            url: "<?php echo base_url() ?>index.php/posts/questtag/action/all",
            method: "GET"
        }).done(function (data) {
	        $('#questtags option').remove();
			for (i = 0; i < data.length; i++) {
		    	var option ="<option id ='questtagName' value="+data[i].QuesttagId+">"+data[i].QuesttagName+"</option>";
			    $('#questtags').append(option);
		    }                     
        });

        function getquesttag() {
            $questtagid = document.getElementById("questtags").value;
        }

        $("#uploadpost").click(function(event) {
            event.preventDefault();
            var caption = $('#caption').val();
            var question = $('#question').val();
            // var questiontags = $('#questiontags').val();//This is used to send the tags from the form

            var postdata = {
                questtagid: $questtagid,
                caption: caption,
                question: question,
                // questiontags:questiontags
            };

            $.ajax({
                url: "<?php echo base_url() ?>index.php/posts/create",
                data: JSON.stringify(postdata),
                contentType: "application/json",
                method: "POST"
            }).done(function (data) {
                var result = data.result;
                if (result == "done") {
                    location.href="<?php echo base_url()?>index.php/myprofile";
                }
                else {
                    document.getElementById("errormsg").innerHTML = "Post is not created";
                }
            });
        });
    </script>
</body>
</html> 




