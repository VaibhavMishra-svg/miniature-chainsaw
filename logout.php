<?php
ob_start();
session_start();
session_destroy(); //Logouts
header("Location: login.php");
?>