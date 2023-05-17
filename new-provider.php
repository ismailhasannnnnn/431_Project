<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(empty($_SESSION["user_email"])) {
    die("email isn't there");
}

if(empty($_POST["providerName"])) {
    die("missing provider name");
}
if(empty($_POST["providerType"])) {
    die("missing provider name");
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


$mysqli = require __DIR__ . "/database.php";

$userID = $_SESSION["user_id"];
$providerName = $_POST["providerName"];
$bio = $_POST["bio"];
$streetAddress = $_POST["street-address"];
$zipcode = $_POST["postal-code"];
$city = $_POST["city"];
$country = $_POST["country"];
$providerType = $_POST["providerType"];

$query = "INSERT INTO providers (userID, providerName, bio, streetAddress,zipcode,city,country, providerType)
           VALUES (?,?,?,?,?,?,?,?)";
$stmt = $mysqli->stmt_init();

if( ! $stmt->prepare($query)){
    die("SQL error". $mysqli->error);
}

if(!$stmt->bind_param("ssssssss",
    $userID,
    $providerName,
    $bio,
    $streetAddress,
    $zipcode,
    $city,
    $country,
    $providerType)){
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

    header("Location: edit-provider.php");
    exit;
}