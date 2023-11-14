<?php

require "../classes/Database.php";
require "../classes/Auth.php";
require "../classes/Image.php";

session_start();

if(!Auth::isLoggedIn()){
    die("Nepovolený prístup");
}

if (isset($_GET['image_name']) && isset($_GET['user_id'])) {
    $db = new Database();
    $connection = $db->connectDB();

    $user_id = $_GET['user_id'];
    $image_name = $_GET['image_name'];

    if($_SERVER["REQUEST_METHOD"] === "POST"){


    Image::deleteImage($connection,$user_id,$image_name);


    // Presmerovanie späť na pôvodnú stránku
    header("Location: photos.php");
    exit();
}
} else {
    echo "Chyba: Nekorektné parametre.";
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
    
    <h1>Vážne chcete vymazať obrázok ?</h1>
    <form method="POST">
        <input type="submit" value="áno">
        <button><a href="../admin/photos.php">Naspäť</a></button>
    </form>
</body>
</html>