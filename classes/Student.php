<?php

class Student {
    
    //Vytiahne žiaka z DB
 public static function getStudent($connection, $id , $collumn = "*"){ //$collumn - špecifikujeme si vždy čo chceme z DB vybrať, defaultne to bude všetko = *
        //SQL príkaz ktorý nám podľa ID nájde študenta
        $sql = "SELECT $collumn FROM student WHERE id = :id";
        //pripraví Statment - pripojenieDB + príkaz
        //$stmt = mysqli_prepare($connection, $sql);

    $stmt = $connection->prepare($sql);

        if($stmt === false){
            //ak je pripojenie na DB alebo príkaz zlý tak nám vypíše error
            echo mysqli_error($connection);
        } else{
            //zviaže statment s integerom ID = vymení otáznik v $sql za hodnotu ID
            //mysqli_stmt_bind_param($stmt, "i", $id);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                        //vykoná statment a ak je pravdivý tak pokračuje
           if( $stmt->execute()){
          return $stmt->fetch();
           }
        }
    }
    

    
    //Aktualizuje žiaka
    public static function updateStudent($connection, $first_name,$second_name,$age,$life,$college,$id){
        $sql = "UPDATE student SET first_name = :first_name ,second_name = :second_name ,age = :age,life = :life ,college = :college WHERE id = :id";
        //pripraví SQL statment
         //$statment = mysqli_prepare($connection,$sql);
         $stmt = $connection->prepare($sql);
         //zviaže SQL statment s dátami z Formulára
         //mysqli_stmt_bind_param($statment,"ssiss",  $first_name,$second_name,$age,$life,$college, $id);
         $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
         $stmt->bindValue(":second_name", $second_name, PDO::PARAM_STR);
         $stmt->bindValue(":age", $age, PDO::PARAM_INT);
         $stmt->bindValue(":life", $life, PDO::PARAM_STR);
         $stmt->bindValue(":college", $college, PDO::PARAM_STR);
         $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        //vykoná sql statment
         //$result = mysqli_stmt_execute($statment);
         $result = $stmt->execute();
    
         if($result) {
            echo "Úspešne upravené dáta";
            header("location:ziak.php?id=$id");
         }
    }


    
    //vymaže žiaka
    public static function vymazatZiaka($connection, $id){
        $sql = "DELETE FROM student WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

       // $statment = mysqli_prepare($connection, $sql);
       // if(!$statment) echo mysqli_error($connection);
        //else mysqli_stmt_bind_param($statment, "i", $id);
        if($stmt->execute()) {
          header("location: ziaci.php");
        }
        else echo "Chyba pri vymazaní žiaka";
    }

//Vytiahne žiakov z DB
public static function getStudents($connection,$collumn = "*"){ //$collumn - špecifikujeme si vždy čo chceme z DB vybrať, defaultne to bude všetko = *
 $sql = "SELECT $collumn FROM student";
//Výsledok zo zavolania mysqli , prvé je pripojenie na DB, druhé je Náš príkaz 
 //$result = mysqli_query( $connection, $sql);
 $stmt = $connection->prepare($sql);
 
 //PDO vyžiadanie a vrátenie študentov
 if($stmt->execute()){
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 //Fetch all nám prehodí object na Asociatívne pole.
 //$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

}

                    
    //pridá žiaka
    public static function addStudent($connection, $first_name,$second_name,$age,$life,$college){
    //SQL príkaz pre vloženie nového študenta do tabuľky, prvé sú definované aké dáta budem vkladať
    //Otázniky sú pre prepare/bind, nahradia sa reálnymi údajmi
    $sql = "INSERT INTO student(first_name, second_name,age,life, college) values(:first_name,:second_name,:age,:life,:college)";
    
    //Pripravi SQL príkaz pre vykonanie
    //$statment = mysqli_prepare($connection, $sql);

    $stmt = $connection->prepare($sql);

    $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
    $stmt->bindValue(":second_name", $second_name, PDO::PARAM_STR);
    $stmt->bindValue(":age", $age, PDO::PARAM_INT);
    $stmt->bindValue(":life", $life, PDO::PARAM_STR);
    $stmt->bindValue(":college", $college, PDO::PARAM_STR);



    if($stmt->execute()){
        $id = $connection->lastInsertId();
        echo "Žiak úspešné vložený";
       Student::prejstNaZiaka($id);
    }
    else echo "Žiak nepridaný, chyba!";
    
   /*  if($statment === false) {
        echo mysqli_error($connection);
    } else {
    //Zviaže hodnoty zo $statment , ssiss - S - string, I - integer - podľa dát aké bude viazať. 
    //následne tam dosadí dáta z $_POST[aké si vyberieme]
    mysqli_stmt_bind_param($statment,"ssiss",$first_name,$second_name,$age,$life,$college);
    
    //Nakoniec vloží žiada do tabuľky
    $result = mysqli_stmt_execute($statment);
   
     if($result) {
        //vytiahne nám ID žiaka ktorého sme vlozili do Databázi
        $id = mysqli_insert_id($connection);
        echo "Žiak úspešné vložený";
    
        //Po úspešnom odoslaní žiaka do databázi nás presmeruje na jeho url
        //header("location: ziak.php?id=".$id);
        prejstNaZiaka($id);
    } else{
        echo mysqli_stmt_error($statment); 
    }
    /* Celý postup zajišťuje bezpečné vkládání dat do databáze a minimalizuje riziko SQL injection útoků. Díky použití předpřipravených dotazů jsou hodnoty odděleny od samotného SQL kódu. */
    }
   
        //prejde na ziaka s ID
        public static function prejstNaZiaka($id){
            header("location: ziak.php?id=".$id);
        }
}

?>