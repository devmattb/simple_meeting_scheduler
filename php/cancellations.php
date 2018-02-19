<?php

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    // Fields:
    $cancellationId = $_POST["cancellation"];
    $meetingId = "";

    // Connect to database.
    $db = getDB();
    $sql = "";
    if (isset($_POST['approve'])) { // TODO: NOT WORKING
        // Approve-button was clicked
        $query = "SELECT * FROM cancellation WHERE id=".$cancellationId;

        // Find the meeting we're supposedly trying to cancel.
        $data = getContent($db, $query);
        foreach($data as $row) { 
    
            $meetingId = $row["meetingId"];   

        } // End foreach
    
        // Set the correct sql command
        $sql = "DELETE FROM meeting WHERE id=".$meetingId;     
        
    }
    else if (isset($_POST['deny'])) { // TODO: NOT WORKING
        // Deny-button was clicked, set the correct sql command
         $sql = "DELETE FROM cancellation WHERE id=".$cancellationId;
    }
    
    // Execute command:
    $query = $db->prepare($sql);
    $query->execute();
    
    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: http://localhost/simple_meeting_scheduler/");
?>