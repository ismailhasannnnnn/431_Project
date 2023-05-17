<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $query = "SELECT * FROM `meetings` WHERE
                              recipient = '{$_SESSION["user_email"]}'
                            ORDER BY `date` DESC LIMIT 5
                             ";

    $meetingResult = $mysqli->query($query);

    $recentMeetings = $meetingResult->fetch_all(MYSQLI_ASSOC);


    $sqlMessages = "SELECT  `from`, LEFT(`content`, 20) AS `short_content`, `datetime` FROM `messages`
                WHERE (`to` = '{$_SESSION["user_email"]}' AND `datetime` IN (
                    SELECT MAX(`datetime`) FROM `messages`
                    WHERE `to` = '{$_SESSION["user_email"]}'
                    GROUP BY `from`)
                )
                ORDER BY `datetime` DESC
                LIMIT 5";



    $messagesResult = $mysqli->query($sqlMessages);

    $recentMessages = $messagesResult->fetch_all(MYSQLI_ASSOC);





}

//function getPractices($search)
//{
//    $mysqli = require __DIR__ . "/database.php";
//    if (strlen($search) == 5 && ctype_digit($search)) {
//        $zipcode = $search;
//        $sql = "SELECT * FROM practices WHERE zipcode='$zipcode'";
//    } else {
//        $name = $search;
//        $sql = "SELECT * FROM practices WHERE practiceName='$name'";
//    }
//    $result = $mysqli->query($sql);
//    echo "<table>";
//    echo "<tr><th>Practice Name</th><th>Street Address</th><th>City</th><th>Zip Code</th><th>Country</th><th>Contact Button</th></tr>";
//    while ($row = $result->fetch_assoc()) {
//
//        $emailQuery = "SELECT email FROM users WHERE ID={$row['userID']}";
//        $emailResult = $mysqli->query($emailQuery);
//        $email = mysqli_fetch_array($emailResult)[0];
//        $contactUrl = 'new-message-view.php?email=' . $email;
//        echo "<tr><td>{$row['practiceName']}</td><td>{$row['streetAddress']}</td><td>{$row['city']}</td><td>{$row['zipcode']}</td><td>{$row['country']}</td><td><a href=$contactUrl class='button'>Contact</a></td>";
//    }
//    echo "</table>";
//
//}

//function getPractices($search)
//{
//    $mysqli = require __DIR__ . "/database.php";
//
//    if (strlen($search) == 5 && ctype_digit($search)) {
//        $sql = "SELECT * FROM practices WHERE zipcode=?";
//    } else {
//        // Check if the search term matches a known practice type
//        $practiceTypes = ['family', 'pediatric', 'orthopedic', 'dermatology', 'cardiology', 'gastroenterology', 'neurology', 'endocrinology', 'psychiatry', 'oncology', 'ophthalmology', 'otolaryngology', 'urology', 'radiology', 'anesthesiology', 'surgery', 'physical_therapy', 'dental'];
//        if (in_array($search, $practiceTypes)) {
//            $sql = "SELECT * FROM practices WHERE practiceType=?";
//        } else {
//            $sql = "SELECT * FROM practices WHERE practiceName=?";
//        }
//    }
//
//    // Prepare the statement
//    $stmt = $mysqli->prepare($sql);
//    $stmt->bind_param('s', $search);
//
//    // Execute the statement
//    $stmt->execute();
//    $result = $stmt->get_result();
//
//    echo "<table>";
//    echo "<tr><th>Practice Name</th><th>Type</th><th>Street Address</th><th>City</th><th>Zip Code</th><th>Country</th><th>Contact Button</th></tr>";
//    while ($row = $result->fetch_assoc()) {
//
//        $emailQuery = "SELECT email FROM users WHERE ID=?";
//        $emailStmt = $mysqli->prepare($emailQuery);
//        $emailStmt->bind_param('i', $row['userID']);
//        $emailStmt->execute();
//        $emailResult = $emailStmt->get_result();
//        $email = $emailResult->fetch_array()[0];
//        $contactUrl = 'new-message-view.php?email=' . $email;
//        echo "<tr><td>{$row['practiceName']}</td><td>{$row['practiceType']}</td><td>{$row['streetAddress']}</td><td>{$row['city']}</td><td>{$row['zipcode']}</td><td>{$row['country']}</td><td><a href=$contactUrl class='button'>Contact</a></td>";
//    }
//    echo "</table>";
//}

