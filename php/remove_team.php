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

    // Check that all values are set:
    if (!isset($_POST["teamId"])) {
        $_SESSION["error"] = 3; // Some fields were not set.
        header("Location: ".getHomeURL());
        return;
    }

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
