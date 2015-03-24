<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Teacher');
?>

<!DOCTYPE html>
<HTML>
   <link rel="stylesheet" type="text/css" href="teacherHomePage.css">
   <script src="tabcontent.js" type="text/javascript"></script>
   <script src="jquery-1.11.2.js"></script>
   <?php include_once 'teacherHomePage_control.php'; ?>

<HEAD>
    <style>
        div#load_screen{
            background:#FFF;
            opacity:0.7;
            position:fixed;
            z-index:10;
            top: 0px;
            width:100%;
            height:100%;
        }
    </style>
    <script>
        window.addEventListener("load", function(){
            var load_screen = document.getElementById("load_screen");
            document.body.removeChild(load_screen);
        });
    </script>
    <TITLE>
        MegaTest - Online Testing Application
    </TITLE>
</HEAD>

<BODY style="background:#F6F9FC; font-family:Arial;">
   <?php include_once 'reload_goback.php'; ?>
   <div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
   <div class="header">
       <img src="images/header.png" class="header"/>
       <img src="images/logo.png" class="testLogo"/>
       <form action="logout.php"><input type="submit" value="Sign out" class="logout-button"></form>
   </div>

   <div id='cssmenu'>
       <ul>
           <li class='loginPage.html'><a href='#'><span>Home</span></a></li>
           <li><a href='#'><span>About</span></a></li>
           <li><a href='#'><span>Team</span></a></li>
           <li class='last'><a href='#'><span>Contact</span></a></li>
       </ul>
   </div>

   <div class="content">
      <form action="testMakingPage.php"><input type="submit" value="+ Create Test" class="create-button"></form>

      <div class="courses">
         <table id="courseTable">
            <?php $class_list = get_class_list(); ?>
         </table>
      </div>

      <span id='classTitle'></span><br />

      <div class="testEachCourse">
         <div class="loader"></div>
         <div class="welcome"></div>
         <table id="testTable">
            <!-- Table Elements Generated By AJAX Script -->
         </table>
      </div>
   </div>


   <div class="footer"></br>
      <img src="images/footerblue.png" class="footerblue"/>
      <ft>&copy; MegaMonkeys, Inc. - Pensacola Christian College 2015</ft>
   </div>
</BODY>
</HTML>


<script type="text/javascript">
   $(document).ready(function() { $.ajaxSetup({ cache: false }); });

   var current;
   var class_list = <?php echo json_encode($class_list) ?>;
      //[0]-COURSE_NO [1]-SECTION_NO [2]-SECTION_ID [3]-COURSE_DESCRIPTION
   //get_class_test(Object.keys(class_list)[0]);
   $(".loader").fadeOut(1);

   function get_class_test(section_id) {
      current = section_id;
      $(".welcome").fadeOut(1);
      $("#testTable").fadeOut(1);
      $(".loader").fadeIn("slow");
      document.getElementById("classTitle").innerHTML = class_list[section_id];
      var data = 'teacherHomePage_control.php?section_id=' + section_id;
      $('#testTable').load(data);
   }

   function delete_test(test_id) {
      $("#testTable").fadeOut(1);
      $(".loader").fadeIn("slow");
      var data = 'teacherHomePage_control.php?action=delete&section_id=' + current + '&test_id=' + test_id;
      $('#testTable').load(data);
   }

   function modify_test(test_id) {
      var data = 'teacherHomePage_control.php?action=modify&section_id=' + current + '&test_id=' + test_id;
      window.location.href = data;
   }

   function grade_test(test_id) {
      alert('under construction');
   }

   $(document).ajaxComplete(function() {
      $(".loader").fadeOut(1);
      $("#testTable").fadeIn("slow");
   });

   //When Page Loads
   $(function() {
      page_resize();
   });
   //When Page Size Changes
   $( window ).resize(function() {
      page_resize();
   });
      function page_resize() {
         //alert($(window).height() + " " + $(document).height());
         $('#classTitle').css("left", 300 + ($(window).width() - 1100) / 2);
         $('.courses').css("max-height", $(window).height() - 360);
         $('.testEachCourse').css("left", 300 + ($(window).width() - 1100) / 2);
         $('.testEachCourse').css("height", $(window).height() - 280 );
      }
</script>

<?php
   if( isset( $_SESSION['section_id'] ) ) {
      echo '<script type="text/javascript"> get_class_test('.$_SESSION['section_id'].'); </script>';
      unset($_SESSION['section_id']);
   }
?>