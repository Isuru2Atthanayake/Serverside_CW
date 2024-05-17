<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>QuestEdu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/navigation.css">
</head>
<body>
     <div class="navigatdiv">
          <div class="weblogodiv">
               <a href="<?php echo base_url()?>index.php/home">
               <img class="logoimage" src="<?php echo base_url() ?>images/logo.png" alt="Logo" /></a>
          </div>
          <div class="navdiv">
               <div class="navelementdiv">
                        <a href="<?php echo base_url()?>index.php/postquestctrl" class="icon-button">
                            <img class="linkimage" src="<?php echo base_url() ?>" alt="Add Post"/>
                            <span>Ask a Question</span>
                        </a>
               </div>
               <div class="navelementdiv">
                    <a href="<?php echo base_url()?>index.php/home">
                    <img class="linkimage" src="<?php echo base_url() ?>images/home.png"/></a>
               </div>
              <div class="navelementdiv userprofdiv">
                  <a href="<?php echo base_url()?>index.php/myprofile" class="profilelink">
                      <span><?php echo $username ?></span>
                  </a>
              </div>
          </div>
     </div>
     <!-- search -->
     <div class="searchresults" id="searchresults"></div>


     <script type="text/javascript" lang="javascript">
     var username="<?php echo $username ?>";
     //search function WHEN USER TYPES IN SEARCH BAR
     function searchquest() {
         if($('#search').val().length==0){
             document.getElementById("searchresults").style.display = "none";
         }
         else{//overlay only displayed when something is typed
             document.getElementById("searchresults").style.display = "block";
         }
         var userdata = {//get the search string
             question: $('#search').val().toLowerCase()
         };
         $.ajax({//get questions from the search string
             url: "<?php echo base_url() ?>index.php/users/user/action/searchquest",
             data: JSON.stringify(userdata),
             contentType: "application/json",
             method: "POST"
         }).done(function (data) {//display the search results
             $('#searchresults div').remove();
             $('#searchresults a').remove();
             if(data.length==0){//display no results if array length is 0
                 var div ="<div class ='user noresult'>No Results</div>";
                 $('#searchresults').append(div);
             }
             else{//display the search results
                 for (i = 0; i < data.length; i++) {
                     var div ="<a class='userlinks' href='<?php echo base_url() ?>index.php/postquestctrl/post?postid="
                         +data[i].PostId+"'><div class ='user'><div class='searchqestdat'>"+data[i].Question+"<br>"+data[i].QuestTitle+"</div></div></a>";
                     $('#searchresults').append(div);
                 }
             }
         });
     }
     </script>
</body>
</html>