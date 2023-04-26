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



<h1> Your Practice </h1>
<p> Looks like you haven't set up your practice yet. <a href="#"> Set up practice.</a></p>


</body>
</html>