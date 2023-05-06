<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] != 3) {
        include("./database.php");
        include("./class/user-class.php");
        $User = new User;
        $contact_id = $_GET["contact_id"];
        $User->delete_contact($contact_id);
        header('Location: contact-list.php');
    } else {
        include("./404.php");
    }
?>