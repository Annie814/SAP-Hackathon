<?php


function OpenCon_init()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";

    $conn = new mysqli($dbhost, $dbuser, $dbpass) or die("Connect failed: %s\n". $conn -> error);

// Create database & tables
    $db = "ShareTable";
    $sql = "CREATE DATABASE IF NOT EXISTS ShareTable";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
        $sql = file_get_contents('../sql/ShareTable.sql');
        if ($conn->multi_query($sql) === TRUE) {
            echo "Table MyGuests created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    } else {
        echo "Error creating database: " . $conn->error;
    }
    return new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n");;

}

function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $db = "ShareTable";
    $conn_final = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn_final -> error);
    return $conn_final;
}

function CloseCon($conn)
{
    $conn -> close();
}


?>