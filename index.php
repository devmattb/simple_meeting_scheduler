<!DOCTYPE html>
<html>
<head>

    <!-- CSS Stylesheets -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Open+Sans|Oswald|Oleo+Script" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">          <!-- FontAwesome Icons -->
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


    <!-- Initialize FullCalendar -->
    <script>
        $(document).ready(function() {

            // Init modals:
            $('.modal').modal();

            // Init form elements
            $('select').material_select();

            // Init schedule
            $('.schedule').fullCalendar({

              header: {
                // Buttons and header text:
                left: 'agendaDay, agendaWeek, month, list',
                center: 'title',
                right: 'prev, today, next'

              },
              allDayText: 'Deadlines', // Appears on top of the calendar issues.
              //´Specifying our time ranges.
              minTime: '06:00:00',
              maxTime: '22:00:00',
              editable: false, // Not editable
              weekends: true, // Include weekends.
              defaultView: 'agendaWeek',
              eventStartEditable: false,
              // Enabling list-view.
              listDayFormat: true,
              height: 950,

                // TODO: Get events from DB!

            });

            // Init timepicker
            $('.timepicker').pickatime({
                default: 'now', // Set default time: 'now', '1:30AM', '16:30'
                fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
                twelvehour: false, // Use AM/PM or 24-hour format
                donetext: 'OK', // text for done-button
                cleartext: 'Clear', // text for clear-button
                canceltext: 'Cancel', // Text for cancel-button
                autoclose: false, // automatic close timepicker
                ampmclickable: true, // make AM PM clickable
                aftershow: function(){} //Function for after opening timepicker
            });

            // Init datepicker:
            $('.datepicker').pickadate({
              selectMonths: true, // Creates a dropdown to control month
              selectYears: false, // Creates a dropdown of 15 years to control year,
              today: 'Today',
              clear: 'Clear',
              close: 'DONE',
              formatSubmit: 'yyyy-mm-dd',
              closeOnSelect: true // Close upon selecting a date,
            });


        }); // End of document.ready()
    </script>
</head>

<body>

  <!-- ADD MEETING FORM -->
  <div id="add" class="modal modal-fixed-footer">
    <div class="modal-content">
    <div class="row col s12 center">
      <h4 style="margin-top: 20px; margin-bottom: 25px;">Create a Meeting:</h4>
      <div class="row">
          <form>

            <!-- ROOMS & FACILITIES -->
            <div class="col s12">
              <div class="col s2"></div><!--DUMMY-->

              <!-- ROOMS -->
              <div class="input-field col s4 grey-text">

                <select id="selectOne" name="rooms">
                  <option value="" disabled selected>Rooms</option>
                  <option value="TODO">TODO</option>
                  <option value="TODO">TODO</option>
                </select>

              </div>

              <!-- FACILITIES -->
              <div class="input-field col s4 grey-text">

                <select id="selectTwo" name="facilities">
                  <option value="" disabled selected>Facilities</option>
                  <option value="TODO">TODO</option>
                  <option value="TODO">TODO</option>
                </select>

              </div>

              <div class="col s2"></div><!--DUMMY-->
            </div>

            <!-- PEOPLE ONLY -->
              <div class="col s12">
                <div class="col s2"></div><!--DUMMY-->

                  <!-- PEOPLE -->
                  <div class="input-field col s8 grey-text">

                    <select multiple id="selectThree" name="people">
                      <option value="" disabled selected>People</option>
                      <option value="TODO">TODO</option>
                      <option value="TODO">TODO</option>
                    </select>

                  </div>


                <div class="col s2"></div><!--DUMMY-->
              </div>

                <!-- TIME & DATE -->
                <div class="col s12">
                  <div class="col s2"></div><!--DUMMY-->

                  <!-- TIME -->
                  <div class="input-field col s4 grey-text">

                    <label for="timepicker" >Select Time</label>
                    <input id="timepicker" name="timepicker" type="text" class="timepicker">

                  </div>

                  <!-- DATE -->
                  <div class="input-field col s4 grey-text">

                    <label for="datepicker" >Select Date</label>
                    <input id="datepicker" name="datepicker" type="text" class="datepicker">

                  </div>

                  <div class="col s2"></div><!--DUMMY-->
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="col s12">
                    <br>
                    <button type="submit" role="submit" class="orange darken-1 btn center">
                        <span class="flow-text">
                            ADD MEETING &nbsp;<i class="fa fa-send"></i>
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
          <form>

            <!-- MEETINGS ONLY -->
              <div class="col s12">
                <div class="col s2"></div><!--DUMMY-->

                  <!-- MEETINGS -->
                  <div class="input-field col s8 grey-text">

                    <select id="selectFour" name="meetings">
                      <option value="" disabled selected>Browse Scheduled Meetings</option>
                      <option value="TODO">TODO</option>
                      <option value="TODO">TODO</option>
                    </select>

                  </div>

                <div class="col s2"></div><!--DUMMY-->
              </div>

                <!-- SUBMIT BUTTON -->
                <div class="col s12">
                    <br>
                    <button type="submit" role="submit" class="orange darken-1 btn center">
                        <span class="flow-text">
                            REMOVE MEETING &nbsp;<i class="fa fa-send"></i>
                        </span>
                    </button>
                </div>

            </form>

            <div class="col s2"></div><!--DUMMY-->
            <div style="margin-top: 50px; margin-bottom: 40px;" class="col s8 divider"></div>
            <div class="col s2"></div><!--DUMMY-->

            <form>

            <!-- CANCELLATIONS ONLY -->
              <div class="col s12">
                <div class="col s2"></div><!--DUMMY-->

                  <!-- CANCELLATIONS -->
                  <div class="input-field col s8 grey-text">

                    <select id="selectFive" name="cancellations">
                      <option value="" disabled selected>Browse Cancellation Requests</option>
                      <option value="TODO">TODO</option>
                      <option value="TODO">TODO</option>
                    </select>

                  </div>

                <div class="col s2"></div><!--DUMMY-->
              </div>

            <!-- SUBMIT BUTTON -->
            <div class="col s12">
                <br>
                <button type="submit" role="submit" class="orange darken-1 btn center">
                    <span class="flow-text">
                        REMOVE CANCELLATION &nbsp;<i class="fa fa-send"></i>
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
              <li><a id="addBtn" class="hoverableBtn btn-floating green darken-1 modal-trigger" href="#add"><i class="material-icons">add</i></a></li>
              <li><a id="removeBtn" class="hoverableBtn btn-floating red darken-1 modal-trigger" href="#remove"><i class="material-icons">remove</i></a></li>
            </ul>

          </div>

        </div>

    </div>

</body>
</html>
