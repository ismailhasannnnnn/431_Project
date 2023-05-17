<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();


}

?>

<!DOCTYPE html>
<html>
<head>
    <title> DocMeet Home </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/custom.css">

    <!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">-->
</head>

    <body>


        <nav>

            <div class="divider"></div>
            <a href="index.php" >DocMeet Dashboard</a>

            <a href="appointment-view.php"> Appointments </a>

            <a href="edit-practice.php"> Your Practice</a>

            <a href="message-view.php">Messages</a>


        </nav>

        <div class="container main-card">

            <h1 class="dash"> About You </h1>

            <p> Your Name:  <?= htmlspecialchars($user["Name"]) ?> </p>

            <a href="logout.php" class="button"> Log Out</a>



        </div>




    </body>
</html>

