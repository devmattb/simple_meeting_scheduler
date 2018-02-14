<?php

  // Create all required fields to create a meeting.
  // All Values received dynamically via AJAX.
  
  $title = "Meeting in "+$facility+$room; // Statically set meeting.
  $start = $_POST["startTime"];
  $end = $_POST["endTime"];
  $url = $_POST["url"];

  // Room options:
  $facility = $_POST["facilty"];
  $room = $_POST["room"];
  $people = $_POST["people"]; // TODO. Array handling?

  // Connect to database.
  try {
    $db = new PDO("msql:host=localhost;dbname=simple_meeting_scheduler", "root", "root");
  } catch (Exception $e) {
    exit("Unable to connect to database. Error: " + $e );
  }

?>
