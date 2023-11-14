<?php
//require "../components/secret/db.php";
//funkcia pre pripojenie do databázy
//$connection = connectDB();
require "../classes/Database.php";
require "../classes/Student.php";
require "../classes/Auth.php";
$database = new Database();
$connection = $database->connectDB();

//require "../components/secret/ziskat-ziaka.php";

//require "../components/secret/auth.php";
session_start();

if(!Auth::isLoggedIn()){
    die("Nepovolený prístup.");
}

$role = $_SESSION["role"];

if($role !== "admin"){
    die("nedostatočné práva!");
}

$id = $_GET["id"];

if(!is_numeric($id) || !isset($id)) exit;

$student = Student::getStudent($connection,$id);

if($student === null) {
    echo "Študent neexistuje, chybné ID.";
    exit();
}


//Ak bol formulár odoslaný tak spraví script
if($_SERVER["REQUEST_METHOD"] === "POST"){

$first_name = $_POST["first_name"];
$second_name = $_POST["second_name"];
$age = $_POST["age"];
$life = $_POST["life"];
$college = $_POST["college"];




//updatuje študenta 
Student::updateStudent($connection, $first_name,$second_name,$age,$life,$college, $id);

 if($result) {
    echo "Úspešne upravené dáta";
    //prejstNaZiaka($id);
    header("location:ziak.php?id=$id");
 }
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
 <h1>Editácia Žiaka s ID: <?php echo $id . " - " . $student["first_name"] . " " . $student["second_name"]?></h1>
 <form method="POST" id="forma">
       
       <input type="text" name="first_name" placeholder="Krstné meno" id="first_name" value="<?php echo htmlspecialchars($student["first_name"]) ?>"> <br>
       <input type="text" name="second_name" placeholder="Priezvisko" value="<?php echo htmlspecialchars($student["second_name"]) ?>"> <br>
       <input type="number" name="age" placeholder="Vek" min=10 value="<?php echo htmlspecialchars($student["age"])?>"> <br>
       <textarea name="life" placeholder="Život" ><?php echo htmlspecialchars($student["life"])?></textarea> <br>
       <input type="text" name="college" placeholder="koľaj" value="<?php echo htmlspecialchars($student["college"])?>"> <br>
       <input type="submit" value="Odoslať">
       
   </form>
<br>
<a href="ziaci.php">Naspäť na žiakov</a>
</body>
</html>