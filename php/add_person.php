<?php 
    /**
    *   Adds a person to our database.
    **/

    // Start the session if it doesn't exist.
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    require("functions.php");

    if ( empty($_POST["name"]) || empty($_POST["position"]) || empty($_POST["teams"])  ) {
        $_SESSION["error"] = 3;
        header("Location: ".getHomeURL());
        return;
    }

    $name = $_POST["name"];
    $position = $_POST["position"];
    $teams = (string)implode(",",$_POST["teams"]); // We want to process this as a string.

    $db = getDB();
    
    $sql = "INSERT INTO people (name, position, teams ) VALUES (:name, :position, :teams)";

    // Execute command:
    $query = $db->prepare($sql);
    $query->execute(array(':name'=>$name, ':position'=>$position, ':teams'=>$teams));

    // Redirect when finished. Note that this URL is right now static.
    $_SESSION["error"] = 0;
    header("Location: ".getHomeURL());
?>