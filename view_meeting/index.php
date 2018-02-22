<!DOCTYPE html>
<html>
    
<!-- Imports and other administrative info: -->
<head>
    <!-- META Tags: -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    <!-- Our PHP Function Library, And Our Preloader -->
    <?php  
        require("../php/functions.php"); 
        include("../imports/preloader.html");
    ?>
    
    <!-- CSS Stylesheets -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Open+Sans|Oswald|Oleo+Script" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
       <!-- FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">                              <!-- Google Icon Font -->
    <link rel="stylesheet" href="../imports/materialize/css/materialize.min.css">                                          <!-- Materialize CSS -->
    <link rel="stylesheet" href="../imports/fullcalendar/fullcalendar.css">                                                <!-- FullCalendar CSS -->

    <!-- Our General Stylesheet -->
    <link rel="stylesheet" href="../css/general.css">

    <!-- Our Calendar Stylesheet -->
    <link rel="stylesheet" href="../css/calendar.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!--

    Import FullCalendar and it's dependencies (jQuery, Momentjs).

    IMPORTANT: Import jQuery and MomentJS before FullCalendar and Materialize.js

    -->
    <script src='../imports/fullcalendar/lib/jquery.min.js'></script>  <!-- jQuery -->
    <script src='../imports/fullcalendar/lib/moment.min.js'></script> <!-- MomentJS -->
    <script src="../imports/fullcalendar/fullcalendar.js"></script>   <!-- FullCalendar -->
    <script src="../imports/materialize/js/materialize.min.js"></script> <!-- Materialize JS -->

    <!-- Our initialization script. -->
    <script src="lib/init.js"></script>
    
    <script>

        $(document).ready(function(){
                      
            // Preloader
            $('.preloader-background').delay(200).fadeOut('slow');
            $('.preloader-wrapper').delay(200).fadeOut();  
            
        });
    
    </script>
    
    <!-- Meeting Info Handling -->
    <?php
    
        $date = ""; 
        $startTime = ""; 
        $endTime = ""; 
        $facility = ""; // TODO
        $room = "";
        $people = "";   // TODO
        $badgesString = "";
        $colorArr = ["blue","green","red","yellow","black","pink", "orange"];
    
        if ( isset($_GET["id"]) ) {
                  
            $db = getDB(); // Imported from php/functions.php

            $query = "SELECT * FROM meeting WHERE id=".$_GET["id"];

            // Generate all our rooms as HTML options:
            $data = getContent($db, $query);
            foreach($data as $row) { 

                $meetingID = $row["id"];
                $date = substr($row["start"],0,10);
                $startTime = substr($row["start"],11,13);
                $endTime = substr($row["end"],11,13);
                $room = $row["room"];
                $people = $row["people_ids"];
                $facility = $row["facility"];
                

            } // End foreach
            
            
            $allID = "(".$people.")";
            $query = "SELECT * FROM people WHERE id IN ".$allID;
            $allPeople = "";
            
            // Generate all our rooms as HTML options:
            $data = getContent($db, $query);
            foreach($data as $row) { 
                
                $teams = explode(",",$row["teams"]);
                $allBadgeString = "";
                $i =  0;
                foreach($teams as $team) {
                    $allBadgeString .= '<span class="new badge '.$colorArr[$i].'" data-badge-caption="'.$team.'"></span>';
                    $i+=1;
                }

                $allPeople .= 
                '
                <li class="collection-item avatar">
                  <img src="../img/profile.png" alt="" class="circle">
                  <span class="title">'.$row["name"].'</span>
                  <p> 
                     '.$row["position"].'
                  </p>
                  <a href="#!" class="secondary-content">'.$allBadgeString.'</a>
                </li>
                ';

            } // End foreach
            
     
        } else {  
            // We're missing the ID. Redirect to main page.
            header("Location: http://localhost/simple_meeting_scheduler/");
        }
    ?>
</head>

<!-- View Meeting GUI -->
<body>
    <div class="row">
        <div style="margin-top: 100px;" class="col s12">
            <div class="col s3"></div><!--DUMMY-->
            <div class="col s6">
            
              <!-- Meeting info: -->
              <div class="notHoverable card webOrange white-text z-depth-4">
                <div class="card-content">
                  <p>Meeting ID: <?php echo $meetingID;?> </p>
                </div>
                <div class="card-tabs">
                  <ul style="overflow:hidden!important;" class="tabs tabs-fixed-width">
                    <li class="tab"><a href="#test4">WHEN</a></li>
                    <li class="tab"><a class="active" href="#test5">WHERE</a></li>
                    <li class="tab"><a href="#test6">WHO</a></li>
                  </ul>
                </div>
                <div style="min-height: 150px; max-height: 950px;" class="card-content grey lighten-4">
                  <div class="black-text" id="test4">
                    Date: <b><?php echo $date ?></b> <br><br>
                    Start Time: <b><?php echo $startTime ?></b> <br><br>
                    End Time: <b><?php echo $endTime ?></b>
                  </div>
                  <div class="black-text" id="test5">
                    Facility: <b><?php echo $facility ?></b><br><br>
                    Room: <b><?php echo $room ?></b>
                  </div>
                  <div class="black-text" id="test6">
                    <ul class="collection">
                    
                        <?php echo $allPeople ?>
                      
                    </ul>
                  </div>
                </div>
              </div>
             <div style="position: absolute; bottom: 10px; left: 10px;">
               <div class="col s12 center"> 
                    <a href="../">    
                       <button class="hoverableBtn blue btn-large center waves-effect waves-light">Go Back Home</button>
                    </a>
                </div>
                </div>
            </div>
            <div class="col s3"></div><!--DUMMY-->
        </div>
    </div>

</body>
</html>
