<!DOCTYPE html>
<html>
    
<!-- Imports and other administrative info: -->
<head>
    <!-- META Tags: -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    <!-- Our PHP Function Library, And Our Preloader -->
    <?php  
        require("php/functions.php"); 
        include("imports/preloader.html");
    ?>
    
    <!-- CSS Stylesheets -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Open+Sans|Oswald|Oleo+Script" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

        <!-- FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">                              <!-- Google Icon Font -->
    <link rel="stylesheet" href="imports/materialize/css/materialize.min.css">                                          <!-- Materialize CSS -->
    <link rel="stylesheet" href="imports/fullcalendar/fullcalendar.css">                                                <!-- FullCalendar CSS -->

    <!-- Our General Stylesheet -->
    <link rel="stylesheet" href="css/general.css">

    <!-- Our Calendar Stylesheet -->
    <link rel="stylesheet" href="css/calendar.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!--

    Import FullCalendar and it's dependencies (jQuery, Momentjs).

    IMPORTANT: Import jQuery and MomentJS before FullCalendar and Materialize.js

    -->
    <script src='imports/fullcalendar/lib/jquery.min.js'></script>  <!-- jQuery -->
    <script src='imports/fullcalendar/lib/moment.min.js'></script> <!-- MomentJS -->
    <script src="imports/fullcalendar/fullcalendar.js"></script>   <!-- FullCalendar -->
    <script src="imports/materialize/js/materialize.min.js"></script> <!-- Materialize JS -->

    <!-- Our initialization script. -->
    <script src="lib/init.js"></script>
    
    <!-- Error Handling visualization -->
    <?php
        // Start the session if it doesn't exist.
        if(session_id() == '' || !isset($_SESSION)) {
            // session isn't started
            session_start();
        }
        if ( isset($_SESSION["error"]) ) {
            if ( $_SESSION["error"] == 0 ) {
    ?>
        <script>
            $(document).ready(function(){
               Materialize.toast('Success!', 8000, 'green');
            });
        </script>
    <?php
            } else if ( $_SESSION["error"] == 1 ) {
    ?>
        <script>
            $(document).ready(function(){
               Materialize.toast('Error when scheduling meeting. Room was already booked.', 8000, 'red');
            });
        </script>
    <?php   
            } else if ( $_SESSION["error"] == 2 ) {
    ?>
        <script>
            $(document).ready(function(){
               Materialize.toast('Error when scheduling meeting. Some people were already booked.', 8000, 'red');
            });
        </script>
    <?php
            } else if ( $_SESSION["error"] == 3 ) {
    ?>
        <script>
            $(document).ready(function(){
               Materialize.toast('Error: Some mandatory fields were left empty!', 8000, 'red');
            });
        </script>
    <?php
            } else if ( $_SESSION["error"] == 4 ) {
    ?>
        <script>
            $(document).ready(function(){
               Materialize.toast('Error: The start time was after the end time!', 8000, 'red');
            });
        </script>
    <?php   
            }
        }
        unset($_SESSION["error"]); // Error has been displayed.
    ?>
</head>


