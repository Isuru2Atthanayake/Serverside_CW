<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!-- user view "Search,notify" -->
<html lang="en">
<head>
    <title>QuestEdu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/navigation.css">
</head>
<body>
     <div class="navigationdiv">
          <div class="logodiv">
               <a href="<?php echo base_url()?>index.php/home">
               <img class="logoimage" src="<?php echo base_url() ?>images/logo.png" alt="Logo" /></a>
          </div>
<!--          <div class="searchdiv">-->
<!--               <input type="text" class="search" id="search" placeholder="Search for Questions..." onkeyup='searchusers()'/>-->
<!--          </div>-->
          <div class="linkdiv">
               <div class="linkelement">
                        <a href="<?php echo base_url()?>index.php/posts" class="icon-button">
                            <img class="linkimage" src="<?php echo base_url() ?>" alt="Add Post"/>
                            <span>Ask a Question</span>
                        </a>
               </div>
               <div class="linkelement">
                    <a href="<?php echo base_url()?>index.php/home">
                    <img class="linkimage" src="<?php echo base_url() ?>images/home.png"/></a>
               </div>
<!--               <div class="linkelement">-->
<!--                    <img style="cursor:pointer" onclick='notifications();' class="linkimage" src="--><?php //echo base_url() ?><!--images/bell.png"/>-->
<!--               </div>-->
<!--              <div class="profilediv">-->
<!--                  <div class="userlink">-->
<!--                      <a href="--><?php //echo base_url()?><!--index.php/myprofile" class="profilelink"><span>--><?php //echo $username ?><!--</span></a></div>-->
<!--              </div>-->
              <div class="linkelement profilediv">
                  <a href="<?php echo base_url()?>index.php/myprofile" class="profilelink">
                      <span><?php echo $username ?></span>
                  </a>
              </div>
          </div>

     </div>
     <!-- search and notification overlays -->
     <div class="searchresults" id="searchresults"></div>
<!--     <div class="notifications" id="notifications"></div>-->

     <script type="text/javascript" lang="javascript">
     var username="<?php echo $username ?>";
     //search function WHEN USER TYPES IN SEARCH BAR
     function searchusers() {
          if($('#search').val().length==0){
               document.getElementById("searchresults").style.display = "none";
          }
          else{//overlay only displayed when something is typed
               document.getElementById("searchresults").style.display = "block";
          }
          var userdata = {
                question: $('#search').val().toLowerCase()
          };
          $.ajax({//get users from the search string
                url: "<?php echo base_url() ?>index.php/users/user/action/searchuser",
                data: JSON.stringify(userdata),
                contentType: "application/json",
                method: "POST"
            }).done(function (data) {
               $('#searchresults div').remove(); 
               $('#searchresults a').remove(); 
               if(data.length==0){//display no results if array length is 0
                    var div ="<div class ='user noresult'>No Results</div>";
                    $('#searchresults').append(div);
               }
               else{
                    // for (i = 0; i < data.length; i++) {
                    //      var div ="<a class='userlinks' href='<?php echo base_url() ?>index.php/users/userprofile/?username="
                    //      +data[i].Question+"'><div class ='user'><div class= 'seauserimagediv'><img class='seauserimage' src='<?php echo base_url() ?>images/profilepics/"
                    //      +data[i].UserImage+"'/></div><div class='searuserdeet'>"+data[i].Question+"<br>"+data[i].Name+"</div></div></a>";
                    //      $('#searchresults').append(div);
		          // } 
                    for (i = 0; i < data.length; i++) {
                         var div ="<a class='userlinks' href='<?php echo base_url() ?>index.php/posts/post?postid="
                         +data[i].PostId+"'><div class ='user'><div class='searuserdeet'>"+data[i].Question+"<br>"+data[i].QuestTitle+"</div></div></a>";
                         $('#searchresults').append(div);
		          }
               }
          });
     }
     </script>
</body>
</html>