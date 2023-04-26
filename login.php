<?php

$is_invalid = false;

if($_SERVER["REQUEST_METHOD"] === "POST" ){
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM users
            WHERE email = '%s'",
            $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if($user){

        if($_POST["password"] === $user["Password"]){

            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["ID"];

            header("Location: index.php");
            exit;


        }

    }

    $is_invalid = true;


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
    <h1> Login </h1>

    <?php if ($is_invalid): ?>
        <em> Invalid username or password</em>
    <?php endif; ?>

    <form method="post">
        <label for="email"> Email </label>
        <input type="email" name="email" id="email"
        value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>">

        <label for="password"> Password </label>
        <input type="password" name="password" id="password">

        <button> Log in </button>

    </form>

</body>
</html>