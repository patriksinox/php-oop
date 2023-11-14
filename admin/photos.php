<?php 
require "../classes/Auth.php";
require "../classes/Database.php";
require "../classes/Image.php";

session_start();



if(!Auth::isLoggedIn()){
    die("Nepovolený prístup");
}

$db = new Database();
$connection = $db->connectDB();

$user_id = $_SESSION["logged_in_user_id"];

$fotky = Image::getImages($connection,$user_id);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nahrávanie fotiek</title>
</head>
<body>
    <?php require "../components/secret/admin-header.php" ?>
    <h1>Nahrávanie fotiek</h1>

    <!-- Nahratie obrázka -->
    <form action="upload-photos.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" >
    <input type="submit" name="submit" value="Nahrať obrázok">
    </form>


    
    <ul>

    
    <?php if(!empty($fotky)) foreach($fotky as $index=>$fotka): ?>
        <li>
        <img  width="200px"  src='../uploads/<?=$user_id ?>/<?=$fotka["image_name"]?>'/> 
        <a href="delete-image.php?user_id=<?= $user_id?>&image_name=<?= $fotka["image_name"]?>">vymazať</a>
        <a download href="../uploads/<?=$user_id ?>/<?=$fotka["image_name"]?>" >Stiahnúť</a>
        
        
        </li>
    <?php endforeach; ?>
    </ul>

    

</body>
</html>