
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

if(isset($_SESSION["user_id"])){

    $mysqli = require __DIR__ . "/database.php";

    //Pull from meetings table




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


    <div class="row">

        <div class="one-half column">
            <h1 class="dash"> Your Appointments</h1>

        </div>
        <div class="one-half column">
            <div id='calendar'></div>
        </div>

    </div>




</div>




</body>
</html>