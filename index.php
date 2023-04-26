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
<html>
<head>
    <title> DocMeet Home </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
</head>
<body>
    <h1> Home </h1>

    <?php if (isset($user)): ?>
        <p> You are now logged in as <?= htmlspecialchars($user["Name"]) ?> </p>

<!--        <p> <a href="logout.php"> Log out </a>-->
        <p> <button><a href="logout.php"> Log out </a> </button></p>


    <?php else: ?>
        <p> <a href="login.php"> Log in </a> or <a href="signup.php"> sign up.</a></p>

    <?php endif; ?>


</body>
</html>