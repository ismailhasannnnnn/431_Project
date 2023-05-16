<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

function getReceivedMessages(): void
{
    if (isset($_SESSION["user_email"])) {
        $mysqli = require __DIR__ . "/database.php";
        $sql = "SELECT m1.`from`, m1.content, m1.datetime FROM messages m1 
                JOIN (
                    SELECT `from`, MAX(datetime) as max_datetime
                    FROM messages
                    WHERE `to` = '{$_SESSION["user_email"]}'
                    GROUP BY `from`
                    ) 
                m2 ON m1.`from` = m2.`from` AND m1.datetime = m2.max_datetime
                ORDER BY datetime DESC";
        $result = $mysqli->query($sql);

        echo "<table>";
        echo "<tr><th>Sender Email</th><th>Last Message</th><th>Date/Time Sent</th><th>Reply...</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $url = 'conversation-view.php?email=' . $row['from'];
            echo "<tr><td>{$row['from']}</td><td>{$row['content']}</td><td>{$row['datetime']}</td><td><a class='button' href=$url>Reply</td></tr>";
        }
        echo "</table>";
    }
}

function getSentMessages(): void
{
    if (isset($_SESSION["user_email"])) {
        $mysqli = require __DIR__ . "/database.php";
        $sql = "SELECT m1.`to`, m1.content, m1.datetime FROM messages m1 
                JOIN (
                    SELECT `to`, MAX(datetime) as max_datetime
                    FROM messages
                    WHERE NOT `to` = '{$_SESSION["user_email"]}'
                    GROUP BY `to`
                    ) 
                m2 ON m1.`to` = m2.`to` AND m1.datetime = m2.max_datetime
                ORDER BY datetime DESC";
        $result = $mysqli->query($sql);

        echo "<table>";
        echo "<tr><th>Recipient Email</th><th>Last Message</th><th>Date/Time Sent</th><th>Reply...</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $url = 'conversation-view.php?email=' . $row['to'];
            echo "<tr><td>{$row['to']}</td><td>{$row['content']}</td><td>{$row['datetime']}</td><td><a class='button' href=$url>Reply</td></tr>";
        }
        echo "</table>";
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
    <h1 class="dash">Received Messages</h1>

    <div>
        <?php
        getReceivedMessages();
        ?>
    </div>

    <div>
        <button><a href="new-message-view.html">New Meeting Request </a></button>
    </div>

</div>

<div class="container main-card">
    <h1 class="dash">Sent Messages</h1>

    <div>
        <?php
        getSentMessages();
        ?>
    </div>

</div>

</body>
</html>
