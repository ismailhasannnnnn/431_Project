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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/custom.css">


    <!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">-->
</head>
<body>

<!--<nav>-->
<!--    <a href="index.php" >DocMeet</a>-->
<!--    --><?php //if (!isset($user)): ?>
<!--        <a href="#"> FAQ </a>-->
<!--    --><?php //endif; ?>
<!--    --><?php //if (isset($user)): ?>
<!--        <a href="edit-practice.php"> Your Practice</a>-->
<!--        <a href="edit-profile.php"> Your Profile </a>-->
<!---->
<!--        <a href="message-view.php">Messages</a>-->
<!--    --><?php //endif; ?>
<!--</nav>-->
<!---->




<?php if (isset($user)): ?>
        <p> You are now logged in as <?= htmlspecialchars($user["Name"]) ?>
            (<?= htmlspecialchars($user["Type"]) ?>)</p>



        <input type="search" placeholder="Search Practices.." style="height:3em;">



<!--        <p> <a href="logout.php"> Log out </a>-->
        <p> <button><a href="logout.php"> Log out </a> </button></p>


    <?php else: ?>


<!--                <img src="images/doctors1.png" class="doctor">-->



            <div class="doctor">

                <nav>
                    <a href="index.php" >DocMeet</a>
                    <?php if (!isset($user)): ?>
                        <a href="#"> FAQ </a>
                    <?php endif; ?>
                    <?php if (isset($user)): ?>
                        <a href="edit-practice.php"> Your Practice</a>
                        <a href="edit-profile.php"> Your Profile </a>

                        <a href="message-view.php">Messages</a>
                    <?php endif; ?>
                </nav>



                <div class="cover">
                <div class="container logoGroup">
                        <h1> DocMeet™ </h1>
                        <h5> Connecting healthcare professionals for seamless networking.</h5>
                        <br>
                        <p>  <a href="login.php" class="button landing-button"> Log in </a> or  <a href="signup.html" class="button landing-button"> Sign up</a> </p>
                </div>

            </div>

            </div>



<!--             <div class="container centered-container">-->
<!--             </div>-->

            <div class="container centered-container">


            </div>








    <?php endif; ?>





</body>
</html>