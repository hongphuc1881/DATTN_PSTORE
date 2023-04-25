<?php
session_start();
ob_start();
if (isset($_SESSION["user"]) && $_SESSION["user"]["role"] != 3) {
    include("./database.php");
    include("./header.php");
    include("./menu.php");
    include("./footer.php");
} else {
    include("./404.php");
}
?>