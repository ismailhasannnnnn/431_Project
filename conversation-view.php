<?php
session_start();
ini_set('display_errors', 0);

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";



    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

function getConversation(): void
{
    if (isset($_GET['email'])) {
        $mysqli = require __DIR__ . "/database.php";
        $email = $_GET['email'];
        $user_email = $_SESSION['user_email'];
        $fromQuery = "SELECT `from`, `to`, content, datetime, `read`, time_read FROM messages WHERE `from`='$email' AND `to`='$user_email'";
        $toQuery = "SELECT `from`, `to`, content, datetime, `read`, time_read FROM messages WHERE `to`='$email' AND `from`='$user_email'";

        // Combine the two queries into a single query
        $query = "$fromQuery UNION $toQuery ORDER BY datetime ASC";
        $result = $mysqli->query($query);

        $lastMessageQuery = "SELECT m1.`from`, m1.content, m1.datetime, m1.`read`, m1.time_read FROM messages m1
                            JOIN (
                                SELECT `from`, MAX(datetime) as max_datetime
                                FROM messages
                                WHERE `to` = ? AND `from` = ?
                                GROUP BY `from`
                                )
                            m2 ON m1.`from` = m2.`from` AND m1.datetime = m2.max_datetime";

        $stmt = $mysqli->prepare($lastMessageQuery);
        $stmt->bind_param("ss", $email, $user_email);
        $stmt->execute();
        $lastMessageResult = $stmt->get_result();
        $lastMessage = mysqli_fetch_array($lastMessageResult)[1];

        $lastRecipientMessageQuery = "SELECT m1.`from`, m1.content, m1.datetime, m1.`read`, m1.time_read FROM messages m1
                            JOIN (
                                SELECT `from`, MAX(datetime) as max_datetime
                                FROM messages
                                WHERE `to` = ? AND `from` = ?
                                GROUP BY `from`
                                )
                            m2 ON m1.`from` = m2.`from` AND m1.datetime = m2.max_datetime";

        $stmt = $mysqli->prepare($lastRecipientMessageQuery);
        $stmt->bind_param("ss", $user_email, $email);
        $stmt->execute();
        $lastRecipientMessageResult = $stmt->get_result();
        $lastRecipientMessage = mysqli_fetch_array($lastRecipientMessageResult)[1];
        $dateTimeVariable = date('Y-m-d H:i:s');

        // Prepare the SQL statement
        $updateReadReceiptQuery = "UPDATE messages SET `read` = true, time_read = ? 
                          WHERE content = ? AND `to` = ? AND `from` = ?";

        // Prepare and bind the parameters
        $stmt = $mysqli->prepare($updateReadReceiptQuery);
        $stmt->bind_param('ssss', $dateTimeVariable, $lastRecipientMessage, $user_email, $email);

        // Execute the prepared statement
        $stmt->execute();

        // CSS styles for the conversation
        echo '<style>
                .conversation {
                    border: 1px solid #ccc;
                    padding: 10px;
                    margin-bottom: 10px;
                    max-height: 600px;
                    overflow-y: auto;
                    display: flex;
                    flex-direction: column-reverse;
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
                    background-color: #e1e1e1;
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
        echo '<div>';

        while ($row = $result->fetch_assoc()) {
            $sender = $row['from'];
            $message = $row['content'];
            $timestamp = $row['datetime'];

            // Determine the CSS class based on the message sender
            $cssClass = ($sender === $email) ? 'recipient-message' : 'sender-message';
            $cssTimestamp = ($sender === $email) ? 'timestamp-recipient' : 'timestamp-sender';
            $readReceipt = ($row['read'] == 1) ? 'Read' : 'Delivered';


            // Display the message with appropriate CSS class
            echo '<div class="message-container">';
            echo '<div class="' . $cssClass . '">' . $message . '</div>';
            if ($message == $lastMessage) {
                if($readReceipt === 'Read') {
                    $readTimestampQuery = "SELECT time_read FROM messages WHERE content='$lastMessage' AND datetime='$timestamp'";
                    $readTimestampResult = mysqli_query($mysqli, $readTimestampQuery);
                    $timestamp = mysqli_fetch_array($readTimestampResult)[0];
                }

                echo '<div class="' . $cssTimestamp . '">' . $readReceipt . ' ' . $timestamp . '</div>';
            } else {
                echo '<div class="' . $cssTimestamp . '">' . $timestamp . '</div>';
            }
            echo '</div>';
        }

        echo '</div>';
        // End the conversation container
        echo '</div>';
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

    <a href="appointment-view.php"> Appointments </a>


    <?php if ($user["Type"] == "provider") : ?>
        <a href="edit-provider.php"> Provider Profile </a>
    <?php else : ?>
        <a href="edit-practice.php"> Your Practice</a>
    <?php endif; ?>

    <a href="message-view.php">Messages</a>

</nav>

<div class="container main-card">
    <?php if (isset($_GET['email'])): ?>

        <h1>
            <?php
            echo $_GET['email'];
            ?>
        </h1>

    <?php
    getConversation();
    ?>

        <form class="searchbar" id="searchbarForm" action="send-message.php?" method="post" onsubmit="changeAction()">
            <input type="text" name="sendMessage" id="sendMessage">
            <button style="display:flex; align-items:center; justify-content:center;"><i
                    class="material-icons">arrow</i></button>
        </form>

        <script>
            document.getElementById("sendMessage").focus();

            function changeAction() {
                const url = window.location.search;
                const params = new URLSearchParams(url);
                const email = params.get('email');
                document.getElementById("searchbarForm").action = "send-message.php?email=" + email;
            }
        </script>


    <?php else: ?>

        <h1>How did you get here?</h1>

    <?php endif ?>

</div>

</body>
</html>