<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!-- user view "Search,notify" -->
<html lang="en">
<head>
    <title>HolidayGram</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/navigation.css">
</head>
<body>
     <div class="navigationdiv">
          <div class="logodiv">
               <a href="<?php echo base_url()?>index.php/home">
               <img class="logoimage" src="<?php echo base_url() ?>images/logo.png" alt="Logo" /></a>
          </div>
          <div class="searchdiv"> 
               <input type="text" class="search" id="search" placeholder="Search for user..." onkeyup='searchusers()'/>
          </div>
          <div class="linkdiv">
               <div class="linkelement">
                    <a href="<?php echo base_url()?>index.php/posts">
                    <img class="linkimage" src="<?php echo base_url() ?>images/add.png"/></a>
               </div>
               <div class="linkelement">
                    <a href="<?php echo base_url()?>index.php/home">
                    <img class="linkimage" src="<?php echo base_url() ?>images/home.png"/></a>
               </div>
               <div class="linkelement">
                    <img style="cursor:pointer" onclick='notifications();' class="linkimage" src="<?php echo base_url() ?>images/bell.png"/>
               </div>
          </div>
          <div class="profilediv">
               <div class="userlink">
               <a href="<?php echo base_url()?>index.php/myprofile" class="profilelink"><span><?php echo $username ?></span></a></div>
          </div>
     </div>
     <!-- search and notification overlays -->
     <div class="searchresults" id="searchresults"></div>
     <div class="notifications" id="notifications"></div>

     <script type="text/javascript" lang="javascript">
     var username="<?php echo $username ?>";
     // function searchusers() {
     //      if($('#search').val().length==0){
     //           document.getElementById("searchresults").style.display = "none";
     //      }
     //      else{//overlay only displayed when something is typed
     //           document.getElementById("searchresults").style.display = "block";
     //      }
     //      var userdata = {
     //            username: "@" + $('#search').val().toLowerCase()
     //      };
     //      $.ajax({//get users from the search string
     //            url: "<?php echo base_url() ?>index.php/users/user/action/searchuser",
     //            data: JSON.stringify(userdata),
     //            contentType: "application/json",
     //            method: "POST"
     //        }).done(function (data) {
     //           $('#searchresults div').remove(); 
     //           $('#searchresults a').remove(); 
     //           if(data.length==0){//display no results if array length is 0
     //                var div ="<div class ='user noresult'>No Results</div>";
     //                $('#searchresults').append(div);
     //           }
     //           else{
     //                for (i = 0; i < data.length; i++) {
     //                     var div ="<a class='userlinks' href='<?php echo base_url() ?>index.php/users/userprofile/?username="
     //                     +data[i].Username+"'><div class ='user'><div class= 'seauserimagediv'><img class='seauserimage' src='<?php echo base_url() ?>images/profilepics/"
     //                     +data[i].UserImage+"'/></div><div class='searuserdeet'>"+data[i].Username+"<br>"+data[i].Name+"</div></div></a>";
     //                     $('#searchresults').append(div);
	// 	          } 
     //           }
     //      });
     // }
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
                         +data[i].PostId+"'><div class ='user'><div class='searuserdeet'>"+data[i].Question+"<br>"+data[i].Caption+"</div></div></a>";
                         $('#searchresults').append(div);
		          }
               }
          });
     }
     //when notification button is clicked on
     function notifications(){//pverlay on displays when its clicked
          if(document.getElementById("notifications").style.display == "none"){
               document.getElementById("notifications").style.display = "block";
               $.ajax({//get notifications for user
                    url: "<?php echo base_url() ?>index.php/myprofile/notifications",
                    data: JSON.stringify({username: username}),
                    contentType: "application/json",
                    method: "GET"
               }).done(function (data) {
                    $('#notifications div').remove(); 
                    $('#notifications a').remove(); 
                    if(data.length==0){//no notifications
                    var div ="<div class =''>No Notifications</div>";
                    $('#notifications').append(div);
               }
               else{
                    for (i = 0; i < data.length; i++) {
                         //when there is a comment body, means a comment notification
                         if (data[i].CommentBody!=null && data[i].PostId!=null){
                              var div ="<a href='<?php echo base_url() ?>index.php/posts/post?postid="
                              +data[i].PostId+"'><div>"+data[i].Username+"    "+data[i].Notification+"</br><span class='commentspam'>"
                              +data[i].CommentBody+"</span></div></a>";
                              $('#notifications').append(div);
                         }//when there is a post id but no comment, means its a post like
                         else if(data[i].CommentBody==null && data[i].PostId!=null){
                              var div ="<a href='<?php echo base_url() ?>index.php/posts/post?postid="
                              +data[i].PostId+"'><div>"+data[i].Username+"    "+data[i].Notification+"</div></a>";
                              $('#notifications').append(div);
                         }//otherwise its a follow
                         else if(data[i].CommentBody==null && data[i].PostId==null){
                              var div ="<a href='<?php echo base_url() ?>index.php/users/userprofile/?username="
                              +data[i].Username+"'><div>"+data[i].Username+"    "+data[i].Notification+"</div></a>";
                              $('#notifications').append(div);
                         }
		          } 
               }
          });
     }
     else{
          document.getElementById("notifications").style.display = "none";
     }
     }
     </script>
</body>
</html>