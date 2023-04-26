<?php

session_start();

if(isset($_SESSION["user_id"])){

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title> DocMeet </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
</head>

<body>
<nav>
    <a href="index.php" >DocMeet</a>
    <?php if (isset($user)): ?>
        <a href="edit-practice.php"> Your Practice</a>
        <a href="message-view.php">Messages</a>
        <a href="#"> </a>

    <?php endif; ?>
</nav>

<h1> <?= htmlspecialchars($user["Name"]) ?>'s Messages </h1>


<table>
    <tr>
        <th>Message</th>
        <th>From</th>
        <th>Time</th>
    </tr>
    <tr>
        <td>Hello Welcome to . . .</td>
        <td>Justin Gonzales</td>
        <td>2:21 PM</td>
    </tr>
    <tr>
        <td> Greetings, I was wondering . . </td>
        <td>Ismail Hasan</td>
        <td>12:00 PM</td>
    </tr>
</table>


</body>
</html>

