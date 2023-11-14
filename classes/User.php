<?php

class User{

//pridá žiaka
public static function createUser($connection, $first_name,$second_name,$email,$password, $role){
    //SQL príkaz pre vloženie nového študenta do tabuľky, prvé sú definované aké dáta budem vkladať
    //Otázniky sú pre prepare/bind, nahradia sa reálnymi údajmi
    $sql = "INSERT INTO user(first_name, second_name,email, password, role) values(:first_name,:second_name, :email, :password,:role)";
    
    //Pripravi SQL príkaz pre vykonanie
    //$statment = mysqli_prepare($connection, $sql);
    $stmt = $connection->prepare($sql);

    $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
    $stmt->bindValue(":second_name", $second_name, PDO::PARAM_STR);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":password", $password, PDO::PARAM_STR);
    $stmt->bindValue(":role", $role , PDO::PARAM_STR);


try {
    $stmt->execute();
    return $id = $connection->lastInsertId();
} catch (\Throwable $th) {
    throw $th;
}

    
    
   
    }

    //Prihlásenie uživateľa
public static function login($connection, $email,$password){
        $sql = "SELECT * FROM `user` WHERE email = :email";
       // $statment = mysqli_prepare($connection, $sql);

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $uzivatel = null;

        try {
            $stmt->execute();
           $uzivatel = $stmt->fetch(PDO::FETCH_ASSOC);
         }
             catch (\Throwable $th) {
            throw $th;
            exit;
        }

           // $uzivatel = mysqli_fetch_array($result, MYSQLI_ASSOC);

            //Ak heslo uživateľa je rovnaké ako hash z DB tak pokračuje
            if(password_verify($password, $uzivatel["password"])){

            session_regenerate_id(); //zabráni fixation attacku - je to vždy dobré mať
             //nastavenie že je uživateľ úspešne prihlasený
             $_SESSION["isLoggedIn"] = true;
            //nastavenie ID uživateľa
            $_SESSION["logged_in_user_id"] = $uzivatel["id"];
            //nastavenia Role uživateľovi
            $_SESSION["role"] = $uzivatel["role"];


           //presmerovanie uživateľa
            header("location:/php-oop/admin/ziaci.php");
            }
           else{
            echo "Zlé prihlasovacie údaje!";
           }
        
        }



        public static function getUserId($connection, $email){
            $sql = "SELECT id FROM `user` WHERE email = :email";
            
            $stmt = $connection->prepare($sql);

        
            if(!$stmt) {
                echo mysqli_error($connection);
            } else {
                //mysqli_stmt_bind_param($statment, "s", $email);
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
              //mysqli_stmt_execute($statment);
              $stmt->execute();
               //$result = mysqli_stmt_get_result($statment);
                $id = $stmt->fetch();
        
                return $id[0];
            }
        }




    }



    



?>