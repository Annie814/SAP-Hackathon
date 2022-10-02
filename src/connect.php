<?php

function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $db = "ShareTable";


    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);

// Create database
    $sql = "CREATE DATABASE ShareTable";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }
    //echo "Connected Successfully";

    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}

?>