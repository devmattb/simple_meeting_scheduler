<?php

// NOTE: NOT FINISHED.


    require("functions.php");

    // Values below are updated dynamically via AJAX:
    $id = $_POST["id"];
    $title = $_POST["title"];
    $start = $_POST["start"];
    $end = $_POST["end"];


    // Connect to database.
    $db = getDB();

    // Update the database records with a rescheduled event. (Maybe a meeting was moved?):
    // NOTE: The "?" are placeholders...
    $sql = "UPDATE evenement SET title=?, start=?, end=?, WHERE id=?";
    $q = $db->prepare($sql);
    $q->execute(array($title, $start, $end, $id));

 ?>
