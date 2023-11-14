<?php 
//XSS - Cross site scripting
// htmlspecialchars() - je to funkcia ktorá bude brať všetko vo vnútri ako html - dobré do nej vložiť dáta - zabráni aby nám spustilo nejaký hnusný script
//mysqli_real_escape_string() - Obrana proti SQL injection v inputoch, buď použiť toto alebo binding a prepare


$first_name = null;
$second_name = null;
$age = null;
$life = null;
$college = null;

require "../classes/Auth.php";
session_start();

if(!Auth::isLoggedIn()){
    die("Nepovolený prístup.");
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
require "../classes/Database.php";
 //require "../components/secret/db.php";
 //funkcia pre pripojenie do databázy
 //$connection = connectDB();
 require "../classes/Student.php";

 $database = new Database();
 $connection = $database->connectDB();

 //ziskanie funkcie pridaťŽiaka
 //require "../components/secret/ziskat-ziaka.php";

 $first_name = $_POST["first_name"];
$second_name = $_POST["second_name"];
$age = $_POST["age"];
$life = $_POST["life"];
$college = $_POST["college"];

Student::addStudent($connection, $first_name,$second_name,$age,$life,$college);

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
<?php require "../components/secret/admin-header.php" ?>
    <h1>Pridať žiaka</h1>

    <form action="pridat-ziaka.php" method="POST" id="forma">
       
        <input type="text" name="first_name" placeholder="Krstné meno" id="first_name" value="<?php echo htmlspecialchars($first_name) ?>"> <br>
        <input type="text" name="second_name" placeholder="Priezvisko" value="<?php echo htmlspecialchars($second_name) ?>"> <br>
        <input type="number" name="age" placeholder="Vek" min=10 value="<?php echo htmlspecialchars($age)?>"> <br>
        <textarea name="life" placeholder="Život" ><?php echo htmlspecialchars($life)?></textarea> <br>
        <input type="text" name="college" placeholder="koľaj" value="<?php echo htmlspecialchars($college)?>"> <br>
        <input type="submit" value="Odoslať">
        
    </form>

    
    <a href="ziaci.php">Všetci Žiaci</a>

    
</body>
</html>