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
<body class="main">

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

    <nav>
        <a href="index.php" style="font-size:20px;" >DocMeet</a>


            <a href="edit-practice.php"> Your Practice</a>

            <a href="message-view.php">Messages</a>

            <a href="edit-profile.php"> Your Profile </a>
    </nav>

    <div class="divider"></div>


    <div class="container main-card">
        <h1 class="dash">Dashboard</h1>


        <div class="row">

            <div class="two-thirds column">
                <h4>Practices and Providers Near You</h4>
                <input type="search" placeholder="Search Practices by name or zipcode" style="height:3em; width:20em;">

            </div>

            <div class="one-third column">
                <h4>Quick Links </h4>
                <a href="logout.php" class="button"> Log out </a>
                <a href="logout.php" class="button"> Edit Profile </a>
            </div>



        </div>

        <div class="row">
            <div class=" column">
                <h4> Recent Messages</h4>

                <table class="u-full-width">
                    <thead>
                    <tr>
                        <th>Message</th>
                        <th>From</th>
                        <th>Date</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Hey I was thinking we could meet up.</td>
                        <td>jgonza1427@gmail.com</td>
                        <td> 2 days ago</td>
                    </tr>
                    <tr>
                        <td>Dwayne Johnson</td>
                        <td>The Rock</td>
                        <td>3 days ago</td>

                    </tr>
                    </tbody>
                </table>



            </div>

            <div class="one-half column">

            </div>

        </div>






<!--        (--><?php //= htmlspecialchars($user["Type"]) ?><!--)-->



    </div>







    <?php else: ?>

            <div class="doctor">

                <nav class="landingNav">
                    <a href="index.php" >DocMeet</a>
                    <a href="#"> FAQ </a>



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














    <?php endif; ?>





</body>
</html>