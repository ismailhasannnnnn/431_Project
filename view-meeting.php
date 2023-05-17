<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_GET["meeting_id"])) {
    die("No meeting ID provided");
}

$mysqli = require __DIR__ . "/database.php";

$meeting_id = $_GET["meeting_id"];

$query = "SELECT * FROM `meetings` WHERE meeting_ID = ?";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($query)) {
    die("SQL error: " . $mysqli->error);
}

if (!$stmt->bind_param("i", $meeting_id)) {
    die("Binding parameters failed: " . $stmt->error);
}

if (!$stmt->execute()) {
    die("Execution failed: " . $stmt->error);
}

$result = $stmt->get_result();

$meeting = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newFood = $_POST['newFood'];

    $updateQuery = "UPDATE `meetings` SET `favoriteFood` = ? WHERE `meeting_ID` = ?";

    $stmtUpdate = $mysqli->stmt_init();

    if (!$stmtUpdate->prepare($updateQuery)) {
        die("SQL error: " . $mysqli->error);
    }

    if (!$stmtUpdate->bind_param("si", $newFood, $meeting_id)) {
        die("Binding parameters failed: " . $stmtUpdate->error);
    }

    if (!$stmtUpdate->execute()) {
        die("Execution failed: " . $stmtUpdate->error);
    }

    $stmtUpdate->close(); // close the update statement

    // Since the meeting info was updated, fetch it again
    if (!$stmt->prepare($query)) {
        die("SQL error: " . $mysqli->error);
    }

    if (!$stmt->bind_param("i", $meeting_id)) {
        die("Binding parameters failed: " . $stmt->error);
    }

    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $meeting = $result->fetch_assoc();
}


?>




<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <script src='fullcalendar-6.1.7/dist/index.global.js'></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="js/Calendar.js"></script>

</head>



<body>


<nav>
    <div class="divider"></div>
    <a href="index.php" >DocMeet Dashboard</a>


    <a href="#" style="font-weight: bold;"> Appointments </a>

    <a href="edit-practice.php"> Your Practice</a>

    <a href="message-view.php">Messages</a>



</nav>

<div class="container main-card">

    <h1 class="dash cut"> <?= htmlspecialchars($meeting["name"]) ?> </h1>
    <h4> Date: <span style="font-weight: bold;"><?= htmlspecialchars($meeting["date"]) ?> </span> </h4>
    <h4> Time: <span style="font-weight: bold;"><?= htmlspecialchars($meeting["Time"]) ?> </span> </h4>
    <h4> Participants: <span style="font-weight: bold;">  <?= htmlspecialchars($meeting["sender"]) ?> and  <?= htmlspecialchars($meeting["recipient"]) ?>    </span></h4>
    <h5 class="cut"> Message: <span style="font-weight: bold;"><?= htmlspecialchars($meeting["messageContent"]) ?> </span> </h5>

    <h5> Preferred Foods: <span style="font-weight: bold;"><?= htmlspecialchars($meeting["favoriteFood"]) ?> </span></h5>


    <form id="editFoodForm" method="POST" action="">
        <label for="newFood">Edit Preferred Food:</label>
        <input type="text" id="newFood" name="newFood" value="<?= htmlspecialchars($meeting["favoriteFood"]) ?>">
        <input type="submit" value="Update">
    </form>



</div>

</body>

</html>

