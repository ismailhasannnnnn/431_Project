<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(isset($_SESSION["user_email"])){
    $mysqli = require __DIR__ . "/database.php";

    $query = "SELECT * FROM `meetings` WHERE
                             sender = '{$_SESSION["user_email"]}'
                             OR recipient = '{$_SESSION["user_email"]}'";

    $result = $mysqli->query($query);

    $meetings = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($meetings);
} else {
    echo json_encode([]);
}