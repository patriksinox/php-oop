<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../php-oop/vendor/PHPMailer/src/Exception.php';
require '../php-oop/vendor/PHPMailer/src/PHPMailer.php';
require '../php-oop/vendor/PHPMailer/src/SMTP.php';

$first_name = null;
$second_name = null;
$email = null;
$text = null;



if($_SERVER["REQUEST_METHOD"] === "POST"){



$first_name = $_POST["first_name"];
$second_name = $_POST["second_name"];
$email = $_POST["email"];
$text = $_POST["text"];

$errors = [];

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Nesprávny e-mail!";
}

if(empty($errors)){
    $mail = new PHPMailer(true);

 try {


        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->CharSet = "UTF-8";
        $mail->Username = "patriksubjak1502@gmail.com";
        $mail->Password = "nič-nebude" ;
        $mail->SMTPSecure = "ssl" ;
        $mail->Port = 465 ;
    

        $mail->setFrom("patriksubjak1502@gmail.com");
        $mail->addAddress("patriksubjak1502@gmail.com");
       // $mail->Subject = "Vyplnený formulár";
       // $mail->Body = $poslanyEmail;

        $mail->isHTML(true);
        $mail->Subject = 'Vyplnený formulár';
        $mail->Body    = '<b>Odosielateľ: </b>' . $email . "<br>" . "<b>Správa: </b>" . $text;
        
    
    
        $mail->send();
        echo "správa odoslaná";
    
    
    } catch (Exception $e) {
          echo "Zpráva nebyla odeslána: ", $mail->ErrorInfo;
    } 
    
}



}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktkný formulár</title>
</head>
<body>
    <?php require "../php-oop/components/header.php" ?>
    <h1>Kontaktný formulár</h1>

    <?php if(!empty($errors)): ?>
        <ul>
            <?php foreach($errors as $one_error): ?>
                <li><?= $one_error ?></li>
                <?php endforeach; ?>
        </ul>
    <?php endif ;?>

    <form method="POST" >
    <input type="text" name="first_name" placeholder="Krstné meno" value="<?= $first_name ?>" required> <br>
    <input type="text" name="second_name" placeholder="Priezvisko" value="<?= $second_name ?>" required> <br>
    <input type="email" name="email" placeholder="email@email"  value="<?= $email ?>" required> <br>
    <textarea name="text" placeholder="Vaša správa" cols="30" rows="10"><?= $text ?></textarea> <br>
    <button>Odoslať</button>

    </form>
    
</body>
</html>