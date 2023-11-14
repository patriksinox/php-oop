<?php
require "../classes/Database.php";

require "../classes/Student.php";
require "../classes/Auth.php";
session_start();





if(!Auth::isLoggedIn() ){
    die("Nepovolený prístup.");
}
$role = $_SESSION["role"];
if($role !== "admin"){
die("nedostatočné práva");
}

$database = new Database();
$connection = $database->connectDB();

$id = $_GET["id"];


if($_SERVER["REQUEST_METHOD"] === "POST") {
    Student::vymazatZiaka($connection, $id);
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
    <h1>Vážne chcete vymazať Žiaka?</h1>
    <form method="POST" >
        <button>Áno</button>
        <button><a href="ziak.php?id=<?php echo $id?>">Nie</a></button>
        <br>
        <button><a href="ziaci.php">Všetci Žiaci</a></button>
    </form>
</body>
</html>