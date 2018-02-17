<?php
    /**
    *
    *   This file handles form submissions that regard additions of meetings.
    *   After the PHP code has run, we redirect to the main page again.
    *   
    *   We use this page when we initialize our calendar, in lib/init.js
    *   
    **/

    /**
    *    TODOS:
    *   Check that the meeting we're trying to add has the following characteristics:
    *  
    *   - Does not occur in the same time and room as an already existing meeting.
    *   - Does not inlcude people that are already booked in some other meeting, the same time.
    *   - Add these parameters to the database so that we can calculate the above.
    */


    require("functions.php");
    // Create all required fields to create a meeting.
    // All Values received dynamically via AJAX.

    // Room options:
    $facility ="";
    // $facility = $_POST["facilty"];   TODO: Choose with Room?
    $room = $_POST["room"];
    $people = $_POST["people"]; // TODO. Array handling?

    // Event options:
    $title = $people;
    $date = $_POST["date"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];

    $HHStart = substr($startTime,0,2);
    $MMStart = substr($startTime,3,5);
    $HHEnd = substr($endTime,0,2);
    $MMEnd = substr($endTime,3,5);

    // NOTE: The start and end format for a meeting is: "yyyy-mm-dd HH:MM:SS"
    $start = $date." ".$HHStart.":".$MMStart.":00";
    $end = $date." ".$HHEnd.":".$MMEnd.":00";


    $url = "NOT_USED";
    //$desc = $_POST[""]; // TODO Description including list of people attending?

    // Connect to database.
    $db = getDB(); // Imported from php/functions.php

    // Create and execute the sql to insert records:
    // TODO: Do the colons indicate something? Investigate...
    $sql = "INSERT INTO meeting (title, start, end, url) VALUES (:title, :start, :end, :url)";

    $query = $db->prepare($sql); // Prepare db to execute sql.

    // Now execute the sql and replace placeholders with actual values, grabbed in the beginning of this code.
    $query->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end, ':url'=>$url));
    
    // Redirect when finished. Note that this URL is right now static.
    header("Location: http://localhost/simple_meeting_scheduler/");

?>
