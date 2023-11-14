<?php

class Image {


    public static function insertImage($connection, $user_id, $image_name){
        $sql = "INSERT INTO image (user_id, image_name) VALUES (:user_id, :image_name)";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":user_id", $user_id , PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        }
    }
    
    public static function getImages($connection,$user_id){
        $sql = "SELECT * from image where user_id = :user_id";
        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public static function deleteImage($connection, $user_id, $image_name){
        $sql = "DELETE from image where user_id = :user_id AND image_name = :image_name ";
        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);

        

        if($stmt->execute()){
            unlink("../uploads/$user_id/$image_name");
            return "Obrázok vymazaný!";
        }
    }


}



?>