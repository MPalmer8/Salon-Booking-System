<?php
session_start();
unset($_SESSION["StaffID"]);
unset($_SESSION["StaffFirstName"]);
header("Location:login.php");
?>
