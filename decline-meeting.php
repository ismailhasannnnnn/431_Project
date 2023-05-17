<?php
session_start();

if(!isset($_POST['meeting_id'])) {
    echo 'No meeting ID provided';
    exit;
}

$mysqli = require __DIR__ . "/database.php";

$meeting_id = $_POST['meeting_id'];

$query = "UPDATE meetings SET accepted = 0 WHERE meeting_ID = ? AND recipient = ?";

$stmt = $mysqli->prepare($query);

if (!$stmt) {
    echo 'Error: ' . $mysqli->error;
    exit;
}

$stmt->bind_param('ss', $meeting_id, $_SESSION['user_email']);

$stmt->execute();

if ($stmt->affected_rows === 0) {
    echo 'No meeting found with this ID for this user, or the meeting was already declined';
} else {
    echo 'Meeting declined';
}

$stmt->close();
?>