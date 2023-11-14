<?php
//require "../components/secret/db.php";
//require "../components/secret/user.php";
require "../classes/Database.php";
require "../classes/User.php";


session_start();


if($_SERVER["REQUEST_METHOD"] === "POST"){
    //$connection = connectDB();
    $database = new Database();
    $connection = $database->connectDB();

    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];
    $email = $_POST["email"];
    $password =  password_hash($_POST["password"], PASSWORD_DEFAULT); //heslo vždy odosielať v HASHI do databázi
    $role = "user";

    //var_dump($first_name, $second_name,$email,$password);

    $id = User::createUser($connection, $first_name, $second_name,$email,$password,$role);

    echo "Uživateľ úspešne vytvorený $id";

    if(!empty($id)){
        session_regenerate_id(); //zabráni fixation attacku - je to vždy dobré mať

        //nastavenie že je uživateľ úspešne prihlasený
        $_SESSION["isLoggedIn"] = true;
        //nastavenie ID uživateľa
        $_SESSION["logged_in_user_id"] = $id;
       //nastavenie role uživateľovi
        $_SESSION["role"] = $role;

        header("location: http://localhost/php-oop/admin/ziaci.php");
    }
    else{
        echo "Uživateľ sa nevytvoril";
    }
}



?>