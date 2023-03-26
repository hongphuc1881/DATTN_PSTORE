<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/user-class.php");
        $User = new User;
        $user_id = $_GET["user_id"];
        $User->lock_user($user_id);
        header('Location: user-list.php');
    } else {
        include("./404.php");
    }
?>