<?php

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    if (!isset($_POST["peopleIds"])) {
        $_SESSION["error"] = 3;
        header("Location: ".getHomeURL());
        return;
    }

    $peopleIds = (string) implode(",",$_POST["peopleIds"]); // Turns the array in to a string.

    $db = getDB();
    
    $sql = "DELETE FROM people WHERE id IN (".$peopleIds.")";

    // Execute command:
    $query = $db->prepare($sql);
    $query->execute();

    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: ".getHomeURL());

?>