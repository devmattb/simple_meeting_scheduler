<?php
    /**
    *
    *   This file creates a page that outputs a large json array containing all meetings
    *   that are scheduled in the calendar, and their respective attributes.
    *   
    *   We use this page when we initialize our calendar, in lib/init.js
    *
    **/
    require("functions.php");

    // List of events
    $json = array();

    $sql = "SELECT * FROM meeting ORDER BY id";
  
    $db = getDB(); // Imported from php/functions.php

    // Send the query to the database, or send the error info if the query fails...
    $result = $db->query($sql) or die(print_r($db->errorInfo()));

    // Echo out the json encoded array to the webpage... (TODO: Make a success page..?)
    echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
    
?>
