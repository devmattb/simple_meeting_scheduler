<?php

  // List of events
  $json = new Array();

  $requete = "SELECT * FROM evenement ORDER BY id";

  // Try to connect to database:
  try {
    $db = new PDO("mysql:host=localhost; dbname=simple_meeting_scheduler", "root", "root");
  } catch(Exception $e) {
    exit("Unable to connect to database. Error: " + $e);
  }

  // Send the query to the database, or send the error info if the query fails...
  $result = $db->query($requete) or die(print_r($db->errorInfo()))

  // Echo out the json encoded array to the webpage...
  echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

?>
