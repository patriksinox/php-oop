<?php
//require "../databaza/components/secret/db.php";
//require "../databaza/components/secret/user.php";
require "classes/Database.php";
require "classes/User.php";

session_start();


if($_SERVER["REQUEST_METHOD"] === "POST"){
    //$connection = connectDB();
    $database = new Database();
    $connection = $database->connectDB();

    $email = $_POST["email"];
    $password = $_POST["password"];
   

   User::login($connection, $email,$password);




}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require "../php-oop/components/header.php"?>
    <h1>Prihlásenie</h1>

    <form  method="POST">
    <input type="email" name="email" placeholder="email"> <br>
    <input type="password" name="password" placeholder="password"> <br>
    <input type="submit" value="Prihlásiť">

    </form>
</body>
</html>