<?php
session_start();

//function getConversation(): void
//{
//    if(isset($_GET['email'])) {
//        $mysqli = require __DIR__ . "/database.php";
//        $email = $_GET['email'];
//        $user_email = $_SESSION['user_email'];
//        $fromQuery = "SELECT `from`, `to`, content, datetime FROM messages WHERE `from`='$email' AND `to`='$user_email'";
//        $fromResult = $mysqli->query($fromQuery);
////        $fromArray = mysqli_fetch_array($fromResult);
//
//        $toQuery = "SELECT `from`, `to`, content, datetime FROM messages WHERE `to`='$email' AND `from`='$user_email'";
//        $toResult = $mysqli->query($toQuery);
////        $toArray = mysqli_fetch_array($toResult);
//
//        echo "<table>";
//        echo "<tr><th>Sender Email</th><th>Last Message</th><th>Date/Time Sent</th><th>Reply...</th></tr>";
//        while($row = $toResult->fetch_assoc()) {
//            echo "<tr><td>{$row['from']}</td><td>{$row['content']}</td></tr>";
//        }
//        echo "</table>";
//    }
//}

function getConversation(): void
{
    if(isset($_GET['email'])) {
        $mysqli = require __DIR__ . "/database.php";
        $email = $_GET['email'];
        $user_email = $_SESSION['user_email'];
        $fromQuery = "SELECT `from`, `to`, content, datetime FROM messages WHERE `from`='$email' AND `to`='$user_email'";
        $toQuery = "SELECT `from`, `to`, content, datetime FROM messages WHERE `to`='$email' AND `from`='$user_email'";

        // Combine the two queries into a single query
        $query = "$fromQuery UNION $toQuery ORDER BY datetime ASC";
        $result = $mysqli->query($query);

        // CSS styles for the conversation
        echo '<style>
                .conversation {
                    border: 1px solid #ccc;
                    padding: 10px;
                    margin-bottom: 10px;
                    max-height: 700px;
                    overflow-y: auto;
                }

                .message-container {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .sender-message {
                    padding: 10px;
                    background-color: #80caff;
                    align-self: flex-end;
                    border-radius: 5px;
                    font-weight: bold;
                    word-break: break-word;              
                    max-width: 200px;
                          
                }

                .recipient-message {
                    padding: 10px;
                    font-weight: bold;
                    background-color: #a8a8a8;
                    align-self: flex-start;
                    border-radius: 5px;
                    word-break: break-word;
                    max-width: 200px;
                }
                
                .timestamp-sender {
                    padding-bottom: 20px;
                    align-self: flex-end;
                    color: #3d3939;
                    font-size: 12px;
                }
                
                .timestamp-recipient {
                    padding: 5px;
                    align-self: flex-start;
                    color: #3d3939;
                    font-size: 12px;
                }
            </style>';

        // Start the conversation container
        echo '<div class="conversation">';

        while($row = $result->fetch_assoc()) {
            $sender = $row['from'];
            $message = $row['content'];
            $timestamp = $row['datetime'];

            // Determine the CSS class based on the message sender
            $cssClass = ($sender === $email) ? 'recipient-message' : 'sender-message';
            $cssTimestamp = ($sender === $email) ? 'timestamp-recipient' : 'timestamp-sender';

            // Display the message with appropriate CSS class
            echo '<div class="message-container">';
            echo '<div class="'.$cssClass.'">'.$message.'</div>';
            echo '<div class="'.$cssTimestamp.'">'.$timestamp.'</div>';
            echo '</div>';
        }

        // End the conversation container
        echo '</div>';
    }
}

function sendMessage(): void
{
    if(isset($_POST['sendMessage'])) {
        $mysqli = require __DIR__ . "/database.php";
        $toEmail = $_GET['email'];
        $user_email = $_SESSION['user_email'];
        $message = $_POST['sendMessage'];
        $dateTimeVariable = date('Y-m-d H:i:s');
        $query = "INSERT INTO messages VALUES ('$toEmail', '$user_email', '$message', '$dateTimeVariable')";
        $result = mysqli_query($mysqli, $query);
//        echo "<script> window.location.reload(); </script>";
        header("Refresh:0");
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
    <?php if(isset($_GET['email'])): ?>

    <h1>
        <?php
            echo $_GET['email'];
        ?>
    </h1>

    <?php
        getConversation();
        if(isset($_POST['sendMessage'])) {
            sendMessage();
            unset($_POST['sendMessage']);
        }
    ?>

    <form class="searchbar" action="" method="post">
        <input type="text"  name="sendMessage" id="sendMessage">
        <button style="display:flex; align-items:center; justify-content:center;"><i class="material-icons">arrow</i></button>
    </form>

    <?php else: ?>

    <h1>How did you get here?</h1>

    <?php endif ?>

</div>

</body>
</html>