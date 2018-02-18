<?php

    /**
    *
    *   This file is a small function library, with functions that are
    *   frequently used throughout the application.
    *
    **/
    
    /**
    *   Starts a database connection with some static parameters.
    **/
    function getDB() {
        $servername = "localhost";
        $dbName   = 'simple_meeting_scheduler';
        $port = 3306;
        $username = "root";
        $password = "";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbName;charset=utf8", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn; 
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return;
        }
    }

    /**
    *   Gets all the entities that are selected in the given $db, with any given $query.
    **/
    function getContent($db, $query) {
        $sql = $db->prepare($query);
        $sql->execute();
        return $sql->fetchAll();
    }

?>