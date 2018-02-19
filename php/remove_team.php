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

    $teamId = $_POST["teamId"];
    $db = getDB();
    
    $sql = "DELETE FROM team WHERE id=".$teamId;

    // Execute command:
    $query = $db->prepare($sql);
    $query->execute();

    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: http://localhost/simple_meeting_scheduler/");
?>