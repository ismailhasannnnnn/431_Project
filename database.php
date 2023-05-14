<?php

$host = "localhost";
$dbname = "431_Project";
$username = "ismailhasan";
$password = "Stripes12";

$mysqli = new mysqli($host, $username, $password, $dbname);

if( $mysqli->connect_errno){
    die("Connection error: " . $mysqli->connect_error);
}



return $mysqli;
