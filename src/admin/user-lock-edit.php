<?php
session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/user-class.php");
    
        $User = new User;
        if(!isset($_GET["user_id"]) || $_GET["user_id"] == NULL) {
            echo "<script>window.location.href = 'user-list.php'</script>";
        } else {
            $user_id = $_GET["user_id"];
        }
      
        $unlock_user = $User->unlock_user($user_id);
        echo "<script>window.location.href = 'user-list.php' </script>";
    } else {
        include("./404.php");
    }
?>

