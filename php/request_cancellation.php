<?php

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    // Fields:
    $meetingIdsArr = $_POST["meetingIds"];
    $userId = $_POST["userId"];
    $date = "";
    $startTime = "";
    $endTime = "";
    $room = "";
    $deletedDirectly = false;

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
            $adminUserId = $row["booked_by_user_id"];

        } // End foreach

        if ( $adminUserId != $userId ) { // If this isn't the user that booked the particular meetings
        // Create and execute the sql to insert records:
          $sql = "INSERT INTO cancellation (meeting_id, date, start, end, room) VALUES (:meeting_id, :date, :start, :end, :room)";
          $query = $db->prepare($sql); // Prepare db to execute sql.
          $query->execute(array(':meeting_id'=>$meetingId, ':date'=>$date, ':start'=>$startTime, ':end'=>$endTime, ':room'=>$room));
        } else { // If this is the user that booked the particular meetings, delete this meeting directly. No need for approval.
          $sql = "DELETE FROM meeting WHERE id=".$meetingId;
          $query = $db->prepare($sql); // Prepare db to execute sql.
          $query->execute();
          $deletedDirectly = true;
        }

    }
    // Redirect when finished. Note that this URL is right now static.
    if ($deletedDirectly != true) { // If no meeting was deleted directly.
      $_SESSION["error"] = 0;
      header("Location: ".getHomeURL());
    } else {
      $_SESSION["error"] = 6;
      header("Location: ".getHomeURL());
    }
?>
