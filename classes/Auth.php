<?php
class Auth{
    public static function isLoggedIn(){
      return isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"];
        
      }
}

?>