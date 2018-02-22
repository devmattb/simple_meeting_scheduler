/**
*
*   This file initiates all javascript dependencies.
*   Settings for the calendar and time/datepicker can be found below.
*
**/

$(document).ready(function() {

    // Preloader
    $('.preloader-background').delay(400).fadeOut('slow');
	$('.preloader-wrapper').delay(400).fadeOut();
    
    // Init modals:
    $('.modal').modal();

    // Init form elements
    $('select').material_select();
    
    // Init tabs:
    $('ul.tabs').tabs();

    // Init schedule
    var schedule = $('.schedule').fullCalendar({

        header: {
            // Buttons and header text:
            left: 'agendaDay, agendaWeek, month',
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
        timeFormat: 'H(:mm)', // uppercase H for 24-hour clock

        // Get events from DB!
        eventSources: [

        // your event source
        {
            url: 'php/events.php', // use the `url` property
            color: 'orange',              // an option! (Right now overridden by css/calendar.css)
            textColor: '#fff'  // an option!
        }
        
        // any other sources...

        ],

    }); // End of Calendar init.

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
        format:"HH:MM:SS",
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
        format: 'yyyy-mm-dd',
        min: new Date(),
        closeOnSelect: true // Close upon selecting a date,
    });


}); // End of document.ready()
