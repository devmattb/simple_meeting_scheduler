<!DOCTYPE html>
<html>
<head>
    
    <!-- CSS Stylesheets -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">                              <!-- Google Icon Font -->
    <link rel="stylesheet" href="imports/materialize/css/materialize.min.css">   <!-- Materialize CSS -->
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
            
        }); // End of document.ready()
    </script>
</head>

<body>

    <div class="row col s12">
        <div class="schedule"></div>
        
        <div id="buttonHolder">
            <button class="btn-large waves-effect waves-light blue darken-1">Select</button>
            <button class="btn-large waves-effect waves-light green darken-1">Insert</button>
            <button class="btn-large waves-effect waves-light red darken-1">Delete</button>
        </div>
    </div>

</body>
</html>