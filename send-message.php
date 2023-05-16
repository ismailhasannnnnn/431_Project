<?php
session_start();
if(isset($_POST['sendMessage'])) {
    $mysqli = require __DIR__ . "/database.php";
    $toEmail = $_GET['email'];
    $user_email = $_SESSION['user_email'];
    $message = $_POST['sendMessage'];
    $dateTimeVariable = date('Y-m-d H:i:s');
    $falseVal = 0;
    $nullVal = null;
//    $query = "INSERT INTO messages VALUES ('$toEmail', '$user_email', '$message', '$dateTimeVariable', false, null)";
    $query = "INSERT INTO messages (`to`, `from`, content, datetime, `read`, time_read) VALUES (?,?,?,?,?,?)";
    $stmt = $mysqli->stmt_init();
    if(!$stmt->prepare($query)){
        die("SQL error". $mysqli->error);
    }

    if(!$stmt->bind_param("ssssss",
        $toEmail,
        $user_email,
        $message,
        $dateTimeVariable,
        $falseVal,
        $nullVal)){
        die("Binding parameters failed:" . $stmt->error);
    }

    try {
        $stmt->execute();
    } catch (Exception $e) {
        echo "Errors executing statement: " . $e->getMessage();
    }

//    $result = mysqli_query($mysqli, $query);
    header("Location: conversation-view.php?email=$toEmail");
    exit();
}
