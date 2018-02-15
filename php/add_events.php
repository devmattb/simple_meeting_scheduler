<?php

  // Create all required fields to create a meeting.
  // All Values received dynamically via AJAX.

  // Room options:
  $facility = $_POST["facilty"];
  $room = $_POST["room"];
  $people = $_POST["people"]; // TODO. Array handling?

  // Event options:
  $title = "Meeting in "+$facility+$room; // Statically set meeting.
  $start = $_POST["startTime"];
  $end = $_POST["endTime"];
  $url = $_POST["url"];
  $desc = $_POST[""]; // TODO Description including list of people attending?

  // Connect to database.
  try {
    $db = new PDO("msql:host=localhost;dbname=simple_meeting_scheduler", "root", "root");
  } catch (Exception $e) {
    exit("Unable to connect to database. Error: " + $e );
  }

  // Create and execute the sql to insert records:
  // TODO: Do the colons indicate something? Investigate...
  $sql = "INSERT INTO evenement (title, start, end, url) VALUES (:title, :start, :end, :url)";

  $query = $db->prepare($sql); // Prepare db to execute sql.

  // Now execute the sql and replace placeholders with actual values, grabbed in the beginning of this code.
  $query->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end, ':url'=>$url));



?>
