<?php

    /**
    *
    *   This file handles form submissions that regard additions of meetings.
    *   After the PHP code has run, we redirect to the main page again.
    *
    *   We use this page when we initialize our calendar, in lib/init.js
    *
    *   SESSION VARIABLE ERROR CODES: Add Meeting
    *   error = 0 -> No errors! Successful insert!
    *   error = 1 -> Room was already booked at that date and time interval.
    *   error = 2 -> Some people were already booked at that date and time interval.
    *   error = 3 -> Some fields were not set when the form was sent.
    *   error = 4 -> The start time was after the the end time.
    *   error = 5 -> User did not belong to the team that he/she was booking for.
    *
    **/

    /**
    *
    *   Check that the meeting we're trying to add has the following characteristics:
    *
    *   - Does not occur in the same time and room as an already existing meeting.
    *   - Does not include people that are already booked in some other meeting, the same time.
    *   - Add these parameters to the database so that we can calculate the above.
    */

    function sendMeetingCollisionErr() {

      // ERROR! Prompt the user that the meeting could not be booked.
      $_SESSION["error"] = 1;
      header("Location: ".getHomeURL());
      return;

    }

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    // Check that all values are set:
    if (!isset($_POST["room"], $_POST["date"], $_POST["startTime"], $_POST["endTime"], $_POST["people"], $_POST["userId"], $_POST["teamId"])) {
        $_SESSION["error"] = 3; // Some fields were not set.
        header("Location: ".getHomeURL());
        return;
    }

    // Room options:
    $room = $_POST["room"];
    $teamId = $_POST["teamId"];
    $people = (string) implode(",",$_POST["people"]); // Turns the array in to a string.
    $business_people = (string) implode(",",$_POST["businessPeeps"]); // Turns the array in to a string.

    // Event options:
    $title = $room;
    $date = $_POST["date"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $userId = $_POST["userId"];

    $HHStart = substr($startTime,0,2);
    $MMStart = substr($startTime,3,5);
    $HHEnd = substr($endTime,0,2);
    $MMEnd = substr($endTime,3,5);

    // Check that the time is set correctly:
    if ( $HHStart == $HHEnd && $MMStart > $MMEnd ) {
        $_SESSION["error"] = 4; // Time was set incorrectly!
        header("Location: ".getHomeURL());
        return;
    } else if ( $HHStart > $HHEnd ) {
        $_SESSION["error"] = 4; // Time was set incorrectly!
        header("Location: ".getHomeURL());
        return;
    }

    // Connect to database.
    $db = getDB(); // Imported from php/functions.php

    /**
    *   Check that this user is a team member of the team he/she is booking for...
    **/

    $query = "SELECT * FROM team WHERE id=".$teamId;
    $data = getContent($db, $query);
    foreach($data as $row) {
        $teamName = $row["name"];
    }

    $query = "SELECT * FROM people WHERE id=".$userId;
    $data = getContent($db, $query);
    foreach($data as $row) {
        $userTeams = explode(",",$row["teams"]);
    }

    $userIsInChoosenTeam = false;
    foreach($userTeams as $team){
        if ($team == $teamName) {
            $userIsInChoosenTeam = true;
        }
    }

    if (!$userIsInChoosenTeam) {
        $_SESSION["error"] = 5; // SELECTED USER NOT IN TEAM!
        header("Location: ".getHomeURL());
        return;
    }
    /**
    *   DONE.
    **/

    // NOTE: The start and end format for a meeting is: "yyyy-mm-dd HH:MM:SS"
    $start = $date." ".$HHStart.":".$MMStart.":00";
    $end = $date." ".$HHEnd.":".$MMEnd.":00";

    // Create a URL as a permalink to this meetings info. Last ID +1!
    $meetingID = 1; // This is changed in the foreach loop.

    $query = "SELECT * FROM meeting ORDER BY id"; // Select all meetings.


    /**
    *
    *   MEETING COLLISION HANDLER:
    *
    **/
    $data = getContent($db, $query);
    foreach($data as $row) {

        // If the start date is the same as the date we're trying to schedule now:
        if ( substr($row["start"],0,10) == $date ) {

            // Check if the times overlap.
            $existingMeetingStartHH = (int) substr($row["start"],11,13);
            $existingMeetingEndHH = (int) substr($row["end"],11,13);

            $existingMeetingStartMM = (int) substr($row["start"],14,16);
            $existingMeetingEndMM = (int) substr($row["end"],14,16);

            if ( $HHEnd != $existingMeetingEndHH && $HHStart != $existingMeetingStartHH )  {
                // The meetings are scheduled the same day, BUT NOT the same hour.
                if ( !( $HHEnd < $existingMeetingStartHH || $HHStart > $existingMeetingEndHH ) ) {
                    // The meeting we're trying to schedule is NOT before
                    // NOR after the compared meeting.
                    // This means there has been a definite time/date collision.

                    // Check if there is a Room/People collision too.
                    if ( $row["room"] == $room ) {
                        sendMeetingCollisionErr();
                    }

                }

            } else { // Both hour intervals is equal for the compared times.

              if ( $row["room"] == $room ) {
                  sendMeetingCollisionErr();
              }

            }

        }

        $meetingID = ($row["id"]+1); // Set the meeting ID to the last ID+1 (Makes URL function.)
    }

    $url = getHomeURL()."view_meeting?id=".$meetingID;

    // Get the facility of the room...
    $facility = "";
    $getFacilityQ = "SELECT * FROM room";
    $data = getContent($db, $getFacilityQ);
    foreach($data as $row) {
        if ( $row["name"] == $room) {
            $facility = $row['facility'];
        }
    }

    $getFacilityQ = "SELECT * FROM facility WHERE id=".$facility;
    $data = getContent($db, $getFacilityQ);
    foreach($data as $row) {
        $facility = $row['name'];
    }

    /**
    *   Calculate and log the cost of this meeting:
    **/
    $sDT = new DateTime($start);
    $eDT = new DateTime($end);
    $interval = $sDT->diff($eDT); // The time difference between start/end of meeting.
    $hours = (float)$interval->format('%h');
    $minutes = (float)$interval->format('%i');

    /**
    *   Convert facility letter to ASCII -96, making A=1, B=2, etc.
    *   Use the above as the dollar/hour rate, so multiply by hour+min/60
    **/
    $roomCost = (int)ord(strtolower($facility))*($hours+($minutes/60));

    /**
    *   Insert Cost to Team:
    **/
    $sql = "INSERT INTO cost_log (cost,date,room,team_id, meeting_id) VALUES (:cost,:date,:room,:team_id,:meeting_id)";

    $query = $db->prepare($sql); // Prepare db to execute sql.

    // Now execute the sql and replace placeholders with actual values, grabbed in the beginning of this code.
    $query->execute(array(':cost' => $roomCost,':date' => $date,':room' => $room,':team_id' => $teamId, ':meeting_id' => $meetingID));

    /**
    *   Finally, Insert Meeting:
    **/
    // Create and execute the sql to insert records:
    $sql = "INSERT INTO meeting (title, start, end, date, url, room, facility, people_ids, business_people_ids, booked_by_user_id, booked_by_team_id) VALUES (:title, :start, :end, :date, :url, :room, :facility, :people_ids, :business_people_ids, :booked_by_user_id, :booked_by_team_id)";

    $query = $db->prepare($sql); // Prepare db to execute sql.

    // Now execute the sql and replace placeholders with actual values, grabbed in the beginning of this code.
    $query->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end, ':date'=>$date, ':url'=>$url, ':room'=>$room, ':facility'=>$facility, ':people_ids'=>$people, ':business_people_ids'=>$business_people,':booked_by_user_id'=>$userId, ':booked_by_team_id'=>$teamId));

    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: ".getHomeURL());

?>
