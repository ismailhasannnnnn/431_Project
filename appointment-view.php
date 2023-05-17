
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

if(isset($_SESSION["user_email"])){

    $mysqli = require __DIR__ . "/database.php";


    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();


    //Pull from meetings table
    $query = "SELECT * FROM `meetings` WHERE
                             sender = '{$_SESSION["user_email"]}'
                             OR recipient = '{$_SESSION["user_email"]}'
                             
                             ";

    $result = $mysqli->query($query);

    $meetings = $result->fetch_all(MYSQLI_ASSOC);

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function() {
                    var meetingId = this.dataset.meetingId;

                    fetch('delete-meeting.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'meeting_id=' + encodeURIComponent(meetingId),
                    })
                        .then(response => response.text())
                        .then(result => {
                            console.log(result);
                            location.reload(); // Reload the page to update the table
                        })
                        .catch(error => console.log('Error:', error));
                });
            });


            document.querySelectorAll('.accept-button').forEach(button => {
                button.addEventListener('click', function() {
                    var meetingId = this.dataset.meetingId;

                    fetch('accept-meeting.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'meeting_id=' + encodeURIComponent(meetingId),
                    })
                        .then(response => response.text())
                        .then(result => {
                            console.log(result);
                            location.reload();
                        })
                        .catch(error => console.log('Error:', error));
                });
            });


            document.querySelectorAll('.decline-button').forEach(button => {
                button.addEventListener('click', function() {
                    var meetingId = this.dataset.meetingId;

                    fetch('delete-meeting.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'meeting_id=' + encodeURIComponent(meetingId),
                    })
                        .then(response => response.text())
                        .then(result => {
                            console.log(result);
                            location.reload();
                        })
                        .catch(error => console.log('Error:', error));
                });
            });



            // document.querySelectorAll('.decline-button').forEach(button => {
            //     button.addEventListener('click', function() {
            //         var meetingId = this.dataset.meetingId;
            //
            //         fetch('decline-meeting.php', {
            //             javascript
            //             Copy code
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/x-www-form-urlencoded',
            //             },
            //             body: 'meeting_id=' + encodeURIComponent(meetingId),
            //         })
            //             .then(response => response.text())
            //             .then(result => {
            //                 console.log(result);
            //                 location.reload();
            //             })
            //             .catch(error => console.log('Error:', error));
            //     });
            // });
            //








        });





    </script>



</head>



<body>


<nav>
    <div class="divider"></div>
    <a href="index.php" >DocMeet Dashboard</a>


    <a href="#" style="font-weight: bold;"> Appointments </a>

    <?php if ($user["Type"] == "provider") : ?>
        <a href="edit-provider.php"> Provider Profile </a>
    <?php else : ?>
        <a href="edit-practice.php"> Your Practice</a>
    <?php endif; ?>

    <a href="message-view.php">Messages</a>





</nav>
<div class="container main-card">

    <div class="row">
        <h1 class="dash"> Your Appointments</h1>


    </div>




    <div class="row">

        <div class="seven columns">

            <?php if (!empty($meetings)) : ?>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <th>Meeting Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($meetings as $meeting) : ?>
                        <tr>
                            <td class="meeting-name-cell">  <a href="view-meeting.php?meeting_id=<?php echo $meeting['meeting_ID']; ?>"> <?php echo $meeting['name']; ?>     </a>     </td>
                            <td><?php echo $meeting['date']; ?></td>
                            <td><?php echo $meeting['Time']; ?></td>



                            <td>
                                <?php if ($meeting['sender'] === $_SESSION['user_email']): ?> <!-- Only show the delete button if the current user is the sender -->
                                    <button class="delete-button" data-meeting-id="<?php echo $meeting['meeting_ID']; ?>">Delete</button>
                                <?php endif; ?>


                                <?php if ($meeting['recipient'] === $_SESSION['user_email'] && !$meeting['accepted']): ?> <!-- Only show these buttons if the current user is the recipient and the meeting has not been accepted yet -->
                                    <button class="accept-button" data-meeting-id="<?php echo $meeting['meeting_ID']; ?>">Accept</button>
                                    <button class="decline-button" data-meeting-id="<?php echo $meeting['meeting_ID']; ?>">Decline</button>
                                <?php endif; ?>

                            </td>

                            <td>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No meetings found.</p>

            <?php endif; ?>


            <a href="new-meeting-view.php" class="button"> Set up a meeting</a>

        </div>



        <div class="five columns">

            <div id='calendar'></div>

        </div>

    </div>




</div>







</body>
</html>