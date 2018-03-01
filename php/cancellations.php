<?php

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    // Check that all values are set:
    if (!isset($_POST["cancellationIds"], $_POST["userId"])) {
        $_SESSION["error"] = 3; // Some fields were not set.
        header("Location: ".getHomeURL());
        return;
    }
    
    // Fields:
    $cancellationIdsArr = $_POST["cancellationIds"];
    $userId = $_POST["userId"];
    $meetingId = "";
    $adminOfAllMeetings = true;
    // Connect to database.
    $db = getDB();

    foreach($cancellationIdsArr as $cancellationId) {

        $query = "SELECT * FROM cancellation WHERE id=".$cancellationId;
        // Find the meeting we're supposedly trying to cancel.
        $data = getContent($db, $query);
        foreach($data as $row) {
            $meetingId = $row["meeting_id"];
        } // End foreach

        $query = "SELECT * FROM meeting WHERE id=".$meetingId;
        // Find the meeting we're supposedly trying to cancel.
        $data = getContent($db, $query);
        foreach($data as $row) {
            $adminUserId = $row["booked_by_user_id"];
        } // End foreach

        if ($userId == $adminUserId) { // Only do db operations if the user trying to cancel this meeting is the owner of the meeting.

          if (isset($_POST['approve'])) { // Approve-button was clicked, delete this meeting.
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
        } else {
          $adminOfAllMeetings = false;
        }

    }
    if ($adminOfAllMeetings) {
      // Redirect when finished. Note that this URL is right now static.
      $_SESSION["error"] = 0;
      header("Location: ".getHomeURL());
    } else {
      // Some meetings were not affected by the action, since the managing user was not the ower of all the meetings req. for cancellation.
      $_SESSION["error"] = 7;
      header("Location: ".getHomeURL());
    }
?>
