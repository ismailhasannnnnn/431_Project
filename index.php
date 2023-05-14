<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();


}

function getPractices($search)
{
    $mysqli = require __DIR__ . "/database.php";
    if(strlen($search) == 5 && ctype_digit($search)) {
        $zipcode = $search;
        $sql = "SELECT * FROM practices WHERE zipcode='$zipcode'";
    } else {
        $name = $search;
        $sql = "SELECT * FROM practices WHERE practiceName='$name'";
    }
    $result = $mysqli->query($sql);
    echo "<table>";
    echo "<tr><th>Practice Name</th><th>Street Address</th><th>City</th><th>Zip Code</th><th>Country</th><th>Contact Button</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['practiceName']}</td><td>{$row['streetAddress']}</td><td>{$row['city']}</td><td>{$row['zipcode']}</td><td>{$row['country']}</td><td><button>Contact</button></td>";
    }
    echo "</table>";

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
    <div class="divider"></div>
    <a href="index.php" style="font-weight: bold;">DocMeet Dashboard</a>


    <a href="edit-practice.php"> Your Practice</a>

    <a href="message-view.php">Messages</a>

    <a href="edit-profile.php"> Your Profile </a>

</nav>

<div class="container main-card">


    <div class="row">
        <div class="two-thirds column">
            <h1 class="dash">DocMeet Dashboard</h1>
        </div>

        <!--            <div class="one-third column"> <br></div>-->

        <div class="one-third column" style="text-align:right; display:inline;">

            <div style="padding-top:5px;">
                <span class="profileName"> Logged in as <?= htmlspecialchars($user["Name"]) ?> </span>
                <a href="edit-profile.php"> <img src="/images/emptyavatar.png" class="icon"> </a>
            </div>


        </div>
    </div>


    <div class="row">
        <div class="six columns">

            <div class="row">
                <h4> Search for Practices and Providers</h4>
                <div class="searchbar">
                    <form action="" method="get">
                        <input type="search" placeholder="Search by Name or Zip..." name="search" id="search">
                        <button style="display:flex; align-items:center; justify-content:center;"><i
                                class="material-icons">search</i></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="six columns">
            <h4> Quick Links</h4>
            <a href="new-message-view.html" class="button"> Create an Invite</a>
            <a href="edit-practice.php" class="button"> Edit Practice</a>
            <a href="logout.php" class="button"> Log Out</a>
        </div>


    </div>

    <div class="row">

        <div class="six columns">
            <h4> Recent Invites</h4>
        </div>

        <div class="six columns">
            <h4> Recent Messages</h4>
        </div>


    </div>

    <?php else: ?>

        <div class="doctor">

            <nav class="landingNav">
                <a href="index.php">DocMeet</a>
                <a href="#"> FAQ </a>


            </nav>


            <div class="cover">
                <div class="container logoGroup">
                    <h1> DocMeet™ </h1>
                    <h5> Connecting healthcare professionals for seamless networking.</h5>
                    <br>
                    <p><a href="login.php" class="button landing-button"> Log in </a> or <a href="signup.html"
                                                                                            class="button landing-button">
                            Sign up</a></p>
                </div>

            </div>

        </div>


    <?php endif; ?>
</div>

<?php
if (isset($_GET['search'])) {
    echo "<div class='container main-card'>";
    echo "  <div class='six columns'>";
    getPractices($_GET['search']);
    unset($_GET['search']);
    echo "</div>";
    echo "</div>";
}
?>

</body>
</html>