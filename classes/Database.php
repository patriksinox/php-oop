<?php
class Database{
    public function connectDB(){
 
        $db_host = "localhost";
        $db_user = "patrikdb" ;
        $db_password = "deskjet";
        $db_name = "skola" ;
        //prihlásenie do DB
        //$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

         //prihlásenie do DB - PDO
        $connection = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8";

        try {
            $db = new PDO($connection , $db_user,$db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            //throw $e->getMessage();
            throw $e;
            exit;
        }

    }
}



?>