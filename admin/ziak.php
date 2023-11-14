<?php
//require "../components/secret/db.php";
 //funkcia pre pripojenie do databázy
 //$connection = connectDB();
 require "../classes/Student.php";
 require "../classes/Database.php";
 require "../classes/Auth.php";
 $database = new Database();
 $connection = $database->connectDB();

 //require "../components/secret/auth.php";
 session_start();
 
 if(!Auth::isLoggedIn()){
     die("Nepovolený prístup.");
 }

 
 //require "../components/secret/ziskat-ziaka.php";

$idcko = $_GET["id"];


//Ak ID nie je číslo alebo nie je definované tak script nepokračuje
if(!is_numeric($idcko) || !isset($idcko)) exit;


$student = Student::getStudent($connection,$idcko);

/* //SQL príkaz na DB ktorá vyberie všetky polia z DB Student
$sql = "SELECT * FROM student WHERE id = $idcko";
//Výsledok zo zavolania mysqli , prvé je pripojenie na DB, druhé je Náš príkaz 
$result = mysqli_query( $connection, $sql);


//ak je result false alebo prázdny tak vypíše chybu
if($result === false){
    echo mysqli_error($connection);
    exit;
}

//fetch_assoc nám prehodí jednú array na associativne pole
$student = mysqli_fetch_assoc($result); */

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
    <h1>Informácie o žiakovi s ID: <?php echo $student["id"];?></h1>
    <?php if($student === null):?>
        <p>Žiadny žiak</p>

    <?php else: ?>
        <h2><?php echo $student["first_name"]. " " .$student["second_name"]?></h2>
        <h3>Vek: <?php echo $student["age"];?></h3>
        <h4>Fakulta: <?php echo $student["college"]; ?></h4>
        <p><strong> Dodatočné informácie:</strong> <?php echo  htmlspecialchars($student["life"]) ?> </p>
    <?php endif ?>
<br>
<a href="editacia-ziaka.php?id=<?php echo $idcko ?>">Editovať žiaka</a>
<a href="vymazatZiaka.php?id=<?php echo $idcko ?>">Vymazať Žiaka</a>
<br>
<a href="ziaci.php">Naspäť na všetkých</a>
    
</body>
</html>