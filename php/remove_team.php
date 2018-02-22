<?php 
    /**
    *   Removes a given team from our database.
    **/

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    $teamId = (string)implode(",",$_POST["teamId"]);
    $db = getDB();
    
    $sql = "DELETE FROM team WHERE id IN  (".$teamId.")";

    // Execute command:
    $query = $db->prepare($sql);
    $query->execute();

    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: ".getHomeURL());
?>