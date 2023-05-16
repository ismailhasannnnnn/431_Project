<?php
session_start();
if(isset($_POST['sendMessage'])) {
    $mysqli = require __DIR__ . "/database.php";
    $toEmail = $_GET['email'];
    $user_email = $_SESSION['user_email'];
    $message = $_POST['sendMessage'];
    $dateTimeVariable = date('Y-m-d H:i:s');
    $query = "INSERT INTO messages VALUES ('$toEmail', '$user_email', '$message', '$dateTimeVariable', false, null)";
    $result = mysqli_query($mysqli, $query);
    header("Location: conversation-view.php?email=$toEmail");
    exit();
}
