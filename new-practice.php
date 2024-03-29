<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(empty($_SESSION["user_email"])) {
    die("email isn't there");
}

if(empty($_POST["practiceName"])) {
    die("missing practice name");
}
if(empty($_POST["practiceType"])) {
    die("Please select a practice type.");
}
if(empty($_POST["bio"])) {
    die("missing bio");
}
if(empty($_POST["street-address"])) {
    die("missing street address");
}
if(empty($_POST["postal-code"])) {
    die("missing postal code");
}
if(empty($_POST["city"])) {
    die("missing city");
}
if(empty($_POST["country"])) {
    die("missing country");
}
if(empty($_POST["logo"])) {
    die("Please upload an image for your logo");
}





$mysqli = require __DIR__ . "/database.php";
$userID = $_SESSION["user_id"];
$practiceName = $_POST["practiceName"];
$bio = $_POST["bio"];
$streetAddress = $_POST["street-address"];
$zipcode = $_POST["postal-code"];
$city = $_POST["city"];
$country = $_POST["country"];
$logo = $_POST["logo"];
$practiceType = $_POST["practiceType"];

$query = "INSERT INTO practices (userID, practiceName, bio, streetAddress,zipcode,city,country,logo, practiceType)
           VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $mysqli->stmt_init();


if( ! $stmt->prepare($query)){
    die("SQL error". $mysqli->error);
}

if(!$stmt->bind_param("sssssssss",
    $userID,
    $practiceName,
    $bio,
    $streetAddress,
    $zipcode,
    $city,
    $country,
    $logo,
    $practiceType)){
    die("Binding parameters failed:" . $stmt->error);
}

try {
    $stmt->execute();
} catch (Exception $e) {
    //echo "Errors executing statement: " . $e->getMessage();
}

if ($stmt->errno) {
        echo "Error executing statement: " . $stmt->error;
}else{

    header("Location: edit-practice.php");
    exit;
}