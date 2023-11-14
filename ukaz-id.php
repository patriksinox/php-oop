<?php
//require "../databaza/components/secret/db.php";
//require "../databaza/components/secret/user.php";
require "classes/User.php";
require "classes/Database.php";

session_start();

$id = null;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    //$connection = connectDB();
    $database = new Database();
    $connection = $database->connectDB();

    $email = $_POST["email"];
   
    $id = User::getUserId($connection, $email);


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
    <h1>Ukaž ID</h1>
    <h1>ID je <?php echo $id ?></h1>
    <form  method="POST">
        <input type="email" name="email" >
        <input type="submit" value="Zobraz ID">
    </form>
</body>
</html>