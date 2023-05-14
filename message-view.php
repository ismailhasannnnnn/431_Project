<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

function getMessages() {
    if (isset($_SESSION["user_email"])) {

        $mysqli = require __DIR__ . "/database.php";
        $sql = "SELECT DISTINCT * FROM messages WHERE `to` = '{$_SESSION["user_email"]}'";
        $result = $mysqli->query($sql);

        echo "<table>";
        echo "<tr><th>Sender Email</th><th>Last Message</th><th>Reply...</th></tr>";
        while($row = $result->fetch_assoc()) {
            $url = 'new-message-view.html?email=' . $row['from'];
            echo "<tr><td>{$row['from']}</td><td>{$row['content']}</td><td><a class='button' href=$url>Reply</td></tr>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
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
    <a href="index.php">DocMeet Dashboard</a>


    <a href="edit-practice.php"> Your Practice</a>

    <a href="message-view.php" style="font-weight:bold;">Messages</a>

    <a href="edit-profile.php"> Your Profile </a>
</nav>


<div class="container main-card">
    <h1 class="dash">Messages </h1>


<!--    <table>-->
<!--        <tr>-->
<!--            <th>Message</th>-->
<!--            <th>From</th>-->
<!--            <th>Time</th>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Hello Welcome to . . .</td>-->
<!--            <td>Justin Gonzales</td>-->
<!--            <td>2:21 PM</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td> Greetings, I was wondering . . </td>-->
<!--            <td>Ismail Hasan</td>-->
<!--            <td>12:00 PM</td>-->
<!--        </tr>-->
<!--    </table>-->
    <div>
        <?php
        getMessages();
        ?>
    </div>

    <div>
        <button><a href="new-message-view.html">New Meeting Request </a></button>
    </div>


<!--    <div>-->
<!--        <h1>-->
<!--            Inbox-->
<!--        </h1>-->
<!---->
<!--        --><?php //if (isset($message)): ?>
<!--            <p> From:--><?php //= htmlspecialchars($message["from"]) ?><!--  --><?php //= htmlspecialchars($message["content"]) ?><!-- </p>-->
<!--        --><?php //endif; ?>
<!---->
<!---->

<!---->
<!--    </div>-->


</div>


</body>
</html>

