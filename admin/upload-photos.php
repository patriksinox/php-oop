<?php 
require "../classes/Database.php";
require "../classes/Auth.php";
require "../classes/Image.php";

session_start();

if(!Auth::isLoggedIn()){
    die("Nepovolený prístup");
}

$chyba = null;

$user_id = $_SESSION["logged_in_user_id"];


if(isset($_POST["submit"]) && isset($_FILES["image"])){
    $db = new Database();
    $connection = $db->connectDB();
    
    var_dump($_FILES["image"]);
    $image = $_FILES["image"];

    $image_name = $image["name"];
    $image_size = $image["size"] ;
    $image_tmp_name = $image["tmp_name"];
    $image_type = $image["type"];
    $error = $image["error"];
  
    $povolena_velkost = 1048576 ; //10 mb

    if($error === 0){
        if($image_size > $povolena_velkost){
            $error_message = "Váš súbor je príliš veľký. Povolená veľkosť je 10 mb.";
            $chyba = $error_message;
        }
        else{
            //pozrie aký extension má náš súbor 
            $image_extenstion = pathinfo($image_name, PATHINFO_EXTENSION); 
            //prevedie extension na malé písmená 
            $image_extenstion_lowerCase = strtolower($image_extenstion);
            //pole povolených extension
            $allowed_extension = ["jpg","jpeg","png","webp"];

            //Pozrie pole že či sa v ňom nachádza to čo chceme = povolené extenzie súborov.
            if(in_array($image_extenstion_lowerCase, $allowed_extension)){
                //Vygeneruje názov fotky
                $generated_name = uniqid("IMG-",true) . "." . $image_extenstion;
                
                //Ak zložka neexistuje
                if(!file_exists("../uploads/" . $user_id)){
                    //tak vytvorí zložku v uploads
                    mkdir("../uploads/" . $user_id, 0777,true);
                }
               
                //vytvorí cestu do zložky pre nahratie súboru
                $image_path = "../uploads/" . $user_id . "/" . $generated_name;
                //presunie fotku z dočasnéj serverovej zložky na zložku kde chceme ($image_path)
                move_uploaded_file($image_tmp_name, $image_path);
                
                //vloží obrázok do Databázy
                Image::insertImage($connection, $user_id,$generated_name );
                header("location: photos.php");
            }
            
            else{
                echo ("<br> <br> nesprávny typ súboru $image_type");
            }

        }
    } else{
        header("location: photos.php");
    }
   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nahratie Fotky</title>
</head>
<body>
    <h1>
        <?= $chyba ?>
    </h1>
    <a href='photos.php'>Naspäť na stránku</a>
</body>
</html>