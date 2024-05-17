<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/createQuestpost.css">
</head>
<body>
<!--this is the interface of creating the question posts and it is used to post the question to the database-->
    <div class="postquestcontainer">
        <div class="questdiv">
            <div class="questerr" id="questerr"></div>
            <div class="queslabel"> <label for="questtitle">Enter the Question Below</label></div>
            <div><textarea name="question" id="question" maxlength="255"></textarea></div>
            <div class="queslabel"> <label for="questtitle">About Question</label></div>
            <div><textarea name="questtitle" id="questtitle"  maxlength="100"></textarea></div>

            <div class="questtag"><label for="questtags">Tags</label></div>
            <div>
                <select onchange='getquesttag();' id="questtags">
                    <option id ='questtagName' value=""></option>
                </select>
            </div>
            <div class="questsubmitdiv"><div id="uploadquest" >Post Question</div></div>
        </div>
    </div>
        <script type="text/javascript" lang="javascript">
        var $questtagid = "1";//default tag id of the questions
        //load tag posts at start and display in drop down
        $.ajax({
            //to get tags parametered from Posts.php controller,and it is used to display the dropdown of the ask question form
            url: "<?php echo base_url() ?>index.php/postquestctrl/questtag/action/all",
            method: "GET"
        }).done(function (data) {//this is used to display the tags in the dropdown
	        $('#questtags option').remove();
			for (i = 0; i < data.length; i++) {
		    	var option ="<option id ='questtagName' value="+data[i].QuesttagId+">"+data[i].QuesttagName+"</option>";
			    $('#questtags').append(option);
		    }                     
        });

        function getquesttag() {//this is used to get the tag id of the selected tag in the dropdown
            $questtagid = document.getElementById("questtags").value;
        }

        $("#uploadquest").click(function(event) {//this is used to post the question to the database
            event.preventDefault();
            var questtitle = $('#questtitle').val();//This is used to send the title from the form
            var question = $('#question').val();//This is used to send the question from the form


            var postdata = {//this is used to send the data to the database to store the question including the questtagid,questtitle and question
                questtagid: $questtagid,
                questtitle: questtitle,
                question: question,
            };

            $.ajax({//this is used to send the data to the database to store the question if the data is valid and it is used to display the error message if the data is not valid
                url: "<?php echo base_url() ?>index.php/postquestctrl/create",
                data: JSON.stringify(postdata),
                contentType: "application/json",
                method: "POST"
            }).done(function (data) {
                var result = data.result;
                if (result == "done") {
                    location.href="<?php echo base_url()?>index.php/myprofile";
                }
                else {
                    document.getElementById("questerr").innerHTML = "Post is not created";
                }
            });
        });
    </script>
</body>
</html> 




