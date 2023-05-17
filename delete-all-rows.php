<?php


$host = "localhost";
$dbname = "DockMeet";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

$tables = array("users", "meetings", "messages", "practices", "providers");

foreach ($tables as $table) {
    $sql = "DELETE FROM $table";
    if ($mysqli->query($sql) === FALSE) {
        echo "Error deleting rows from $table: " . $mysqli->error;
    } else {
        echo "All rows deleted from $table successfully.<br>";
    }
}

$mysqli->close();


?>