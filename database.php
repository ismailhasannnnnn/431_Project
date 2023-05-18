<?php

$host = "localhost";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password);

if( $mysqli->connect_errno){
    die("Connection error: " . $mysqli->connect_error);
}

// Create a new database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS DockMeet";
if (!$mysqli->query($sql)) {
    die("Error creating database: " . $mysqli->error);
}

// Select the database
$mysqli->select_db("DockMeet") or die($mysqli->error);

// Check if database is selected
if ($mysqli->error) {
    die("Error selecting database: " . $mysqli->error);
}

//SQL QUERIES TO CREATE TABLES IF DOESNT EXIST

$sql = "
    CREATE TABLE IF NOT EXISTS `users` (
        `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `Email` VARCHAR(255) NOT NULL,
        `Name` VARCHAR(255) NOT NULL,
        `Password` VARCHAR(255) NOT NULL,
        `Type` VARCHAR(255) NOT NULL,
        UNIQUE (`Email`)
    )
";

if (!$mysqli->query($sql)) {
    die("Error creating table: " . $mysqli->error);
}

$sql = "CREATE TABLE IF NOT EXISTS `meetings` (
    `meeting_ID` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL,
    `date` date NOT NULL,
    `Time` time NOT NULL,
    `sender` varchar(255) NOT NULL,
    `recipient` varchar(255) NOT NULL,
    `favoriteFood` text,
    `accepted` tinyint(1) NOT NULL,
    `messageContent` text
)";

if ($mysqli->query($sql) === FALSE) {
    echo "Error creating table: " . $mysqli->error;
}


$sql = "CREATE TABLE IF NOT EXISTS `messages` (
    `to` varchar(255) NOT NULL,
    `from` varchar(255) NOT NULL,
    `content` text,
    `datetime` datetime NOT NULL,
    `read` tinyint(1) NOT NULL,
    `time_read` datetime DEFAULT NULL
)";

if ($mysqli->query($sql) === FALSE) {
    echo "Error creating table: " . $mysqli->error;
}

$sql = "CREATE TABLE IF NOT EXISTS `practices` (
    `practiceID` int(10) AUTO_INCREMENT PRIMARY KEY,
    `userID` int(10) NOT NULL,
    `practiceName` varchar(255) NOT NULL,
    `bio` text,
    `streetAddress` varchar(255) NOT NULL,
    `zipcode` int(5) NOT NULL,
    `city` varchar(255) NOT NULL,
    `country` varchar(255) NOT NULL,
    `logo` blob,
    `practiceType` varchar(255) NOT NULL
)";

if ($mysqli->query($sql) === FALSE) {
    echo "Error creating table: " . $mysqli->error;
}


$sql = "CREATE TABLE IF NOT EXISTS `providers` (
    `providerID` int(10) AUTO_INCREMENT PRIMARY KEY,
    `userID` int(10) NOT NULL,
    `providerName` varchar(255) NOT NULL,
    `bio` text,
    `streetAddress` varchar(255) NOT NULL,
    `zipcode` int(5) NOT NULL,
    `city` varchar(255) NOT NULL,
    `country` varchar(255) NOT NULL,
    `providerType` varchar(255) NOT NULL
)";

if ($mysqli->query($sql) === FALSE) {
    echo "Error creating table: " . $mysqli->error;
}









return $mysqli;
