<?php
session_start();
if (isset($_SESSION["user_id"])) {

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
    <title> DocMeet Home </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/custom.css">


</head>
<body class="main">

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

    <h1 class="dash">
        Create a New Message
    </h1>





    <form action="new-message.php" method="post" novalidate>

        <div>
            <label for="emailTo">Recipient Email: </label>
            <input type="text" id="emailTo" name="emailTo"/>
        </div>
        <br>
        <div>
            <label for="content">Message Content: </label>
            <textarea id="content" name="content" rows="8" cols="20"></textarea>
        </div>


        <br>


        <div>
            <button>Submit</button>
        </div>


    </form>






</div>







<script>
    const url = window.location.search;
    const urlParams = new URLSearchParams(url);
    console.log(urlParams.get("email"));
    if (urlParams.get("email") != null) {
        document.getElementById("emailTo").value = urlParams.get("email");
    }
</script>

</body>

</html>
