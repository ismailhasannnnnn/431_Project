<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if(empty($_SESSION["user_email"])) {
    die("email isn't there");
}

if(empty($_POST["emailTo"])) {
    die("recipient email isnt there");
}

if(empty($_POST["emailTo"])) {
    die("Message isn't there");
}

if(empty($_POST["meeting-date"])) {
    die("date isnt there");
}

if(empty($_POST["meeting-time"])) {
    die("time isn't there");
}

if(empty($_POST["meetingName"])) {
    die("Please set up a meeting name");
}

if(empty($_POST["food"])) {
    die("Please type your preferred food");
}
if(empty($_POST["meetingContent"])) {
    die("Please type a message");
}






$mysqli = require __DIR__ . "/database.php";


$fromEmail = $_SESSION["user_email"];
$toEmail = $_POST["emailTo"];
$date = $_POST["meeting-date"];
$time = $_POST["meeting-time"];
$meetingName = $_POST['meetingName'];
$favoriteFood = $_POST['food'];
$accepted = 0;
$meetingContent = $_POST['meetingContent'];

$query = "INSERT INTO meetings (name, date, time, sender,recipient,favoriteFood, accepted, messageContent)
            values (?, ?, ?, ?, ?, ?, ?, ?)";


$stmt = $mysqli->stmt_init();


if( ! $stmt->prepare($query)){
    die("SQL error". $mysqli->error);
}

if(!$stmt->bind_param("ssssssss",
    $meetingName,
    $date,
    $time,
    $fromEmail,
    $toEmail,
    $favoriteFood,
    $accepted,
    $meetingContent
    )){

    die("Binding parameters failed:" . $stmt->error);
}

try {
    $stmt->execute();
} catch (Exception $e) {
    //echo "Errors executing statement: " . $e->getMessage();
}

if ($stmt->errno) {
    if($stmt->errno === 1062){
        die("Email already in use. Please try another email.");
    }else{
        echo "Error executing statement: " . $stmt->error;
    }
}else{

//    echo "Signup Successful";
    header("Location: appointment-view.php");
    exit;
}

