<?php

if(empty($_POST["name"])){
    die("Name is required");
}

if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

if(strlen($_POST["password"]) < 8){
    die("password must be at least 8 characters");
}

if($_POST["password"] !== $_POST["password_confirm"]){
    die("Passwords do not match");
}



$mysqli = require __DIR__ . "/database.php";



$sql = "INSERT INTO users (Name, Email, Password, Type)
           VALUES (?,?,?,?)";

$stmt = $mysqli->stmt_init();


if( ! $stmt->prepare($sql)){
    die("SQL error". $mysqli->error);
}

if(!$stmt->bind_param("ssss",
                    $_POST["name"],
                    $_POST["email"],
                    $_POST["password"],
                    $_POST["user_type"])){
    die("Binding parameters failed:" . $stmt->error);
}



try {
    $stmt->execute();
} catch (Exception $e) {
    //echo "Errors executing statement: " . $e->getMessage();
}

if ($stmt->errno) {
    if($stmt->errno === 1062){
        die("Email already in use. Please try another email.");
    }else{
        echo "Error executing statement: " . $stmt->error;
    }
}else{

//    echo "Signup Successful";
    header("Location: signup-success.html");
    exit;
}


