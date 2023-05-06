<?php
    session_start();
    ob_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/user-class.php");
    
        $User = new User;
        if(!isset($_GET["user_id"]) || $_GET["user_id"] == NULL) {
            header("location: user-list.php");
        } else {
            $user_id = $_GET["user_id"];
        }
      
        $unlock_user = $User->unlock_user($user_id);
        header("location: user-list.php");
    } else {
        include("./404.php");
    }
?>

