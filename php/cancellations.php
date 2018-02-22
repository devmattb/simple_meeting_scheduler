<?php

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    // Fields:
    $cancellationIdsArr = $_POST["cancellationIds"];
    $meetingId = "";

    // Connect to database.
    $db = getDB();
   
    foreach($cancellationIdsArr as $cancellationId) {
        
        if (isset($_POST['approve'])) { 
            // Approve-button was clicked
            $query = "SELECT * FROM cancellation WHERE id=".$cancellationId;

            // Find the meeting we're supposedly trying to cancel.
            $data = getContent($db, $query);
            foreach($data as $row) { 

                $meetingId = $row["meetingId"];   

            } // End foreach

            // Remove this cancellation from the database:

            // Set the correct sql command
            $sql = "DELETE FROM meeting WHERE id=".$meetingId;  
            $query = $db->prepare($sql);
            $query->execute();


        }
        
        // Always remove the cancellation, if it was denied or if it was approved!
        $sql = "DELETE FROM cancellation WHERE id=".$cancellationId;

        // Execute command:
        $query = $db->prepare($sql);
        $query->execute();
        
    }
    
    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: ".getHomeURL());
?>