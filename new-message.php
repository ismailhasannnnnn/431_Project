<?php
session_start();

if(empty($_SESSION["user_email"])) {
    die("email isn't there");
}

if(empty($_POST["emailTo"])) {
    die("recipient email isnt there");
}

if(empty($_POST["content"])) {
    die("there's no message");
}

$mysqli = require __DIR__ . "/database.php";
$fromEmail = $_SESSION["user_email"];
$toEmail = $_POST["emailTo"];
$content = $_POST["content"];
$dateTimeVariable = date('Y-m-d H:i:s');
$falseVal = 0;
$nullVal = null;

$query = "INSERT INTO messages VALUES (?, ?, ?, ?, ? , ?)";

$stmt = $mysqli->stmt_init();


if( ! $stmt->prepare($query)){
    die("SQL error". $mysqli->error);
}

if(!$stmt->bind_param("ssssss",
    $toEmail,
    $fromEmail,
    $content,
    $dateTimeVariable,
    $falseVal,
    $nullVal)){
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
    header("Location: message-view.php");
    exit;
}

