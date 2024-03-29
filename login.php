<?php
$is_invalid = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $email = $mysqli->real_escape_string($_POST["email"]);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        $hashedPass = hash('sha256', $_POST["password"]);

        if ($hashedPass == $user["Password"]) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["ID"];
            $_SESSION["user_email"] = $_POST["email"];
            header("Location: index.php");
            exit;
        } else {
            $is_invalid = true;
            $error_message = "Invalid password.";
        }
    } else {
        $is_invalid = true;
        $error_message = "Invalid username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DocMeet Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>
<nav>
    <div class="divider"></div>
    <a href="index.php" style="font-weight: bold;">DocMeet</a>
    <a href="index.php">FAQ</a>
</nav>

<div class="container main-card">
    <h1 class="dash">DockMeet Login</h1>

    <?php if ($is_invalid): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <p>
            <button>Log in</button>
            <a href="signup.html">Sign up instead</a>
        </p>
    </form>
</div>
</body>
</html>