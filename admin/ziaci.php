<?php
//require "../components/secret/db.php";
require "../classes/Database.php";
require "../classes/Student.php";
 //funkcia pre pripojenie do databázy
 //$connection = connectDB();

 $databaza = new Database();
 $connection = $databaza->connectDB();


 require "../classes/Auth.php";
session_start();

if(!Auth::isLoggedIn()){
    die("Nepovolený prístup.");
}

    $role = $_SESSION["role"];

 //funkcia pre získanie žiakov z DB
 //require "../components/secret/ziskat-ziaka.php";
 $collumn = "first_name,second_name,id";
 $students = Student::getStudents($connection,$collumn);


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
    <h1>Zoznam žiakov školy</h1>


    <!-- Viac riadkový IF -->
    <?php if(empty($students)) : ?>
        <p>Žiadny žiaci</p>
       

        <!-- : - znamená v PHP niečo ako {} - v JS -->
    <?php else : ?>

    <form class="form-meno">
        <input type="text" name="name" id="name" class="meno">
    </form>

        <ul class="allStudents-div">
         <?php foreach($students as $index => $student) : ?>
            <li class="hacko">
            <h3 > <?php echo " $student[first_name] $student[second_name]"; ?> </h3>
        <!-- Dynamický link  -->
        <?php if($role === "admin"): ?>
            <a href="ziak.php?id=<?php echo $student["id"] ;?>">Viac informácií</a>
        <a href="vymazatZiaka.php?id=<?php echo $student["id"] ?>">Vymazať Študenta</a>
<?php endif ?>
       
       </li>
         
         <?php endforeach; ?>
        </ul>
    <?php endif; ?>


    <!-- Jednoriadkový IF -->
    <?php if(5>2) echo "5 je viac ako 2"; ?>
    <br>
            <a href="/php-oop">Naspäť na hlavnú stránku</a>
            <br>
            <a href="pridat-ziaka.php">Pridať žiaka</a> <br>
            
            
         <script src="../js/filter.js"></script>

</body>
</html>

