<?php

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    // Fields:
    $meetingIdsArr = $_POST["meetingIds"];
    $date = "";
    $startTime = "";
    $endTime = "";
    $room = "";
                
    // Connect to database.
    $db = getDB();
    
    foreach($meetingIdsArr AS $meetingId) {
        
        $query = "SELECT * FROM meeting WHERE id=".$meetingId;

        // Set date/start/end
        $data = getContent($db, $query);
        foreach($data as $row) { 

            // Formatting...
            $startTimeArr = explode(":",substr($row["start"], 11,17));
            $endTimeArr = explode(":",substr($row["end"], 11,17));

            // Setting fields:
            $date = substr($row["start"], 0,10);
            $startTime = $startTimeArr[0].':'.$startTimeArr[1];
            $endTime = $endTimeArr[0].':'.$endTimeArr[1];       
            $room = $row["room"];   

        } // End foreach

        // Create and execute the sql to insert records:
        // TODO: Do the colons indicate something? Investigate...
        $sql = "INSERT INTO cancellation (meeting_id, date, startTime, endTime, room) VALUES (:meeting_id, :date, :startTime, :endTime, :room)";

        $query = $db->prepare($sql); // Prepare db to execute sql.

        // Now execute the sql and replace placeholders with actual values, grabbed in the beginning of this code.
        $query->execute(array(':meeting_id'=>$meetingId, ':date'=>$date, ':startTime'=>$startTime, ':endTime'=>$endTime, ':room'=>$room));
    
    }
    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: ".getHomeURL());
?>