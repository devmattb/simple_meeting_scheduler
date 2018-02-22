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

    if ( empty($_POST["teamName"]) ) {
        $_SESSION["error"] = 3;
        header("Location: ".getHomeURL());
        return;
    }

    $teamName = $_POST["teamName"];   

    $db = getDB();
    
    $sql = "INSERT INTO team (name) VALUES (:name)";

    // Execute command:
    $query = $db->prepare($sql);
    $query->execute(array(':name'=>$teamName));

    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: ".getHomeURL());
?>