function getPractices($search)
{
    $mysqli = require __DIR__ . "/database.php";

    if (strlen($search) == 5 && ctype_digit($search)) {
        $sqlPractices = "SELECT * FROM practices WHERE zipcode=?";
        $sqlProviders = "SELECT * FROM providers WHERE zipcode=?";
    } else {
        // Check if the search term matches a known practice type
        $practiceTypes = ['family', 'pediatric', 'orthopedic', 'dermatology', 'cardiology', 'gastroenterology', 'neurology', 'endocrinology', 'psychiatry', 'oncology', 'ophthalmology', 'otolaryngology', 'urology', 'radiology', 'anesthesiology', 'surgery', 'physical_therapy', 'dental', 'gastrology','radiology', 'radiologist'];
        if (in_array($search, $practiceTypes)) {
            $sqlPractices = "SELECT * FROM practices WHERE practiceType=?";
            $sqlProviders = "SELECT * FROM providers WHERE providerType=?";
        } else {
            $sqlPractices = "SELECT * FROM practices WHERE practiceName=?";
            $sqlProviders = "SELECT * FROM providers WHERE providerName=?";
        }
    }

    // Prepare the statements
    $stmtPractices = $mysqli->prepare($sqlPractices);
    $stmtPractices->bind_param('s', $search);

    $stmtProviders = $mysqli->prepare($sqlProviders);
    $stmtProviders->bind_param('s', $search);

    // Execute the statements and fetch all rows
    $stmtPractices->execute();
    $resultPractices = $stmtPractices->get_result();
    $practices = $resultPractices->fetch_all(MYSQLI_ASSOC);

    $stmtProviders->execute();
    $resultProviders = $stmtProviders->get_result();
    $providers = $resultProviders->fetch_all(MYSQLI_ASSOC);

    echo "<table>";
    echo "<tr><th>Type</th><th>Name</th><th>Title</th><th>Street Address</th><th>City</th><th>Zip Code</th><th>Country</th><th>Contact</th></tr>";
    foreach ($practices as $row) {
        $emailQuery = "SELECT email FROM users WHERE ID=?";
        $emailStmt = $mysqli->prepare($emailQuery);
        $emailStmt->bind_param('i', $row['userID']);
        $emailStmt->execute();
        $emailResult = $emailStmt->get_result();
        $email = $emailResult->fetch_array()[0];
        $contactUrl = 'new-message-view.php?email=' . $email;
        $inviteUrl = 'new-meeting-view.php?email=' . $email;

        echo "<tr><td style='font-weight: bold;'>Practice</td><td>{$row['practiceName']}</td><td>{$row['practiceType']}</td><td>{$row['streetAddress']}</td><td>{$row['city']}</td><td>{$row['zipcode']}</td><td>{$row['country']}</td><td><a href=$contactUrl class='button'>Contact</a><a href=$inviteUrl class='button'>&nbsp Invite &nbsp   </a></td></tr>";
    }

    foreach ($providers as $row) {
        $emailQuery = "SELECT email FROM users WHERE ID=?";
        $emailStmt = $mysqli->prepare($emailQuery);
        $emailStmt->bind_param('i', $row['userID']);
        $emailStmt->execute();
        $emailResult = $emailStmt->get_result();
        $email = $emailResult->fetch_array()[0];
        $contactUrl = 'new-message-view.php?email=' . $email;
        $inviteUrl = 'new-meeting-view.php?email=' . $email;

        echo "<tr><td style='font-weight: bold;'>Provider</td><td>{$row['providerName']}</td><td>{$row['providerType']}</td><td>{$row['streetAddress']}</td><td>{$row['city']}</td><td>{$row['zipcode']}</td><td>{$row['country']}</td><td><a href=$contactUrl class='button'>Contact</a><a href=$inviteUrl class='button'>&nbsp Invite &nbsp</a></td></tr>";
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


</head>
<body class="main">




<?php if (isset($user)): ?>

    <nav>
        <div class="divider"></div>
        <a href="index.php" style="font-weight: bold;">DocMeet Dashboard</a>
        
        <a href="appointment-view.php"> Appointments </a>


        <?php if ($user["Type"] == "provider") : ?>
            <a href="edit-provider.php"> Provider Profile </a>
        <?php else : ?>
            <a href="edit-practice.php"> Your Practice</a>
        <?php endif; ?>

        <a href="message-view.php">Messages</a>

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
                <form class="searchbar" action="" method="get">
                    <input type="search" placeholder="Search by Name, Zip, or Type..." name="search" id="search">
                    <button style="display:flex; align-items:center; justify-content:center;"><i class="material-icons">search</i></button>
                </form>
            </div>
        </div>

        <div class="six columns">
            <h4> Quick Links</h4>
            <a href="new-meeting-view.php" class="button"> Create an Invite</a>
            <a href="new-message-view.php" class="button"> New Message</a>
            <a href="edit-practice.php" class="button"> Edit Practice</a>
        </div>


    </div>

    <div class="row">

        <div class="six columns">
            <h4> Recent Invites</h4>


                <?php if (!empty($recentMeetings)) : ?>
                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <th>Meeting Name</th>
                            <th>Date</th>
                            <th>Time</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($recentMeetings as $meeting) : ?>
                            <tr>
                                <td class="meeting-name-cell"><a href="view-meeting.php?meeting_id=<?php echo $meeting['meeting_ID']; ?>"><?php echo $meeting['name']; ?></a></td>
                                <td><?php echo $meeting['date']; ?></td>
                                <td><?php echo $meeting['Time']; ?></td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No recent invites found.</p>
                <?php endif; ?>




        </div>




        <div class="six columns">
            <h4> Recent Messages</h4>


            <?php if (!empty($recentMessages)) : ?>
            <table style="width: 100%;">
                    <tr>
                        <th>Sender</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                    <?php foreach ($recentMessages as $message): ?>
                        <tr>
                            <td><a href="conversation-view.php?email=<?= htmlspecialchars($message['from']) ?>"><?= htmlspecialchars($message['from']) ?></a></td>
                            <td><?= htmlspecialchars($message['short_content']) ?></td>
                            <td><?= htmlspecialchars($message['datetime']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No messages found.</p>
            <?php endif; ?>

        </div>


    </div>

    <?php else: ?>

        <div class="doctor">

            <nav class="landingNav">
                <a href="index.php">DocMeet</a>


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
if(isset($_GET['search'])){
    echo '<div class="container main-card">';
    echo '    <div class="row">';
//    echo '        <div class="one column"><br></div>';
    echo '        <div class="twelve columns">';
    echo '            ';
    getPractices($_GET['search']);
    unset($_GET['search']);
    echo '        </div>';
//    echo '        <div class="one column"><br></div>';
    echo '    </div>';
    echo '</div>';
}
?>

</body>
</html>