<!-- GUI -->
<body>

  <!-- ADD MEETING FORM -->
  <div id="add" class="modal modal-fixed-footer">
    <div class="modal-content">
    <div class="row col s12 center">
      <h4 style="margin-top: 20px; margin-bottom: 25px;">Create a Meeting:</h4>
      <div class="row">
          <form method="post" action="php/add_events.php">

            <!-- PEOPLE & FACILITIES -->
            <div class="col s12">
              <div class="col s2"></div><!--DUMMY-->
                
                  <!-- PEOPLE -->
                  <div class="input-field col s8 grey-text">

                    <select multiple id="selectThree" name="people[]">
                      <option value="" disabled selected>People</option>
                    <!-- PHP Display all rooms from our database! -->
                    <?php

                        $db = getDB(); // Imported from php/functions.php

                        $query = "SELECT * FROM people ORDER BY id";

                        // Generate all our rooms as HTML options:
                        $data = getContent($db, $query);
                        foreach($data as $row) { 
                        
                    ?>
                        <!-- GENERATE THE HTML OPTIONS WITH THE WANTED DATABASE INFO -->
                        <option value=<?php echo $row["id"]; ?> ><?php echo html_entity_decode($row["name"], ENT_NOQUOTES, "UTF-8")." (".$row["position"].")"; ?></option>

                    <?php
                        } // End foreach
                    ?>
                    </select>

                  </div>


              <!-- FACILITIES  REMOVED. WHEN YOU CHOOSE A ROOM, A FACILITY IS CHOSEN TOO!
              <div class="input-field col s4 grey-text">

                <select id="selectTwo" name="facility">
                  <option value="" disabled selected>Facilities</option>
                  <option value="TODO">TODO</option>
                  <option value="TODO">TODO</option>
                </select>

              </div>-->

              <div class="col s2"></div><!--DUMMY-->
            </div>

            <!-- ROOMS & DATE  -->
              <div class="col s12">
                <div class="col s2"></div><!--DUMMY-->

                  <!-- ROOMS -->
                  <div class="input-field col s4 grey-text">

                    <select id="selectOne" name="room">
                    <option value="" disabled selected>Rooms</option>
                        <!-- PHP Display all rooms from our database! -->
                        <?php

                            $db = getDB(); // Imported from php/functions.php

                            $query = "SELECT * FROM room ORDER BY id";

                            // Generate all our rooms as HTML options:
                            $data = getContent($db, $query);
                            foreach($data as $row) { 

                        ?>
                            <!-- GENERATE THE HTML OPTIONS WITH THE WANTED DATABASE INFO -->
                            <option value=<?php echo $row["name"]; ?> ><?php echo $row["name"]; ?></option>

                        <?php
                            } // End foreach
                        ?>
                    </select>

                  </div>

                  <!-- DATE -->
                  <div class="input-field col s4 grey-text">

                    <label for="datepicker" >Select Date</label>
                    <input id="datepicker" name="date" type="text" class="datepicker">

                  </div>


                <div class="col s2"></div><!--DUMMY-->
              </div>

                <!-- TIME & DATE -->
                <div class="col s12">
                  <div class="col s2"></div><!--DUMMY-->

                  <!-- TIME -->
                  <div class="input-field col s4 grey-text">

                    <label for="timepicker1" >Select Start Time</label>
                    <input id="timepicker1" name="startTime" type="text" class="timepicker">

                  </div>

                  <!-- TIME -->
                  <div class="input-field col s4 grey-text">

                    <label for="timepicker2" >Select End Time</label>
                    <input id="timepicker2" name="endTime" type="text" class="timepicker">

                  </div>

                  <div class="col s2"></div><!--DUMMY-->
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="col s12">
                    <br>
                    <button type="submit" role="submit" class="green darken-1 btn center">
                        <span class="flow-text">
                            ADD MEETING &nbsp;<i class="far fa-paper-plane"></i>
                        </span>
                    </button>
                </div>

            </form>
        </div>
    </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn blue darken-2">DONE</a>
    </div>
  </div>

  <!-- REMOVE MEETING FORM -->
  <div id="remove" class="modal modal-fixed-footer">
    <div class="modal-content">
    <div class="row col s12 center">
      <h4 style="margin-top: 20px; margin-bottom: 25px;">Manage Meetings:</h4>
      <div class="row">
          <form method="post" action="php/request_cancellation.php">

            <!-- MEETINGS ONLY -->
              <div class="col s12">
                <div class="col s1"></div><!--DUMMY-->

                  <!-- MEETINGS -->
                  <div class="input-field col s10 grey-text">

                    <select multiple id="selectFour" name="meetingIds[]">
                      <option value="" disabled selected>Browse Scheduled Meetings</option>
                        <!-- PHP Display all meetings from our database! -->
                        <?php

                            $db = getDB(); // Imported from php/functions.php

                            $query = "SELECT * FROM meeting ORDER BY id";

                            // Generate all our rooms as HTML options:
                            $data = getContent($db, $query);
                            foreach($data as $row) { 
                            $startTimeArr = explode(":",substr($row["start"], 11,17));
                            $endTimeArr = explode(":",substr($row["end"], 11,17));
                        ?>
                            
                            <!-- GENERATE THE HTML OPTIONS WITH THE WANTED DATABASE INFO -->
                            <option value=<?php echo $row["id"]; ?>> 
                                <?php 
                                    echo substr($row["start"], 0,10).' '
                                    .$startTimeArr[0].':'.$startTimeArr[1].' to '
                                    .$endTimeArr[0].':'.$endTimeArr[1].' in '.$row["room"]; 
                                ?>
                            </option>

                        <?php
                            } // End foreach
                        ?>
                    </select>

                  </div>

                <div class="col s1"></div><!--DUMMY-->
              </div>

                <!-- SUBMIT BUTTON -->
                <div class="col s12">
                    <br>
                    <button type="submit" role="submit" class="red darken-1 btn center">
                        <span class="flow-text">
                            REQUEST CANCELLATIONS &nbsp;<i class="far fa-paper-plane"></i>
                        </span>
                    </button>
                </div>

            </form>

            <div class="col s2"></div><!--DUMMY-->
            <div style="margin-top: 50px; margin-bottom: 40px;" class="col s8 divider"></div>
            <div class="col s2"></div><!--DUMMY-->

            <form method="post" action="php/cancellations.php">

            <!-- CANCELLATIONS ONLY -->
              <div class="col s12">
                <div class="col s1"></div><!--DUMMY-->

                  <!-- CANCELLATIONS -->
                  <div class="input-field col s10 grey-text">

                    <select multiple id="selectFive" name="cancellationIds[]">
                      <option value="" disabled selected>Browse Cancellation Requests</option>
                        <!-- PHP Display all meeting cancellations from our database! -->
                        <?php

                            $db = getDB(); // Imported from php/functions.php

                            $query = "SELECT * FROM cancellation ORDER BY id";

                            // Generate all our rooms as HTML options:
                            $data = getContent($db, $query);
                            foreach($data as $row) { 
                        ?>
                            
                            <!-- GENERATE THE HTML OPTIONS WITH THE WANTED DATABASE INFO -->
                            <option value=<?php echo $row["id"]; ?>> 
                                <?php 
                                    echo $row["date"].' '.$row["startTime"].' to '.$row["endTime"].' in '
                                        .$row["room"]; 
                                ?>
                            </option>

                        <?php
                            } // End foreach
                        ?>
                    </select>

                  </div>

                <div class="col s1"></div><!--DUMMY-->
              </div>

            <!-- SUBMIT BUTTON -->
            <div class="col s12">
                <br>
                <button type="submit" role="submit" name="approve" value="approve" class="green darken-1 btn center">
                    <span class="flow-text">
                        APPROVE &nbsp;<i class="fa fa fa-thumbs-up"></i>
                    </span>
                </button>
                <button type="submit" role="submit" name="deny" value="deny" class="red darken-1 btn center">
                    <span class="flow-text">
                        DENY &nbsp;<i class="far fa-frown"></i>
                    </span>
                </button>
            </div>

            </form>
        </div>
        </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn blue darken-2">DONE</a>
    </div>
  </div>

  <!-- TEAMS FORM -->
  <div id="team" class="modal modal-fixed-footer">
    <div class="modal-content">
    <div class="row col s12 center">
      <h4 style="margin-top: 20px; margin-bottom: 25px;">Manage Teams:</h4>
      <div class="row">
          
      <div style="margin-top: 10px;" class="row col s12">
          <form method="post" action="php/remove_team.php">

            <!-- Teams ONLY -->
              <div class="col s12">
                <div class="col s2"></div><!--DUMMY-->

                  <!-- Teams -->
                  <div class="input-field col s8 grey-text">

                    <select multiple id="selectFour" name="teamId[]">
                      <option value="" disabled selected>Browse Existing Teams</option>
                        <!-- PHP Display all meetings from our database! -->
                        <?php

                            $db = getDB(); // Imported from php/functions.php

                            $query = "SELECT * FROM team ORDER BY id";

                            // Generate all our teams as HTML options:
                            $data = getContent($db, $query);
                            foreach($data as $row) { 
                        ?>

                            <!-- GENERATE THE HTML OPTIONS WITH THE WANTED DATABASE INFO -->
                            <option value=<?php echo $row["id"]; ?>> 
                                <?php 
                                    echo $row["name"];
                                ?>
                            </option>

                        <?php
                            } // End foreach
                        ?>
                    </select>

                  </div>

                <div class="col s2"></div><!--DUMMY-->
              </div>
            <!-- SUBMIT BUTTON -->
            <div class="col s12">
                <br>
                <button type="submit" role="submit" name="deny" value="deny" class="red darken-1 btn center">
                    <span class="flow-text">
                        REMOVE TEAM &nbsp;<i class="far fa-frown"></i>
                    </span>
                </button>

            </div>
            </form>
        </div>
          
        <div style="margin-top: 50px;" class="row col s12">
            <form method="post" action="php/add_team.php">

                <!-- ADD A TEAM ONLY -->
                  <div class="col s12">
                    <div class="col s2"></div><!--DUMMY-->

                      <!-- Team Name -->
                      <div class="input-field col s8 grey-text">
                          <input placeholder="Eg. 'Creative'" id="teamName" name="teamName" type="text" class="validate">
                          <label for="teamName">Team Name</label>
                      </div>

                    <div class="col s2"></div><!--DUMMY-->
                  </div>
                <!-- SUBMIT BUTTON -->
                <div class="col s12">
                    <br>
                    <button type="submit" role="submit" name="approve" value="approve" class="green darken-1 btn center">
                        <span class="flow-text">
                            ADD TEAM &nbsp;<i class="fa fa fa-thumbs-up"></i>
                        </span>
                    </button>
                </div>
                </form>
          </div>
          
        </div>
        </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn blue darken-2">DONE</a>
    </div>
  </div>
    
    
  <!-- PEOPLE FORM -->
  <div id="people" class="modal modal-fixed-footer">
    <div class="modal-content">
    <div class="row col s12 center">
      <h4 style="margin-top: 20px; margin-bottom: 25px;">Manage People:</h4>
      <div class="row">
          
          <div class="row col s12">
              <form method="post" action="php/remove_people.php">

                <!-- People  -->
                  <div class="col s12">
                    <div class="col s2"></div><!--DUMMY-->

                      <!-- PEOPLE -->
                      <div class="input-field col s8 grey-text">

                        <select multiple id="selectThree" name="peopleIds[]">
                          <option value="" disabled selected>People</option>
                        <!-- PHP Display all rooms from our database! -->
                        <?php

                            $db = getDB(); // Imported from php/functions.php

                            $query = "SELECT * FROM people ORDER BY id";

                            // Generate all our rooms as HTML options:
                            $data = getContent($db, $query);
                            foreach($data as $row) { 

                        ?>
                            <!-- GENERATE THE HTML OPTIONS WITH THE WANTED DATABASE INFO -->
                            <option value=<?php echo $row["id"]; ?> ><?php echo html_entity_decode($row["name"], ENT_NOQUOTES, "UTF-8")." (".$row["position"].")"; ?></option>

                        <?php
                            } // End foreach
                        ?>
                        </select>

                      </div>

                    <div class="col s2"></div><!--DUMMY-->
                  </div>

                <!-- SUBMIT BUTTON -->
                <div class="col s12">
                    <br>
                    <button type="submit" role="submit" name="deny" value="deny" class="red darken-1 btn center">
                        <span class="flow-text">
                            REMOVE PEOPLE &nbsp;<i class="far fa-frown"></i>
                        </span>
                    </button>

                </div>

                </form>
            </div>
          
        <div style="margin-top: 50px;" class="row col s12">
            <form method="post" action="php/add_person.php">

                <!-- ADD A PERSON ONLY -->
                  <div class="col s12">
                    <div class="col s2"></div><!--DUMMY-->

                      <!-- Name -->
                      <div class="input-field col s4 grey-text">
                          <input placeholder="Eg. 'Peter Parker'" id="name" name="name" type="text" class="validate">
                          <label for="name">Full Name</label>
                      </div>
                      
                      <!-- Position -->
                      <div class="input-field col s4 grey-text">
                          <input placeholder="Eg. 'CEO'" id="name" name="name" type="text" class="validate">
                          <label for="name">Position</label>
                      </div>

                    <div class="col s2"></div><!--DUMMY-->
                      

                  </div>
                
                <div class="col s12">
                     <div class="col s2"></div><!--DUMMY--> 
                                            <!-- Team -->
                      <div class="input-field col s8 grey-text">
                        <select multiple id="selectFour" name="teamNames[]">
                          <option value="" disabled selected>Add Person to Teams</option>
                            <!-- PHP Display all meetings from our database! -->
                            <?php

                                $db = getDB(); // Imported from php/functions.php

                                $query = "SELECT * FROM team ORDER BY id";

                                // Generate all our teams as HTML options:
                                $data = getContent($db, $query);
                                foreach($data as $row) { 
                            ?>

                                <!-- GENERATE THE HTML OPTIONS WITH THE WANTED DATABASE INFO -->
                                <option value=<?php echo $row["name"]; ?>> 
                                    <?php 
                                        echo $row["name"];
                                    ?>
                                </option>

                            <?php
                                } // End foreach
                            ?>
                        </select>
                      </div>

                     <div class="col s2"></div><!--DUMMY--> 
                </div> 
                <!-- SUBMIT BUTTON -->
                <div class="col s12">
                    <br>
                    <button type="submit" role="submit" name="approve" value="approve" class="green darken-1 btn center">
                        <span class="flow-text">
                            ADD PERSON &nbsp;<i class="fa fa fa-thumbs-up"></i>
                        </span>
                    </button>
                </div>
                </form>
          </div>
          
        </div>
        </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn blue darken-2">DONE</a>
    </div>
  </div>
    
    <!-- MAIN GUI -->
    <div class="row col s12">

        <!-- CALENDAR -->
        <div class=" col s10 offset-s1 schedule"></div>

        <!-- MENU / BUTTONS -->
        <div id="buttonHolder">
          <div class="fixed-action-btn horizontal">

            <!-- MENU HOVER BUTTON -->
            <a class="z-depth-3 btn-floating btn-large blue darken-2">
              <i class="large material-icons">mode_edit</i>
            </a>

            <!-- ADD/REMOVE BUTTONS -->
            <ul>
              <li>
                  <a id="addBtn" class="hoverableBtn btn-floating green darken-2 modal-trigger" href="#add"><i class="material-icons">event_available</i>
                  </a>
              </li>
              <li>
                  <a id="removeBtn" class="hoverableBtn btn-floating red darken-2 modal-trigger" href="#remove"><i class="material-icons">event_busy</i>
                  </a>
              </li>
              <li>
                  <a id="team" class="hoverableBtn btn-floating orange darken-2 modal-trigger" href="#team">
                      <i class="material-icons">group</i>
                  </a>
              </li>
                
              <li>
                  <a id="people" class="hoverableBtn btn-floating blue darken-3 modal-trigger" href="#people">
                      <i class="material-icons">person</i>
                  </a>
              </li>
            </ul>

          </div>

        </div>

    </div>

</body>
</html>
