<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();




if (!isset($_POST["meeting_id"])) {
    die("No meeting ID provided");
}



$mysqli = require __DIR__ . "/database.php";

$meeting_id = $_POST["meeting_id"];

$query = "DELETE FROM `meetings` WHERE `meeting_ID` = ?";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($query)) {
    die("SQL error: " . $mysqli->error);
}

if (!$stmt->bind_param("i", $meeting_id)) {
    die("Binding parameters failed: " . $stmt->error);
}

if (!$stmt->execute()) {
    die("Execution failed: " . $stmt->error);
}

echo "Success";


?>