
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

if(isset($_SESSION["user_id"])){

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $sql = "SELECT *
            FROM practices
            WHERE userID = {$_SESSION["user_id"]}";

    $result1 = $mysqli->query($sql);
    $practice = $result1->fetch_assoc();



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
        <a href="index.php">DocMeet Dashboard</a>


        <a href="edit-practice.php" style="font-weight:bold;"> Your Practice</a>

        <a href="message-view.php">Messages</a>

        <a href="edit-profile.php"> Your Profile </a>

    </nav>



    <div class="container main-card">


        <h1 class="dash"> Your Practice </h1>


        <?php if (isset($practice)): ?>
            <p>Practice Name: <?php echo $practice["practiceName"]; ?></p>
            <p>Bio: <?php echo $practice["bio"]; ?></p>
            <p>Address: <?php echo $practice["streetAddress"] . ", " . $practice["city"] . ", " . $practice["country"] . " " . $practice["zipcode"]; ?></p>

            <a href="#"> Edit Practice</a>

        <?php else: ?>
            <p>Looks like you haven't set up your practice yet. <a href="new-practice-view.php">Set up practice.</a></p>
        <?php endif; ?>



    </div>










</body>
</html>
